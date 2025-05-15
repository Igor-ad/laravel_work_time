<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Api\AuthException;
use App\Exceptions\Api\BadHttpMethodException;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\ServiceException;
use App\Exceptions\Api\ValidatorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    public function __construct(protected Handler $handler) {}

    public function register(): void
    {
        $this->handler->renderable(function (Throwable $e, $request) {

            return match (true) {
                $e instanceof AuthenticationException && $request->is('api/*')
                => throw new AuthException($e->getMessage()),

                $e instanceof MethodNotAllowedHttpException && $request->is('api/*')
                => throw new BadHttpMethodException($e->getMessage()),

                $e instanceof NotFoundHttpException && $request->is('api/*')
                => throw new NotFoundException(str_replace(
                    search: ['[App\\Models\\', ']'],
                    replace: [': ', ''],
                    subject: $e->getMessage(),
                )),

                $e instanceof ValidatorException && $request->is('api/*')
                => throw new ValidationException($e->validator),

                default => throw new ServiceException($e->getMessage()),
            };

        });
    }
}
