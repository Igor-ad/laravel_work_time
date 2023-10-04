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
        $this->testMachine();
        $this->testWorker();

        $used = $this->modelMachine->worker()->first();

        if ($used) {
            throw new RuntimeException(
                message: __('work_time.start_fail', ['id' => $this->machine])
            );
        }
    }

    /**
     * @return void
     */
    private function startCycle(): void
    {
        $this->modelMachine->update(['worker_id' => $this->modelWorker->getAttribute('id')]);
        $cycle = Cycle::create();

        $this->historyRepository->create($this->modelWorker, $this->machine, $cycle);
    }

    /**
     * @return History
     */
    private function endConditions(): History
    {
        $this->testMachine();
        $this->testWorker();

        $cycleId = $this->historyRepository->cycleIdToUse($this->machine, $this->modelWorker);

        if (!$cycleId) {
            throw new RuntimeException(
                message: __('work_time.end_fail', ['id' => $this->machine])
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
        $this->modelMachine->update(['worker_id' => null]);
    }
}
