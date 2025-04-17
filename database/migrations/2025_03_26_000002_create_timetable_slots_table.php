<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetable_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timetable_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained();
            $table->foreignId('teacher_id')->nullable()->constrained();
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_number')->nullable();
            $table->enum('type', ['class', 'break', 'lunch'])->default('class');
            $table->timestamps();

            // Prevent schedule conflicts
            $table->unique(['timetable_id', 'day_of_week', 'start_time']);
            $table->unique(['teacher_id', 'day_of_week', 'start_time'], 'teacher_schedule_conflict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetable_slots');
    }
};