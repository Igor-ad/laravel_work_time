<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends ServiceException
{
    protected int $status = Response::HTTP_NOT_FOUND;
}
