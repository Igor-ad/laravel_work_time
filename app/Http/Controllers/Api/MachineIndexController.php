<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;

class MachineIndexController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $this->key = __('work_time.machines');
        $this->collection = Machine::query()->orderBy('id')->get('id');

        return $this->responseCollect();
    }
}
