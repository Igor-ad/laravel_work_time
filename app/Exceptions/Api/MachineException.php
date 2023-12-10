<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

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
