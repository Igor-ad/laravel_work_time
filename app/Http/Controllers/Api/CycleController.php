<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerValidateTrait;
use App\Http\Requests\Api\CycleRequest;
use App\Http\Resources\CycleEndResource;
use App\Http\Resources\CycleStartResource;
use App\Services\CycleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class CycleController extends Controller
{
    use MachineWorkerValidateTrait;

    public function __construct(
        protected CycleService $cycleService,
        protected CycleRequest $request,
    )
    {
        $this->validateInput();
    }

    public function start(): JsonResponse
    {
        $this->cycleService->start($this->machineId, $this->workerName);

        return $this->apiResponse(
            new CycleStartResource($this->toCollect()),
            Response::HTTP_CREATED
        );
    }

    public function end(): JsonResponse
    {
        $this->cycleService->end($this->machineId, $this->workerName);

        return $this->apiResponse(
            new CycleEndResource($this->toCollect()),
        );
    }

    public function toCollect(): Collection
    {
        return collect([
            'machine' => $this->machineId,
            'worker' => $this->workerName,
        ]);
    }
}
