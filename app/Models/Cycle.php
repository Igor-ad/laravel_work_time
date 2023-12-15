<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cycle extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'complete',
    ];

    /**
     *  Accessor of the 'complete' attribute.
     */
    protected function getCompleteAttribute($value): string
    {
        return $value ? 'Complete' : 'Run';
    }

    /**
     * @return BelongsToMany
     */
    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'histories')
            ->as('cycle_worker');
    }

    /**
     * @return BelongsToMany
     */
    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'histories')
            ->as('cycle_machine');
    }
}
