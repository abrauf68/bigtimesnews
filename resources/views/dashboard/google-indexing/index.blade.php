@extends('layouts.master')

@section('title', __('Google Indexing'))

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Google Indexing') }}</li>
@endsection

@section('content')
    @include('dashboard.google-indexing.partials.nav')

    @unless ($oauthConfigured)
        <div class="alert alert-warning">
            <strong>{{ __('Google OAuth is not set up yet.') }}</strong>
            {{ __('Create an OAuth client (Web application) in Google Cloud Console, enable the "Google Search Console API", add this authorized redirect URI and put the keys in .env as GOOGLE_INDEXING_CLIENT_ID and GOOGLE_INDEXING_CLIENT_SECRET:') }}
            <code class="d-block mt-2">{{ route('dashboard.google_indexing.oauth.callback') }}</code>
        </div>
    @endunless

    <div class="alert alert-info">
        {{ __('This module monitors indexing. The URL Inspection API only reports whether Google has indexed a URL; it cannot request indexing. New URLs reach Google through your sitemap, which this module imports and submits to Search Console.') }}
    </div>

    @include('dashboard.google-indexing.partials.stats')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Sites') }}</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>{{ __('Site') }}</th>
                        <th>{{ __('Google') }}</th>
                        <th>{{ __('Indexed / Total') }}</th>
                        <th>{{ __('Pending') }}</th>
                        <th>{{ __('Last batch') }}</th>
                        <th>{{ __('Last sitemap sync') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sites as $site)
                        @php
                            $c = $perSite[$site->id] ?? [];
                            $total = array_sum($c);
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.google_indexing.sites.show', $site) }}" class="fw-semibold">{{ $site->name }}</a>
                                @unless ($site->is_active)<span class="badge bg-label-secondary ms-1">{{ __('Paused') }}</span>@endunless
                                <div class="text-muted small">{{ $site->site_url }}</div>
                            </td>
                            <td>
                                @if ($site->isConnected())
                                    <span class="badge bg-label-{{ $site->isHealthy() ? 'success' : 'danger' }}">{{ $site->isHealthy() ? __('Connected') : __('Needs attention') }}</span>
                                @else
                                    <span class="badge bg-label-secondary">{{ __('Not connected') }}</span>
                                @endif
                            </td>
                            <td>{{ number_format($c['indexed'] ?? 0) }} / {{ number_format($total) }}</td>
                            <td>{{ number_format($c['pending'] ?? 0) }}</td>
                            <td class="small">{{ $site->last_batch_at ? $site->last_batch_at->diffForHumans() : '-' }}</td>
                            <td class="small">{{ $site->last_sitemap_sync_at ? $site->last_sitemap_sync_at->diffForHumans() : '-' }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('dashboard.google_indexing.sites.show', $site) }}" class="btn btn-sm btn-outline-primary">{{ __('Open') }}</a>
                                <a href="{{ route('dashboard.google_indexing.urls.index', $site) }}" class="btn btn-sm btn-outline-secondary">{{ __('URLs') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">{{ __('No sites yet. Add your first site to get started.') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">{{ __('Recent activity') }}</h5>
            <a href="{{ route('dashboard.google_indexing.logs') }}">{{ __('View all') }}</a>
        </div>
        <div class="card-body">
            @include('dashboard.google-indexing.partials.log-table', ['logs' => $recentLogs, 'showSite' => true])
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.google-indexing.partials.charts-js')
@endsection
