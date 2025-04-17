<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop tables if they exist (in reverse order of dependencies)
        Schema::dropIfExists('topic_activities');
        Schema::dropIfExists('subtopics');
        Schema::dropIfExists('topics');

        // Create topics table
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('class_level');
            $table->text('learning_objectives')->nullable();
            $table->enum('duration', ['1 Week', '2 Weeks', '3 Weeks', '4 Weeks', '1 Month', '2 Months', 'Term']);
            $table->text('teaching_methods')->nullable();
            $table->text('assessment_methods')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create subtopics table
        Schema::create('subtopics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('order');
            $table->timestamps();
        });

        // Create topic activities table
        Schema::create('topic_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['Assignment', 'Quiz', 'Homework']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_activities');
        Schema::dropIfExists('subtopics');
        Schema::dropIfExists('topics');
    }
};
