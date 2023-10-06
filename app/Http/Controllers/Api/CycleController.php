<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerValidateTrait;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Api\CycleRequest;
use App\Services\CycleService;
use Exception;
use Illuminate\Http\JsonResponse;

class CycleController extends Controller
{
    use ResponseTrait, MachineWorkerValidateTrait;

    /**
     * @param CycleService $cycleService
     * @param CycleRequest $request
     */
    public function __construct(
        protected CycleService $cycleService,
        protected CycleRequest $request,
    )
    {
        $this->validateInput();
    }

    /**
     * @return JsonResponse
     */
    public function start(): JsonResponse
    {
        try {

            $this->cycleService->start();

        } catch (Exception $e) {
            $this->setProp(__('work_time.error'), $e->getMessage());

            return $this->responseError();
        }
        $this->setProp(__('work_time.message'), __('work_time.start_cycle'));

        return $this->responseCreate();
    }

    /**
     * @return JsonResponse
     */
    public function end(): JsonResponse
    {
        try {

            $this->cycleService->end();

        } catch (Exception $e) {
            $this->setProp(__('work_time.error'), $e->getMessage());

            return $this->responseError();
        }
        $this->setProp(__('work_time.message'), __('work_time.end_cycle'));

        return $this->responseResource();
    }

    /**
     * @param string $key
     * @param string $message
     * @return void
     */
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
