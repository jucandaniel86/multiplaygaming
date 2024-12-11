<?php

  namespace App\Interfaces;

  interface FeatureInterface
  {
    public function index($params = []);

    public function getById($id);

    public function save(array $data, $featureID = 0);

    public function delete($id);

    public function getFeaturesDropdown();
  }
