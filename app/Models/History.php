<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class History extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'worker_id',
        'machine_id',
        'cycle_id',
    ];

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(
            Worker::class,
            'histories',
            'worker_id',
            'worker_id',
            'worker_id',
            'id',
        );
    }

    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(
            Machine::class,
            'histories',
            'machine_id',
            'machine_id',
            'machine_id',
            'id',
        );
    }

    public function cycles(): BelongsToMany
    {
        return $this->belongsToMany(
            Cycle::class,
            'histories',
            'cycle_id',
            'cycle_id',
            'cycle_id',
            'id',
        );
    }
}
