<?php

  namespace App\Interfaces;

  use Illuminate\Http\Request;

  interface ClientsRepositoryInterface
  {
    public function clientsList(Request $request): array;

    public function clientsListAll();

    public function storeClient(Request $request);

    public function deleteClient(Request $request);

    public function brandsList(Request $request);

    public function storeBrand(Request $request);

    public function deleteBrand(Request $request);

    public function storeTaxes(Request $request);

    public function deleteTax(Request $request);

    public function getTaxList(Request $request);
  }
