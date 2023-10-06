<?php

namespace App\Services;

use App\Http\Controllers\MachineWorkerPropertiesTrait;
use App\Http\Requests\Api\MachineRequest;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class MachineService
{
    use MachineWorkerPropertiesTrait;

    public function __construct(
        protected HistoryRepository $historyRepository,
        protected MachineRequest    $request,
    )
    {
        $this->validateInput();
    }

    /**
     * @return Collection
     */
    public function now(): Collection
    {
        try {
            $this->setMachine();

            return $this->machine->worker()->get('name');

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @return Collection
     */
    public function history(): Collection
    {
        try {
            $this->setMachine();

            return $this->historyRepository->machineHistory($this->machineId);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
