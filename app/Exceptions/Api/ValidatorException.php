<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidatorException extends ValidationException
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            data: [
                'errors' => $this->validator->errors(),
            ],
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
            options: JSON_PRETTY_PRINT,
        );
    }
}
