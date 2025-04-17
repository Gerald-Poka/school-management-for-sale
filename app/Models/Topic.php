<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'duration',
        'class_level'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function subtopics()
    {
        return $this->hasMany(Subtopic::class)->orderBy('order');
    }

    public function activities()
    {
        return $this->hasMany(TopicActivity::class);
    }

    // Add this scope to help with filtering
    public function scopeForLevel($query, $level)
    {
        // Log the incoming level value
        Log::info('Level before conversion:', ['level' => $level]);
        
        // Convert Standard to Primary if needed
        $standardizedLevel = 'Primary ' . filter_var($level, FILTER_SANITIZE_NUMBER_INT);
        
        // Log the converted level
        Log::info('Standardized level:', ['standardized_level' => $standardizedLevel]);
        
        return $query->where('class_level', $standardizedLevel);
    }

    public function scopeWithDebug($query)
    {
        // Log the full query with bindings
        Log::info('Query Debug:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'connection' => $query->getConnection()->getName()
        ]);
        
        return $query;
    }
}