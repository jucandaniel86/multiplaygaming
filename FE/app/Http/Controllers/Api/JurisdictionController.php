<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\JurisdictionRequest;
  use App\Models\Jurisdiction;
  use App\Traits\QueryTrait;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use DB;

  class JurisdictionController extends Controller
  {
    use QueryTrait;

    /**
     * @param JurisdictionRequest $request
     * @return JsonResponse
     */
    public function save(JurisdictionRequest $request): JsonResponse
    {
      $Data = $request->only(['name', 'alias']);
      $ID = (int)$request->get('id');

      DB::beginTransaction();

      try {
        $Data = Jurisdiction::updateOrCreate(['id' => $ID], $Data);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Data,
          'Jurisdiction was saved successfuly',
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
      $params = $request->only(['search']);
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "(name LIKE '%{$params['search']}%')"
        ],
      ];

      return ApiResponseClass::sendResponse(
        $this->getFilteredList(Jurisdiction::query(), $request->all(), []), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        $this->deleteByID(Jurisdiction::query(), $request->get('id')), 'Success');
    }
  }
