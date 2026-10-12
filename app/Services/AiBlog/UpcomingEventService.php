<?php

namespace App\Services\AiBlog;

use App\Models\AiBlogEvent;
use Carbon\Carbon;

/**
 * Builds "upcoming date" topics (holidays, observances, shopping days) for the US.
 *
 * Dates are COMPUTED here (never guessed by the AI): floating holidays use the
 * "nth weekday of month" rules and Easter uses the standard Gregorian algorithm.
 * Each event expands into several search angles, each of which becomes its own post.
 *
 * Note: a topic's hash does not contain the year, so an event/angle is only ever
 * written once. The post has to be refreshed by hand in later years.
 */
class UpcomingEventService
{
    /** Window (days ahead of today) in which an event becomes eligible for a post. */
    public const MIN_DAYS = 3;
    public const MAX_DAYS = 42;

    /**
     * @return array<int, array{topic:string, context:string, source_key:string, event_date:Carbon}>
     */
    public function upcomingTopics(?Carbon $today = null, int $minDays = self::MIN_DAYS, int $maxDays = self::MAX_DAYS): array
    {
        $today = ($today ?? now())->copy()->startOfDay();
        $from = $today->copy()->addDays($minDays);
        $to = $today->copy()->addDays($maxDays);

        $topics = [];

        foreach ([$today->year, $today->year + 1] as $year) {
            foreach ($this->definitions() as $def) {
                if (!empty($def['even_years_only']) && $year % 2 !== 0) {
                    continue;
                }

                $date = ($def['date'])($year);
                if (!$date || $date->lt($from) || $date->gt($to)) {
                    continue;
                }

                foreach ($def['angles'] as $i => $template) {
                    $topics[] = [
                        'topic' => str_replace('{name}', $def['name'], $template),
                        'context' => $this->buildContext($def, $date, $today),
                        'source_key' => $def['key'] . '|' . $i,
                        'event_date' => $date,
                    ];
                }
            }
        }

        foreach ($this->customEvents($from, $to) as $event) {
            $date = Carbon::parse($event->event_date)->startOfDay();
            foreach ($this->observanceAngles() as $i => $template) {
                $topics[] = [
                    'topic' => str_replace('{name}', $event->title, $template),
                    'context' => $this->buildContext(
                        ['name' => $event->title, 'facts' => 'Custom event added by the site admin. Use only well-known, widely confirmed information about it.'],
                        $date,
                        $today
                    ),
                    'source_key' => 'custom' . $event->id . '|' . $i,
                    'event_date' => $date,
                ];
            }
        }

        // Nearest event first (least time left), then keep angle order stable.
        usort($topics, fn ($a, $b) => $a['event_date']->timestamp <=> $b['event_date']->timestamp);

        return $topics;
    }

    /**
     * All events on a given calendar year, for tests / display.
     * @return array<string, Carbon>
     */
    public function eventsForYear(int $year): array
    {
        $out = [];
        foreach ($this->definitions() as $def) {
            if (!empty($def['even_years_only']) && $year % 2 !== 0) {
                continue;
            }
            $out[$def['key']] = ($def['date'])($year);
        }

        return $out;
    }

    protected function customEvents(Carbon $from, Carbon $to)
    {
        try {
            return AiBlogEvent::where('is_active', true)
                ->whereBetween('event_date', [$from->toDateString(), $to->toDateString()])
                ->get();
        } catch (\Throwable $e) {
            return collect(); // table not migrated yet
        }
    }

    protected function buildContext(array $def, Carbon $date, Carbon $today): string
    {
        $days = $today->diffInDays($date);

        $lines = [
            "Event: {$def['name']}.",
            'Date (verified, computed by the site, do not change it): ' . $date->format('l, F j, Y') . " ({$days} days from today).",
        ];

        if (!empty($def['facts'])) {
            $lines[] = 'Verified facts you may rely on: ' . $def['facts'];
        }

        $lines[] = 'Do not state other specific dates, hours or policies unless you are certain; where businesses vary, say so and tell readers to check locally.';

        return implode(' ', $lines);
    }

    protected function observanceAngles(): array
    {
        return [
            '{name}: date, history and why it matters',
            'How Americans celebrate {name}: traditions, ideas and activities',
            '{name}: quick facts and answers to common questions',
        ];
    }

