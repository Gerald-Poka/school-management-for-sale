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
        Schema::table('teaching_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('teaching_schedules', 'academic_year')) {
                $table->string('academic_year')->default(date('Y').'-'.(date('Y')+1))->after('wing');  // Format: 2024-2025
            }
            if (!Schema::hasColumn('teaching_schedules', 'term')) {
                $table->enum('term', ['1', '2', '3'])->default('1')->after('academic_year');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('teaching_schedules', 'term')) {
                $table->dropColumn('term');
            }
            if (Schema::hasColumn('teaching_schedules', 'academic_year')) {
                $table->dropColumn('academic_year');
            }
        });
    }
};
