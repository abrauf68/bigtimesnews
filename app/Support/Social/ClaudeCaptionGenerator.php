<?php

namespace App\Support\Social;

use App\Contracts\Social\CaptionGeneratorContract;
use App\Enums\SocialPlatform;
use App\Models\AiBlogSetting;
use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClaudeCaptionGenerator implements CaptionGeneratorContract
{
    protected const API_URL = 'https://api.anthropic.com/v1/messages';
    protected const API_VERSION = '2023-06-01';

    public function __construct(protected FallbackCaptionGenerator $fallback)
    {
    }

    public function generate(Post $post, SocialPlatform $platform): array
    {
        try {
            $apiKey = $this->apiKey();

            if (empty($apiKey)) {
                return $this->fallback->generate($post, $platform);
            }

            $model = $this->model();
            $url = $this->postUrl($post);
            $limit = $platform->config()['caption_limit'] ?? 280;
            $titleLimit = $platform->config()['title_limit'] ?? null;
            $excerpt = $this->excerpt($post);
            $tags = $this->tags($post);

            $system = $this->systemPrompt($platform, $limit, $titleLimit);
            $user = $this->userPrompt($post, $url, $excerpt, $tags, $limit, $titleLimit);

            $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'anthropic-version' => self::API_VERSION,
                    'content-type' => 'application/json',
                ])
                ->timeout(60)
                ->post(self::API_URL, [
                    'model' => $model,
                    'max_tokens' => 600,
                    'system' => $system,
                    'messages' => [
                        ['role' => 'user', 'content' => $user],
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('Social caption Claude call failed', [
                    'platform' => $platform->value,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->fallback->generate($post, $platform);
            }

            $text = collect($response->json('content', []))
                ->where('type', 'text')
                ->pluck('text')
                ->implode("\n");

            $parsed = $this->parseJson($text);

            if (empty($parsed['caption'])) {
                return $this->fallback->generate($post, $platform);
            }

            $caption = trim($parsed['caption']);
            if (!str_contains($caption, $url)) {
                $caption = rtrim($caption) . ' ' . $url;
            }

            return [
                'caption' => mb_substr($caption, 0, $limit + 60),
                'title' => isset($parsed['title']) ? trim($parsed['title']) : null,
                'source' => 'generated',
            ];
        } catch (Throwable $e) {
            Log::error('Social caption generation failed, using fallback', [
                'platform' => $platform->value,
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);

            return $this->fallback->generate($post, $platform);
        }
    }

    protected function apiKey(): ?string
    {
        return AiBlogSetting::first()?->claude_api_key;
    }

    protected function model(): string
    {
        return AiBlogSetting::first()?->claude_qa_model ?: 'claude-haiku-4-5-20251001';
    }

    protected function postUrl(Post $post): string
    {
        if (!$post->category) {
            return url('/');
        }

        return route('frontend.news.show', [$post->category->slug, $post->slug]);
    }

    protected function excerpt(Post $post): string
    {
        $text = trim((string) ($post->meta_description ?: strip_tags((string) $post->content)));

        return mb_substr($text, 0, 400);
    }

    protected function tags(Post $post): string
    {
        $tags = is_array($post->tags) ? $post->tags : (json_decode((string) $post->tags, true) ?: []);

        return implode(', ', array_filter((array) $tags));
    }

    protected function systemPrompt(SocialPlatform $platform, int $limit, ?int $titleLimit): string
    {
        $rules = match ($platform) {
            SocialPlatform::X => "Write a single caption under {$limit} characters total, including the link. Punchy, newsworthy tone. Include exactly one primary keyword naturally. End with a short call to action.",
            SocialPlatform::Facebook => "Write an engaging caption under {$limit} characters. Conversational tone, 1-3 short paragraphs, a clear call to action, end with the link.",
            SocialPlatform::Instagram => "Write a caption under {$limit} characters. Do not include a raw URL (Instagram captions are not clickable); instead end with a clear call to action telling readers to tap the link in bio. Add 5 to 8 relevant, non-spammy hashtags at the end, based on the category, tags and primary keyword.",
            SocialPlatform::Threads => "Write a conversational, natural caption under {$limit} characters, like a person sharing news with followers. One or two short paragraphs, at most one relevant hashtag, end with a short call to action and the link.",
            SocialPlatform::LinkedIn => "Write a professional, informative caption under {$limit} characters suited to a business/news audience. No hashtag spam (at most 3 relevant hashtags). End with the link and a clear call to action.",
            SocialPlatform::Pinterest => "Return a short, keyword-rich pin title under {$titleLimit} characters, and a separate pin description under {$limit} characters that naturally includes the primary keyword and a call to action ending with the link.",
            SocialPlatform::Tumblr => "Write a caption under {$limit} characters, informal and engaging tone typical of Tumblr, ending with the link and a call to action.",
            SocialPlatform::Reddit => "Return a completely neutral, non-promotional, non-clickbait post title under {$titleLimit} characters that objectively describes what the article is about, exactly as a Reddit community would expect from a news link post (no calls to action, no hype words, no emojis, no exclamation marks). Also return a short neutral one-sentence description under {$limit} characters. Never sound like an advertisement.",
        };

        return <<<SYS
You are a professional social media copywriter for a news publication.
Write only in the same language as the article title and excerpt given to you.
Only use the facts explicitly provided below. Never invent statistics, quotes, names, or claims that are not present in the given fields.
{$rules}
Respond with ONLY a single valid JSON object, no markdown fences, no commentary.
SYS;
    }

    protected function userPrompt(Post $post, string $url, string $excerpt, string $tags, int $limit, ?int $titleLimit): string
    {
        $category = $post->category->name ?? '';

        $schema = $titleLimit
            ? '{"title": "string", "caption": "string"}'
            : '{"caption": "string"}';

        return <<<PROMPT
Article title: {$post->title}
Meta title: {$post->meta_title}
Excerpt / meta description: {$excerpt}
Category: {$category}
Tags: {$tags}
URL to include: {$url}

Return ONLY this JSON object:
{$schema}
PROMPT;
    }

    protected function parseJson(string $raw): array
    {
        $cleaned = trim($raw);
        $cleaned = preg_replace('/^```(?:json)?\s*/i', '', $cleaned);
        $cleaned = preg_replace('/\s*```$/', '', $cleaned);

        if (($start = strpos($cleaned, '{')) !== false && ($end = strrpos($cleaned, '}')) !== false) {
            $cleaned = substr($cleaned, $start, $end - $start + 1);
        }

        $decoded = json_decode($cleaned, true);

        return is_array($decoded) ? $decoded : [];
    }
}
