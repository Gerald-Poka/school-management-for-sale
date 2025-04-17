<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'guardian_id',
        'admission_number',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'academic_level_id', // Fixed typo here
        'special_needs',
        'date_of_admission',
        'profile_picture',
        'is_active',
        'name',
        'registration_number'
    ];

    protected $dates = [
        'date_of_birth',
        'date_of_admission',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_admission' => 'date',
        'is_active' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public static function generateAdmissionNumber()
    {
        $year = date('Y');
        $prefix = 'GT-' . $year . '-';
        $attempts = 0;
        $maxAttempts = 10;

        do {
            $attempts++;
            // Generate a random 4-digit number
            $randomNumber = mt_rand(1000, 9999);
            
            // Create the admission number
            $admissionNumber = $prefix . $randomNumber;
            
            // Log the attempt
            \Log::info("Generating admission number attempt {$attempts}", [
                'admission_number' => $admissionNumber,
                'exists_in_students' => self::where('admission_number', $admissionNumber)->exists(),
                'exists_in_users' => \App\Models\User::where('username', $admissionNumber)->exists()
            ]);

            // Check if this admission number exists in students table
            $existsInStudents = self::where('admission_number', $admissionNumber)->exists();
            
            // Check if this admission number exists as username in users table
            $existsInUsers = \App\Models\User::where('username', $admissionNumber)->exists();
            
        } while (($existsInStudents || $existsInUsers) && $attempts < $maxAttempts);

        if ($attempts >= $maxAttempts) {
            \Log::error("Failed to generate unique admission number after {$maxAttempts} attempts");
            throw new \Exception("Failed to generate unique admission number after {$maxAttempts} attempts");
        }

        return strtoupper($admissionNumber);
    }

    public function getNameAttribute()
    {
        return $this->getFullNameAttribute();
    }

    public function getRegistrationNumberAttribute()
    {
        return $this->admission_number;
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}