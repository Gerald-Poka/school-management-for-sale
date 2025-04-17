
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->enum('relationship', ['father', 'mother', 'uncle', 'aunt', 'guardian', 'other']);
            $table->string('primary_phone');
            $table->string('alternative_phone')->nullable();
            $table->string('email')->nullable();
            $table->text('residential_address');
            $table->string('occupation')->nullable();
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};