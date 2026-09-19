<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\Http\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::query()
            ->where('username', $data['username'])
            ->first();

        if (!$user || !$user->is_active) {
            return $this->response->error(
                message: 'Invalid credentials.',
                status: 401
            );
        }

        if (!Hash::check($data['password'], $user->password)) {
            return $this->response->error(
                message: 'Invalid credentials.',
                status: 401
            );
        }

        $token = $user->createToken('api')->plainTextToken;

        $user->update([
            'last_login_at' => now(),
        ]);

        return $this->response->success(
            data: [
                'user' => new UserResource($user),
                'token' => $token,
            ],
            message: 'Login successful.'
        );
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->response->success(
            data: new UserResource($user)
        );
    }

    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return $this->response->success(
            message: 'Logout successful.'
        );
    }
}