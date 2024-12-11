<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\SavePartnerRequest;
  use App\Interfaces\BannerRepositoryInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use DB;

  class BannerController extends Controller
  {
    private BannerRepositoryInterface $service;

    public function __construct(BannerRepositoryInterface $service)
    {
      $this->service = $service;
    }

    /**
     * @param SavePartnerRequest $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
      DB::beginTransaction();

      try {
        $Banner = $this->service->save($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Banner,
          'Banner was saved successfuly',
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
     * @return JsonResponse
     */
    public function client_area(): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->service->clientArea(), '');
    }
  }
