<?php

  namespace App\Repositories;

  use App\Exceptions\ApiResponseException;
  use App\Interfaces\ClientAreaInterface;
  use App\Models\ClientAreaOptions;

  class ClientAreaRepository implements ClientAreaInterface
  {

    public function option($optionName)
    {
      return ClientAreaOptions::query()->where('option_name', $optionName)->first();
    }

    public function options(array $options)
    {
      return ClientAreaOptions::query()
        ->when(is_array($options) && count($options), function ($query) use ($options) {
          $query->whereIn('option_name', $options);
        })
        ->get();
    }

    public function save(array $options)
    {
      if (!count($options)) throw new ApiResponseException('Invalid Params');

      foreach ($options as $option) {
        ClientAreaOptions::updateOrCreate([
          'option_name' => $option['option_name']
        ], [
          'option_value' => $option['option_value']
        ]);
      }

      return $options;
    }
  }
