<?php

use Illuminate\Support\Str;

if (! function_exists('absolute_media_url')) {
    function absolute_media_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return rtrim(config('app.url'), '/') . '/' . ltrim($path, '/');
    }
}