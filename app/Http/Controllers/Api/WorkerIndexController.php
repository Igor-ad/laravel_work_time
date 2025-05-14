<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerResource;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;

class WorkerIndexController extends Controller
{
    public function index(): JsonResponse
    {
        $collection = Worker::query()->orderBy('id')->get();

        return $this->apiResponse(
            new WorkerResource($collection),
        );
    }
}
