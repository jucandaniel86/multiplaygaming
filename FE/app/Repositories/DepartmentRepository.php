<?php

  namespace App\Repositories;

  use App\Enums\StatusEnum;
  use App\Interfaces\DepartmentsRepositoryInterface;
  use App\Models\Departments;
  use App\Traits\QueryTrait;

  class DepartmentRepository implements DepartmentsRepositoryInterface
  {
    use QueryTrait;

    public function index($withRelations = false)
    {
      if ($withRelations) {
        return Departments::query()
          ->selectRaw('id, name as label')
          ->whereHas('jobs', function ($query) {
            $query->where('DELETED', 0)
              ->where('job_status', StatusEnum::PUBLISHED->value);
          })->get();
      }

      return Departments::query()
        ->selectRaw('id, name as label')
        ->get();
    }

    public function save(array $data, $categoryID = 0)
    {
      if ($categoryID) {
        $category = Departments::find($categoryID);
        if ($category) {
          $category->update($data);
          return $category;
        }
        return ['error' => 'Model not found'];
      }
      return Departments::create($data);
    }

    public function itemList($params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "name LIKE '%{$params['search']}%'"
        ],
      ];
      return $this->getFilteredList(Departments::query(), $params, $search);
    }

    public function getById($id)
    {
      return Departments::findOrFail($id);
    }

    public function delete($id)
    {
      return $this->deleteByID(Departments::query(), $id);
    }
  }
