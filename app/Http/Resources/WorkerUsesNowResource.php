<?php

declare(strict_types=1);

namespace App\Http\Resources;

class WorkerUsesNowResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.worker_now', ['name' => $this->collection->get('worker')['name']]);
    }
}
