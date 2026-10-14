<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /** Public author page URL, e.g. /author/3/jane-doe */
    public function getUrlAttribute(): string
    {
        return route('frontend.author', ['id' => $this->id, 'slug' => Str::slug($this->name) ?: 'author']);
    }

    /** Uploaded photo URL, or null when the author has no photo. */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->image ? asset($this->image) : null;
    }

    /** Up to two initials, used when there is no photo. */
    public function getInitialsAttribute(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $letters = '';
        foreach (array_slice($parts, 0, 2) as $p) {
            $letters .= mb_strtoupper(mb_substr($p, 0, 1));
        }

        return $letters !== '' ? $letters : 'BT';
    }

    /** Social profile URLs, used as schema.org sameAs. */
    public function getSameAsAttribute(): array
    {
        return array_values(array_filter([
            $this->linkedin, $this->facebook, $this->twitter, $this->instagram, $this->threads,
        ], fn ($u) => is_string($u) && preg_match('#^https?://#i', $u)));
    }
}
