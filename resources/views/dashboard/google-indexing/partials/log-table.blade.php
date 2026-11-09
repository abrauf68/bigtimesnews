<div class="table-responsive">
    <table class="table table-sm align-middle">
        <thead>
            <tr>
                <th style="width:150px">{{ __('Time') }}</th>
                @if ($showSite ?? false)<th>{{ __('Site') }}</th>@endif
                <th>{{ __('Type') }}</th>
                <th>{{ __('Level') }}</th>
                <th>{{ __('Message') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td class="text-nowrap small">{{ $log->created_at->format('M j, H:i:s') }}</td>
                    @if ($showSite ?? false)<td>{{ $log->site->name ?? '-' }}</td>@endif
                    <td><span class="badge bg-label-secondary">{{ $log->type }}</span></td>
                    <td><span class="badge bg-label-{{ $log->levelBadge() }}">{{ $log->level }}</span></td>
                    <td>{{ $log->message }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">{{ __('No activity yet.') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
