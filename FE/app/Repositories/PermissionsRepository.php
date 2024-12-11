<?php

  namespace App\Repositories;

  use App\Interfaces\PermissionsInterface;
  use App\Traits\QueryTrait;
  use Illuminate\Http\Request;
  use App\Models\Permission;
  use Spatie\Permission\Models\Role;

  class PermissionsRepository implements PermissionsInterface
  {
    use QueryTrait;

    public function getPermissionsList(Request $request): array
    {
      return $this->vDatatable(Permission::class, [
        'pagination' => $request->only(['start', 'length']),
        'like' => [
          'name' => $request->get('search')
        ]
      ]);
    }

    public function allPermissions()
    {
      return Permission::all();
    }

    public function savePermission(Request $request)
    {
      $ID = $request->has('id') ? $request->get('id') : 0;
      if ($ID) {
        return Permission::findById($ID)->update($request->only(['name', 'category_id']));
      }
      return Permission::create($request->only(['name', 'category_id']));
    }

    public function deletePermission(Request $request)
    {
      $id = $request->get('id');
      $Permission = Permission::findById($id);
      $Permission->delete();
    }

    public function rolesList(Request $request)
    {
      return $this->vDatatable(Role::class, [
        'pagination' => $request->only(['start', 'length']),
        'relations' => ['permissions'],
        'like' => [
          'name' => $request->get('search')
        ]
      ]);
    }

    public function saveRole(Request $request)
    {
      $ID = $request->has('id') ? $request->get('id') : 0;
      if ($ID) {
        $Role = Role::findById($ID);
        $Role->update($request->only(['name']));
      } else {
        $Role = Role::create($request->only(['name']));
      }

      if ($request->has('permissions')) {
        $Role->syncPermissions($request->get('permissions'));
      }

      return $Role;
    }

    public function getRole($id)
    {
      return Role::with('permissions')->find($id);
    }

    public function deleteRole($id)
    {
      $Role = Role::findById($id);
      $Role->syncPermissions([]);
      $Role->delete();
    }
  }
