<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\WorkerException;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;

class WorkerService
{
    public function now(string $workerName): Collection
    {
        $data = Worker::where('name', $workerName)->first()->machinesNow()->get('id');

        if (!$data->value('id')) {
            throw new WorkerException(
                __('work_time.worker_not_busy', ['name' => $workerName])
            );
        }
        return $data;
    }
}
