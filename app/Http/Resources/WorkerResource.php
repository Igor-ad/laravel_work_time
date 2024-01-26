<?php

declare(strict_types=1);

namespace App\Http\Resources;

class WorkerResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.workers');
    }
}
