<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CycleService;
use Illuminate\Http\JsonResponse;

class CycleController extends Controller
{
    /**
     * @param CycleService $cycleService
     */
    public function __construct(
        protected CycleService $cycleService,
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function start(): JsonResponse
    {
        return $this->cycleService->start();
    }

    /**
     * @return JsonResponse
     */
    public function end(): JsonResponse
    {
        return $this->cycleService->end();
    }
}
