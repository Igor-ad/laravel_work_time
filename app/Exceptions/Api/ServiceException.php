<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceException extends Exception
{
    protected int $status = Response::HTTP_NOT_IMPLEMENTED;

    public function render(Request $request): JsonResponse
    {
        return response()->json(
            data: $this->toArray(),
            status: $this->status,
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
