<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\MachineException;

use App\Repositories\MachineRepository;
use Illuminate\Support\Collection;

class MachineService
{
    public function __construct(
        protected MachineRepository $repository,
    ) {}

    /**
     * @throws MachineException
     */
    public function now(int $machineId): Collection
    {
        $machine = $this->repository->statusNow($machineId);

        if (!$machine->getAttribute('worker_id')) {
            throw new MachineException(
                __('work_time.machine_not_use', ['id' => $machineId])
            );
        }
        return collect(['machine' => $machine]);
    }
}
