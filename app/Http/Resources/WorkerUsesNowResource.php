<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkerUsesNowResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'message' => __('work_time.worker_now', ['name' => $this->collection->get('name')]),
            'data' => $this->collection->except('name'),
        ];
    }
}
