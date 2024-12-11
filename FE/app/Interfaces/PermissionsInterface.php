<?php

  namespace App\Interfaces;

  use Illuminate\Http\Request;

  interface PermissionsInterface
  {
    public function getPermissionsList(Request $request): array;

    public function savePermission(Request $request);

    public function deletePermission(Request $request);

    public function allPermissions();

    public function rolesList(Request $request);

    public function saveRole(Request $request);

    public function deleteRole($id);

    public function getRole($id);
  }
