@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="row">

        <!-- Stats Cards -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Posts</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalPosts) }}</h3>
                    </div>
                    <div class="avatar bg-light-danger p-3 rounded">
                        <i class="fas fa-newspaper text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Users</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-3 rounded">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Views</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalViews) }}</h3>
                    </div>
                    <div class="avatar bg-light-success p-3 rounded">
                        <i class="fas fa-chart-line text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Likes</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalLikes) }}</h3>
                    </div>
                    <div class="avatar bg-light-warning p-3 rounded">
                        <i class="fas fa-heart text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-2">

        <!-- Engagement Trend Chart -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 pb-0">
                    <h5 class="card-title mb-0">Engagement Trend</h5>
                    <small class="text-muted">Likes & comments, last 7 days</small>
                </div>
                <div class="card-body">
                    <canvas id="trafficChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Chart -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 pb-0">
                    <h5 class="card-title mb-0">Category Split</h5>
                    <small class="text-muted">Posts per category</small>
                </div>
                <div class="card-body">
                    @if($categorySplit->isEmpty())
                        <p class="text-muted text-center mb-0 py-4">No categories yet.</p>
                    @else
                        <canvas id="categoryChart"></canvas>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-2">

        <!-- Latest News -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0">
                    <h5 class="mb-0">Latest News</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Likes</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPosts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('dashboard.posts.show', $post->id) }}" class="text-body">
                                            {{ \Illuminate\Support\Str::limit($post->title, 45) }}
                                        </a>
                                    </td>
                                    <td><span class="badge bg-label-primary">{{ $post->category->name ?? 'N/A' }}</span></td>
                                    <td>
                                        @if($post->status === 'published')
                                            <span class="badge bg-label-success">Published</span>
                                        @else
                                            <span class="badge bg-label-danger">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($post->likes_count) }}</td>
                                    <td>{{ number_format($post->comments_count) }}</td>
                                    <td>{{ $post->created_at->format('M d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No posts yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Most Liked Posts -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0">
                    <h5 class="mb-0">Most Liked Posts</h5>
                </div>
                <div class="card-body">
                    @forelse($topLikedPosts as $post)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-truncate" style="max-width: 75%;">{{ $post->title }}</span>
                            <span class="fw-bold">{{ number_format($post->likes_count) }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-danger" style="width: {{ $post->likes_count > 0 ? round(($post->likes_count / $topLikedMax) * 100) : 0 }}%"></div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0 py-4">No likes yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection


@section('script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const trendLabels = @json($trendLabels);
        const trendLikes = @json($trendLikes);
        const trendComments = @json($trendComments);

        new Chart(document.getElementById('trafficChart'), {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [
                    {
                        label: 'Likes',
                        data: trendLikes,
                        borderColor: '#E62323',
                        backgroundColor: 'rgba(230, 35, 35, 0.08)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Comments',
                        data: trendComments,
                        borderColor: '#7367F0',
                        backgroundColor: 'rgba(115, 103, 240, 0.08)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        @if($categorySplit->isNotEmpty())
        const categoryLabels = @json($categorySplit->pluck('name'));
        const categoryCounts = @json($categorySplit->pluck('posts_count'));

        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryCounts,
                    backgroundColor: ['#E62323', '#7367F0', '#28C76F', '#FF9F43', '#00CFE8', '#A8AAAE']
                }]
            }
        });
        @endif
    </script>

@endsection
