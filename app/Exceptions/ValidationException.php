<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends Exception
{
    public function __construct(protected array $data = [])
    {
        
    }

    public function render(): JsonResponse
    {
        return \response()->json([
            "message" => __('Lütfen alanları kontrol ediniz!'),
            "errors" => $this->data,
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
