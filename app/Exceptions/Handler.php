<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
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

            if ($request->is('api/*') && ($e instanceof MethodNotAllowedHttpException)) {
                throw new HttpResponseException(
                    response()->json(
                        data: [
                            'error' => $e->getMessage(),
                        ],
                        status: $e->getStatusCode(),
                        options: JSON_PRETTY_PRINT,
                    )
                );
            }

            if ($request->is('api/*') && ($e instanceof AuthenticationException)) {
                throw new HttpResponseException(
                    response()->json(
                        data: [
                            'error' => $e->getMessage(),
                        ],
                        status: Response::HTTP_UNAUTHORIZED,
                        options: JSON_PRETTY_PRINT,
                    )
                );
            }

            if ($request->is('api/*') && ($e instanceof NotFoundHttpException)) {
                throw new HttpResponseException(
                    response()->json(
                        data: [
                            'error' => $e->getMessage(),
                        ],
                        status: $e->getStatusCode(),
                        options: JSON_PRETTY_PRINT,
                    )
                );
            }
        });
    }
}
