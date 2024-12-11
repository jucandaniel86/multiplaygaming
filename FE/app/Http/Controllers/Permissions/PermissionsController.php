<?php

  namespace App\Http\Controllers\Permissions;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Interfaces\PermissionsInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;

  use DB;

  class PermissionsController extends Controller
  {
    private PermissionsInterface $permissions;

    public function __construct(PermissionsInterface $permissions)
    {
      $this->permissions = $permissions;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->permissions->getPermissionsList($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->permissions->allPermissions($request), '');
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
        $Permission = $this->permissions->savePermission($request);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Permission,
          'Permission was saved successfuly',
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
      $this->permissions->deletePermission($request);
      return ApiResponseClass::sendResponse(
        null,
        'Permission was deleted successfuly',
        201
      );
    }
  }
