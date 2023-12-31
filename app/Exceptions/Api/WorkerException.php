<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

class WorkerException extends ServiceException
{
    public function toArray(): array
    {
        return [
            'errors' => [
                'worker' => $this->getMessage(),
            ]
        ];
    }
}
