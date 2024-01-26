<?php

declare(strict_types=1);

namespace App\Http\Resources;

class CycleEndResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.end_cycle');
    }
}
