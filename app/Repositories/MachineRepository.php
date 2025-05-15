<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MachineRepository
{
    public function statusNow(int $machineId): Model
    {
        return Machine::with('worker')
            ->where('id', $machineId)
            ->first();
    }

    public function cycleRelationHistory(int $machineId): Collection
    {
        return Machine::find($machineId)
            ->cycles()
            ->with(['workers'])
            ->get();
    }
}
