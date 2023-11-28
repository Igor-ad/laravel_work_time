<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerPropertiesTrait;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Api\CycleRequest;
use App\Services\CycleService;
use Exception;
use Illuminate\Http\JsonResponse;

class CycleController extends Controller
{
    use ResponseTrait, MachineWorkerPropertiesTrait;

    public function __construct(
        protected CycleService $cycleService,
        protected CycleRequest $request,
    )
    {
        $this->validateInput();
        $this->setMachine();
        $this->setWorker();
    }

    public function start(): JsonResponse
    {
        try {

            $this->cycleService->start($this->machineId, $this->workerName);

        } catch (Exception $e) {
            $this->setProp(__('work_time.error'), $e->getMessage());

            return $this->responseError();
        }
        $this->setProp(__('work_time.message'), __('work_time.start_cycle'));

        return $this->responseCreate();
    }

    public function end(): JsonResponse
    {
        try {

            $this->cycleService->end($this->machineId, $this->workerName);

        } catch (Exception $e) {
            $this->setProp(__('work_time.error'), $e->getMessage());

            return $this->responseError();
        }
        $this->setProp(__('work_time.message'), __('work_time.end_cycle'));

        return $this->responseResource();
    }

    private function setProp(string $key, string $message): void
    {
        $this->key = $key;
        $this->model = collect([
            'machine' => $this->machineId,
            'worker' => $this->workerName,
            'msg' => $message,
        ]);
    }
}
