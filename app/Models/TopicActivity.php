<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'type',
        'title'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
