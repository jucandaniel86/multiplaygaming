<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Http\Controllers\Controller;
  use App\Interfaces\ClientAreaInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use DB;

  class ClientAreaController extends Controller
  {
    private ClientAreaInterface $clientArea;

    public function __construct(ClientAreaInterface $clientArea)
    {
      $this->clientArea = $clientArea;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function option(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientArea->option($request->get('option_name')), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function options(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->clientArea->options($request->get('options') ? $request->get('options') : []), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
      DB::beginTransaction();

      try {
        $SavedItem = $this->clientArea->save($request->get('options'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $SavedItem,
          'Options was saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
      }
    }
  }
