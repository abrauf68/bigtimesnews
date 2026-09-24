<?php

namespace App\Services\AiBlog;

use App\Models\AiBlogSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ClaudeService
{
    protected const API_URL = 'https://api.anthropic.com/v1/messages';
    protected const API_VERSION = '2023-06-01';

    public function __construct(protected AiBlogSetting $settings)
    {
    }

    /**
     * Step 1 (Claude Sonnet): research-grounded, SEO-optimized first draft.
     */
    public function generateArticle(string $topic, string $context, string $country, array $categories = []): array
    {
        $countryLabel = $country === 'GLOBAL' || empty($country) ? 'a global, international audience' : "readers in {$country}";

        $system = <<<SYS
You are a senior digital journalist and SEO content strategist writing for a news & lifestyle blog.
You write clean, well-researched, engaging articles that read like they were written by an experienced human writer, not generic AI filler.
Never use the em dash or en dash character in your writing (in the title, content, or anywhere else) - use a comma, a period, or a plain hyphen surrounded by spaces instead.
Always respond with ONLY a single valid JSON object. No markdown code fences, no commentary before or after.
SYS;

        $categoryList = !empty($categories) ? implode(', ', $categories) : 'US News, World News, Business, Sports, Entertainment, Technology, Health, Lifestyle';

        $user = <<<PROMPT
Write a full, original, SEO-optimized blog post about this currently trending topic: "{$topic}"

Related context you can use for grounding (may be partial, verify tone rather than copying facts verbatim): "{$context}"

Target audience: {$countryLabel}.

Available categories on this site (choose the single one that best fits this topic's actual subject matter, do not default to a generic one): {$categoryList}

Requirements:
- 1200 to 1500 words of substantive, well-organized content in content_html (count the visible text, not the HTML tags).
- Natural, human, editorial tone. Vary sentence length. No robotic transitions like "In conclusion" or "In today's fast-paced world".
- Use a compelling H1-worthy title, then structure the body with 3-6 H2 sections and H3s where useful.
- Include a short, punchy introduction and a satisfying closing thought (not a generic summary paragraph).
- Naturally weave in the main keyword and 2-3 related keywords without keyword-stuffing.
- Do not fabricate specific statistics, quotes, or named sources you are not confident about; write generally and factually instead.
- Include at least 2 bulleted or numbered lists (<ul>/<ol> with <li>) covering concrete points, steps, or examples — not just decorative.
- Include exactly one HTML <table> (with <thead>, <tbody>, <tr>, <th>, <td>) giving a genuinely useful at-a-glance breakdown, comparison, or set of facts related to the topic. If the topic has no obvious tabular data, build a sensible "Quick Facts" or "Key Takeaways" table instead — never skip the table.
- Insert exactly 3 image placeholders as their own line, in plain text (not wrapped in any HTML tag), at natural reading breaks: {{IMAGE_1}} shortly after the introduction, {{IMAGE_2}} roughly in the middle of the article, {{IMAGE_3}} before the closing section.
- Output valid semantic HTML for the body (using <h2>, <h3>, <p>, <ul>/<ol>/<li>, <table>/<thead>/<tbody>/<tr>/<th>/<td>, <strong> etc. only — no <html>/<body> wrapper, no inline styles, no <h1>).
- Do not use the em dash (—) or en dash (–) anywhere in the title, meta fields, or content. Use a comma, a period, or a plain hyphen with spaces around it instead.

Return ONLY this JSON object:
{
  "title": "string, the article's H1 title, under 70 characters",
  "slug": "string, url-safe kebab-case slug derived from the title",
  "category": "string, the single best-fitting category name copied exactly from the available categories list above, based on what this article is actually about",
  "meta_title": "string, <= 60 characters, SEO title tag",
  "meta_description": "string, <= 155 characters, compelling SEO meta description",
  "meta_keywords": "string, 5-8 comma separated keywords/phrases",
  "tags": ["3 to 6 short tag strings"],
  "read_time": "string like '4 min read'",
  "content_html": "string, the full HTML body as described above, including the table, lists, and the 3 {{IMAGE_n}} placeholders",
  "image_search_query": "string, 2-4 words, a concrete, safe-for-work Unsplash search phrase for the article's main/featured image",
  "image_queries": ["string, 2-4 words, Unsplash search phrase for {{IMAGE_1}}", "string for {{IMAGE_2}}", "string for {{IMAGE_3}}"]
}
PROMPT;

        $result = $this->call($this->settings->claude_writer_model, $system, $user, 6000);

        return $this->parseJson($result, 'article generation');
    }

    /**
     * Step 2 (Claude Haiku): humanize + SEO/QA recheck pass on the draft.
     */
    public function humanizeAndQa(array $draft): array
    {
        $system = <<<SYS
You are a meticulous human copy editor and SEO QA reviewer.
You are given a drafted blog post as JSON. Rewrite it so it reads naturally and humanly — remove any robotic AI phrasing,
repetitive sentence patterns, generic filler, or awkward transitions — while preserving all facts and meaning.
Also verify and, if needed, fix basic on-page SEO: meta_title <= 60 characters, meta_description <= 155 characters,
heading structure present, keyword present naturally in the first paragraph, content_html still roughly 1200-1500 words.
Keep the article's <table>, its <ul>/<ol> lists, and the three {{IMAGE_1}}, {{IMAGE_2}}, {{IMAGE_3}} placeholders exactly
as they are and in the same relative positions — never remove, rename, merge, or wrap them, even while polishing the
surrounding prose. Keep the "category" field exactly as given, do not change it.
Remove any em dash (—) or en dash (–) you find anywhere in the text (title, meta fields, content) and replace it with a
comma, a period, or a plain hyphen with spaces around it, whichever reads most naturally in context.
Always respond with ONLY a single valid JSON object, same shape as given to you, no markdown fences, no commentary.
SYS;

        $user = "Here is the drafted post as JSON. Polish it and return the corrected, humanized, SEO-checked version in the exact same JSON shape (keys: title, slug, category, meta_title, meta_description, meta_keywords, tags, read_time, content_html, image_search_query, image_queries):\n\n"
            . json_encode($draft, JSON_UNESCAPED_SLASHES);

        $result = $this->call($this->settings->claude_qa_model, $system, $user, 6000);

        $final = $this->parseJson($result, 'humanize/QA pass');

        // Defensive fallback: if the QA pass dropped a required field, keep the drafted value.
        foreach ($draft as $key => $value) {
            if (!array_key_exists($key, $final) || $final[$key] === null || $final[$key] === '') {
                $final[$key] = $value;
            }
        }

        $draftHtml = (string) ($draft['content_html'] ?? '');
        $finalHtml = (string) ($final['content_html'] ?? '');
        foreach (['{{IMAGE_1}}', '{{IMAGE_2}}', '{{IMAGE_3}}'] as $placeholder) {
            if (str_contains($draftHtml, $placeholder) && !str_contains($finalHtml, $placeholder)) {
                $final['content_html'] = $draftHtml;
                break;
            }
        }

        return $final;
    }

    protected function call(string $model, string $system, string $userMessage, int $maxTokens): string
    {
        if (empty($this->settings->claude_api_key)) {
            throw new RuntimeException('Claude API key is not configured in AI Blog Automation settings.');
        }

        $response = Http::withHeaders([
                'x-api-key' => $this->settings->claude_api_key,
                'anthropic-version' => self::API_VERSION,
                'content-type' => 'application/json',
            ])
            ->timeout(180)
            ->post(self::API_URL, [
                'model' => $model,
                'max_tokens' => $maxTokens,
                'system' => $system,
                'messages' => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

        if (!$response->successful()) {
            Log::error('Claude API call failed', [
                'model' => $model,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RuntimeException('Claude API request failed with status ' . $response->status());
        }

        $data = $response->json();
        $text = collect($data['content'] ?? [])
            ->where('type', 'text')
            ->pluck('text')
            ->implode("\n");

        if (trim($text) === '') {
            throw new RuntimeException('Claude API returned an empty response.');
        }

        return $text;
    }

    protected function parseJson(string $raw, string $stepLabel): array
    {
        $cleaned = trim($raw);
        // Strip ```json ... ``` or ``` ... ``` fences if the model added them anyway
        $cleaned = preg_replace('/^```(?:json)?\s*/i', '', $cleaned);
        $cleaned = preg_replace('/\s*```$/', '', $cleaned);

        // If there is stray text around the object, grab the outermost { ... }
        if (($start = strpos($cleaned, '{')) !== false && ($end = strrpos($cleaned, '}')) !== false) {
            $cleaned = substr($cleaned, $start, $end - $start + 1);
        }

        $decoded = json_decode($cleaned, true);

        if (!is_array($decoded)) {
            Log::error("Claude {$stepLabel} returned unparsable JSON", ['raw' => $raw]);
            throw new RuntimeException("Could not parse Claude's {$stepLabel} response as JSON.");
        }

        return $decoded;
    }
}
