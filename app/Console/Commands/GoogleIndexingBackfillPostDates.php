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
        $this->info('Updated ' . $resolver->backfill() . ' URL(s).');

        return self::SUCCESS;
    }
}
