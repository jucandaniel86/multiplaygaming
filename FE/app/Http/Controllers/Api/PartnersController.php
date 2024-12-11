<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\SavePartnerRequest;
  use App\Interfaces\PartnersRepositoryInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use DB;

  class PartnersController extends Controller
  {
    private PartnersRepositoryInterface $service;

    public function __construct(PartnersRepositoryInterface $service)
    {
      $this->service = $service;
    }

    /**
     * @param SavePartnerRequest $request
     * @return JsonResponse
     */
    public function save(SavePartnerRequest $request): JsonResponse
    {
      DB::beginTransaction();

      try {
        $Job = $this->service->save($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Job,
          'Partner was saved successfuly',
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
    public function list(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->service->list($request->all()), '', 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        $this->service->delete((int)$request->get('id')),
        'Success'
      );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePriority(Request $request): JsonResponse
    {
      DB::beginTransaction();

      try {
        $Job = $this->service->updatePriority($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Job,
          'Partner was saved successfuly',
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex, $ex->getMessage());
      }
    }
  }
