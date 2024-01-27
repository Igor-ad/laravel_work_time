<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\WorkerException;
use App\Models\Worker;
use Illuminate\Support\Collection;

class WorkerService
{
    /**
     * @throws WorkerException
     */
    public function now(string $workerName): Collection
    {
        $worker = Worker::with('machinesNow')
            ->where('name', $workerName)
            ->first();

        if (!$worker->getAttribute('machinesNow')) {
            throw new WorkerException(
                __('work_time.worker_not_busy', ['name' => $workerName])
            );
        }
        return collect(['worker' => $worker]);
    }
}
