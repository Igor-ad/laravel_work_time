<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    public function collectionResponse(array|object $collection, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            data: $collection,
            status: $status,
            options: JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
        );
    }
}
