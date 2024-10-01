<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public function success(array $data, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    public function error(string $message = "Hata"): JsonResponse
    {
        return response()->json([
            'error' => 'Internal Server Error',
            'message' => $message
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
