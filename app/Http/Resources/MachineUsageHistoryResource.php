<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MachineUsageHistoryResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'message' => __('work_time.machine_history', ['id' => $this->collection->get('id')]),
            'count' => $this->collection->count(),
            'data' => $this->collection->except('id'),
        ];
    }
}
