<?php

  namespace App\Repositories;

  use App\Interfaces\AnnouncesRepositoryInterface;
  use App\Models\Announce;
  use App\Traits\QueryTrait;

  class AnnouncesRepository implements AnnouncesRepositoryInterface
  {
    use QueryTrait;

    const IS_ACTIVE = 1;

    public function index()
    {
      return Announce::query()
        ->selectRaw('id, title as label')
        ->get();
    }

    public function itemList($params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "title LIKE '%{$params['search']}%' OR subtitle LIKE '%{$params['search']}%'"
        ],
      ];
      return $this->getFilteredList(
        Announce::query()
          ->selectRaw('title, id, subtitle, started_at, ended_at, is_active,
          (
            CASE WHEN CURDATE() between started_at AND ended_at
            THEN 1 ELSE 0
            END
          ) AS active_on_interval
          '),
        $params,
        $search);
    }

    public function save(array $data, $ID = 0)
    {
      if ($ID) {
        $Item = $this->getById($ID);
        if ($Item) {
          $Item->update($data);
          return $Item;
        }
        return ['error' => 'Model not found'];
      }
      return Announce::create($data);
    }

    public function getById($id)
    {
      return Announce::findOrFail($id);
    }

    public function delete(int $id)
    {
      return $this->deleteByID(Announce::query(), $id);
    }

    public function getActiveAnnounce($moreThanOne, $random = false)
    {
      $Result = Announce::query()
        ->where('started_at', '<=', now())
        ->where('ended_at', '>=', now())
        ->where('is_active', self::IS_ACTIVE);

      if ($moreThanOne) {
        if ($random) {
          return $Result->inRandomOrder()->get();
        }
        return $Result->get();
      }

      if ($random) {
        return $Result->inRandomOrder()->first();
      }
      return $Result->first();
    }
  }
