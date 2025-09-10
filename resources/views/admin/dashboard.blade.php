@extends('admin.layouts.app')

@section('title', 'Dashboard v3')
@section('page_title', 'Dashboard v3')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard v3</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <!-- Online Store Visitors -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Online Store Visitors
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">820 Visitors Over Time</h5>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +12.5% Since last week
                        </small>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm">View Report</a>
                </div>
                <div class="chart">
                    <canvas id="visitorsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Sales -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    Sales
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">$18,230.00 Sales Over Time</h5>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +33.1% Since last month
                        </small>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm">View Report</a>
                </div>
                <div class="chart">
                    <canvas id="salesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Products -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box"></i>
                    Products
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Sales</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Some Product</td>
                            <td>$13 USD</td>
                            <td>
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> +12%
                                </span>
                                12,000 Sold
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Another Product</td>
                            <td>$29 USD</td>
                            <td>
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> +0.9%
                                </span>
                                123,234 Sold
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Amazing Product</td>
                            <td>$1,230 USD</td>
                            <td>
                                <span class="text-danger">
                                    <i class="fas fa-arrow-down"></i> -3%
                                </span>
                                198 Sold
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Perfect Item</td>
                            <td>$199 USD</td>
                            <td>
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> +6%
                                </span>
                                87 Sold
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Online Store Overview -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    Online Store Overview
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">+12% CONVERSION RATE</h5>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +2.5% Since last month
                        </small>
                    </div>
                    <i class="fas fa-arrow-up text-success fa-2x"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">+0.8% SALES RATE</h5>
                        <small class="text-warning">
                            <i class="fas fa-arrow-up"></i> +0.3% Since last month
                        </small>
                    </div>
                    <i class="fas fa-shopping-cart text-warning fa-2x"></i>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i>
                    Recent Orders
                </h3>
            </div>
            <div class="card-body">
                @forelse($recentOrders as $order)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>#{{ $order->id }}</strong>
                        <br>
                        <small>{{ $order->tennguoidung }}</small>
                    </div>
                    <div class="text-right">
                        <span class="badge badge-{{ $order->trangthai == 'Chờ xác nhận' ? 'warning' : ($order->trangthai == 'Đã giao hàng' ? 'success' : 'info') }}">
                            {{ $order->trangthai }}
                        </span>
                        <br>
                        <small>{{ number_format($order->tongtien) }} VNĐ</small>
                    </div>
                </div>
                @empty
                <p class="text-muted">Chưa có đơn hàng nào</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng đơn hàng</span>
                <span class="info-box-number">{{ number_format($totalOrders) }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    70% Increase in 30 days
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Người dùng</span>
                <span class="info-box-number">{{ number_format($totalUsers) }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    70% Increase in 30 days
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-hamburger"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Món ăn</span>
                <span class="info-box-number">{{ number_format($totalMonAn) }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    70% Increase in 30 days
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-chart-line"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Doanh thu</span>
                <span class="info-box-number">{{ number_format($totalRevenue) }} VNĐ</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    70% Increase in 30 days
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Visitors Chart
    var visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
    var visitorsChart = new Chart(visitorsCtx, {
        type: 'line',
        data: {
            labels: ['16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
            datasets: [{
                label: 'This Week',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 60, 70, 85, 90, 75, 80, 95],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }, {
                label: 'Last Week',
                data: [45, 49, 60, 61, 46, 45, 30, 35, 50, 60, 75, 80, 65, 70, 85],
                borderColor: 'rgb(201, 203, 207)',
                backgroundColor: 'rgba(201, 203, 207, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 200
                }
            }
        }
    });

    // Sales Chart
    var salesCtx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'This year',
                data: [12000, 19000, 3000, 5000, 2000, 3000, 15000],
                backgroundColor: 'rgb(75, 192, 192)'
            }, {
                label: 'Last year',
                data: [8000, 15000, 2000, 3000, 1500, 2000, 12000],
                backgroundColor: 'rgb(201, 203, 207)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 30000
                }
            }
        }
    });
});
</script>
@endpush
