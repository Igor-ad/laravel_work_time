<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerValidateTrait;
use App\Http\Requests\Api\WorkerRequest;
use App\Http\Resources\WorkerJobHistoryResource;
use App\Http\Resources\WorkerUsesNowResource;
use App\Services\WorkerHistoryJoinService;
use App\Services\WorkerHistoryRelationService;
use App\Services\WorkerService;
use Illuminate\Http\JsonResponse;

class WorkerController extends Controller
{
    use MachineWorkerValidateTrait;

    public function __construct(
        protected WorkerHistoryJoinService $history,
        protected WorkerService            $workerService,
        protected WorkerRequest            $request,
    )
    {
        $this->validateInput();
    }

    public function now(): JsonResponse
    {
        $data = $this->workerService->now($this->workerName);
        $data->put('name', $this->workerName);

        return $this->apiResponse(
            new WorkerUsesNowResource($data)
        );
    }

    public function history(): JsonResponse
    {
        $data = $this->history->history($this->workerName);
        $data->put('name', $this->workerName);

        return $this->apiResponse(
            new WorkerJobHistoryResource($data),
        );
    }
}
