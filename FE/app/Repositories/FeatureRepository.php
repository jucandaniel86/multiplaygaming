<?php

  namespace App\Repositories;

  use App\Interfaces\FeatureInterface;
  use App\Models\Feature;
  use App\Traits\QueryTrait;

  class FeatureRepository implements FeatureInterface
  {
    use QueryTrait;

    public function index($params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "name LIKE '%{$params['search']}%' OR long_name LIKE '%{$params['search']}%'"
        ],
        [
          "condition" => true,
          "query" => "DELETED = 0"
        ]
      ];
      return $this->getFilteredList(Feature::query(), $params, $search);
    }

    public function getById($id)
    {
      return Feature::findOrFail($id);
    }

    public function save(array $data, $featureID = 0)
    {
      if ($featureID) {
        $feature = Feature::find($featureID);
        if ($feature) {
          $feature->update($data);
          return $feature;
        }
        return ['error' => 'Model not found'];
      }
      return Feature::create($data);
    }

    public function delete($id)
    {
      $this->softDeleteByID(Feature::query(), $id);
    }

    public function getFeaturesDropdown()
    {
      return Feature::query()
        ->selectRaw('id, name as label')
        ->orderBy('name', 'asc')
        ->get();
    }
  }
