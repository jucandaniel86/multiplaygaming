<?php

  namespace App\Interfaces;

  interface CarrerRepositoryInterface
  {
    public function index(array $params = []);

    public function getById($id);

    public function getlastDraft($articleType);

    public function store(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function getBySlug($slug, $id);

    public function filterJobs(array $params, array $relations, $sort = [], $limit = 0);
  }
