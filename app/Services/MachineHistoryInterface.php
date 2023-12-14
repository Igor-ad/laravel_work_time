<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface MachineHistoryInterface
{
    public function history(int $machineId): Collection;
}
