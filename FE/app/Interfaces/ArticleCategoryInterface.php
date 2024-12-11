<?php

  namespace App\Interfaces;

  interface ArticleCategoryInterface
  {
    public function index();

    public function itemList($params = []);

    public function save(array $data, $categoryID = 0);

    public function getById($id);

    public function delete($id);
  }
