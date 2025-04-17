<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teaching_schedules', function (Blueprint $table) {
            $table->enum('wing', ['A', 'B'])->after('room_number');
        });
    }

    public function down()
    {
        Schema::table('teaching_schedules', function (Blueprint $table) {
            $table->dropColumn('wing');
        });
    }
};