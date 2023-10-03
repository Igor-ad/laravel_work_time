<?php

namespace App\Services;

use App\Models\Machine;
use App\Repositories\HistoryRepository;
use Illuminate\Database\Eloquent\Collection;

class MachineService
{
    public function __construct(
        protected HistoryRepository $historyRepository,
    )
    {
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Machine::query()->orderBy('id')->get('id');
    }

    /**
     * @param int $machineId
     * @return Collection
     */
    public function now(int $machineId): Collection
    {
        return Machine::find($machineId)->worker()->get('name');
    }

    /**
     * @param int $machineId
     * @return Collection
     */
    public function history(int $machineId): Collection
    {
        return $this->historyRepository->machineHistory($machineId);
    }
}
