<?php

namespace App\Http\Controllers\Dashboard\GoogleIndexing;

use App\Http\Controllers\Controller;
use App\Jobs\GoogleIndexing\SubmitSitemapJob;
use App\Jobs\GoogleIndexing\SyncSitemapJob;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use App\Services\GoogleIndexing\BatchService;
use App\Services\GoogleIndexing\GoogleOAuthService;
use App\Services\GoogleIndexing\SearchConsoleClient;
use App\Services\GoogleIndexing\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class SiteController extends Controller
{
    public function index(StatsService $stats, GoogleOAuthService $oauth)
    {
        $this->authorize('view setting');

        $sites = IndexingSite::orderBy('name')->get();
        $overview = $stats->build();
        $perSite = $stats->perSite();
        $recentLogs = IndexingLog::with('site:id,name')->latest('created_at')->limit(12)->get();
        $oauthConfigured = $oauth->isConfigured();

        return view('dashboard.google-indexing.index', compact('sites', 'overview', 'perSite', 'recentLogs', 'oauthConfigured'));
    }

    public function create()
    {
        $this->authorize('create setting');

        return view('dashboard.google-indexing.sites.form', ['site' => new IndexingSite([
            'is_active' => true,
            'auto_discover' => true,
            'daily_limit' => config('google_indexing.default_daily_limit'),
            'batch_time' => '03:00',
            'batch_size' => config('google_indexing.default_batch_size'),
            'reinspect_days' => 3,
            'recheck_indexed_days' => 30,
        ]), 'properties' => []]);
    }

    public function store(Request $request)
    {
        $this->authorize('create setting');

        $site = IndexingSite::create($this->validated($request));
        IndexingLog::record($site->id, 'system', 'info', 'Site added.');

        return redirect()->route('dashboard.google_indexing.sites.show', $site)
            ->with('success', __('Site added. Now connect Google Search Console.'));
    }

    public function show(IndexingSite $site, StatsService $stats)
    {
        $this->authorize('view setting');

        $overview = $stats->build([$site->id]);
        $recentLogs = $site->logs()->latest('created_at')->limit(15)->get();

        return view('dashboard.google-indexing.sites.show', compact('site', 'overview', 'recentLogs'));
    }

    public function edit(IndexingSite $site, SearchConsoleClient $client)
    {
        $this->authorize('update setting');

        // List the properties the connected Google account can access, to help pick the right one.
        $properties = [];
        if ($site->isConnected()) {
            try {
                $properties = collect($client->listSites($site))->pluck('siteUrl')->all();
            } catch (Throwable $e) {
                Log::info('Could not list Search Console properties: ' . $e->getMessage());
            }
        }

        return view('dashboard.google-indexing.sites.form', compact('site', 'properties'));
    }

    public function update(Request $request, IndexingSite $site)
    {
        $this->authorize('update setting');

        $site->update($this->validated($request, $site));

        return redirect()->route('dashboard.google_indexing.sites.show', $site)->with('success', __('Site settings updated.'));
    }

    public function destroy(IndexingSite $site, GoogleOAuthService $oauth)
    {
        $this->authorize('delete setting');

        if ($site->isConnected()) {
            $oauth->disconnect($site);
        }
        $site->delete(); // URLs, logs and usage are removed by the foreign keys

        return redirect()->route('dashboard.google_indexing.index')->with('success', __('Site removed.'));
    }

    public function toggle(IndexingSite $site)
    {
        $this->authorize('update setting');
        $site->update(['is_active' => !$site->is_active]);

        return back()->with('success', $site->is_active ? __('Site enabled.') : __('Site paused.'));
    }

    public function syncSitemap(IndexingSite $site)
    {
        $this->authorize('update setting');

        if (!$site->sitemap_url) {
            return back()->with('error', __('Set a sitemap URL first.'));
        }

        SyncSitemapJob::dispatch($site->id);

        return back()->with('success', __('Sitemap sync queued. New URLs will appear shortly.'));
    }

    public function submitSitemap(IndexingSite $site)
    {
        $this->authorize('update setting');

        if (!$site->isConnected() || !$site->sitemap_url) {
            return back()->with('error', __('Connect Google and set a sitemap URL first.'));
        }

        SubmitSitemapJob::dispatch($site->id);

        return back()->with('success', __('Sitemap submission queued.'));
    }

    public function runBatch(IndexingSite $site, BatchService $batches)
    {
        $this->authorize('update setting');

        if (!$site->isConnected()) {
            return back()->with('error', __('Connect Google Search Console first.'));
        }

        $result = $batches->run($site, false);

        return back()->with('success', __(':n URL(s) queued for inspection.', ['n' => $result['queued']]));
    }

    protected function validated(Request $request, ?IndexingSite $site = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'site_url' => ['required', 'url', 'max:255', Rule::unique('indexing_sites', 'site_url')->ignore($site?->id)],
            'property_url' => ['required', 'string', 'max:255', 'regex:#^(sc-domain:[a-z0-9.\-]+|https?://\S+/)$#i'],
            'sitemap_url' => 'nullable|url|max:255',
            'daily_limit' => 'required|integer|min:1|max:' . config('google_indexing.daily_hard_cap'),
            'batch_time' => 'required|date_format:H:i',
            'batch_size' => 'required|integer|min:1|max:' . config('google_indexing.daily_hard_cap'),
            'reinspect_days' => 'required|integer|min:1|max:60',
            'recheck_indexed_days' => 'required|integer|min:7|max:180',
        ], [
            'property_url.regex' => __('Use the exact Search Console property: https://example.com/ (with trailing slash) or sc-domain:example.com'),
        ]);

        $data['site_url'] = rtrim($data['site_url'], '/');
        $data['is_active'] = $request->boolean('is_active');
        $data['auto_discover'] = $request->boolean('auto_discover');

        return $data;
    }
}
