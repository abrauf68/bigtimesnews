@extends('layouts.master')

@section('title', __('Google Indexing Activity Log'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.google_indexing.index') }}">{{ __('Google Indexing') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Activity Log') }}</li>
@endsection

@section('content')
    @include('dashboard.google-indexing.partials.nav')

    <div class="card">
        <div class="card-header">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="site_id" class="form-select">
                        <option value="">{{ __('All sites') }}</option>
                        @foreach ($sites as $s)
                            <option value="{{ $s->id }}" @selected(request('site_id') == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">{{ __('All types') }}</option>
                        @foreach (['oauth', 'sitemap', 'inspect', 'batch', 'discover', 'import', 'system'] as $t)
                            <option value="{{ $t }}" @selected(request('type') === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="level" class="form-select">
                        <option value="">{{ __('All levels') }}</option>
                        @foreach (['info', 'warning', 'error'] as $l)
                            <option value="{{ $l }}" @selected(request('level') === $l)>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary">{{ __('Filter') }}</button>
                    <a href="{{ route('dashboard.google_indexing.logs') }}" class="btn btn-outline-secondary">{{ __('Reset') }}</a>
                </div>
            </form>
        </div>
        <div class="card-body">
            @include('dashboard.google-indexing.partials.log-table', ['logs' => $logs, 'showSite' => true])
            {{ $logs->links() }}
        </div>
    </div>
@endsection
