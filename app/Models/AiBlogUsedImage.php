<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiBlogUsedImage extends Model
{
    protected $fillable = ['photo_id', 'used_at'];

    protected $casts = [
        'used_at' => 'datetime',
    ];
}
