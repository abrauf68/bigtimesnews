@extends('layouts.master')

@section('title', $site->name)

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.google_indexing.index') }}">{{ __('Google Indexing') }}</a></li>
    <li class="breadcrumb-item active">{{ $site->name }}</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between gap-3">
                <div>
                    <h4 class="mb-1">{{ $site->name }}
                        @unless ($site->is_active)<span class="badge bg-label-secondary ms-1">{{ __('Paused') }}</span>@endunless
                    </h4>
                    <div class="text-muted">{{ $site->site_url }}</div>
                    <div class="mt-2">
                        @if ($site->isConnected())
                            <span class="badge bg-label-{{ $site->isHealthy() ? 'success' : 'danger' }}">
                                {{ $site->isHealthy() ? __('Google connected') : __('Needs attention') }}</span>
                            @if ($site->google_email)<span class="text-muted small ms-2">{{ $site->google_email }}</span>@endif
                        @else
                            <span class="badge bg-label-secondary">{{ __('Not connected to Google') }}</span>
                        @endif
                        <span class="text-muted small ms-2">{{ __('Property') }}: {{ $site->property_url }}</span>
                    </div>
                    @if (!$site->isHealthy() && $site->health_message)
                        <div class="alert alert-danger mt-3 mb-0">{{ $site->health_message }}</div>
                    @endif
                </div>

                <div class="d-flex flex-wrap align-items-start gap-2">
                    @can('update setting')
                        @if ($site->isConnected())
                            <form method="POST" action="{{ route('dashboard.google_indexing.sites.run_batch', $site) }}">@csrf
                                <button class="btn btn-primary"><i class="ti ti-player-play ti-xs me-1"></i>{{ __('Run batch now') }}</button></form>
                            <form method="POST" action="{{ route('dashboard.google_indexing.sites.submit_sitemap', $site) }}">@csrf
                                <button class="btn btn-outline-primary">{{ __('Submit sitemap') }}</button></form>
                        @endif
                        <form method="POST" action="{{ route('dashboard.google_indexing.sites.sync_sitemap', $site) }}">@csrf
                            <button class="btn btn-outline-primary">{{ __('Sync sitemap') }}</button></form>
                        @if ($site->isConnected())
                            <a href="{{ route('dashboard.google_indexing.sites.connect', $site) }}" class="btn btn-outline-secondary">{{ __('Reconnect') }}</a>
                            <form method="POST" action="{{ route('dashboard.google_indexing.sites.disconnect', $site) }}" onsubmit="return confirm('{{ __('Disconnect this site from Google?') }}')">@csrf
                                <button class="btn btn-outline-danger">{{ __('Disconnect') }}</button></form>
                        @else
                            <a href="{{ route('dashboard.google_indexing.sites.connect', $site) }}" class="btn btn-success"><i class="ti ti-brand-google ti-xs me-1"></i>{{ __('Connect Google Search Console') }}</a>
                        @endif
                    @endcan
                </div>
            </div>
            <hr>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('dashboard.google_indexing.urls.index', $site) }}" class="btn btn-sm btn-outline-secondary">{{ __('Manage URLs') }}</a>
                <a href="{{ route('dashboard.google_indexing.urls.export', $site) }}" class="btn btn-sm btn-outline-secondary">{{ __('Export CSV') }}</a>
                @can('update setting')
                    <a href="{{ route('dashboard.google_indexing.sites.edit', $site) }}" class="btn btn-sm btn-outline-secondary">{{ __('Settings') }}</a>
                    <form method="POST" action="{{ route('dashboard.google_indexing.sites.toggle', $site) }}">@csrf
                        <button class="btn btn-sm btn-outline-secondary">{{ $site->is_active ? __('Pause') : __('Resume') }}</button></form>
                @endcan
                @can('delete setting')
                    <form method="POST" action="{{ route('dashboard.google_indexing.sites.destroy', $site) }}" onsubmit="return confirm('{{ __('Remove this site and all its URLs and logs?') }}')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">{{ __('Remove') }}</button></form>
                @endcan
            </div>
        </div>
    </div>

    @include('dashboard.google-indexing.partials.stats', ['overview' => $overview])

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ __('Schedule & limits') }}</h5></div>
        <div class="card-body">
            <div class="row g-3 small">
                <div class="col-6 col-md-3"><div class="text-muted">{{ __('Daily batch') }}</div><strong>{{ $site->batchTimeShort() }}</strong> ({{ config('app.timezone') }}) · {{ number_format($site->batch_size) }} {{ __('URLs') }}</div>
                <div class="col-6 col-md-3"><div class="text-muted">{{ __('Daily limit') }}</div><strong>{{ number_format($site->effectiveDailyLimit()) }}</strong></div>
                <div class="col-6 col-md-3"><div class="text-muted">{{ __('Last batch') }}</div>{{ $site->last_batch_at ? $site->last_batch_at->format('M j, H:i') : '-' }}</div>
                <div class="col-6 col-md-3"><div class="text-muted">{{ __('Sitemap') }}</div>
                    {{ $site->sitemap_url ?: '-' }}<br>
                    <span class="text-muted">{{ __('Synced') }}: {{ $site->last_sitemap_sync_at ? $site->last_sitemap_sync_at->diffForHumans() : '-' }} ·
                        {{ __('Submitted') }}: {{ $site->last_sitemap_submit_at ? $site->last_sitemap_submit_at->diffForHumans() : '-' }} ·
                        {{ number_format($site->sitemap_urls_found) }} {{ __('URLs found') }}</span></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">{{ __('Recent activity') }}</h5>
            <a href="{{ route('dashboard.google_indexing.logs', ['site_id' => $site->id]) }}">{{ __('View all') }}</a>
        </div>
        <div class="card-body">
            @include('dashboard.google-indexing.partials.log-table', ['logs' => $recentLogs])
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.google-indexing.partials.charts-js')
@endsection
