<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\AttachRolePermissionRequest;
use App\Http\Requests\SyncRolePermissionsRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Support\Http\ApiResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(
            $request->validated()
        );

        return $this->response->created(
            data: new RoleResource($role),
            message: 'Role created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['permissions']);

        return $this->response->success(
            data: new RoleResource($role)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update(
            $request->validated()
        );

        return $this->response->success(
            data: new RoleResource($role),
            message: 'Role updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->response->noContent();
    }

    public function permissions(Role $role)
    {
        return PermissionResource::collection(
            $role->permissions
        );
    }

    /**
     * Attach permission to role.
     */
    public function attachPermission( AttachRolePermissionRequest $request, Role $role)
    {
        $role->permissions()->attach(
            $request->validated()['permission_id']
        );

        return $this->response->success(
            data: null,
            message: 'Permission attached successfully.'
        );
    }

    /**
     * Detach permission from role.
     */
    public function detachPermission(Role $role, Permission $permission)
    {
        $role->permissions()->detach($permission->id);

        return $this->response->success(
            data: null,
            message: 'Permission removed successfully.'
        );
    }

    /**
     * Synchronize role permissions.
     */
    public function syncPermissions(SyncRolePermissionsRequest $request, Role $role)
    {
        $role->permissions()->sync(
            $request->validated()['permissions']
        );

        return $this->response->success(
            data: null,
            message: 'Permissions updated successfully.'
        );
    }
}