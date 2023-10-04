<?php

namespace App\Services;

use App\Http\Controllers\Api\ModelsTestController;
use App\Http\Requests\Api\MachineRequest;
use App\Models\Machine;
use App\Repositories\HistoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class MachineService
{
    use ModelsTestController;

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
    public function index(): Collection
    {
        return Machine::query()->orderBy('id')->get('id');
    }

    /**
     * @return Collection
     */
    public function now(): Collection
    {
        try {
            $this->testMachine();

            return $this->modelMachine->worker()->get('name');

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
            $this->testMachine();

            return $this->historyRepository->machineHistory($this->modelMachine);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
