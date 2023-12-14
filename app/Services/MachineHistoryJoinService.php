<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\MachineException;
use App\Repositories\HistoryRepository;
use Illuminate\Database\Eloquent\Collection;

class MachineHistoryJoinService implements MachineHistoryInterface
{
    public function __construct(
        protected HistoryRepository $history,
    )
    {
    }

    public function history(int $machineId): Collection
    {
        $data = $this->history->machineHistory($machineId);

        if (!$data->toArray()) {
            throw new MachineException(
                __('work_time.machine_history_fail', ['id' => $machineId])
            );
        }
        return $data;
    }
}
