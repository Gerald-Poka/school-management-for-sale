<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'academic_level_id',
        'academic_year',
        'term',
        'is_active'
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function slots()
    {
        return $this->hasMany(TimetableSlot::class);
    }

    public static function generateTimeSlots()
    {
        return [
            ['08:45', '09:45'], // Period 1
            ['09:45', '10:45'], // Period 2
            ['10:45', '11:15'], // Break
            ['11:15', '12:15'], // Period 3
            ['12:15', '13:15'], // Period 4
            ['13:15', '14:15'], // Lunch
            ['14:15', '15:15'], // Period 5
            ['15:15', '16:15'], // Period 6
        ];
    }
}