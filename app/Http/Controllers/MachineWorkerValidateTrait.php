<?php

namespace App\Http\Controllers;

/**
 * This Trait is simplified Data Transfer Object
 */
trait MachineWorkerValidateTrait
{
    private readonly string|null $workerName;
    private readonly int|null $machineId;

    /**
     * @return void
     */
    protected function validateInput(): void
    {
        $validData = $this->request->validated();

        $this->workerName = $validData['worker'] ?? null;
        $this->machineId = $validData['machine'] ?? null;
    }
}
