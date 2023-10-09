<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerPropertiesTrait;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Api\MachineRequest;
use App\Services\MachineService;
use Exception;
use Illuminate\Http\JsonResponse;

class MachineController extends Controller
{
    use ResponseTrait, MachineWorkerPropertiesTrait;

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
        $this->setMachine();
    }

    /**
     * @return JsonResponse
     */
    public function now(): JsonResponse
    {
        $this->key = __('work_time.machine_now', ['id' => $this->machineId]);
        try {

            $this->model = $this->machineService->now($this->machineId);

        } catch (Exception $e) {
            $this->setProp($e->getMessage());

            return $this->responseError();
        }

        return $this->responseResource();
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $this->key = __('work_time.machine_history', ['id' => $this->machineId]);
        try {

            $this->collection = $this->machineService->history($this->machineId);

        } catch (Exception $e) {
            $this->setProp($e->getMessage());

            return $this->responseError();
        }
        return $this->responseCollect();
    }

    private function setProp(string $message): void
    {
        $this->key = __('work_time.error');
        $this->model = collect(['machine' => $this->machineId, 'msg' => $message]);
    }
}
