<?php

  namespace App\Interfaces;

  interface AnnouncesRepositoryInterface
  {
    public function index();

    public function itemList($params = []);

    public function save(array $data, $ID = 0);

    public function getById($id);

    public function delete(int $id);

    public function getActiveAnnounce($moreThanOne, $random = false);
  }
