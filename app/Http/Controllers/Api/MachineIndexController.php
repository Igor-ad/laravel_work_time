<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Resources\MachineResource;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;

class MachineIndexController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $collection = Machine::query()->orderBy('id')->get('id');

        return $this->collectionResponse(
            new MachineResource($collection),
        );
    }
}
