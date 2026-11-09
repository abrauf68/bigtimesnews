@extends('layouts.master')

@section('title', __('URLs') . ' - ' . $site->name)

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.google_indexing.index') }}">{{ __('Google Indexing') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.google_indexing.sites.show', $site) }}">{{ $site->name }}</a></li>
    <li class="breadcrumb-item active">{{ __('URLs') }}</li>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row g-3 mb-4">
        @foreach (['indexed' => 'success', 'not_indexed' => 'danger', 'pending' => 'secondary', 'error' => 'warning'] as $st => $color)
            <div class="col-6 col-md-3">
                <a href="{{ route('dashboard.google_indexing.urls.index', [$site, 'status' => $st]) }}" class="card h-100 text-decoration-none">
                    <div class="card-body py-3">
                        <div class="text-muted small text-capitalize">{{ str_replace('_', ' ', $st) }}</div>
                        <h4 class="mb-0 text-{{ $color }}">{{ number_format($counts[$st] ?? 0) }}</h4>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @can('update setting')
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">{{ __('Add URLs') }}</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.google_indexing.urls.store', $site) }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-7">
                        <label class="form-label">{{ __('Paste URLs (one per line)') }}</label>
                        <textarea name="urls" rows="5" class="form-control" placeholder="https://example.com/news/some-post">{{ old('urls') }}</textarea>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">{{ __('or upload a CSV') }}</label>
                        <input type="file" name="csv" class="form-control" accept=".csv,.txt">
                        <div class="form-text">{{ __('The first column (or a column named "url") is used. Duplicates and URLs from other domains are skipped.') }}</div>
                        <button class="btn btn-primary mt-3">{{ __('Import') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3"><input type="text" name="q" class="form-control" placeholder="{{ __('Search URL') }}" value="{{ request('q') }}"></div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">{{ __('All statuses') }}</option>
                        @foreach (\App\Models\IndexingUrl::STATUSES as $st)
                            <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="source" class="form-select">
                        <option value="">{{ __('All sources') }}</option>
                        @foreach (\App\Models\IndexingUrl::SOURCES as $src)
                            <option value="{{ $src }}" @selected(request('source') === $src)>{{ $src }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="from" class="form-control" value="{{ request('from') }}" title="{{ __('Added from') }}"></div>
                <div class="col-md-2"><input type="date" name="to" class="form-control" value="{{ request('to') }}" title="{{ __('Added to') }}"></div>
                <div class="col-md-1 d-flex gap-1">
                    <button class="btn btn-primary">{{ __('Go') }}</button>
                </div>
                <div class="col-12 d-flex gap-2">
                    <a href="{{ route('dashboard.google_indexing.urls.index', $site) }}" class="btn btn-sm btn-outline-secondary">{{ __('Reset') }}</a>
                    <a href="{{ route('dashboard.google_indexing.urls.export', array_merge(['site' => $site->id], request()->only('q', 'status', 'source', 'from', 'to'))) }}" class="btn btn-sm btn-outline-success"><i class="ti ti-download ti-xs me-1"></i>{{ __('Export CSV (current filter)') }}</a>
                </div>
            </form>
        </div>

        <form method="POST" action="{{ route('dashboard.google_indexing.urls.bulk', $site) }}" id="bulkForm">
            @csrf
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width:30px"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                            <th>{{ __('URL') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Coverage') }}</th>
                            <th>{{ __('Last crawl') }}</th>
                            <th>{{ __('Inspected') }}</th>
                            <th>{{ __('Source') }}</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($urls as $u)
                            <tr>
                                <td><input type="checkbox" class="form-check-input row-check" name="ids[]" value="{{ $u->id }}"></td>
                                <td style="max-width:380px"><a href="{{ $u->url }}" target="_blank" rel="noopener" class="text-break">{{ $u->url }}</a>
                                    @if ($u->last_error)<div class="small text-danger text-break">{{ \Illuminate\Support\Str::limit($u->last_error, 140) }}</div>@endif</td>
                                <td><span class="badge bg-label-{{ $u->statusBadge() }}">{{ __($u->statusLabel()) }}</span></td>
                                <td class="small">{{ $u->coverage_state ?: '-' }}</td>
                                <td class="small text-nowrap">{{ $u->last_crawl_at ? $u->last_crawl_at->format('M j, Y') : '-' }}</td>
                                <td class="small text-nowrap">{{ $u->inspected_at ? $u->inspected_at->diffForHumans() : '-' }}</td>
                                <td><span class="badge bg-label-secondary">{{ $u->source }}</span></td>
                                <td class="text-end text-nowrap">
                                    @if ($u->status !== 'indexed')
                                        <a href="{{ $u->searchConsoleLink() }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-success" title="{{ __('Opens Google Search Console. Click "Request indexing" there.') }}">{{ __('Request') }} <i class="ti ti-external-link ti-xs"></i></a>
                                    @endif
                                    @can('update setting')
                                        <button type="submit" form="inspect-{{ $u->id }}" class="btn btn-sm btn-outline-primary">{{ __('Inspect') }}</button>
                                    @endcan
                                    @can('delete setting')
                                        <button type="submit" form="delete-{{ $u->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Remove this URL?') }}')">&times;</button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-5">{{ __('No URLs match.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @can('update setting')
                <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted small">{{ __('With selected:') }}</span>
                    <button type="submit" name="action" value="inspect" class="btn btn-sm btn-primary">{{ __('Inspect') }}</button>
                    @can('delete setting')
                        <button type="submit" name="action" value="delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Remove the selected URLs?') }}')">{{ __('Delete') }}</button>
                    @endcan
                </div>
            @endcan
        </form>
        <div class="card-body pt-0 d-flex justify-content-end">{{ $urls->onEachSide(1)->links('pagination::bootstrap-5') }}</div>

        {{-- Per-row forms live outside the bulk form (HTML forms cannot be nested). --}}
        @foreach ($urls as $u)
            <form id="inspect-{{ $u->id }}" method="POST" action="{{ route('dashboard.google_indexing.urls.inspect', [$site, $u]) }}">@csrf</form>
            <form id="delete-{{ $u->id }}" method="POST" action="{{ route('dashboard.google_indexing.urls.destroy', [$site, $u]) }}">@csrf @method('DELETE')</form>
        @endforeach
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('checkAll')?.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(function (c) { c.checked = this.checked; }, this);
        });
    </script>
@endsection
