<?php

namespace App\Services;

use App\Models\Machine;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class MachineService
{
    public function __construct(
        protected HistoryRepository $historyRepository,
    )
    {
    }

    public function now(int $machineId): Collection
    {
        try {

            return Machine::find($machineId)->worker()->get('name');

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function history(int $machineId): Collection
    {
        try {

            return $this->historyRepository->machineHistory($machineId);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
