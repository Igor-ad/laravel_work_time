<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Machine extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'worker_id',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'worker_id', 'id');
    }

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'histories');
    }

    public function cycles(): BelongsToMany
    {
        return $this->belongsToMany(Cycle::class, 'histories')
            ->as('cycle_machine');
    }
}
