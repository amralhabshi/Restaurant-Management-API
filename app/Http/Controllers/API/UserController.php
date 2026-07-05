<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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

        $data['password'] =Hash::make($data['password']);

        $user = User::create($data);

        return response()->json(new UserResource($user),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['rloes','employees']);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request,User $user)
    {
        $data = $request->validated();

        if(isset($data['password']))
        {
            $data['password'] =Hash::make($data['password']);
        }

        $user->update($data);

        return new UserResource($user);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null,204);
    }

    public function attachRole(User $user, Role $role)
    {
        $user->roles()->attach($role->id);

        return response()->json([
            'message' => 'Role attached'
        ]);
    }

    public function syncRoles(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        return response()->json([
            'message' => 'Roles updated'
        ]);
    }


}
