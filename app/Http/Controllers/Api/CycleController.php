<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CycleRequest;
use App\Services\CycleService;
use Exception;
use Illuminate\Http\JsonResponse;

class CycleController extends Controller
{
    use ResponseController, ValidateController;

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
            $this->key = __('work_time.error');
            $this->model = collect($this->toArray($e->getMessage()));

            return $this->responseError();
        }
        $this->key = __('work_time.message');
        $this->model = collect($this->toArray(__('work_time.start_cycle')));
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
            $this->key = __('work_time.error');
            $this->model = collect($this->toArray($e->getMessage()));

            return $this->responseError();
        }
        $this->key = __('work_time.message');
        $this->model = collect($this->toArray(__('work_time.end_cycle')));

        return $this->responseCreate();
    }

    /**
     * @param string $message
     * @return array
     */
    protected function toArray(string $message): array
    {
        return [
            'machine' => $this->machine,
            'worker' => $this->worker,
            'msg' => $message,
        ];
    }
}
