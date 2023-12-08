<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerValidateTrait;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Api\WorkerRequest;
use App\Http\Resources\WorkerJobHistoryResource;
use App\Http\Resources\WorkerUsesNowResource;
use App\Services\WorkerService;
use Illuminate\Http\JsonResponse;

class WorkerController extends Controller
{
    use ResponseTrait, MachineWorkerValidateTrait;

    public function __construct(
        protected WorkerRequest $request,
        protected WorkerService $workerService,
    )
    {
        $this->validateInput();
    }

    public function now(): JsonResponse
    {
        $collection = $this->workerService->now($this->workerName);
        $collection->put('name', $this->workerName);

        return $this->collectionResponse(
            new WorkerUsesNowResource($collection)
        );
    }

    public function history(): JsonResponse
    {
        $collection = $this->workerService->history($this->workerName);
        $collection->put('name', $this->workerName);

        return $this->collectionResponse(
            new WorkerJobHistoryResource($collection),
        );
    }
}
