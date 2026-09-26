<?php

namespace App\Jobs;

use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostFaq;
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
            $authorId = $settings->default_author_id
                ?: Author::where('is_active', 'active')->inRandomOrder()->value('id');
            $userId = $settings->posted_by_user_id;

            $activeCategories = Category::where('is_active', 'active')->get(['id', 'name']);

            if ($activeCategories->isEmpty() || !$authorId || !$userId) {
                throw new \RuntimeException('AI Blog Automation is missing a default category, author, or "post as" user. Please complete the settings.');
            }

            $claude = new ClaudeService($settings);

            $draft = $claude->generateArticle(
                $topic->topic,
                (string) $topic->context,
                (string) $topic->country,
                $activeCategories->pluck('name')->all()
            );
            $final = $claude->humanizeAndQa($draft);

            $categoryId = $this->resolveCategoryId($final['category'] ?? null, $activeCategories, $settings->default_category_id);

            $title = $this->cleanText(trim((string) ($final['title'] ?? $topic->topic)));
            $slug = $this->uniqueSlug($final['slug'] ?? $title);

            $unsplash = new UnsplashService($settings);

            $imagePath = $unsplash->fetchImage(
                $final['image_search_query'] ?? $topic->topic,
                $slug
            );

            $inlineQueries = is_array($final['image_queries'] ?? null) ? $final['image_queries'] : [];
            $inlineImageUrls = $unsplash->fetchContentImages($inlineQueries, $slug);
            $content = $this->insertInlineImages($this->cleanText((string) ($final['content_html'] ?? '')), $inlineImageUrls);

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
            $post->content = $content;
            $post->meta_title = $this->cleanText(Str::limit($final['meta_title'] ?? $title, 60, ''));
            $post->meta_description = $this->cleanText(Str::limit($final['meta_description'] ?? '', 160, ''));
            $post->meta_keywords = $this->cleanText($final['meta_keywords'] ?? '');
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

            $faqs = is_array($final['faqs'] ?? null) ? $final['faqs'] : [];
            $validFaqCount = count(array_filter($faqs, fn ($f) => !empty($f['question'] ?? null) && !empty($f['answer'] ?? null)));

            if ($validFaqCount < 10) {
                try {
                    $faqs = $claude->generateFaqs($title, $content);
                } catch (\Throwable $e) {
                    Log::warning('AI blog FAQ fallback generation failed', [
                        'post_id' => $post->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $this->saveFaqs($post, $faqs);

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

    /**
     * Match the category name Claude picked against the site's real, active
     * categories (case-insensitive, with a bit of tolerance for wording),
     * so posts land in the category that actually matches the news topic
     * instead of always falling back to one fixed default category.
     */
    protected function resolveCategoryId(?string $categoryName, $activeCategories, ?int $fallbackCategoryId): int
    {
        $categoryName = trim((string) $categoryName);

        if ($categoryName !== '') {
            $needle = Str::lower($categoryName);

            // Exact match first.
            $match = $activeCategories->first(fn ($category) => Str::lower($category->name) === $needle);

            // Otherwise a loose contains-match either direction (e.g. "US" vs "US News").
            if (!$match) {
                $match = $activeCategories->first(function ($category) use ($needle) {
                    $catName = Str::lower($category->name);
                    return str_contains($catName, $needle) || str_contains($needle, $catName);
                });
            }

            if ($match) {
                return $match->id;
            }
        }

        return $fallbackCategoryId ?: $activeCategories->first()->id;
    }

    /**
     * Strip em dashes and en dashes so generated text doesn't carry the
     * tell-tale "AI look". Replaced with a plain space so words don't run
     * together.
     */
    protected function cleanText(?string $text): string
    {
        if ($text === null || $text === '') {
            return (string) $text;
        }

        $text = str_replace(['—', '–'], ' ', $text);

        // Collapse any double spaces the replacement above may have created.
        return preg_replace('/ {2,}/', ' ', $text);
    }

    protected function insertInlineImages(string $content, array $imageUrls): string
    {
        $placeholders = ['{{IMAGE_1}}', '{{IMAGE_2}}', '{{IMAGE_3}}'];

        foreach ($placeholders as $index => $placeholder) {
            $url = $imageUrls[$index] ?? null;

            $replacement = $url
                ? '<figure class="ai-blog-inline-image"><img src="' . e($url) . '" alt="" loading="lazy"></figure>'
                : '';

            $content = str_replace($placeholder, $replacement, $content);
        }

        return $content;
    }

    protected function saveFaqs(Post $post, array $faqs): void
    {
        $order = 0;
        foreach ($faqs as $faq) {
            $question = $this->cleanText(trim((string) ($faq['question'] ?? '')));
            $answer = $this->cleanText(trim((string) ($faq['answer'] ?? '')));

            if ($question === '' || $answer === '') {
                continue;
            }

            PostFaq::create([
                'post_id' => $post->id,
                'question' => $question,
                'answer' => $answer,
                'sort_order' => $order++
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
