<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MachineUsedNowResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.machine_now', ['id' => $this->collection->get('id')]);
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->getMessage(),
            'data' => $this->collection->except('id'),
        ];
    }
}
