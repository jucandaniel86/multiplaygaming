<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use App\Interfaces\ClientsRepositoryInterface;
  use DB;

  class ClientsController extends Controller
  {
    protected ClientsRepositoryInterface $clientRepository;

    /**
     * @param ClientsRepositoryInterface $clientRepository
     */
    public function __construct(ClientsRepositoryInterface $clientRepository)
    {
      $this->clientRepository = $clientRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientRepository->clientsList($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
      DB::beginTransaction();

      try {
        $Client = $this->clientRepository->storeClient($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Client,
          'Client was saved successfuly',
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex, $ex->getMessage());
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientRepository->deleteClient($request), 'Client was deleted successfuly');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function brandsList(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientRepository->brandsList($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeBrand(Request $request): JsonResponse
    {
      DB::beginTransaction();

      try {
        $Brand = $this->clientRepository->storeBrand($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Brand,
          'Brand was saved successfuly',
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex, $ex->getMessage());
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteBrand(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientRepository->deleteBrand($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeTax(Request $request): JsonResponse
    {
      if ($request->has('id')) {
        $request->validate([
          'tax' => 'required|numeric'
        ]);
      } else {
        $request->validate([
          'brand_id' => 'required',
          'brand_rgs_id' => 'required',
          'country_id' => 'required',
          'tax' => 'required|numeric'
        ]);
      }

      DB::beginTransaction();

      try {
        $Tax = $this->clientRepository->storeTaxes($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Tax,
          'Tax was saved successfuly',
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex, $ex->getMessage());
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteTax(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientRepository->deleteTax($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTaxesList(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientRepository->getTaxList($request), '');
    }
  }
