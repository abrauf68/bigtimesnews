<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        if (typeof Chart === 'undefined') { return; }
        const o = @json($overview);

        new Chart(document.getElementById('giStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['{{ __('Indexed') }}', '{{ __('Not Indexed') }}', '{{ __('Pending') }}', '{{ __('Error') }}'],
                datasets: [{ data: [o.indexed, o.not_indexed, o.pending, o.error], backgroundColor: ['#28c76f', '#ea5455', '#a8aaae', '#ff9f43'], borderWidth: 0 }]
            },
            options: { maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'bottom' } } }
        });

        new Chart(document.getElementById('giTrendChart'), {
            type: 'line',
            data: {
                labels: o.labels,
                datasets: [
                    { label: '{{ __('API inspections') }}', data: o.series_inspections, borderColor: '#00cfe8', backgroundColor: 'rgba(0,207,232,.12)', fill: true, tension: .3 },
                    { label: '{{ __('Newly indexed') }}', data: o.series_new_indexed, borderColor: '#28c76f', tension: .3 },
                    { label: '{{ __('New URLs added') }}', data: o.series_new_urls, borderColor: '#7367f0', tension: .3 }
                ]
            },
            options: { maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, plugins: { legend: { position: 'bottom' } } }
        });
    })();
</script>
