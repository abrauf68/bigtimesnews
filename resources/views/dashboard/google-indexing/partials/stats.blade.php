@php
    $cards = [
        ['label' => __('Total URLs'), 'value' => number_format($overview['total']), 'icon' => 'ti-link', 'color' => 'primary'],
        ['label' => __('Indexed'), 'value' => number_format($overview['indexed']) . ' (' . $overview['indexed_pct'] . '%)', 'icon' => 'ti-circle-check', 'color' => 'success'],
        ['label' => __('Not Indexed'), 'value' => number_format($overview['not_indexed']), 'icon' => 'ti-circle-x', 'color' => 'danger'],
        ['label' => __('Pending'), 'value' => number_format($overview['pending']), 'icon' => 'ti-clock', 'color' => 'secondary'],
        ['label' => __('Errors'), 'value' => number_format($overview['error']), 'icon' => 'ti-alert-triangle', 'color' => 'warning'],
        ['label' => __('API calls today'), 'value' => number_format($overview['used_today']) . ' / ' . number_format($overview['limit_today']), 'icon' => 'ti-api', 'color' => 'info'],
    ];
    $apiPct = $overview['limit_today'] > 0 ? min(100, round($overview['used_today'] / $overview['limit_today'] * 100)) : 0;
@endphp
<div class="row g-3 mb-4">
    @foreach ($cards as $c)
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-label-{{ $c['color'] }} p-2 me-2"><i class="ti {{ $c['icon'] }} ti-sm"></i></span>
                        <span class="text-muted small">{{ $c['label'] }}</span>
                    </div>
                    <h5 class="mb-0">{{ $c['value'] }}</h5>
                    @if ($c['icon'] === 'ti-api')
                        <div class="progress mt-2" style="height:6px"><div class="progress-bar bg-info" style="width:{{ $apiPct }}%"></div></div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">{{ __('Index status') }}</h5></div>
            <div class="card-body"><div style="height:260px"><canvas id="giStatusChart"></canvas></div></div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">{{ __('Last 14 days') }}</h5></div>
            <div class="card-body"><div style="height:260px"><canvas id="giTrendChart"></canvas></div></div>
        </div>
    </div>
</div>
