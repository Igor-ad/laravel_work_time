<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;

class MachineIndexController extends Controller
{
    use ResponseController;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->key = __('work_time.machines');
        $this->collection = Machine::query()->orderBy('id')->get('id');

        return $this->responseCollect();
    }
}
