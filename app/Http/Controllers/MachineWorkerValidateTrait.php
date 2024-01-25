<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * This Trait is simplified Data Transfer Object
 */
trait MachineWorkerValidateTrait
{
    private readonly string|null $workerName;
    private readonly int|null $machineId;

    protected function validateInput(): void
    {
        $this->workerName = (string)$this->request->input('worker') ?? null;

        $this->machineId = (int)$this->request->input('machine') ?? null;
    }
}
