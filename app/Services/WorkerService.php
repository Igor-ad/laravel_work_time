<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CycleServiceException;
use App\Models\Worker;
use App\Repositories\HistoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerService
{
    public function __construct(
        protected HistoryRepository $history,
    )
    {
    }

    public function now(string $workerName): Collection
    {
        $collection = Worker::where('name', $workerName)->first()->machinesNow()->get('id');

        if (!$collection->value('id')) {
            throw new CycleServiceException(
                __('work_time.worker_not_busy', ['name' => $workerName])
            );
        }
        return $collection;
    }

    public function history(string $workerName): LengthAwarePaginator
    {
        $collection = $this->history->workerHistory($workerName);

        if (!$collection->toArray()['data']) {
            throw new CycleServiceException(
                __('work_time.worker_history_fail', ['name' => $workerName])
            );
        }
        return $collection;
    }
}
