<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function routines()
    {
        return $this->belongsToMany(Routine::class, 'routine_exercise')
            ->withPivot('exercise_order', 'reps', 'sets', 'duration', 'rest_time')
            ->withTimestamps();
    }

    public function routineExercises(): HasMany
    {
        return $this->hasMany(RoutineExercise::class);
    }

    public function getEmbedUrl()
    {
        if (!$this->video_url) return null;

        preg_match(
            '%(?:youtube\.com/(?:watch\?v=|embed/|v/)|youtu\.be/)([a-zA-Z0-9_-]{11})%',
            $this->video_url,
            $matches
        );

        $videoId = $matches[1] ?? null;

        return $videoId ? "https://www.youtube.com/embed/$videoId" : null;
    }
}
