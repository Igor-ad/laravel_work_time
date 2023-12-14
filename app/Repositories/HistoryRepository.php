<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\History;
use App\Models\Machine;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryRepository
{
    public function cycleIdToUse(int $machineId, string $workerName): ?History
    {
        return History::join('machines', 'machines.id', 'histories.machine_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('workers', 'workers.id', 'histories.worker_id')
            ->where('machines.id', $machineId)
            ->where('workers.name', $workerName)
            ->where('cycles.complete', false)
            ->select('cycles.id')
            ->first();
    }

    public function create(int $workerId, int $machineId, int $cycleId): ?History
    {
        return History::create([
            'worker_id' => $workerId,
            'machine_id' => $machineId,
            'cycle_id' => $cycleId,
        ]);
    }

    public function machineCycleRelationHistory(int $machineId): Collection
    {
        return Machine::find($machineId)
            ->cycles()
            ->select('id', 'created_at as start', 'updated_at as end', 'complete')
            ->get();
    }

    public function machineHistory(int $machineId): Collection
    {
        return History::join('machines', 'machines.id', 'histories.machine_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('workers', 'workers.id', 'histories.worker_id')
            ->where('machines.id', $machineId)
            ->select(
                'workers.name as worker',
                'cycles.created_at as start',
                'cycles.updated_at as end',
                'cycles.complete'
            )
            ->orderBy('cycles.id', 'desc')
            ->get();
    }

    public function machineRelationHistory(int $machineId): Collection
    {
        return History::with(['cycles.workers'])
            ->select('worker_id', 'cycle_id')
            ->where('machine_id', $machineId)
            ->get();
    }

    public function workerHistory(string $workerName): LengthAwarePaginator
    {
        return History::join('workers', 'workers.id', 'histories.worker_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('machines', 'machines.id', 'histories.machine_id')
            ->where('workers.name', $workerName)
            ->select(
                'machines.id as machine',
                'cycles.created_at as start',
                'cycles.updated_at as end',
                'cycles.complete'
            )
            ->orderBy('cycles.id', 'desc')
            ->paginate(request('per_page'));
    }

    public function workerRelationHistory(string $workerName): LengthAwarePaginator
    {
        return Worker::where('name', $workerName)->first()
            ->cycles()
            ->paginate(request('per_page', 10));
    }
}
