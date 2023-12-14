<?php

declare(strict_types=1);


namespace App\Services;

use App\Exceptions\Api\MachineException;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Collection;

class MachineService
{
    public function now(int $machineId): Collection
    {
        $data = Machine::find($machineId)->worker()->get('name');

        if (!$data->value('name')) {
            throw new MachineException(
                __('work_time.machine_not_use', ['id' => $machineId])
            );
        }
        return $data;
    }
}
