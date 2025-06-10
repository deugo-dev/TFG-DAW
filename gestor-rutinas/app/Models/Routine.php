<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercise')
            ->withPivot('exercise_order', 'reps', 'sets', 'duration', 'rest_time')
            ->withTimestamps();
    }



    public function routineExercises(): HasMany
    {
        return $this->hasMany(RoutineExercise::class);
    }
}
