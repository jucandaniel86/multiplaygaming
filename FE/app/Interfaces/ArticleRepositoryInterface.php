<?php

  namespace App\Interfaces;

  use Illuminate\Support\Collection;

  interface ArticleRepositoryInterface
  {
    public function index(array $params = []);

    public function getById($id);

    public function getBySlug($slug, $relations = []);

    public function getlastDraft($articleType);

    public function store(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function filterArticles(array $params, array $relations, $sort = [], $limit = 0): Collection;
  }
