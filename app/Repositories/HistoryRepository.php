<?php

namespace App\Repositories;

use App\Models\Cycle;
use App\Models\History;
use App\Models\Machine;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryRepository
{
    /**
     * @param Worker $worker
     * @param Machine $machine
     * @param Cycle $cycle
     * @return History|null
     */
    public function create(Worker $worker, Machine $machine, Cycle $cycle): ?History
    {
        return History::create([
            'worker_id' => $worker->getAttribute('id'),
            'machine_id' => $machine->getAttribute('id'),
            'cycle_id' => $cycle->getAttribute('id'),
        ]);
    }

    /**
     * @param Machine $machine
     * @return Collection|null
     */
    public function machineHistory(Machine $machine): ?Collection
    {
        return History::join('machines', 'machines.id', 'histories.machine_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('workers', 'workers.id', 'histories.worker_id')
            ->where('machines.id', $machine->getAttribute('id'))
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
     * @param Worker $worker
     * @return LengthAwarePaginator|null
     */
    public function workerHistory(Worker $worker): ?LengthAwarePaginator
    {
        return History::join('workers', 'workers.id', 'histories.worker_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('machines', 'machines.id', 'histories.machine_id')
            ->where('workers.name', $worker->getAttribute('name'))
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
     * @param Machine $machine
     * @param Worker $worker
     * @return History|null
     */
    public function cycleIdToUse(Machine $machine, Worker $worker): ?History
    {
        return History::join('machines', 'machines.id', 'histories.machine_id')
            ->join('cycles', 'cycles.id', 'histories.cycle_id')
            ->join('workers', 'workers.id', 'histories.worker_id')
            ->where('machines.id', $machine->getAttribute('id'))
            ->where('workers.id', $worker->getAttribute('id'))
            ->where('cycles.complete', 0)
            ->select('cycles.id')
            ->first();
    }
}
