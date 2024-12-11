<?php

  namespace App\Repositories;

  use App\Enums\ArticleTypesEnum;
  use App\Enums\StatusEnum;
  use App\Interfaces\ArticleRepositoryInterface;
  use App\Models\Article;
  use App\Traits\QueryTrait;
  use App\Traits\UploadFilesTrait;
  use DB;
  use Illuminate\Support\Collection;
  use Mockery\Exception;

  class ArticleRepository implements ArticleRepositoryInterface
  {
    use QueryTrait, UploadFilesTrait;

    public function index(array $params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "title LIKE '%{$params['search']}%'"
        ],
        [
          "condition" => true,
          "query" => "DELETED = 0"
        ]
      ];

      if (isset($params['category_id']) && (int)$params['category_id']) {
        $search[] = [
          "condition" => true,
          "query" => "category_id = " . $params['category_id']
        ];
      }

      if (isset($params['article_status']) && in_array($params['article_status'], array_column(StatusEnum::cases(), 'value'),)) {
        $search[] = [
          "condition" => true,
          "query" => "article_status = '" . $params['article_status'] . "'"
        ];
      }

      if (isset($params['article_type']) && in_array($params['article_type'], array_column(ArticleTypesEnum::cases(), 'value'),)) {
        $search[] = [
          "condition" => true,
          "query" => "article_type = '" . $params['article_type'] . "'"
        ];
      }

      return $this->getFilteredList(Article::query()->with('category'), $params, $search, [
        'column' => 'id',
        'direction' => 'desc'
      ]);
    }

    public function getlastDraft($articleType)
    {
      return Article::where('article_status', StatusEnum::DRAFT->value)
        ->where('created_at', '>=', now()->subDays(1))
        ->where('article_type', $articleType)
        ->where('DELETED', 0)
        ->first();
    }

    public function getById($id)
    {
      return Article::findOrFail($id);
    }

    public function store(array $data)
    {
      return Article::create($data);
    }

    public function update(array $data, $id)
    {
      return Article::whereId($id)->update($data);
    }

    public function delete($id)
    {
      $this->softDeleteByID(Article::query(), $id);
    }

    public function getBySlug($slug, $relations = [])
    {
      $Article = Article::where('slug', $slug)->where("DELETED", 0);

      if (count($relations)) {
        $Article->with($relations);
      }
      return $Article->first();
    }

    public function filterArticles(array $params, array $relations, $sort = [], $limit = 0): Collection
    {
      $Items = Article::query()->where('DELETED', 0)
        ->where('article_status', StatusEnum::PUBLISHED->value)
        ->when(isset($params['category_id']) && (int)$params['category_id'] > 0, function ($query) use ($params) {
          return $query->where('category_id', (int)$params['category_id']);
        })
        ->when(isset($params['title']) && strlen($params['title']) > 2, function ($query) use ($params) {
          return $query->whereRaw('title LIKE "%' . $params['title'] . '%"');
        })
        ->when(isset($params['article_type'])
          && in_array($params['article_type'], array_column(ArticleTypesEnum::cases(), 'value')), function ($query) use ($params) {
          return $query->where('article_type', $params['article_type']);
        })
        ->when(isset($params['is_highlighted']), function ($query) use ($params) {
          return $query->where('is_highlighted', (int)$params['is_highlighted']);
        })
        ->when(isset($params['categories']), function ($query) use ($params) {
          try {
            $categories = json_decode($params['categories']);
            if (count($categories)) {
              return $query->whereIn('category_id', $categories);
            }
          } catch (Exception $exception) {
          }
        });

      if ($limit > 0) {
        $Items->limit($limit);
      }

      if (count($sort)) {
        $Items->orderBy($sort['column'], $sort['direction']);
      }

      if (count($relations)) {
        $Items->with($relations);
      }

      return $Items->get();
    }
  }
