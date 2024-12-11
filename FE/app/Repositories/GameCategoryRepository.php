<?php

  namespace App\Repositories;

  use App\Interfaces\GameCategoryInterface;
  use App\Models\GameCategory;
  use App\Traits\QueryTrait;

  class GameCategoryRepository implements GameCategoryInterface
  {
    use QueryTrait;

    public function index()
    {
      return GameCategory::query()
        ->selectRaw('id, name as label, slug')
        ->where('DELETED', 0)
        ->get();
    }

    public function save(array $data, $categoryID = 0)
    {
      if ($categoryID) {
        $feature = GameCategory::find($categoryID);
        if ($feature) {
          $feature->update($data);
          return $feature;
        }
        return ['error' => 'Model not found'];
      }
      return GameCategory::create($data);
    }

    public function itemList($params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "name LIKE '%{$params['search']}%'"
        ],
        [
          "condition" => true,
          "query" => "DELETED = 0"
        ]
      ];
      return $this->getFilteredList(GameCategory::query(), $params, $search);
    }

    public function getById($id)
    {
      return GameCategory::findOrFail($id);
    }

    public function delete($id)
    {
      $this->softDeleteByID(GameCategory::query(), $id);
    }
  }
