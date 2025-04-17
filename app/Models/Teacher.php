<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'nationality',
        'gender',
        'date_of_birth',
        'birth_certificate_number',
        'national_id',
        'passport_number',
        'phone',
        'alternative_phone',
        'email',
        'physical_address',
        'postal_address',
        'secondary_school',
        'form_four_index',
        'form_six_index',
        'diploma_certificate',
        'degree_certificate',
        'highest_qualification',
        'specialization',
        'other_qualifications',
        'teaching_license_number',
        'license_expiry_date',
        'joining_date',
        'previous_experience',
        'subjects_taught',
        'responsibilities',
        'achievements',
        'ict_skills',
        'language_proficiency',
        'classroom_management_skills',
        'cv_path',
        'teaching_license_path',
        'certificates_path',
        'recommendation_letters_path',
        'id_document_path',
        'birth_certificate_path',
        'is_active'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'license_expiry_date' => 'date',
        'joining_date' => 'date',
        'subjects_taught' => 'array',
        'ict_skills' => 'array',
        'language_proficiency' => 'array',
        'is_active' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TeacherAssignment::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TeachingSchedule::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}