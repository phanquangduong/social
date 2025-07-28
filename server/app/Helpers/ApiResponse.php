<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $metadata = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success'  => true,
            'message'  => $message,
            'code'     => 20001,
            'metadata' => $metadata,
        ], $statusCode);
    }

    public static function fail(string $message = 'Failed', int $statusCode = 400, int $code = 1, mixed $metadata = null): JsonResponse
    {
        return response()->json([
            'success'  => false,
            'message'  => $message,
            'code'     => $code,
            'metadata' => $metadata,
        ], $statusCode);
    }

    public static function requestInvalid(array $metadata = [], int $statusCode = 422): JsonResponse
    {
        return response()->json([
            'success'  => false,
            'message'  => 'Invalid request data',
            'code'     => 40022,
            'metadata' => $metadata,
        ], $statusCode);
    }

    public static function permission(string $message = 'You do not have permission to perform this action', int $statusCode = 403): JsonResponse
    {
        return response()->json([
            'success'  => false,
            'message'  => $message,
            'code'     => 40003,
            'metadata' => null,
        ], $statusCode);
    }
}
