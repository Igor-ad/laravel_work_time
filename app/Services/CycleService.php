<?php

namespace App\Services;

use App\Http\Controllers\Api\ValidateController;
use App\Http\Requests\Api\CycleRequest;
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
    use ValidateController;

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

            $this->startCondition();
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

            $this->endCycle($this->endCondition());

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * @return void
     */
    private function startCondition(): void
    {
        $used = Machine::find($this->machine)->worker()->first();

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
        $worker = Worker::where('name', $this->worker)->first();
        Machine::find($this->machine)->update(['worker_id' => $worker->id]);
        $cycle = Cycle::create();

        $this->historyRepository->create($worker, $this->machine, $cycle);
    }

    /**
     * @return History
     */
    private function endCondition(): History
    {
        $worker = Worker::where('name', $this->worker)->first();
        $cycleId = $this->historyRepository->cycleIdToUse($this->machine, $worker);

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
        Machine::find($this->machine)->update(['worker_id' => null]);
    }
}
