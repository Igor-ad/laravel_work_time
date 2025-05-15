<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cycle extends Model
{
    use HasFactory;

    protected $fillable = ['complete',];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['start', 'end'];

    protected $visible = [
        'id',
        'start',
        'end',
        'complete',
        'workers',
        'machines',
    ];

    /**
     *  Accessor of the 'complete' attribute.
     */
    protected function getCompleteAttribute($value): string
    {
        return $value ? 'Complete' : 'Run';
    }

    protected function getStartAttribute(): ?string
    {
        return $this->attributes['created_at'];
    }

    protected function getEndAttribute(): ?string
    {
        return $this->attributes['updated_at'];
    }

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'histories')
            ->as('cycle_worker');
    }

    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'histories')
            ->as('cycle_machine');
    }
}
