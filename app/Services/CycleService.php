<?php

namespace App\Services;

use App\Http\Controllers\Api\ModelsTestController;
use App\Http\Requests\Api\CycleRequest;
use App\Models\Cycle;
use App\Models\History;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CycleService
{
    use ModelsTestController;

    /**
     * @param HistoryRepository $historyRepository
     * @param CycleRequest $request
     */
    public function __construct(
        protected HistoryRepository $historyRepository,
        protected CycleRequest      $request,
    )
    {
        $this->validateInput();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function start(): void
    {
        DB::beginTransaction();
        try {

            $this->startConditions();
            $this->startCycle();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function end(): void
    {
        DB::beginTransaction();
        try {

            $this->endCycle($this->endConditions());

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * @return void
     */
    private function startConditions(): void
    {
        $this->getMachine();
        $this->getWorker();

        $used = $this->machine->worker()->first();

        if ($used) {
            throw new RuntimeException(
                message: __('work_time.start_fail', ['id' => $this->machineId])
            );
        }
    }

    /**
     * @return void
     */
    private function startCycle(): void
    {
        $this->machine->update(['worker_id' => $this->worker->getAttribute('id')]);
        $cycle = Cycle::create();

        $this->historyRepository->create($this->worker, $this->machine, $cycle);
    }

    /**
     * @return History
     */
    private function endConditions(): History
    {
        $this->getMachine();
        $this->getWorker();

        $cycleId = $this->historyRepository->cycleIdToUse($this->machine, $this->worker);

        if (!$cycleId) {
            throw new RuntimeException(
                message: __('work_time.end_fail', ['id' => $this->machineId])
            );
        }
        return $cycleId;
    }

    /**
     * @param History $history
     * @return void
     */
    private function endCycle(History $history): void
    {
        Cycle::find($history->getAttribute('id'))->update(['complete' => 1]);
        $this->machine->update(['worker_id' => null]);
    }
}
