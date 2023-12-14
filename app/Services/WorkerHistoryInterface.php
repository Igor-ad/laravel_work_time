<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface WorkerHistoryInterface
{
    public function history(string $workerName): LengthAwarePaginator;
}
