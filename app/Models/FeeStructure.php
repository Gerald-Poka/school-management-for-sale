<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = [
        'fee_type_id',
        'academic_level_id',
        'route_name',
        'amount',
        'effective_from',
        'effective_to',
        'is_active'
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean',
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}