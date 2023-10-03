<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\Worker;
use App\Repositories\HistoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerService
{
    public function __construct(
        protected HistoryRepository $historyRepository,
    )
    {
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Worker::query()->orderBy('id')->get('name');
    }

    /**
     * @param string $workerName
     * @return Collection
     */
    public function now(string $workerName): Collection
    {
        $worker = Worker::where('name', $workerName)->first();

        return Machine::where('worker_id', $worker->id)->get('id');
    }

    /**
     * @param string $workerName
     * @return LengthAwarePaginator
     */
    public function history(string $workerName): LengthAwarePaginator
    {
        return $this->historyRepository->workerHistory($workerName);
    }
}
