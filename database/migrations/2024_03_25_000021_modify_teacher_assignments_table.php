<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_assignments', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
            
            // Add new academic_level_id column
            $table->foreignId('academic_level_id')
                  ->after('subject_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_assignments', function (Blueprint $table) {
            // Remove the new column
            $table->dropForeign(['academic_level_id']);
            $table->dropColumn('academic_level_id');
            
            // Restore original column
            $table->foreignId('class_id')
                  ->after('subject_id')
                  ->constrained('classes')
                  ->onDelete('cascade');
        });
    }
};