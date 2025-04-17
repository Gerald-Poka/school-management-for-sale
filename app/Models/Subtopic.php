<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'name',
        'order'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
