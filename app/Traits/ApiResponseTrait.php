<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function apiResponse($data = null, $message = '', $status = 200, $errors = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors ?: null,
            'data' => $data,
        ], $status);
    }
}
