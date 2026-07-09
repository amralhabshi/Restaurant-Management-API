<?php

namespace App\Support\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public function success(
    mixed $data,
    ?string $message = null,
    int $status = 200
    ): JsonResponse {

        $response = [
            'data' => $data,
        ];

        if ($message !== null) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }

    

}