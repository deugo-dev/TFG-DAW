<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'category',
        'is_template',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routines(): BelongsToMany
    {
        return $this->belongsToMany(Routine::class, 'routine_exercise')
                    ->withPivot(['exercise_order', 'reps', 'duration', 'rest_time'])
                    ->withTimestamps();
    }
}

