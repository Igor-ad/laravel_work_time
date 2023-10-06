<?php

namespace App\Http\Controllers\Api;

use App\Models\Machine;
use App\Models\Worker;
use RuntimeException;

trait ModelsTestController
{
    use ValidateController;

    protected Worker $worker;
    protected Machine $machine;

    /**
     * @return void
     */
    public function getMachine(): void
    {
        $machine = Machine::where('id', $this->machineId)->first();

        if (is_null($machine)) {
            throw new RuntimeException(
                message: __('work_time.machine_not_found', ['id' => $this->machineId])
            );
        }
        $this->machine = $machine;
    }

    /**
     * @return void
     */
    public function getWorker(): void
    {
        $worker = Worker::where('name', $this->workerName)->first();

        if (is_null($worker)) {
            throw new RuntimeException(
                message: __('work_time.worker_not_found', ['name' => $this->workerName])
            );
        }
        $this->worker = $worker;
    }
}
