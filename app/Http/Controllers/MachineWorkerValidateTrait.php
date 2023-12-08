<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

/**
 * This Trait is simplified Data Transfer Object
 */
trait MachineWorkerValidateTrait
{
    private readonly string|null $workerName;
    private readonly int|null $machineId;

    protected function validateInput(): void
    {
        $validData = $this->request->validated();

        $this->workerName = Arr::exists($validData, 'worker') ? (string)$validData['worker'] : null;
        $this->machineId = Arr::exists($validData, 'machine') ? (int)$validData['machine'] : null;
    }
}
