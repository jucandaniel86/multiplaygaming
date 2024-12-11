<?php

  namespace App\Interfaces;

  use Illuminate\Http\Request;


  interface BannerRepositoryInterface
  {
    public function save(Request $request);

    public function delete($id);

    public function list(array $params = []): array;

    public function clientArea();
  }
