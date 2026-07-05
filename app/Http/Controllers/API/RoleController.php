<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;

class RoleController extends Controller
{
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

        return response()->json(new RoleResource($role),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['Permissions']);

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update(
            $request->validated()
        );

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null,204);
    }

    public function attachPermission(Role $role, Permission $permission)
    {
        $role->permissions()->attach($permission->id);

        return response()->json([
            'message' => 'Permission attached successfully'
        ]);
    }

    public function detachPermission(Role $role, Permission $permission)
    {
        $role->permissions()->detach($permission->id);

        return response()->json([
            'message' => 'Permission removed'
        ]);
    }

    
    public function syncPermissions(Request $request, Role $role)
    {
        $request->validate([
        'permissions' => 'required|array',
        'permissions.*' => 'exists:permissions,id'
        ]);
        
        $role->permissions()->sync($request->permissions);

        return response()->json([
            'message' => 'Permissions updated'
        ]);
    }
}
