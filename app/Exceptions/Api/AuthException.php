<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Illuminate\Http\Response;

class AuthException extends ServiceException
{
    protected int $status = Response::HTTP_UNAUTHORIZED;
}
