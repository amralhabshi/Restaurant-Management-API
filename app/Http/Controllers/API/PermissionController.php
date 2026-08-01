<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Support\Http\ApiResponse;

class PermissionController extends Controller
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
        $permissions = Permission::paginate(10);

        return PermissionResource::collection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create(
            $request->validated()
        );

        return $this->response->created(
            data: new PermissionResource($permission),
            message: 'Permission created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return $this->response->success(
            data: new PermissionResource($permission)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update(
            $request->validated()
        );

        return $this->response->success(
            data: new PermissionResource($permission),
            message: 'Permission updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return $this->response->noContent();
    }
}