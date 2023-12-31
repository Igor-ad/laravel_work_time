<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MachineUsedNowResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'message' => __('work_time.machine_now', ['id' => $this->collection->get('id')]),
            'data' => $this->collection->except('id'),
        ];
    }
}
