<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\MachineException;

use App\Models\Machine;
use Illuminate\Support\Collection;

class MachineService
{
    /**
     * @throws MachineException
     */
    public function now(int $machineId): Collection
    {
        $machine = Machine::with('worker')
            ->where('id', $machineId)
            ->first();

        if (!$machine->getAttribute('worker_id')) {
            throw new MachineException(
                __('work_time.machine_not_use', ['id' => $machineId])
            );
        }
        return collect(['machine' => $machine]);
    }
}
