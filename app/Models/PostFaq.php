<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostFaq extends Model
{
    protected $table = 'post_faqs';

    protected $fillable = [
        'post_id',
        'question',
        'answer',
        'sort_order'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
