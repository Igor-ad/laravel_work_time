<?php

namespace App\Exceptions;

use App\Exceptions\Api\AuthException;
use App\Exceptions\Api\BadHttpMethodException;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\ValidatorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {

            if ($e instanceof AuthenticationException && $request->is('api/*')) {
                throw new AuthException($e->getMessage());
            }

            if ($e instanceof NotFoundHttpException && $request->is('api/*')) {
                throw new NotFoundException($e->getMessage(), $e->getStatusCode());
            }

            if ($e instanceof MethodNotAllowedHttpException && $request->is('api/*')) {
                throw new BadHttpMethodException($e->getMessage());
            }

            if ($e instanceof ValidationException && $request->is('api/*')) {
                throw new ValidatorException($e->validator);
            }

        });
    }
}
