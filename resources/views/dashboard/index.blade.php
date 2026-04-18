@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="row">

        <!-- Stats Cards -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total News</h6>
                        <h3 class="mb-0 fw-bold">12,450</h3>
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
                        <h3 class="mb-0 fw-bold">5,230</h3>
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
                        <h6 class="text-muted mb-1">Visitors</h6>
                        <h3 class="mb-0 fw-bold">85K</h3>
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
                        <h6 class="text-muted mb-1">Breaking News</h6>
                        <h3 class="mb-0 fw-bold">320</h3>
                    </div>
                    <div class="avatar bg-light-warning p-3 rounded">
                        <i class="fas fa-bolt text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-2">

        <!-- Traffic Chart -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 pb-0">
                    <h5 class="card-title mb-0">Website Traffic</h5>
                    <small class="text-muted">Last 7 days</small>
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
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
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
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>US Elections 2026 Updates</td>
                                <td><span class="badge bg-label-primary">Politics</span></td>
                                <td><span class="badge bg-label-success">Published</span></td>
                                <td>Apr 18</td>
                            </tr>
                            <tr>
                                <td>AI Tech Trends</td>
                                <td><span class="badge bg-label-info">Tech</span></td>
                                <td><span class="badge bg-label-success">Published</span></td>
                                <td>Apr 17</td>
                            </tr>
                            <tr>
                                <td>Stock Market Crash</td>
                                <td><span class="badge bg-label-warning">Finance</span></td>
                                <td><span class="badge bg-label-danger">Draft</span></td>
                                <td>Apr 16</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0">
                    <h5 class="mb-0">Top Categories</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sports</span>
                        <span class="fw-bold">230</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Entertainment</span>
                        <span class="fw-bold">174</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: 65%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Politics</span>
                        <span class="fw-bold">120</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection


@section('script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Traffic Chart
        new Chart(document.getElementById('trafficChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [12000, 15000, 14000, 18000, 22000, 25000, 30000],
                    borderColor: '#E62323',
                    tension: 0.4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['Sports', 'Entertainment', 'Politics', 'Tech'],
                datasets: [{
                    data: [230, 174, 120, 95],
                    backgroundColor: ['#E62323', '#7367F0', '#28C76F', '#FF9F43']
                }]
            }
        });
    </script>

@endsection
