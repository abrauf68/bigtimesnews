<?php

namespace App\Http\Controllers\Dashboard\GoogleIndexing;

use App\Http\Controllers\Controller;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view setting');

        $q = IndexingLog::with('site:id,name')->latest('created_at');
        foreach (['site_id', 'type', 'level'] as $f) {
            if ($request->filled($f)) {
                $q->where($f, $request->input($f));
            }
        }

        $logs = $q->paginate(50)->withQueryString();
        $sites = IndexingSite::orderBy('name')->get(['id', 'name']);

        return view('dashboard.google-indexing.logs', compact('logs', 'sites'));
    }
}
