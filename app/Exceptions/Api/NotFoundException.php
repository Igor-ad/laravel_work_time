<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Illuminate\Http\Response;

class NotFoundException extends ServiceException
{
    protected int $status = Response::HTTP_NOT_FOUND;
}
