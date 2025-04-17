<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeachingSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'academic_level_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room_number',
        'wing',
        'academic_year',
        'term'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public static function rules()
    {
        return [
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_level_id' => 'required|exists:academic_levels,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'required|string',
            'wing' => 'required|in:A,B',    // Add wing validation
            'academic_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'term' => 'required|in:1,2,3',
        ];
    }

    // Relationships
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    // Custom validation for schedule conflicts
    public static function hasConflict($teacherId, $dayOfWeek, $startTime, $endTime, $excludeId = null)
    {
        $query = self::where('teacher_id', $teacherId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Check if teacher has reached maximum classes
    public static function teacherClassCount($teacherId)
    {
        return self::where('teacher_id', $teacherId)
            ->where('is_active', true)
            ->distinct('academic_level_id')
            ->count('academic_level_id');
    }

    // Add method to check room conflicts within a wing
    public static function hasRoomConflict($roomNumber, $wing, $dayOfWeek, $startTime, $endTime, $excludeId = null)
    {
        $query = self::where('room_number', $roomNumber)
            ->where('wing', $wing)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Add method to get wing based on academic level
    public static function getWingForAcademicLevel($academicLevelId)
    {
        $academicLevel = AcademicLevel::find($academicLevelId);
        // You'll need to define your wing assignment logic here
        // For example:
        $lowerLevels = [1, 2, 3]; // Academic level IDs for lower classes
        return in_array($academicLevel->id, $lowerLevels) ? 'A' : 'B';
    }
}