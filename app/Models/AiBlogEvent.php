<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiBlogEvent extends Model
{
    protected $table = 'ai_blog_events';

    protected $fillable = ['title', 'event_date', 'is_active'];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];
}
