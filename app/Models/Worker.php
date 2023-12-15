<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function machinesNow(): HasMany
    {
        return $this->hasMany(Machine::class, 'worker_id');
    }

    /**
     * @return BelongsToMany
     */
    public function cycles(): BelongsToMany
    {
        return $this->belongsToMany(Cycle::class, 'histories')
            ->as('cycle_worker');
    }

    /**
     * @return BelongsToMany
     */
    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'histories');
    }
}
