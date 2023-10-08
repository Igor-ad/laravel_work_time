<?php

namespace App\Services;

use App\Http\Controllers\MachineWorkerPropertiesTrait;
use App\Http\Requests\Api\WorkerRequest;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use RuntimeException;

class WorkerService
{
    use MachineWorkerPropertiesTrait;

    /**
     * @param HistoryRepository $historyRepository
     * @param WorkerRequest $request
     */
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
    public function now(): Collection
    {
        try {
            $this->setWorker();

            return $this->worker->machinesNow()->get('id');

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
            $this->setWorker();

            return $this->historyRepository->workerHistory($this->workerName);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
