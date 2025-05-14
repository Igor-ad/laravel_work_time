<?php

declare(strict_types=1);

namespace App\Http\Controllers;

trait MachineWorkerValidateTrait
{
    private readonly string|null $workerName;
    private readonly int|null $machineId;

    private function validateInput(): void
    {
        $this->workerName = (string)$this->request->input('worker') ?? null;

        $this->machineId = (int)$this->request->input('machine') ?? null;
    }
}
