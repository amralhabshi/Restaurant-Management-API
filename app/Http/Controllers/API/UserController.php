<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Support\Http\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::paginate(10);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->response->created(
            data: new UserResource($user),
            message: 'User created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // راجع اسم العلاقة الثانية داخل User Model
        $user->load(['roles', 'employee']);

        return $this->response->success(
            data: new UserResource($user)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $this->response->success(
            data: new UserResource($user),
            message: 'User updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->response->noContent();
    }

    /**
     * Attach role to user.
     */
    public function attachRole(User $user, Role $role)
    {
        $user->roles()->attach($role->id);

        return $this->response->success(
            message: 'Role attached successfully.'
        );
    }

    /**
     * Synchronize user roles.
     */
    public function syncRoles(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        return $this->response->success(
            message: 'Roles updated successfully.'
        );
    }
}