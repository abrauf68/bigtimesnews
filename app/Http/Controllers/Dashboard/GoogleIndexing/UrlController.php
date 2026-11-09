<?php

namespace App\Http\Controllers\Dashboard\GoogleIndexing;

use App\Http\Controllers\Controller;
use App\Jobs\GoogleIndexing\InspectUrlJob;
use App\Models\IndexingApiUsage;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use App\Models\IndexingUrl;
use App\Services\GoogleIndexing\UrlRegistrar;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UrlController extends Controller
{
    public function index(Request $request, IndexingSite $site)
    {
        $this->authorize('view setting');

        $urls = $this->filtered($request, $site)->orderByRaw('COALESCE(published_at, created_at) DESC')->orderByDesc('id')->paginate(50)->withQueryString();
        $counts = IndexingUrl::where('site_id', $site->id)->selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status');

        return view('dashboard.google-indexing.urls.index', compact('site', 'urls', 'counts'));
    }

    /** Bulk add (pasted list) and CSV upload share this action. */
    public function store(Request $request, IndexingSite $site, UrlRegistrar $registrar)
    {
        $this->authorize('update setting');

        $request->validate([
            'urls' => 'nullable|string|max:500000',
            'csv' => 'nullable|file|mimes:csv,txt|max:5120',
        ]);

        $list = [];
        $source = 'manual';

        if ($request->filled('urls')) {
            $list = preg_split('/[\s,]+/', (string) $request->input('urls'), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        }

        if ($request->hasFile('csv')) {
            $source = 'csv';
            $list = array_merge($list, $this->readCsv($request->file('csv')->getRealPath()));
        }

        if (!$list) {
            return back()->with('error', __('Paste at least one URL or upload a CSV file.'))->withInput();
        }

        if (count($list) > 20000) {
            return back()->with('error', __('Please import at most 20,000 URLs at a time.'))->withInput();
        }

        $r = $registrar->add($site, $list, $source);
        IndexingLog::record($site->id, 'import', 'info', sprintf('Import: %d added, %d duplicate, %d rejected.', $r['added'], $r['duplicates'], $r['rejected']));

        return back()->with('success', __(':added added, :dup already existed, :rej rejected (wrong domain or invalid). :q queued for inspection now; the rest follow in the daily batch.', [
            'added' => $r['added'], 'dup' => $r['duplicates'], 'rej' => $r['rejected'], 'q' => $r['queued'],
        ]));
    }

    public function bulk(Request $request, IndexingSite $site)
    {
        $this->authorize('update setting');

        $data = $request->validate([
            'action' => 'required|in:inspect,delete,requested',
            'ids' => 'required|array|min:1|max:2000',
            'ids.*' => 'integer',
        ]);

        $ids = IndexingUrl::where('site_id', $site->id)->whereIn('id', $data['ids'])->pluck('id')->all();

        if ($data['action'] === 'delete') {
            $this->authorize('delete setting');
            IndexingUrl::whereIn('id', $ids)->delete();

            return back()->with('success', __(':n URL(s) removed.', ['n' => count($ids)]));
        }

        if ($data['action'] === 'requested') {
            IndexingUrl::whereIn('id', $ids)->whereNull('requested_at')->update(['requested_at' => now()]);

            return back()->with('success', __(':n URL(s) marked as requested.', ['n' => count($ids)]));
        }

        $remaining = max(0, $site->effectiveDailyLimit() - IndexingApiUsage::inspectionsToday($site->id));
        $queue = array_slice($ids, 0, $remaining);
        foreach ($queue as $i => $id) {
            InspectUrlJob::dispatch($id)->delay(now()->addSeconds(min($i, 600)));
        }

        return back()->with('success', __(':n URL(s) queued for inspection (:left API calls were left today).', ['n' => count($queue), 'left' => $remaining]));
    }

    public function inspect(IndexingSite $site, IndexingUrl $url)
    {
        $this->authorize('update setting');
        abort_unless($url->site_id === $site->id, 404);

        if (!$site->isConnected()) {
            return back()->with('error', __('Connect Google Search Console first.'));
        }

        InspectUrlJob::dispatch($url->id);

        return back()->with('success', __('Inspection queued.'));
    }

    /** Called when the admin clicks "Request" (they then request indexing manually in Search Console). */
    public function markRequested(Request $request, IndexingSite $site, IndexingUrl $url)
    {
        $this->authorize('update setting');
        abort_unless($url->site_id === $site->id, 404);

        if (!$url->requested_at) {
            $url->update(['requested_at' => now()]);
            IndexingLog::record($site->id, 'inspect', 'info', 'Marked as "Requested" (indexing requested manually in Search Console).', ['url' => $url->url], $url->id);
        }

        return $request->expectsJson() ? response()->json(['ok' => true, 'label' => 'Requested']) : back()->with('success', __('Marked as requested.'));
    }

    public function destroy(IndexingSite $site, IndexingUrl $url)
    {
        $this->authorize('delete setting');
        abort_unless($url->site_id === $site->id, 404);
        $url->delete();

        return back()->with('success', __('URL removed.'));
    }

    public function export(Request $request, IndexingSite $site): StreamedResponse
    {
        $this->authorize('view setting');

        $query = $this->filtered($request, $site)->orderByRaw('COALESCE(published_at, created_at) DESC')->orderByDesc('id');
        $filename = 'indexing-' . \Illuminate\Support\Str::slug($site->name) . '-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel opens it correctly
            fputcsv($out, ['URL', 'Published', 'Status', 'Coverage state', 'Verdict', 'Last crawl', 'Last inspected', 'Next inspection', 'Inspections', 'Source', 'Added', 'Error']);

            $query->chunkById(1000, function ($rows) use ($out) {
                foreach ($rows as $u) {
                    fputcsv($out, [
                        $this->csvSafe($u->url), optional($u->published_at)->format('Y-m-d H:i'), $u->statusLabel(), $this->csvSafe((string) $u->coverage_state), $u->verdict,
                        optional($u->last_crawl_at)->format('Y-m-d H:i'), optional($u->inspected_at)->format('Y-m-d H:i'),
                        optional($u->next_inspect_at)->format('Y-m-d H:i'), $u->inspect_count, $u->source,
                        $u->created_at->format('Y-m-d H:i'), $this->csvSafe((string) $u->last_error),
                    ]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    protected function filtered(Request $request, IndexingSite $site)
    {
        $q = IndexingUrl::where('site_id', $site->id);

        if ($request->filled('q')) {
            $q->where('url', 'like', '%' . str_replace(['%', '_'], ['\\%', '\\_'], $request->input('q')) . '%');
        }
        if ($request->input('status') === 'requested') {
            $q->whereNotNull('requested_at')->where('status', '!=', IndexingUrl::STATUS_INDEXED);
        } elseif ($request->filled('status') && in_array($request->input('status'), IndexingUrl::STATUSES, true)) {
            $q->where('status', $request->input('status'));
        }
        if ($request->filled('source') && in_array($request->input('source'), IndexingUrl::SOURCES, true)) {
            $q->where('source', $request->input('source'));
        }
        if ($request->filled('from')) {
            $q->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $q->whereDate('created_at', '<=', $request->input('to'));
        }

        return $q;
    }

    /** @return array<int,string> */
    protected function readCsv(string $path): array
    {
        $urls = [];
        $handle = fopen($path, 'r');
        if (!$handle) {
            return [];
        }

        $urlColumn = 0;
        $first = true;
        while (($row = fgetcsv($handle)) !== false) {
            if ($first) {
                $first = false;
                $header = array_map(fn ($v) => strtolower(trim((string) $v, " \t\n\r\0\x0B\xEF\xBB\xBF")), $row);
                $idx = array_search('url', $header, true);
                if ($idx === false) {
                    $idx = array_search('post link', $header, true); // the posts "Indexing Sheet" header
                }
                if ($idx !== false) {
                    $urlColumn = $idx;
                    continue; // header row
                }
            }
            if (isset($row[$urlColumn]) && trim($row[$urlColumn]) !== '') {
                $urls[] = trim($row[$urlColumn]);
            }
        }
        fclose($handle);

        return $urls;
    }

    /** Prevent spreadsheet formula injection in exported cells. */
    protected function csvSafe(string $value): string
    {
        return preg_match('/^[=+\-@\t\r]/', $value) ? "'" . $value : $value;
    }
}
