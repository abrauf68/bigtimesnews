<div class="d-flex flex-wrap mb-4 gap-2">
    <a href="{{ route('dashboard.google_indexing.index') }}" class="btn {{ request()->routeIs('dashboard.google_indexing.index') ? 'btn-primary' : 'btn-outline-primary' }}">{{ __('Overview') }}</a>
    <a href="{{ route('dashboard.google_indexing.logs') }}" class="btn {{ request()->routeIs('dashboard.google_indexing.logs') ? 'btn-primary' : 'btn-outline-primary' }}">{{ __('Activity Log') }}</a>
    @can('create setting')
        <a href="{{ route('dashboard.google_indexing.sites.create') }}" class="btn btn-outline-success ms-auto">
            <i class="ti ti-plus ti-xs me-1"></i>{{ __('Add Site') }}
        </a>
    @endcan
</div>
