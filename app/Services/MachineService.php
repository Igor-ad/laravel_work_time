<?php

namespace App\Services;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Collection;

class MachineService
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Machine::query()->orderBy('id')->get('id');
    }
}
