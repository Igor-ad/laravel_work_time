<?php

namespace App\Services;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;

class WorkerService
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Worker::query()->orderBy('id')->get('name');
    }
}
