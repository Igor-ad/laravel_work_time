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
     * @return BelongsToMany
     */
    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'histories');
    }

    /**
     * @return BelongsToMany
     */
    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'histories');
    }
}
