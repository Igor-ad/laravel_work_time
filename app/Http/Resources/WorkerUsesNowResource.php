<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class WorkerUsesNowResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.worker_now', ['name' => $this->collection->get('name')]);
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->getMessage(),
            'data' => $this->collection->except('name'),
        ];
    }
}
