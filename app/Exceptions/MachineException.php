<?php

declare(strict_types=1);

namespace App\Exceptions;

class MachineException extends ServiceException
{
    public function toArray(): array
    {
        return [
            'errors' => [
                'machine' => $this->getMessage(),
            ]
        ];
    }
}
