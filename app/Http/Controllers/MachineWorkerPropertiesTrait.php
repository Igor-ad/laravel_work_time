<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Worker;
use RuntimeException;

trait MachineWorkerPropertiesTrait
{
    use MachineWorkerValidateTrait;

    protected Worker $worker;
    protected Machine $machine;

    /**
     * @return void
     */
    public function setMachine(): void
    {
        $machine = Machine::where('id', $this->machineId)->first();
        $this->exists($machine, __('work_time.machine_not_found', ['id' => $this->machineId]));

        $this->machine = $machine;
    }

    /**
     * @return void
     */
    public function setWorker(): void
    {
        $worker = Worker::where('name', $this->workerName)->first();
        $this->exists($worker, __('work_time.worker_not_found', ['name' => $this->workerName]));

        $this->worker = $worker;
    }

    /**
     * @param Machine|Worker|null $model
     * @param string $message
     * @return void
     */
    private function exists(null|Machine|Worker $model, string $message): void
    {
        if (is_null($model)) {
            throw new RuntimeException(
                message: $message
            );
        }
    }
}
