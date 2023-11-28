<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;

class WorkerIndexController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $this->key = __('work_time.workers');
        $this->collection = Worker::query()->orderBy('id')->get('name');

        return $this->responseCollect();
    }
}
