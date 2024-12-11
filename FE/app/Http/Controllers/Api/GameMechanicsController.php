<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Interfaces\GameRepositoryInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;

  use DB;

  class GameMechanicsController extends Controller
  {
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
      $this->gameRepository = $gameRepository;
    }

    public function list(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->mechanicsList($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
      $request->validate([
        'name' => 'required'
      ]);

      DB::beginTransaction();

      try {
        $Mechanics = $this->gameRepository->saveMechanics($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Mechanics,
          'The record was saved successfuly',
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
      $this->gameRepository->deleteMechanics($request);
      return ApiResponseClass::sendResponse(
        null,
        'The record was deleted successfuly',
        201
      );
    }
  }
