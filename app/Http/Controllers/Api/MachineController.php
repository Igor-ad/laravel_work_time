<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MachineRequest;
use App\Services\MachineService;
use Illuminate\Http\JsonResponse;

class MachineController extends Controller
{
    use ResponseController, ValidateController;

    /**
     * @param MachineService $machineService
     * @param MachineRequest $request
     */
    public function __construct(
        protected MachineService $machineService,
        protected MachineRequest $request,
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
        $this->model = $this->machineService->now($this->machine);

        return $this->responseResource();
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $this->key = __('work_time.machine_history', ['id' => $this->machine]);
        $this->collection = $this->machineService->history($this->machine);

        return $this->responseCollect();
    }
}
