<?php

namespace App\Support\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    //success response
    public function success(
    mixed $data = null,
    ?string $message = null,
    int $status = 200
    ): JsonResponse {

        $response = [];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if ($message !== null) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }

    // Create response
    public function created(
        mixed $data,
        ?string $message = null
    ): JsonResponse
    {
        return $this->success(
            data: $data,
            message: $message,
            status: 201
        );
    }


    // Message response
    public function message(
    string $message,
    int $status = 200
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }

    // Delete response
    public function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }
    
    // Error response
    public function error(
    string $message,
    int $status = 400
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }

}