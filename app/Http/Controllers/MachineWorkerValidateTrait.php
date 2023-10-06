<?php

namespace App\Http\Controllers;

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
