<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse as Response;

class JsonResponse
{
    public static function success($data = ['success']): Response
    {
        return response()->json($data);
    }

    public static function notFound($data = []): Response
    {
        return response()->json(['error' => $data], Response::HTTP_NOT_FOUND);
    }

    public static function unprocessable($data = ['unprocessable']): Response
    {
        return response()->json(['error' => $data], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
