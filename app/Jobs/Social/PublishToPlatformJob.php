<?php

namespace App\Jobs\Social;

use App\Models\SocialPostTarget;
use App\Services\Social\SocialPublishingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class PublishToPlatformJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $timeout = 120;

    public function __construct(protected int $targetId)
    {
    }

    public function backoff(): array
    {
        return [60, 300, 900, 1800];
    }

    public function handle(SocialPublishingService $service): void
    {
        $target = SocialPostTarget::find($this->targetId);

        if (!$target) {
            return;
        }

        $service->publishTarget($target, $this->attempts());
    }

    public function failed(Throwable $exception): void
    {
        $target = SocialPostTarget::find($this->targetId);

        if ($target && $target->status !== 'posted') {
            $target->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
        }
    }
}
