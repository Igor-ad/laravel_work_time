<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MachineService;
use Illuminate\Http\JsonResponse;

class MachineIndexController extends Controller
{
    use ResponseController;

    /**
     * @param MachineService $machineService
     */
    public function __construct(
        protected MachineService $machineService,
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->key = __('work_time.machines');
        $this->collection = $this->machineService->index();

        return $this->responseCollect();
    }
}
