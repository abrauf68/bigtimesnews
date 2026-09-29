<?php

namespace App\Jobs\Social;

use App\Services\Social\SocialPublishingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchSocialPublishingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    public function __construct(protected int $postId)
    {
    }

    public function handle(SocialPublishingService $service): void
    {
        $service->claimAndDispatch($this->postId);
    }
}
