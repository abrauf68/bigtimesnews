<?php

namespace App\Http\Controllers\Dashboard\Social;

use App\Enums\SocialPlatform;
use App\Http\Controllers\Controller;
use App\Models\SocialPostTarget;
use App\Services\Social\SocialPublishingService;
use Illuminate\Http\Request;

class SocialPostStatusController extends Controller
{
    public function index(Request $request)
    {
        $targets = SocialPostTarget::with('post')
            ->latest('updated_at')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('platform'), fn ($q) => $q->where('platform', $request->platform))
            ->paginate(25)
            ->withQueryString();

        $platforms = SocialPlatform::cases();

        return view('dashboard.social.posts', compact('targets', 'platforms'));
    }

    public function updateCaption(Request $request, SocialPostTarget $target)
    {
        $request->validate([
            'caption' => 'required|string',
            'caption_title' => 'nullable|string|max:255',
        ]);

        $target->update([
            'caption' => $request->caption,
            'caption_title' => $request->caption_title,
            'caption_source' => 'manual',
        ]);

        return redirect()->back()->with('success', 'Caption updated.');
    }

    public function retry(SocialPostTarget $target, SocialPublishingService $service)
    {
        $service->retryTarget($target);

        return redirect()->back()->with('success', 'Retry queued for ' . $target->platformEnum()->label() . '.');
    }

    public function resendNow(SocialPostTarget $target, SocialPublishingService $service)
    {
        set_time_limit(120);

        $result = $service->resendNow($target);

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
