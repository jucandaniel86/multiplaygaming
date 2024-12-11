<?php

  namespace App\Repositories;

  use App\Interfaces\ClientsRepositoryInterface;
  use App\Models\Client;
  use App\Models\ClientBrand;
  use App\Models\ClientBrandsTaxes;
  use App\Models\Country;
  use App\Traits\QueryTrait;
  use Illuminate\Http\Request;

  class ClientsRepository implements ClientsRepositoryInterface
  {
    use QueryTrait;

    public function clientsList(Request $request): array
    {
      return $this->vDatatable(Client::class, [
        'pagination' => $request->only(['start', 'length']),
        'like' => [
          'name' => $request->get('search')
        ],
        'count' => [
          'brands'
        ]
      ]);
    }

    public function clientsListAll()
    {
      return Client::select('id, name')->get();
    }

    public function storeClient(Request $request)
    {
      $clientID = (int)$request->get('id');

      if ($clientID) {
        $Client = Client::find($clientID);
        $Client->update(
          $request->only(['name', 'legal_name', 'tax', 'rev_share',
            'bet_limits', 'client_rgs_id'
          ]) + ['currencies' => json_encode($request->get('currencies'))]
        );

        return $Client;
      }

      $Client = Client::create($request->only(['name', 'legal_name', 'tax', 'rev_share',
          'bet_limits', 'client_rgs_id'
        ]) + ['currencies' => json_encode($request->get('currencies'))]
      );

      return $Client;
    }

    public function deleteClient(Request $request)
    {
      $Ids = ClientBrand::where('client_id', $request->get('id'))
        ->get()
        ->pluck('id');

      ClientBrandsTaxes::whereIn('brand_id', $Ids)->delete();
      ClientBrand::where('client_id', $request->get('id'))->delete();

      return $this->deleteByID(Client::query(), $request->get('id'));
    }

    public function brandsList(Request $request): array
    {
      return $this->vDatatable(ClientBrand::class, [
        'pagination' => $request->only(['start', 'length']),
        'like' => [
          'name' => $request->get('search')
        ],
        'with' => [
          'client'
        ],
        'filter' => $request->only('client_id')
      ]);
    }

    public function storeBrand(Request $request): ClientBrand
    {
      $brandID = (int)$request->get('id');

      if ($brandID) {
        $Brand = ClientBrand::find($brandID);
        $Brand->update(
          $request->only(['name', 'client_id', 'brand_url', 'brand_rgs_id'])
        );

        return $Brand;
      }

      $Brand = ClientBrand::create($request->only(['name', 'client_id', 'brand_url', 'brand_rgs_id']));

      return $Brand;
    }

    public function deleteBrand(Request $request)
    {
      return $this->deleteByID(ClientBrand::query(), $request->get('id'));
    }

    public function storeTaxes(Request $request)
    {
      $taxID = (int)$request->get('id');

      if ($taxID) {
        $Tax = ClientBrandsTaxes::find($taxID);

        $Tax->update($request->only(['tax']));

        return $Tax;
      }

      $Tax = ClientBrandsTaxes::create($request->only(['brand_id', 'brand_rgs_id', 'country_id', 'tax']));

      return $Tax;
    }

    public function deleteTax(Request $request)
    {
      return $this->deleteByID(ClientBrandsTaxes::query(), $request->get('id'));
    }

    public function getTaxList(Request $request)
    {
      return ClientBrandsTaxes::join('client_brands', 'client_brands_taxes.brand_id', 'client_brands.id')
        ->when($request->has('client_id'), function ($query) use ($request) {
          return $query->where('client_brands.client_id', '=', $request->get('client_id'));
        })
        ->with(['brand', 'country'])
        ->selectRaw('client_brands_taxes.id, client_brands_taxes.tax, client_brands_taxes.brand_id, client_brands_taxes.country_id')
        ->orderBy('id', 'desc')
        ->get();
    }
  }
