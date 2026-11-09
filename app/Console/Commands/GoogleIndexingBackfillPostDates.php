<?php

namespace App\Console\Commands;

use App\Services\GoogleIndexing\PostDateResolver;
use Illuminate\Console\Command;

class GoogleIndexingBackfillPostDates extends Command
{
    protected $signature = 'google-indexing:backfill-post-dates';
    protected $description = 'Fills the blog post publish date on indexing URLs that do not have one yet.';

    public function handle(PostDateResolver $resolver): int
    {
        $s = $resolver->backfill();

        $this->info("Matched with posts: {$s['matched']}");
        $this->info("Filled from sitemap/created date (no post found): {$s['fallback']}");

        if ($s['unmatched']) {
            $this->warn('URLs with no matching post (sample):');
            foreach ($s['unmatched'] as $u) {
                $this->line('  ' . $u);
            }
        }

        return self::SUCCESS;
    }
}
