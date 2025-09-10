@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')
@section('page_title', 'Quản lý người dùng')

@section('breadcrumb')
    <li class="breadcrumb-item active">Quản lý người dùng</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i> Danh sách người dùng
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm người dùng
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>s
                            <th>Loại tài khoản</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->tennguoidung }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @switch($user->loai_taikhoan)
                                    @case(0)
                                        <span class="badge badge-danger">Admin</span>
                                        @break
                                    @case(1)
                                        <span class="badge badge-primary">Khách hàng</span>
                                        @break
                                    @case(2)
                                        <span class="badge badge-warning">Nhân viên</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">Không xác định</span>
                                @endswitch
                            </td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <a href="#" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="#" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có người dùng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-user-shield"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Admin</span>
                <span class="info-box-number">{{ \DB::table('taikhoan')->where('loai_taikhoan', 0)->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Khách hàng</span>
                <span class="info-box-number">{{ \DB::table('taikhoan')->where('loai_taikhoan', 1)->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-user-tie"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Nhân viên</span>
                <span class="info-box-number">{{ \DB::table('taikhoan')->where('loai_taikhoan', 2)->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng cộng</span>
                <span class="info-box-number">{{ \DB::table('taikhoan')->count() }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Phân bố người dùng
                </h3>
            </div>
            <div class="card-body">
                <canvas id="userChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> Thống kê đăng ký
                </h3>
            </div>
            <div class="card-body">
                <canvas id="registrationChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $adminCount = \DB::table('taikhoan')->where('loai_taikhoan', 0)->count();
    $customerCount = \DB::table('taikhoan')->where('loai_taikhoan', 1)->count();
    $staffCount = \DB::table('taikhoan')->where('loai_taikhoan', 2)->count();
@endphp

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Distribution Chart
    var userCtx = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(userCtx, {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Khách hàng', 'Nhân viên'],
            datasets: [{
                data: [{{ $adminCount }}, {{ $customerCount }}, {{ $staffCount }}],
                backgroundColor: ['#dc3545', '#007bff', '#ffc107']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Registration Chart
    var regCtx = document.getElementById('registrationChart').getContext('2d');
    var regChart = new Chart(regCtx, {
        type: 'bar',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Người dùng mới',
                data: [12, 19, 3, 5, 2, 3, 15, 8, 12, 9, 6, 4],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
