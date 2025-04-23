<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'exam_type',
        'marks_obtained',
        'grade',
        'remarks',
        'exam_date'
    ];

    protected $casts = [
        'exam_date' => 'date'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}