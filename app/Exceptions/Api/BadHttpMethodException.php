<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

class BadHttpMethodException extends ServiceException
{
    protected int $status = Response::HTTP_METHOD_NOT_ALLOWED;
}
