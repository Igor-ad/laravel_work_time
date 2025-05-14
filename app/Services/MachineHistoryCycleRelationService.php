<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\MachineException;
use App\Repositories\MachineRepository;
use Illuminate\Database\Eloquent\Collection;

class MachineHistoryCycleRelationService implements MachineHistoryInterface
{
    public function __construct(
        protected MachineRepository $repository,
    ) {
    }

    /**
     * @throws MachineException
     */
    public function history(int $machineId): Collection
    {
        $data = $this->repository->cycleRelationHistory($machineId);

        if (!$data->toArray()) {
            throw new MachineException(
                __('work_time.machine_history_fail', ['id' => $machineId])
            );
        }
        return $data;
    }
}
