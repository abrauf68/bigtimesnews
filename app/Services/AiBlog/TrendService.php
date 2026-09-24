<?php

namespace App\Services\AiBlog;

use App\Models\AiBlogSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TrendService
{
    /**
     * Return a ranked, de-duplicated list of trending topics.
     * Each item: ['topic' => string, 'context' => string, 'country' => string]
     */
    public function getTrendingTopics(AiBlogSetting $settings, int $limit = 10): array
    {
        if ($settings->trends_provider === 'serpapi' && !empty($settings->trends_api_key)) {
            $items = $this->collect($settings, fn ($geo) => $this->fetchSerpApiTrends($geo, $settings->trends_api_key));
            if (!empty($items)) {
                return array_slice($items, 0, $limit);
            }
            // fall through to free provider if SerpApi returned nothing (e.g. bad key/quota)
        }

        $items = $this->collect($settings, fn ($geo) => $this->fetchGoogleTrendsRss($geo));

        return array_slice($items, 0, $limit);
    }

    /**
     * Fetch from every configured country, merge duplicates and rank topics
     * that appear in multiple regions higher (more relevant when "Global" is selected).
     */
    protected function collect(AiBlogSetting $settings, callable $fetcher): array
    {
        $countries = $settings->trendCountries();
        $collected = [];

        foreach ($countries as $geo) {
            foreach ($fetcher($geo) as $entry) {
                $topic = trim($entry['topic'] ?? '');
                if ($topic === '') {
                    continue;
                }

                $key = Str::lower($topic);
                if (!isset($collected[$key])) {
                    $collected[$key] = [
                        'topic' => $topic,
                        'context' => $entry['context'] ?? '',
                        'country' => $geo,
                        'score' => 0,
                    ];
                }
                $collected[$key]['score']++;
            }
        }

        $list = array_values($collected);
        usort($list, fn ($a, $b) => $b['score'] <=> $a['score']);

        return $list;
    }

    /**
     * Free, no-API-key-required daily trends feed Google publishes per country.
     */
    protected function fetchGoogleTrendsRss(string $geo): array
    {
        try {
            $response = Http::withHeaders([
                    // Google's trending RSS feed occasionally blocks requests with no user agent
                    'User-Agent' => 'Mozilla/5.0 (compatible; AI-Blog-Automation/1.0)',
                ])
                ->timeout(20)
                ->get('https://trends.google.com/trending/rss', [
                    'geo' => $geo,
                ]);

            if (!$response->successful()) {
                Log::warning('Google Trends RSS request failed', ['geo' => $geo, 'status' => $response->status()]);
                return [];
            }

            $xml = @simplexml_load_string($response->body());
            if (!$xml || !isset($xml->channel->item)) {
                return [];
            }

            $items = [];
            foreach ($xml->channel->item as $item) {
                $newsTitle = '';
                $newsSnippet = '';

                $ht = $item->children('https://trends.google.com/trending/rss');
                if (isset($ht->news_item)) {
                    foreach ($ht->news_item as $news) {
                        $newsTitle = (string) ($news->news_item_title ?? '');
                        $newsSnippet = (string) ($news->news_item_snippet ?? '');
                        break; // just need one related headline for grounding context
                    }
                }

                $items[] = [
                    'topic' => (string) $item->title,
                    'context' => trim($newsTitle . '. ' . $newsSnippet),
                ];
            }

            return $items;
        } catch (\Throwable $e) {
            Log::warning('Google Trends RSS fetch failed', ['geo' => $geo, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Optional paid fallback provider (SerpApi's Google Trends "Trending Now" engine).
     * Only used when the admin explicitly configures a SerpApi key in the panel.
     */
    protected function fetchSerpApiTrends(string $geo, string $apiKey): array
    {
        try {
            $response = Http::timeout(20)->get('https://serpapi.com/search.json', [
                'engine' => 'google_trends_trending_now',
                'geo' => $geo,
                'api_key' => $apiKey,
            ]);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();
            $items = [];

            foreach (($data['trending_searches'] ?? []) as $entry) {
                $title = $entry['query'] ?? ($entry['title'] ?? null);
                if (!$title) {
                    continue;
                }
                $articleSnippet = $entry['articles'][0]['title'] ?? '';
                $items[] = [
                    'topic' => $title,
                    'context' => $articleSnippet,
                ];
            }

            return $items;
        } catch (\Throwable $e) {
            Log::warning('SerpApi trends fetch failed', ['geo' => $geo, 'error' => $e->getMessage()]);
            return [];
        }
    }
}
