<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\WorkerException;
use App\Repositories\WorkerRepository;
use Illuminate\Support\Collection;

class WorkerService
{
    public function __construct(
        protected WorkerRepository $repository,
    ) {}

    /**
     * @throws WorkerException
     */
    public function now(string $workerName): Collection
    {
        $worker = $this->repository->statusNow($workerName);

        if (!$worker->getAttribute('machinesNow')) {
            throw new WorkerException(
                __('work_time.worker_not_busy', ['name' => $workerName])
            );
        }
        return collect(['worker' => $worker]);
    }
}
