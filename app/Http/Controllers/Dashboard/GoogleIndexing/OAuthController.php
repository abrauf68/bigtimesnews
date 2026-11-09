<?php

namespace App\Http\Controllers\Dashboard\GoogleIndexing;

use App\Http\Controllers\Controller;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use App\Services\GoogleIndexing\GoogleOAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class OAuthController extends Controller
{
    public function connect(IndexingSite $site, GoogleOAuthService $oauth)
    {
        $this->authorize('update setting');

        if (!$oauth->isConfigured()) {
            return redirect()->route('dashboard.google_indexing.sites.show', $site)
                ->with('error', __('Google OAuth is not configured. Set GOOGLE_INDEXING_CLIENT_ID and GOOGLE_INDEXING_CLIENT_SECRET in .env.'));
        }

        $state = Str::random(40);
        session(['gi_oauth' => ['state' => $state, 'site' => $site->id]]);

        return redirect()->away($oauth->authorizeUrl($site, $state));
    }

    public function callback(Request $request, GoogleOAuthService $oauth)
    {
        $this->authorize('update setting');

        $stored = session()->pull('gi_oauth');
        $site = $stored ? IndexingSite::find($stored['site']) : null;

        if (!$stored || !$site || !hash_equals($stored['state'], (string) $request->query('state'))) {
            return redirect()->route('dashboard.google_indexing.index')->with('error', __('The Google sign-in session expired. Please try again.'));
        }

        $back = redirect()->route('dashboard.google_indexing.sites.show', $site);

        if ($request->filled('error')) {
            IndexingLog::record($site->id, 'oauth', 'warning', 'Google authorization was cancelled or denied: ' . $request->query('error'));

            return $back->with('error', __('Google authorization was cancelled.'));
        }

        try {
            $oauth->connect($site, (string) $request->query('code'));
        } catch (Throwable $e) {
            IndexingLog::record($site->id, 'oauth', 'error', 'Connect failed: ' . $e->getMessage());

            return $back->with('error', $e->getMessage());
        }

        return $back->with('success', __('Google Search Console connected.'));
    }

    public function disconnect(IndexingSite $site, GoogleOAuthService $oauth)
    {
        $this->authorize('update setting');
        $oauth->disconnect($site);

        return back()->with('success', __('Disconnected from Google.'));
    }
}
