<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'credits',
        'level',
        'pdf_link'
    ];

    protected $casts = [
        'credits' => 'integer',
        'department_id' => 'integer'
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class, 'level', 'name');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($subject) {
            // Convert level to proper format if needed
            if (!str_starts_with($subject->level, 'Standard ')) {
                $subject->level = 'Standard ' . $subject->level;
            }
        });
    }

    /**
     * Get the topics for the subject.
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the results for the subject.
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}