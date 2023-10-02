<?php

namespace App\Repositories;

use App\Models\Cycle;
use App\Models\History;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryRepository
{
    /**
     * @param Worker $worker
     * @param int $id
     * @param Cycle $cycle
     * @return History|null
     */
    public function create(Worker $worker, int $id, Cycle $cycle): ?History
    {
        return History::create([
            'worker_id' => $worker->getAttribute('id'),
            'machine_id' => $id,
            'cycle_id' => $cycle->getAttribute('id'),
        ]);
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public function machineHistory(int $id): ?Collection
    {
        return History::join('machines', 'machines.id', 'histories.machine_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('workers', 'workers.id', 'histories.worker_id')
            ->where('machines.id', $id)
            ->select(
                'workers.name as worker',
                'cycles.created_at as start',
                'cycles.updated_at as end',
                'cycles.complete'
            )
            ->orderBy('cycles.id', 'desc')
            ->get();
    }

    /**
     * @param string $name
     * @return LengthAwarePaginator|null
     */
    public function workerHistory(string $name): ?LengthAwarePaginator
    {
        return History::join('workers', 'workers.id', 'histories.worker_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('machines', 'machines.id', 'histories.machine_id')
            ->where('workers.name', $name)
            ->select(
                'machines.id as machine',
                'cycles.created_at as start',
                'cycles.updated_at as end',
                'cycles.complete'
            )
            ->orderBy('cycles.id', 'desc')
            ->paginate(request('per_page'));
    }

    /**
     * @param int $id
     * @param Worker $worker
     * @return History|null
     */
    public function cycleIdToUse(int $id, Worker $worker): ?History
    {
        return History::join('machines', 'machines.id', 'histories.machine_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('workers', 'workers.id', 'histories.worker_id')
            ->where('machines.id', $id)
            ->where('workers.id', $worker->getAttribute('id'))
            ->where('cycles.complete', 0)
            ->select('cycles.id')
            ->first();
    }
}
