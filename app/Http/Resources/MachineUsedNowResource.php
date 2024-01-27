<?php

declare(strict_types=1);

namespace App\Http\Resources;

class MachineUsedNowResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.machine_now', ['id' => $this->collection->get('machine')['id']]);
    }
}
