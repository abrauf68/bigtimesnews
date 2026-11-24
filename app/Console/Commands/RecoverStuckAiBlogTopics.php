<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAiBlogPostJob;
use App\Models\AiBlogTopic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecoverStuckAiBlogTopics extends Command
{
    protected $signature = 'ai-blog:recover-stuck {--minutes=15 : Treat "generating" topics older than this as stuck}';
    protected $description = 'Re-queues AI blog topics stuck on "Generating" (once), then marks them failed so they never hang forever.';

    private const MARK = '[auto-retried after stuck]';

    public function handle(): int
    {
        $cutoff = now()->subMinutes(max(5, (int) $this->option('minutes')));
        $retried = 0;
        $failed = 0;

        AiBlogTopic::where('status', 'generating')->where('updated_at', '<', $cutoff)->get()->each(function (AiBlogTopic $t) use (&$retried, &$failed) {
            if (str_contains((string) $t->error_message, self::MARK)) {
                $t->update(['status' => 'failed', 'error_message' => 'Generation got stuck twice (the server stopped the process). Please retry later.']);
                $failed++;

                return;
            }

            $t->update(['status' => 'pending', 'error_message' => self::MARK]);
            GenerateAiBlogPostJob::dispatch($t->id);
            $retried++;
        });

        if ($retried || $failed) {
            Log::warning('AI blog stuck topics recovered', ['requeued' => $retried, 'failed' => $failed]);
        }
        $this->info("Re-queued {$retried}, marked failed {$failed}.");

        return self::SUCCESS;
    }
}
