<?php

  namespace App\Interfaces;

  use Illuminate\Http\Request;


  interface PartnersRepositoryInterface
  {
    public function save(Request $request);

    public function delete($id);

    public function list(array $params = []): array;

    public function updatePriority(Request $request);

    public function getOrderedItems(): array;
  }
