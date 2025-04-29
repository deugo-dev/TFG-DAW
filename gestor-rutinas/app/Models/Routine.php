<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Routine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_template',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercise')
                    ->withPivot(['exercise_order', 'reps', 'duration', 'rest_time'])
                    ->withTimestamps();
    }
}
