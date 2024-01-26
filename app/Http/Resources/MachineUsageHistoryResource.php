<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MachineUsageHistoryResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.machine_history', ['id' => $this->collection->get('id')]);
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->getMessage(),
            'count' => $this->collection->except('id')->count(),
            'data' => $this->collection->except('id'),
        ];
    }
}
