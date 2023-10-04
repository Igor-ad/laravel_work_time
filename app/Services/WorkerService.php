<?php

namespace App\Services;

use App\Http\Controllers\Api\ModelsTestController;
use App\Http\Requests\Api\WorkerRequest;
use App\Models\Machine;
use App\Models\Worker;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use RuntimeException;

class WorkerService
{
    use ModelsTestController;

    public function __construct(
        protected HistoryRepository $historyRepository,
        protected WorkerRequest     $request,
    )
    {
        $this->validateInput();
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Worker::query()->orderBy('id')->get('name');
    }

    /**
     * @return Collection
     */
    public function now(): Collection
    {
        try {
            $this->testWorker();

            return Machine::where('worker_id', $this->modelWorker->getAttribute('id'))->get('id');

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @return LengthAwarePaginator
     */
    public function history(): LengthAwarePaginator
    {
        try {
            $this->testWorker();

            return $this->historyRepository->workerHistory($this->modelWorker);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
