<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\MachineException;
use App\Models\Cycle;
use App\Models\History;
use App\Models\Machine;
use App\Models\Worker;
use App\Repositories\HistoryRepository;

class CycleService
{
    public function __construct(
        protected HistoryRepository $history,
    )
    {
    }

    public function start(int $machineId, string $workerName): void
    {
        $this->startConditions($machineId);
        $this->startCycle($machineId, $workerName);
    }

    public function end(int $machineId, string $workerName): void
    {
        $history = $this->endConditions($machineId, $workerName);
        $this->endCycle($history, $machineId);
    }

    private function startConditions(int $machineId): void
    {
        $used = Machine::find($machineId)->worker()->first();

        if ($used) {
            throw new MachineException(
                __('work_time.start_fail', ['id' => $machineId])
            );
        }
    }

    private function startCycle(int $machineId, string $workerName): void
    {
        $worker = Worker::where('name', $workerName)->first();
        Machine::find($machineId)->update(['worker_id' => $worker->id]);
        $cycle = Cycle::create();

        $this->history->create($worker->id, $machineId, $cycle->id);
    }

    private function endConditions(int $machineId, string $workerName): History
    {
        $history = $this->history->cycleIdToUse($machineId, $workerName);

        if (!$history) {
            throw new MachineException(
                __('work_time.end_fail', ['id' => $machineId])
            );
        }
        return $history;
    }

    private function endCycle(History $history, int $machineId): void
    {
        Cycle::find($history->getAttribute('id'))->update(['complete' => true]);
        Machine::find($machineId)->update(['worker_id' => null]);
    }
}
