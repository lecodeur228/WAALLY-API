<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Retourne une réponse JSON avec succès.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = '', $statusCode = 200)
    {
        if($data == null) {   return response()->json([
            'status' => true,
            'message' => $message,

        ], $statusCode);
    } else  {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
    }

    /**
     * Retourne une réponse JSON avec une erreur.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = '', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
