<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'relationship',
        'primary_phone',
        'alternative_phone',
        'email',
        'residential_address',
        'occupation',
        'is_emergency_contact'
    ];

    protected $casts = [
        'is_emergency_contact' => 'boolean'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}