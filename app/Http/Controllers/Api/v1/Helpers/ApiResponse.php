<?php

namespace App\Http\Controllers\Api\v1\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    public static function created($data = null, $message = 'Created')
    {
        return self::success($data, $message, 201);
    }

    public static function error($message = 'Error', $status = 400)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => null
        ], $status);
    }
}
