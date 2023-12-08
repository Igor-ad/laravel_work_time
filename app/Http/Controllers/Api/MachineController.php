<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerValidateTrait;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Api\MachineRequest;
use App\Http\Resources\MachineUsageHistoryResource;
use App\Http\Resources\MachineUsedNowResource;
use App\Services\MachineService;
use Illuminate\Http\JsonResponse;

class MachineController extends Controller
{
    use ResponseTrait, MachineWorkerValidateTrait;

    public function __construct(
        protected MachineService $machineService,
        protected MachineRequest $request,
    )
    {
        $this->validateInput();
    }

    public function now(): JsonResponse
    {
        $collection = $this->machineService->now($this->machineId);
        $collection->put('id', $this->machineId);

        return $this->collectionResponse(
            new MachineUsedNowResource($collection)
        );
    }

    public function history(): JsonResponse
    {
        $collection = $this->machineService->history($this->machineId);
        $collection->put('id', $this->machineId);

        return $this->collectionResponse(
            new MachineUsageHistoryResource($collection),
        );
    }
}
