<?php

  namespace App\Interfaces;

  interface DepartmentsRepositoryInterface
  {
    public function index($withRelations = false);

    public function itemList($params = []);

    public function save(array $data, $categoryID = 0);

    public function getById($id);

    public function delete($id);
  }
