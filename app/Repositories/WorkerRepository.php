<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerRepository
{
    public function statusNow(string $workerName): Model
    {
        return Worker::with('machinesNow')
            ->where('name', $workerName)
            ->first();
    }

    public function cycleRelationHistory(string $workerName): LengthAwarePaginator
    {
        return Worker::where('name', $workerName)->first()
            ->cycles()
            ->with(['machines'])
            ->orderBy('id')
            ->paginate(request('per_page', 10));
    }
}
