<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            data: $this->toArray(),
            status: Response::HTTP_NOT_IMPLEMENTED,
            options: JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
        );
    }

    public function toArray(): array
    {
        return [
            'errors' => $this->getMessage(),
        ];
    }
}
