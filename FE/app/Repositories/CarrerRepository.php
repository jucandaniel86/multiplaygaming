<?php

  namespace App\Repositories;

  use App\Enums\StatusEnum;
  use App\Interfaces\CarrerRepositoryInterface;
  use App\Models\Carrer;
  use App\Traits\QueryTrait;
  use Ramsey\Collection\Collection;

  class CarrerRepository implements CarrerRepositoryInterface
  {
    use QueryTrait;

    public function index(array $params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "job_title LIKE '%{$params['search']}%'"
        ],
        [
          "condition" => true,
          "query" => "DELETED = 0"
        ]
      ];

      if (isset($params['department_id']) && (int)$params['department_id']) {
        $search[] = [
          "condition" => true,
          "query" => "department_id = " . $params['department_id']
        ];
      }


      if (isset($params['status']) && in_array($params['status'], array_column(StatusEnum::cases(), 'value'),)) {
        $search[] = [
          "condition" => true,
          "query" => "job_status = '" . $params['status'] . "'"
        ];
      }

      return $this->getFilteredList(
        Carrer::query()
          ->with('department')
          ->withCount('cvs'),
        $params, $search);
    }

    public function getlastDraft($articleType)
    {
      return Carrer::where('job_status', StatusEnum::DRAFT->value)
        ->where('created_at', '>=', now()->subDays(1))
        ->where('DELETED', 0)
        ->first();
    }

    public function getById($id)
    {
      return Carrer::findOrFail($id);
    }

    public function store(array $data)
    {
      return Carrer::create($data);
    }

    public function update(array $data, $id)
    {
      return Carrer::whereId($id)->update($data);
    }

    public function delete($id)
    {
      $this->softDeleteByID(Carrer::query(), $id);
    }

    public function getBySlug($slug, $id)
    {
      return Carrer::where('DELETED', 0)
        ->where("job_status", StatusEnum::PUBLISHED->value)
        ->where('slug', $slug)
        ->where('id', $id)
        ->with('department')
        ->first();
    }

    public function filterJobs(array $params, array $relations, $sort = [], $limit = 0): array
    {
      $start = (isset($params['start'])) ? $params['start'] : 0;
      $length = (isset($params['length']) && $params['length'] > 0) ? $params['length'] : 50;
      $offset = ($start - 1) * $length;

      $Items = Carrer::query()->where('DELETED', 0)
        ->where('job_status', StatusEnum::PUBLISHED->value)
        ->when(isset($params['search']) && strlen($params['search']) > 2, function ($query) use ($params) {
          return $query->whereRaw('job_title LIKE "%' . $params['search'] . '%"');
        })
        ->when(isset($params['departments']), function ($query) use ($params) {
          try {
            $departments = json_decode($params['departments']);
            if (count($departments)) {
              return $query->whereIn('department_id', $departments);
            }
          } catch (\Exception $exception) {
          }
        });

      if (count($sort)) {
        $Items->orderBy($sort['column'], $sort['direction']);
      }

      if (count($relations)) {
        $Items->with($relations);
      }

      $Total = $Items->count();
      $ItemsQuery = $Items
        ->limit($length)
        ->offset($offset);

      return [
        'total' => $Total,
        'items' => $ItemsQuery->get(),
      ];
    }
  }
