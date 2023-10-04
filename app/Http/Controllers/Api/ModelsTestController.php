<?php

namespace App\Http\Controllers\Api;

use App\Models\Machine;
use App\Models\Worker;
use RuntimeException;

trait ModelsTestController
{
    use ValidateController;

    protected Worker $modelWorker;
    protected Machine $modelMachine;

    /**
     * @return void
     */
    public function testMachine(): void
    {
        $machine = Machine::where('id', $this->machine)->first();

        if (is_null($machine)) {
            throw new RuntimeException(
                message: __('work_time.machine_not_found', ['id' => $this->machine])
            );
        }
        $this->modelMachine = $machine;
    }

    /**
     * @return void
     */
    public function testWorker(): void
    {
        $worker = Worker::where('name', $this->worker)->first();

        if (is_null($worker)) {
            throw new RuntimeException(
                message: __('work_time.worker_not_found', ['name' => $this->worker])
            );
        }
        $this->modelWorker = $worker;
    }
}
