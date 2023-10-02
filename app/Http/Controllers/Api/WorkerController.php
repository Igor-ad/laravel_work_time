<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WorkerRequest;
use App\Models\Machine;
use App\Models\Worker;
use App\Repositories\HistoryRepository;
use Illuminate\Http\JsonResponse;

class WorkerController extends Controller
{
    use ResponseController, ValidateController;

    public function __construct(
        protected HistoryRepository $historyRepository,
        protected WorkerRequest     $request,
    )
    {
        $this->validateInput();
    }

    /**
     * @return JsonResponse
     */
    public function now(): JsonResponse
    {
        $worker = Worker::where('name', $this->worker)->first();

        $this->key = __('work_time.worker_now', ['name' => $this->worker]);
        $this->model = Machine::where('worker_id', $worker->id)->get('id');

        return $this->responseResource();
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $this->key = __('work_time.worker_history', ['name' => $this->worker]);
        $this->collection = $this->historyRepository->workerHistory($this->worker);

        return $this->paginateCollect();
    }
}
