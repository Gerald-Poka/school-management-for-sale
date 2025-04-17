<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('birth_certificate_number')->nullable();
            $table->string('national_id')->unique()->nullable();
            $table->string('passport_number')->unique()->nullable();
            
            // Contact Information
            $table->string('phone');
            $table->string('alternative_phone')->nullable();
            $table->string('email')->unique();
            $table->text('physical_address');
            $table->string('postal_address')->nullable();
            
            // Educational Background
            $table->string('secondary_school')->nullable();
            $table->string('form_four_index')->nullable();
            $table->string('form_six_index')->nullable();
            $table->string('diploma_certificate')->nullable();
            $table->string('degree_certificate')->nullable();
            $table->string('highest_qualification');
            $table->string('specialization');
            $table->text('other_qualifications')->nullable();
            
            // Professional Information
            $table->string('teaching_license_number')->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->date('joining_date');
            $table->text('previous_experience')->nullable();
            $table->json('subjects_taught')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('achievements')->nullable();
            
            // Additional Skills
            $table->json('ict_skills')->nullable();
            $table->json('language_proficiency')->nullable();
            $table->text('classroom_management_skills')->nullable();
            
            // Document Management
            $table->string('cv_path')->nullable();
            $table->string('teaching_license_path')->nullable();
            $table->string('certificates_path')->nullable();
            $table->string('recommendation_letters_path')->nullable();
            $table->string('id_document_path')->nullable();
            $table->string('birth_certificate_path')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};