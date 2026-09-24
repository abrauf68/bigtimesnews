<?php

namespace App\Jobs;

use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Services\AiBlog\ClaudeService;
use App\Services\AiBlog\UnsplashService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GenerateAiBlogPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 300; // Claude + Unsplash calls can take a while

    public function __construct(protected int $topicId)
    {
    }

    public function handle(): void
    {
        $topic = AiBlogTopic::find($this->topicId);
        if (!$topic || $topic->status !== 'pending') {
            return;
        }

        $settings = AiBlogSetting::first();
        if (!$settings || !$settings->is_enabled) {
            return;
        }

        $topic->update(['status' => 'generating']);

        try {
            $categoryId = $settings->default_category_id
                ?: Category::where('is_active', 'active')->value('id');
            $authorId = $settings->default_author_id
                ?: Author::where('is_active', 'active')->value('id');
            $userId = $settings->posted_by_user_id;

            if (!$categoryId || !$authorId || !$userId) {
                throw new \RuntimeException('AI Blog Automation is missing a default category, author, or "post as" user. Please complete the settings.');
            }

            $claude = new ClaudeService($settings);

            $draft = $claude->generateArticle($topic->topic, (string) $topic->context, (string) $topic->country);
            $final = $claude->humanizeAndQa($draft);

            $title = trim((string) ($final['title'] ?? $topic->topic));
            $slug = $this->uniqueSlug($final['slug'] ?? $title);

            $imagePath = (new UnsplashService($settings))->fetchImage(
                $final['image_search_query'] ?? $topic->topic,
                $slug
            );

            $tags = $final['tags'] ?? [];
            if (!is_array($tags)) {
                $tags = array_filter(array_map('trim', explode(',', (string) $tags)));
            }

            DB::beginTransaction();

            $post = new Post();
            $post->user_id = $userId;
            $post->source = 'ai';
            $post->ai_blog_topic_id = $topic->id;
            $post->author_id = $authorId;
            $post->category_id = $categoryId;
            $post->title = $title;
            $post->slug = $slug;
            $post->read_time = $final['read_time'] ?? null;
            $post->content = $final['content_html'] ?? '';
            $post->meta_title = Str::limit($final['meta_title'] ?? $title, 60, '');
            $post->meta_description = Str::limit($final['meta_description'] ?? '', 160, '');
            $post->meta_keywords = $final['meta_keywords'] ?? '';
            $post->tags = json_encode(array_values($tags));

            if ($imagePath) {
                $post->main_image = $imagePath;
                $post->meta_image = $imagePath;
            }

            $post->status = $settings->auto_publish ? 'published' : 'draft';
            if ($settings->auto_publish) {
                $post->published_at = now();
            }

            $post->save();

            DB::commit();

            $topic->update(['status' => 'completed', 'post_id' => $post->id]);
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            Log::error('AI blog post generation failed', [
                'topic_id' => $topic->id,
                'topic' => $topic->topic,
                'error' => $e->getMessage(),
            ]);
            $topic->update([
                'status' => 'failed',
                'error_message' => Str::limit($e->getMessage(), 2000),
            ]);
        }
    }

    protected function uniqueSlug(string $source): string
    {
        $base = Str::slug($source) ?: Str::slug('post-' . $this->topicId);
        $slug = $base;
        $i = 1;

        while (Post::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
