<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WorkerService;
use Illuminate\Http\JsonResponse;

class WorkerIndexController extends Controller
{
    use ResponseController;

    /**
     * @param WorkerService $workerService
     */
    public function __construct(
        protected WorkerService $workerService,
    )
    {
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->key = __('work_time.workers');
        $this->collection = $this->workerService->index();

        return $this->responseCollect();
    }
}
