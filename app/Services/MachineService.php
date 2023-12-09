<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\MachineException;
use App\Models\Machine;
use App\Repositories\HistoryRepository;
use Illuminate\Database\Eloquent\Collection;

class MachineService
{
    public function __construct(
        protected HistoryRepository $history,
    )
    {
    }

    public function now(int $machineId): Collection
    {
        $collection = Machine::find($machineId)->worker()->get('name');

        if (!$collection->value('name')) {
            throw new MachineException(
                __('work_time.machine_not_use', ['id' => $machineId])
            );
        }
        return $collection;
    }

    public function history(int $machineId): Collection
    {
        $collection = $this->history->machineHistory($machineId);

        if (!$collection->toArray()) {
            throw new MachineException(
                __('work_time.machine_history_fail', ['id' => $machineId])
            );
        }
        return $collection;
    }
}
