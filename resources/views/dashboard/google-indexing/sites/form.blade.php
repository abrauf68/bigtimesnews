@extends('layouts.master')

@php $editing = $site->exists; @endphp

@section('title', $editing ? __('Edit Site') : __('Add Site'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.google_indexing.index') }}">{{ __('Google Indexing') }}</a></li>
    <li class="breadcrumb-item active">{{ $editing ? __('Edit Site') : __('Add Site') }}</li>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $editing ? route('dashboard.google_indexing.sites.update', $site) : route('dashboard.google_indexing.sites.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">{{ __('Website') }}</h5></div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $site->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Website URL') }}</label>
                    <input type="url" name="site_url" class="form-control" placeholder="https://example.com" value="{{ old('site_url', $site->site_url) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Search Console property') }}</label>
                    <input type="text" name="property_url" class="form-control" list="gi-properties" placeholder="https://example.com/  or  sc-domain:example.com" value="{{ old('property_url', $site->property_url) }}" required>
                    <datalist id="gi-properties">
                        @foreach ($properties as $p)<option value="{{ $p }}">@endforeach
                    </datalist>
                    <div class="form-text">{{ __('Must match the property exactly as it appears in Search Console.') }}
                        @if ($properties) {{ __('Properties on your Google account are suggested as you type.') }} @endif</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Sitemap URL') }}</label>
                    <input type="url" name="sitemap_url" class="form-control" placeholder="https://example.com/sitemap.xml" value="{{ old('sitemap_url', $site->sitemap_url) }}">
                    <div class="form-text">{{ __('A sitemap index is followed automatically.') }}</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">{{ __('Processing') }}</h5></div>
            <div class="card-body row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Daily inspection limit') }}</label>
                    <input type="number" name="daily_limit" class="form-control" min="1" max="{{ config('google_indexing.daily_hard_cap') }}" value="{{ old('daily_limit', $site->daily_limit) }}" required>
                    <div class="form-text">{{ __('Google allows up to :n per property per day.', ['n' => number_format(config('google_indexing.daily_hard_cap'))]) }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Daily batch time') }}</label>
                    <input type="time" name="batch_time" class="form-control" value="{{ old('batch_time', $site->batchTimeShort()) }}" required>
                    <div class="form-text">{{ __('Server time zone: :tz', ['tz' => config('app.timezone')]) }}</div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Batch size') }}</label>
                    <input type="number" name="batch_size" class="form-control" min="1" value="{{ old('batch_size', $site->batch_size) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Re-inspect not indexed (days)') }}</label>
                    <input type="number" name="reinspect_days" class="form-control" min="1" max="60" value="{{ old('reinspect_days', $site->reinspect_days) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Re-check indexed (days)') }}</label>
                    <input type="number" name="recheck_indexed_days" class="form-control" min="7" max="180" value="{{ old('recheck_indexed_days', $site->recheck_indexed_days) }}" required>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" name="auto_discover" value="1" id="auto_discover" @checked(old('auto_discover', $site->auto_discover))>
                        <label class="form-check-label" for="auto_discover">{{ __('Automatically discover new blog URLs (sitemap sync every hour + new posts)') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1" id="is_active" @checked(old('is_active', $site->is_active))>
                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary">{{ $editing ? __('Save changes') : __('Add site') }}</button>
        <a href="{{ $editing ? route('dashboard.google_indexing.sites.show', $site) : route('dashboard.google_indexing.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
    </form>
@endsection
