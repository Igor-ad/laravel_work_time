<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\WorkerException;
use App\Repositories\WorkerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerHistoryCycleRelationService implements WorkerHistoryInterface
{
    public function __construct(
        protected WorkerRepository $repository,
    ) {
    }

    /**
     * @throws WorkerException
     */
    public function history(string $workerName): LengthAwarePaginator
    {
        $data = $this->repository->cycleRelationHistory($workerName);

        if (!collect($data)->get('data')) {
            throw new WorkerException(
                __('work_time.worker_history_fail', ['name' => $workerName])
            );
        }
        return $data;
    }
}
