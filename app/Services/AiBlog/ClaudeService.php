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
    public function generateArticle(string $topic, string $context, string $country): array
    {
        $countryLabel = $country === 'GLOBAL' || empty($country) ? 'a global, international audience' : "readers in {$country}";

        $system = <<<SYS
You are a senior digital journalist and SEO content strategist writing for a news & lifestyle blog.
You write clean, well-researched, engaging articles that read like they were written by an experienced human writer — never like generic AI filler.
Always respond with ONLY a single valid JSON object. No markdown code fences, no commentary before or after.
SYS;

        $user = <<<PROMPT
Write a full, original, SEO-optimized blog post about this currently trending topic: "{$topic}"

Related context you can use for grounding (may be partial, verify tone rather than copying facts verbatim): "{$context}"

Target audience: {$countryLabel}.

Requirements:
- 900 to 1400 words of substantive, well-organized content.
- Natural, human, editorial tone. Vary sentence length. No robotic transitions like "In conclusion" or "In today's fast-paced world".
- Use a compelling H1-worthy title, then structure the body with 2-5 H2 sections and H3s where useful.
- Include a short, punchy introduction and a satisfying closing thought (not a generic summary paragraph).
- Naturally weave in the main keyword and 2-3 related keywords without keyword-stuffing.
- Do not fabricate specific statistics, quotes, or named sources you are not confident about; write generally and factually instead.
- Output valid semantic HTML for the body (using <h2>, <h3>, <p>, <ul>/<li>, <strong> etc. only — no <html>/<body> wrapper, no inline styles, no <h1>).

Return ONLY this JSON object:
{
  "title": "string, the article's H1 title, under 70 characters",
  "slug": "string, url-safe kebab-case slug derived from the title",
  "meta_title": "string, <= 60 characters, SEO title tag",
  "meta_description": "string, <= 155 characters, compelling SEO meta description",
  "meta_keywords": "string, 5-8 comma separated keywords/phrases",
  "tags": ["3 to 6 short tag strings"],
  "read_time": "string like '4 min read'",
  "content_html": "string, the full HTML body as described above",
  "image_search_query": "string, 2-4 words, a concrete, safe-for-work visual search phrase (Unsplash) that matches the article's subject"
}
PROMPT;

        $result = $this->call($this->settings->claude_writer_model, $system, $user, 4000);

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
heading structure present, keyword present naturally in the first paragraph.
Always respond with ONLY a single valid JSON object, same shape as given to you, no markdown fences, no commentary.
SYS;

        $user = "Here is the drafted post as JSON. Polish it and return the corrected, humanized, SEO-checked version in the exact same JSON shape (keys: title, slug, meta_title, meta_description, meta_keywords, tags, read_time, content_html, image_search_query):\n\n"
            . json_encode($draft, JSON_UNESCAPED_SLASHES);

        $result = $this->call($this->settings->claude_qa_model, $system, $user, 4000);

        $final = $this->parseJson($result, 'humanize/QA pass');

        // Defensive fallback: if the QA pass dropped a required field, keep the drafted value.
        foreach ($draft as $key => $value) {
            if (!array_key_exists($key, $final) || $final[$key] === null || $final[$key] === '') {
                $final[$key] = $value;
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
