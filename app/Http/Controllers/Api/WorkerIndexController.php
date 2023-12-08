<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Resources\WorkerResource;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;

class WorkerIndexController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $collection = Worker::query()->orderBy('id')->get('name');

        return $this->collectionResponse(
            new WorkerResource($collection),
        );
    }
}
