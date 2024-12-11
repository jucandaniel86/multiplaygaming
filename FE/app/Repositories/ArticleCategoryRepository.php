<?php

  namespace App\Repositories;

  use App\Interfaces\ArticleCategoryInterface;
  use App\Interfaces\ArticleRepositoryInterface;
  use App\Models\ArticleCategory;
  use App\Models\GameCategory;
  use App\Traits\QueryTrait;

  class ArticleCategoryRepository implements ArticleCategoryInterface
  {
    use QueryTrait;

    public function index()
    {
      return ArticleCategory::query()
        ->selectRaw('id, name as label')
        ->where("DELETED", 0)
        ->get();
    }

    public function save(array $data, $categoryID = 0)
    {
      if ($categoryID) {
        $category = ArticleCategory::find($categoryID);
        if ($category) {
          $category->update($data);
          return $category;
        }
        return ['error' => 'Model not found'];
      }
      return ArticleCategory::create($data);
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
      return $this->getFilteredList(ArticleCategory::query(), $params, $search);
    }

    public function getById($id)
    {
      return ArticleCategory::findOrFail($id);
    }

    public function delete($id)
    {
      $this->softDeleteByID(ArticleCategory::query(), $id);
    }
  }
