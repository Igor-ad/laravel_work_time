<?php

namespace App\Services;

use App\Models\Worker;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use RuntimeException;

class WorkerService
{
    /**
     * @param HistoryRepository $historyRepository
     */
    public function __construct(
        protected HistoryRepository $historyRepository,
    )
    {
    }

    /**
     * @param string $workerName
     * @return Collection
     */
    public function now(string $workerName): Collection
    {
        try {

            return Worker::where('name', $workerName)->first()->machinesNow()->get();

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param string $workerName
     * @return LengthAwarePaginator
     */
    public function history(string $workerName): LengthAwarePaginator
    {
        try {

            return $this->historyRepository->workerHistory($workerName);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