    protected function federalAngles(): array
    {
        return [
            'Are banks open on {name}? Federal Reserve, bank branch and ATM hours',
            'Is the post office open on {name}? USPS, UPS and FedEx delivery',
            'Is the stock market open on {name}? NYSE and Nasdaq trading schedule',
            'What is open and closed on {name}: stores, schools and government offices',
            '{name}: history, meaning and how Americans observe the day',
        ];
    }

    /** Easter Sunday (Anonymous Gregorian algorithm, no PHP calendar extension needed). */
    protected function easter(int $year): Carbon
    {
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($year, $month, $day, 0, 0, 0);
    }

    protected function nth(int $year, int $month, string $weekday, int $n): Carbon
    {
        $ordinals = [1 => 'first', 2 => 'second', 3 => 'third', 4 => 'fourth'];

        return Carbon::parse("{$ordinals[$n]} {$weekday} of " . Carbon::create($year, $month, 1)->format('F') . " {$year}")->startOfDay();
    }

    protected function lastWeekday(int $year, int $month, string $weekday): Carbon
    {
        return Carbon::parse("last {$weekday} of " . Carbon::create($year, $month, 1)->format('F') . " {$year}")->startOfDay();
    }

    protected function definitions(): array
    {
        $fed = $this->federalAngles();
        $obs = $this->observanceAngles();
        $fixed = fn (int $m, int $d) => fn (int $y) => Carbon::create($y, $m, $d, 0, 0, 0);
        $thanksgiving = fn (int $y) => $this->nth($y, 11, 'thursday', 4);

        $closedAll = 'Federal holiday. Federal government offices, Federal Reserve Banks and the US Postal Service are closed (no regular mail delivery), and the NYSE and Nasdaq are closed. If the holiday falls on a weekend, the observed day can differ for government, banks and exchanges, so tell readers to confirm for that specific year. UPS and FedEx schedules vary by service, so readers should check with the carrier.';

        return [
            ['key' => 'new_years_day', 'name' => "New Year's Day", 'angles' => $fed, 'date' => $fixed(1, 1), 'facts' => $closedAll],
            ['key' => 'mlk_day', 'name' => 'Martin Luther King Jr. Day', 'angles' => $fed, 'date' => fn ($y) => $this->nth($y, 1, 'monday', 3), 'facts' => $closedAll],
            ['key' => 'groundhog_day', 'name' => 'Groundhog Day', 'angles' => $obs, 'date' => $fixed(2, 2), 'facts' => 'Not a federal holiday. Observed on February 2, famously at Punxsutawney, Pennsylvania.'],
            ['key' => 'valentines_day', 'name' => "Valentine's Day", 'angles' => array_merge($obs, ["Last minute Valentine's Day gift and date ideas on a budget"]), 'date' => $fixed(2, 14), 'facts' => 'Not a federal holiday. Banks, post offices and the stock market are open as usual.'],
            ['key' => 'presidents_day', 'name' => "Presidents' Day", 'angles' => $fed, 'date' => fn ($y) => $this->nth($y, 2, 'monday', 3), 'facts' => $closedAll],
            ['key' => 'st_patricks_day', 'name' => "St. Patrick's Day", 'angles' => $obs, 'date' => $fixed(3, 17), 'facts' => 'Not a federal holiday. Banks, post offices and the stock market are open as usual.'],
            ['key' => 'dst_start', 'name' => 'Daylight Saving Time', 'angles' => [
                'When do the clocks go forward: daylight saving time start date and what to do',
                'Which US states do not observe daylight saving time',
                'How to adjust to losing an hour of sleep when the clocks change',
            ], 'date' => fn ($y) => $this->nth($y, 3, 'sunday', 2), 'facts' => 'In the US, daylight saving time begins on the second Sunday of March at 2 a.m. local time, when clocks move forward one hour. Hawaii and most of Arizona do not observe it.'],
            ['key' => 'good_friday', 'name' => 'Good Friday', 'angles' => [
                'Is the stock market open on Good Friday? NYSE and Nasdaq schedule',
                'Are banks and the post office open on Good Friday?',
            ], 'date' => fn ($y) => $this->easter($y)->subDays(2), 'facts' => 'Not a federal holiday. The NYSE and Nasdaq are closed on Good Friday. Federal Reserve Banks, most banks and the US Postal Service are generally open, though some local businesses and schools close.'],
            ['key' => 'easter', 'name' => 'Easter', 'angles' => array_merge($obs, ['Easter Sunday: what is open and closed']), 'date' => fn ($y) => $this->easter($y), 'facts' => 'Easter is on a Sunday. Not a federal holiday. Many stores and restaurants have reduced hours or are closed, and there is no regular mail delivery on Sundays.'],
            ['key' => 'tax_day', 'name' => 'Tax Day', 'angles' => [
                'Tax Day deadline: what happens if you miss it and how to avoid penalties',
                'How to file a tax extension: steps, deadline and what it does and does not cover',
            ], 'date' => $fixed(4, 15), 'facts' => 'The federal individual income tax filing deadline is normally April 15, and moves to the next business day when it falls on a weekend or holiday. Explain in general terms only and tell readers to check irs.gov or a tax professional for their situation.'],
            ['key' => 'earth_day', 'name' => 'Earth Day', 'angles' => $obs, 'date' => $fixed(4, 22), 'facts' => 'Observed every April 22. Not a federal holiday.'],
            ['key' => 'cinco_de_mayo', 'name' => 'Cinco de Mayo', 'angles' => $obs, 'date' => $fixed(5, 5), 'facts' => 'Observed on May 5. It marks the 1862 Mexican victory at the Battle of Puebla and is not Mexican Independence Day. Not a federal holiday.'],
            ['key' => 'mothers_day', 'name' => "Mother's Day", 'angles' => array_merge($obs, ["Last minute Mother's Day gift ideas that still arrive on time"]), 'date' => fn ($y) => $this->nth($y, 5, 'sunday', 2), 'facts' => "Mother's Day in the US is the second Sunday of May. Not a federal holiday."],
            ['key' => 'memorial_day', 'name' => 'Memorial Day', 'angles' => $fed, 'date' => fn ($y) => $this->lastWeekday($y, 5, 'monday'), 'facts' => $closedAll],
            ['key' => 'juneteenth', 'name' => 'Juneteenth', 'angles' => $fed, 'date' => $fixed(6, 19), 'facts' => $closedAll . ' Juneteenth became a federal holiday in 2021 and the NYSE has observed it since 2022.'],
            ['key' => 'fathers_day', 'name' => "Father's Day", 'angles' => array_merge($obs, ["Last minute Father's Day gift ideas that still arrive on time"]), 'date' => fn ($y) => $this->nth($y, 6, 'sunday', 3), 'facts' => "Father's Day in the US is the third Sunday of June. Not a federal holiday."],
            ['key' => 'independence_day', 'name' => 'the Fourth of July', 'angles' => array_merge($fed, ['Fourth of July fireworks safety tips and how to plan a cookout']), 'date' => $fixed(7, 4), 'facts' => $closedAll],
            ['key' => 'labor_day', 'name' => 'Labor Day', 'angles' => $fed, 'date' => fn ($y) => $this->nth($y, 9, 'monday', 1), 'facts' => $closedAll],
            ['key' => 'columbus_day', 'name' => "Columbus Day and Indigenous Peoples' Day", 'angles' => $fed, 'date' => fn ($y) => $this->nth($y, 10, 'monday', 2), 'facts' => 'Federal holiday on the second Monday of October. Federal offices, Federal Reserve Banks (so many banks) and the US Postal Service are closed, with no regular mail delivery. The NYSE and Nasdaq are OPEN. Some states and cities call it Indigenous Peoples\' Day instead of Columbus Day, and some local governments and schools do not close. UPS and FedEx schedules vary.'],
            ['key' => 'halloween', 'name' => 'Halloween', 'angles' => array_merge($obs, ['Halloween trick or treating safety tips for families']), 'date' => $fixed(10, 31), 'facts' => 'Observed every October 31. Not a federal holiday. Banks, post offices and the stock market are open as usual unless it falls on a weekend.'],
            ['key' => 'dst_end', 'name' => 'Daylight Saving Time', 'angles' => [
                'When do the clocks go back: daylight saving time end date and what to do',
                'Which US states do not observe daylight saving time',
                'How to adjust to the time change when the clocks fall back',
            ], 'date' => fn ($y) => $this->nth($y, 11, 'sunday', 1), 'facts' => 'In the US, daylight saving time ends on the first Sunday of November at 2 a.m. local time, when clocks move back one hour. Hawaii and most of Arizona do not observe it.'],
            ['key' => 'election_day', 'name' => 'Election Day', 'even_years_only' => true, 'angles' => [
                'Election Day polling hours: when polls open and close',
                'What to bring to vote: ID rules and how to find your polling place',
                'How to track your mail-in ballot step by step',
            ], 'date' => fn ($y) => Carbon::create($y, 11, 1)->next(Carbon::MONDAY)->addDay()->startOfDay(), 'facts' => 'General Election Day is the Tuesday after the first Monday in November (even years). Voting rules, hours and ID requirements differ by state and county, so tell readers to confirm with their state or local election office. Stay strictly neutral and factual: no endorsements, no predictions, no opinions on candidates or parties.'],
            ['key' => 'veterans_day', 'name' => 'Veterans Day', 'angles' => $fed, 'date' => $fixed(11, 11), 'facts' => 'Federal holiday on November 11. Federal offices, Federal Reserve Banks (so many banks) and the US Postal Service are closed, with no regular mail delivery. The NYSE and Nasdaq are OPEN. Many schools and local governments close, but plenty of private businesses stay open. UPS and FedEx schedules vary.'],
            ['key' => 'thanksgiving', 'name' => 'Thanksgiving', 'angles' => array_merge($fed, ['Thanksgiving grocery store hours: which stores are open and when to shop']), 'date' => $thanksgiving, 'facts' => $closedAll . ' Thanksgiving is the fourth Thursday of November. The NYSE and Nasdaq also close early (1 p.m. ET) the next day.'],
            ['key' => 'black_friday', 'name' => 'Black Friday', 'angles' => [
                'Black Friday store hours: when major retailers open and close',
                'Black Friday vs Cyber Monday: which has better deals',
                'Black Friday shopping tips: how to find real deals and avoid scams',
                'Is the stock market open on Black Friday? NYSE and Nasdaq early close',
            ], 'date' => fn ($y) => $this->nth($y, 11, 'thursday', 4)->addDay(), 'facts' => 'Black Friday is the day after Thanksgiving. It is not a federal holiday, so banks and the post office are generally open (some branches may have reduced hours). The NYSE and Nasdaq are open with an early 1 p.m. ET close. Store hours vary by retailer, so tell readers to check each store.'],
            ['key' => 'small_business_saturday', 'name' => 'Small Business Saturday', 'angles' => $obs, 'date' => fn ($y) => $this->nth($y, 11, 'thursday', 4)->addDays(2), 'facts' => 'Observed on the Saturday after Thanksgiving. Not a federal holiday.'],
            ['key' => 'cyber_monday', 'name' => 'Cyber Monday', 'angles' => [
                'Cyber Monday explained: what it is and how it differs from Black Friday',
                'Cyber Monday shopping tips: how to find real deals and avoid scams',
            ], 'date' => fn ($y) => $this->nth($y, 11, 'thursday', 4)->addDays(4), 'facts' => 'Cyber Monday is the Monday after Thanksgiving. Not a federal holiday.'],
            ['key' => 'giving_tuesday', 'name' => 'Giving Tuesday', 'angles' => [
                'Giving Tuesday: what it is and how to give wisely',
                'How to check a charity is legitimate before you donate',
            ], 'date' => fn ($y) => $this->nth($y, 11, 'thursday', 4)->addDays(5), 'facts' => 'Giving Tuesday is the Tuesday after Thanksgiving. Not a federal holiday.'],
            ['key' => 'pearl_harbor_day', 'name' => 'Pearl Harbor Remembrance Day', 'angles' => $obs, 'date' => $fixed(12, 7), 'facts' => 'Observed on December 7 in remembrance of the 1941 attack. Not a federal holiday.'],
            ['key' => 'christmas_eve', 'name' => 'Christmas Eve', 'angles' => [
                'Christmas Eve: what is open and closed (stores, banks, post office)',
                'Is the stock market open on Christmas Eve? NYSE and Nasdaq early close',
            ], 'date' => $fixed(12, 24), 'facts' => 'Not a federal holiday by default (the president sometimes grants federal employees the day off). The NYSE and Nasdaq typically close early (1 p.m. ET) on Christmas Eve when it is a weekday. Banks and the post office are generally open with reduced hours. Store hours vary.'],
            ['key' => 'christmas_day', 'name' => 'Christmas Day', 'angles' => array_merge($fed, ['What is open on Christmas Day: restaurants, stores and pharmacies']), 'date' => $fixed(12, 25), 'facts' => $closedAll],
            ['key' => 'new_years_eve', 'name' => "New Year's Eve", 'angles' => [
                "New Year's Eve: what is open and closed (stores, banks, post office)",
                "New Year's Eve ideas: how Americans celebrate at home and out",
            ], 'date' => $fixed(12, 31), 'facts' => 'Not a federal holiday. Banks and the post office are generally open with reduced hours, and the stock market is open (the NYSE closes at the normal time).'],
        ];
    }
}
