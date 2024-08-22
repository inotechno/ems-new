<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'Operation successful', $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function error($message = 'Operation failed', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    public static function validationError($errors, $message = 'Validation errors', $statusCode = 422)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    public static function notFound($message = 'Resource not found', $statusCode = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    public static function unauthorized($message = 'Unauthorized', $statusCode = 401)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    public static function forbidden($message = 'Forbidden', $statusCode = 403)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}
