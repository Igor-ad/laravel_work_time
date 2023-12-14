<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MachineWorkerValidateTrait;
use App\Http\Requests\Api\MachineRequest;
use App\Http\Resources\MachineUsageHistoryResource;
use App\Http\Resources\MachineUsedNowResource;
use App\Services\MachineHistoryJoinService;
use App\Services\MachineHistoryRelationService;
use App\Services\MachineHistoryCycleRelationService;
use App\Services\MachineService;
use Illuminate\Http\JsonResponse;

class MachineController extends Controller
{
    use MachineWorkerValidateTrait;

    public function __construct(
        protected MachineHistoryJoinService $history,
        protected MachineService            $machineService,
        protected MachineRequest            $request,
    )
    {
        $this->validateInput();
    }

    public function now(): JsonResponse
    {
        $collection = $this->machineService->now($this->machineId);
        $collection->put('id', $this->machineId);

        return $this->apiResponse(
            new MachineUsedNowResource($collection)
        );
    }

    public function history(): JsonResponse
    {
        $collection = $this->history->history($this->machineId);
        $collection->put('id', $this->machineId);

        return $this->apiResponse(
            new MachineUsageHistoryResource($collection),
        );
    }
}
