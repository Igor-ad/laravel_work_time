<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cycle extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'complete' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'complete',
    ];

    /**
     *  Accessor for the 'complete' attribute.
     */
    protected function complete(): Attribute
    {
        return Attribute::make(
            fn(bool $value) => $this->completeCasts($value),
        );
    }

    protected function completeCasts(bool $value): string
    {
        return $value ? 'Complete' : 'Run';
    }

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
