<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routine_exercise', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('exercise_order');
            $table->integer('reps')->nullable();
            $table->string('duration');
            $table->integer('rest_time');
            $table->foreignId('exercise_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('routine_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_exercise');
    }
};
