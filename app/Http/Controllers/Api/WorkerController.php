<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerPropertiesTrait;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Api\WorkerRequest;
use App\Services\WorkerService;
use Exception;
use Illuminate\Http\JsonResponse;

class WorkerController extends Controller
{
    use ResponseTrait, MachineWorkerPropertiesTrait;

    public function __construct(
        protected WorkerRequest $request,
        protected WorkerService $workerService,
    )
    {
        $this->validateInput();
        $this->setWorker();
    }

    public function now(): JsonResponse
    {
        $this->key = __('work_time.worker_now', ['name' => $this->workerName]);
        try {

            $this->model = $this->workerService->now($this->workerName);

        } catch (Exception $e) {
            $this->setProp($e->getMessage());

            return $this->responseError();
        }
        return $this->responseResource();
    }

    public function history(): JsonResponse
    {
        $this->key = __('work_time.worker_history', ['name' => $this->workerName]);
        try {

            $this->collection = $this->workerService->history($this->workerName);

        } catch (Exception $e) {
            $this->setProp($e->getMessage());

            return $this->responseError();
        }
        return $this->paginateCollect();
    }

    private function setProp(string $message): void
    {
        $this->key = __('work_time.error');
        $this->model = collect(['worker' => $this->workerName, 'msg' => $message]);
    }
}
