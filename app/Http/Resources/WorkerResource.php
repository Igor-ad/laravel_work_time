<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkerResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'message' => __('work_time.workers'),
            'count' => $this->collection->count(),
            'data' => $this->collection,
        ];
    }
}
