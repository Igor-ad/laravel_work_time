<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WorkerRequest;
use App\Services\WorkerService;
use Exception;
use Illuminate\Http\JsonResponse;

class WorkerController extends Controller
{
    use ResponseController, ValidateController;

    /**
     * @param WorkerRequest $request
     * @param WorkerService $workerService
     */
    public function __construct(
        protected WorkerRequest $request,
        protected WorkerService $workerService,
    )
    {
        $this->validateInput();
    }

    /**
     * @return JsonResponse
     */
    public function now(): JsonResponse
    {
        $this->key = __('work_time.worker_now', ['name' => $this->workerName]);
        try {

            $this->model = $this->workerService->now();

        } catch (Exception $e) {
            $this->key = __('work_time.error');
            $this->model = collect(['worker' => $this->workerName, 'msg' => $e->getMessage()]);

            return $this->responseError();
        }
        return $this->responseResource();
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $this->key = __('work_time.worker_history', ['name' => $this->workerName]);
        try {

            $this->collection = $this->workerService->history();

        } catch (Exception $e) {
            $this->key = __('work_time.error');
            $this->model = collect(['worker' => $this->workerName, 'msg' => $e->getMessage()]);

            return $this->responseError();
        }
        return $this->paginateCollect();
    }
}
