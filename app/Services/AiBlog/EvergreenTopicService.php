<?php

namespace App\Services\AiBlog;

use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use Illuminate\Support\Facades\Log;

/**
 * Picks evergreen (long-tail, specific question) topics for US readers.
 *
 * Source order:
 *   1. Built-in bank below (seasonal ones are only offered in the months listed,
 *      which are PUBLISH months: roughly 1 to 2 months before the season).
 *   2. When the bank runs dry, Claude (cheap QA model) suggests fresh topics,
 *      told which titles already exist so it does not repeat them.
 *
 * Deliberately avoids medical, legal, investment and political advice.
 */
class EvergreenTopicService
{
    /** [topic, publish months (empty = any month)] */
    protected const BANK = [
        // Seasonal (publish months)
        ['Thanksgiving turkey thawing guide: how many days to thaw a turkey by weight', [10, 11]],
        ['How long to cook a turkey: oven times by weight and temperature', [10, 11]],
        ['How to host Thanksgiving dinner: a timeline from one week out', [10, 11]],
        ['Best time to book Thanksgiving and Christmas flights', [9, 10]],
        ['How to ship holiday packages on time: USPS, UPS and FedEx deadlines', [11, 12]],
        ['How to prepare your home for winter: a room by room checklist', [10, 11]],
        ['How to winterize your car: a checklist before the first freeze', [10, 11, 12]],
        ['How to keep pipes from freezing and what to do if they do', [11, 12, 1]],
        ['How to prepare for a winter storm power outage: emergency kit checklist', [11, 12, 1]],
        ['How to set up a Christmas tree and keep it fresh', [11, 12]],
        ['Last minute Halloween costume ideas using what you already own', [10]],
        ['How to decorate for Halloween on a budget', [9, 10]],
        ['Super Bowl party planning: food, setup and timeline', [12, 1]],
        ["Valentine's Day on a budget: date ideas that cost under 50 dollars", [1, 2]],
        ['Spring cleaning checklist: a room by room guide', [2, 3, 4]],
        ['How to get your yard ready for spring: a simple checklist', [2, 3]],
        ['National park reservation tips: how to book timed entry and campsites', [3, 4, 5]],
        ['How to plan a summer road trip across the US: budget and packing list', [4, 5, 6]],
        ['How to plan a Fourth of July cookout: food, timeline and safety tips', [5, 6]],
        ['How to prepare for hurricane season: emergency kit and evacuation checklist', [5, 6, 7, 8]],
        ['How to keep your home cool in a heat wave without a huge power bill', [5, 6, 7]],
        ['Back to school supply checklist by grade level', [7, 8]],
        ['Best places in the US to see fall foliage and when to go', [8, 9, 10]],
        ['How to get your home ready for fall: gutters, heating and weatherproofing', [9, 10]],

        // Any month
        ['How to get a REAL ID: documents you need and where to apply', []],
        ['How to renew a US passport: cost, processing time and steps', []],
        ['TSA PreCheck vs Global Entry: which is worth it for you', []],
        ['What to do when your flight is canceled: your rights and next steps', []],
        ['How to spot a USPS or package delivery text scam', []],
        ['How to freeze your credit for free: step by step', []],
        ['How to dispute a credit card charge: steps and timeline', []],
        ['How to check your credit report for free', []],
        ['How to cancel a subscription you forgot about: steps for common services', []],
        ['How to replace a lost Social Security card: documents and steps', []],
        ['How to order a copy of your birth certificate: where to apply and how long it takes', []],
        ['How to register to vote: deadlines and requirements by state', []],
        ['How to read your electric bill and find easy ways to lower it', []],
        ['How to ship a package cheaply: USPS vs UPS vs FedEx compared', []],
        ['How to track a lost package and file a claim', []],
        ['How to back up photos from an iPhone or Android phone', []],
        ['How to set up two factor authentication on your important accounts', []],
        ['How to spot a fake website: signs and a quick checklist', []],
        ['How to free up space on your phone without deleting photos', []],
        ['How to speed up a slow laptop: simple fixes that work', []],
        ['How to improve your home Wi-Fi: router placement and settings', []],
        ['What to pack in a carry on for a week long trip', []],
        ['How to find cheap flights: when to book and tools to use', []],
        ['How to meal prep for a week: a beginner plan', []],
        ['How to start composting at home: a simple beginner guide', []],
    ];

