<?php

namespace App\Services;

use App\Models\Cycle;
use App\Models\History;
use App\Models\Machine;
use App\Models\Worker;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CycleService
{
    public function __construct(
        protected HistoryRepository $historyRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function start(int $machineId, string $workerName): void
    {
        DB::beginTransaction();
        try {

            $this->startConditions($machineId);
            $this->startCycle($machineId, $workerName);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * @throws Exception
     */
    public function end(int $machineId, string $workerName): void
    {
        DB::beginTransaction();
        try {

            $history = $this->endConditions($machineId, $workerName);
            $this->endCycle($history, $machineId);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    private function startConditions(int $machineId): void
    {
        $used = Machine::find($machineId)->worker()->first();

        if ($used) {
            throw new RuntimeException(
                message: __('work_time.start_fail', ['id' => $machineId])
            );
        }
    }

    private function startCycle(int $machineId, string $workerName): void
    {
        $worker = Worker::where('name', $workerName)->first();
        Machine::find($machineId)->update(['worker_id' => $worker->id]);
        $cycle = Cycle::create();

        $this->historyRepository->create($worker->id, $machineId, $cycle->id);
    }

    private function endConditions(int $machineId, string $workerName): History
    {
        $history = $this->historyRepository->cycleIdToUse($machineId, $workerName);

        if (!$history) {
            throw new RuntimeException(
                message: __('work_time.end_fail', ['id' => $machineId])
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
