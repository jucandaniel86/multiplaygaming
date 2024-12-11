<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Interfaces\UserInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use App\Http\Requests\{UpdateUserPasswordRequest, UserRequest, UserUpdateRequest};

  use DB;

  class UsersController extends Controller
  {
    private UserInterface $service;

    public function __construct(UserInterface $service)
    {
      $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsersList(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->service->getUsersList($request->all()), '');
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function createUser(UserRequest $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->only(['name', 'email', 'password', 'roles']);

      try {
        $user = $this->service->createUser($details);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $user,
          'The user was created successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    public function updateUser(UserUpdateRequest $request)
    {
      DB::beginTransaction();
      $details = $request->all();

      try {
        $user = $this->service->createUser($details);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $user,
          'The user was saved successfuly',
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['errors' => [$ex->getMessage()]], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteUser(Request $request): JsonResponse
    {
      try {
        return ApiResponseClass::sendResponse($this->service->deleteUser($request->id), 'The user was deleted successfuly');
      } catch (ApiResponseException $exception) {
        return ApiResponseClass::sendError(['error' => $exception->getMessage()], 'Error');
      }
    }

    /**
     * @param UpdateUserPasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(UpdateUserPasswordRequest $request): JsonResponse
    {
      try {
        return ApiResponseClass::sendResponse($this->service->changePassword($request->all()), 'The user was saved successfuly');
      } catch (ApiResponseException $exception) {
        return ApiResponseClass::sendError(['failed' => [$exception->getMessage()]], 'Error');
      }
    }
  }
