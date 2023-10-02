<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MachineRequest;
use App\Models\Machine;
use App\Repositories\HistoryRepository;
use Illuminate\Http\JsonResponse;

class MachineController extends Controller
{
    use ResponseController, ValidateController;

    /**
     * @param HistoryRepository $historyRepository
     * @param MachineRequest $request
     */
    public function __construct(
        protected HistoryRepository $historyRepository,
        protected MachineRequest    $request,
    )
    {
        $this->validateInput();
    }

    /**
     * @return JsonResponse
     */
    public function now(): JsonResponse
    {
        $this->key = __('work_time.machine_now', ['id' => $this->machine]);
        $this->model = Machine::find($this->machine)->worker()->get('name');

        return $this->responseResource();
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $this->key = __('work_time.machine_history', ['id' => $this->machine]);
        $this->collection = $this->historyRepository->machineHistory($this->machine);

        return $this->responseCollect();
    }
}
