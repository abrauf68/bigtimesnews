<?php

namespace App\Support\Social;

use App\Contracts\Social\CaptionGeneratorContract;
use App\Enums\SocialPlatform;
use App\Models\Post;

class FallbackCaptionGenerator implements CaptionGeneratorContract
{
    public function generate(Post $post, SocialPlatform $platform): array
    {
        $limit = $platform->config()['caption_limit'] ?? 280;
        $url = $this->postUrl($post);

        $title = trim((string) ($post->meta_title ?: $post->title));
        $description = trim((string) ($post->meta_description ?: ''));

        if (in_array($platform, [SocialPlatform::Pinterest, SocialPlatform::Reddit], true)) {
            $captionTitle = $this->fitPlain($title, $platform->config()['title_limit'] ?? 100);
            $caption = $this->fit($description !== '' ? $description : $title, $url, $limit);

            return ['caption' => $caption, 'title' => $captionTitle, 'source' => 'fallback'];
        }

        $caption = $description !== '' ? $title . '. ' . $description : $title;
        $caption = $this->fit($caption, $url, $limit);

        return ['caption' => $caption, 'title' => null, 'source' => 'fallback'];
    }

    private function postUrl(Post $post): string
    {
        if (!$post->category) {
            return url('/');
        }

        return route('frontend.news.show', [$post->category->slug, $post->slug]);
    }

    private function fit(string $text, string $url, int $limit): string
    {
        $suffix = ' ' . $url;
        $available = max(0, $limit - mb_strlen($suffix));

        if (mb_strlen($text) > $available) {
            $text = rtrim(mb_substr($text, 0, $available)) . '…';
        }

        return $text . $suffix;
    }

    private function fitPlain(string $text, int $limit): string
    {
        if (mb_strlen($text) > $limit) {
            return rtrim(mb_substr($text, 0, $limit - 1)) . '…';
        }

        return $text;
    }
}
