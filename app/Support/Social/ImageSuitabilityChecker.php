<?php

namespace App\Support\Social;

use App\Enums\SocialPlatform;
use App\Models\Post;
use Illuminate\Support\Facades\File;

class ImageSuitabilityChecker
{
    public function check(Post $post, SocialPlatform $platform): ?string
    {
        if (empty($post->meta_image)) {
            return 'This post has no meta image set.';
        }

        $relative = str_replace('storage/', 'public/', $post->meta_image);
        $absolutePath = storage_path('app/' . ltrim($relative, '/'));

        if (!File::exists($absolutePath)) {
            return 'The meta image file could not be found on disk.';
        }

        $config = $platform->config()['image'] ?? [];

        $sizeMb = File::size($absolutePath) / 1048576;
        $maxMb = $config['max_mb'] ?? 20;
        if ($sizeMb > $maxMb) {
            return sprintf('Meta image is %.1fMB, %s allows a maximum of %sMB.', $sizeMb, $platform->label(), $maxMb);
        }

        $extension = strtolower(File::extension($absolutePath));
        $allowed = $config['formats'] ?? ['jpg', 'jpeg', 'png'];
        if (!in_array($extension, $allowed, true)) {
            return sprintf('Meta image format .%s is not supported by %s.', $extension, $platform->label());
        }

        $dimensions = @getimagesize($absolutePath);
        if ($dimensions === false) {
            return 'Meta image could not be read as a valid image.';
        }

        [$width, $height] = $dimensions;

        $minWidth = $config['min_width'] ?? 0;
        $minHeight = $config['min_height'] ?? 0;
        if ($width < $minWidth || $height < $minHeight) {
            return sprintf(
                'Meta image is %dx%dpx, %s requires at least %dx%dpx.',
                $width, $height, $platform->label(), $minWidth, $minHeight
            );
        }

        $ratio = $height > 0 ? $width / $height : 0;
        $minRatio = $config['min_aspect_ratio'] ?? null;
        $maxRatio = $config['max_aspect_ratio'] ?? null;

        if ($minRatio !== null && $ratio < $minRatio) {
            return sprintf('Meta image aspect ratio (%.2f) is too narrow for %s.', $ratio, $platform->label());
        }

        if ($maxRatio !== null && $ratio > $maxRatio) {
            return sprintf('Meta image aspect ratio (%.2f) is too wide for %s.', $ratio, $platform->label());
        }

        return null;
    }
}