    /**
     * @return array<int, array{topic:string, context:string, source_key:string}>
     */
    public function pick(AiBlogSetting $settings, int $count, bool $seasonalOnly = false): array
    {
        if ($count < 1) {
            return [];
        }

        $month = (int) now()->format('n');
        $nextMonth = $month % 12 + 1;

        $unused = array_values(array_filter(self::BANK, function ($row) use ($month, $nextMonth, $seasonalOnly) {
            if (AiBlogTopic::where('topic_hash', AiBlogTopic::hashFor($row[0]))->exists()) {
                return false;
            }
            $months = $row[1];
            if ($seasonalOnly) {
                return !empty($months) && (in_array($month, $months, true) || in_array($nextMonth, $months, true));
            }

            return true;
        }));

        // In season first, then all-year topics, then out of season ones.
        usort($unused, function ($a, $b) use ($month, $nextMonth) {
            $rank = fn ($row) => empty($row[1]) ? 1 : ((in_array($month, $row[1], true) || in_array($nextMonth, $row[1], true)) ? 0 : 2);

            return $rank($a) <=> $rank($b) ?: strcmp($a[0], $b[0]);
        });

        // Out of season topics are only worth using if nothing else is left.
        $unused = array_values(array_filter($unused, fn ($row) => $seasonalOnly
            || empty($row[1])
            || in_array($month, $row[1], true)
            || in_array($nextMonth, $row[1], true)));

        $picked = [];
        foreach (array_slice($unused, 0, $count) as $row) {
            $picked[] = $this->format($row[0], $this->contextFor($row[0]), 'bank|' . md5($row[0]));
        }

        if (count($picked) < $count) {
            $missing = $count - count($picked);
            foreach ($this->suggestFromClaude($settings, $missing, $seasonalOnly) as $idea) {
                $picked[] = $idea;
            }
        }

        return $picked;
    }

    protected function format(string $topic, string $context, string $sourceKey): array
    {
        return ['topic' => $topic, 'context' => $context, 'source_key' => $sourceKey];
    }

    protected function contextFor(string $topic): string
    {
        return 'Evergreen US explainer. Be specific and practical: real steps, concrete numbers only where you are certain, a checklist or table readers can use. Rules and prices can change, so tell readers to confirm on the official site.';
    }

    /**
     * @return array<int, array{topic:string, context:string, source_key:string}>
     */
    protected function suggestFromClaude(AiBlogSetting $settings, int $count, bool $seasonalOnly): array
    {
        try {
            $existing = AiBlogTopic::whereIn('type', ['evergreen', 'upcoming'])
                ->latest('id')->limit(150)->pluck('topic')->all();

            $claude = new ClaudeService($settings);
            $ideas = $claude->suggestEvergreenTopics($count, $existing, now()->format('F'), $seasonalOnly);

            $out = [];
            foreach ($ideas as $idea) {
                $topic = trim((string) ($idea['topic'] ?? ''));
                if ($topic === '' || AiBlogTopic::where('topic_hash', AiBlogTopic::hashFor($topic))->exists()) {
                    continue;
                }
                $out[] = $this->format($topic, trim((string) ($idea['context'] ?? '')) ?: $this->contextFor($topic), 'ai|' . md5($topic));
            }

            return array_slice($out, 0, $count);
        } catch (\Throwable $e) {
            Log::warning('Evergreen topic suggestion failed', ['error' => $e->getMessage()]);

            return [];
        }
    }
}
