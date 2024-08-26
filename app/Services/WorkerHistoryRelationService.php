<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\WorkerException;
use App\Repositories\HistoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerHistoryRelationService implements WorkerHistoryInterface
{
    public function __construct(
        protected HistoryRepository $history,
    ) {}

    public function history(string $workerName): LengthAwarePaginator
    {
        $data = $this->history->workerRelationHistory($workerName);

        if (!collect($data)->get('data')) {
            throw new WorkerException(
                __('work_time.worker_history_fail', ['name' => $workerName])
            );
        }
        return $data;
    }
}
