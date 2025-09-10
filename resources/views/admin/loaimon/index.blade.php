@extends('admin.layouts.app')

@section('title', 'Quản lý loại món')
@section('page_title', 'Quản lý loại món')

@section('breadcrumb')
    <li class="breadcrumb-item active">Quản lý loại món</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Danh sách loại món
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm loại món
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Mã loại</th>
                            <th>Tên loại</th>
                            <th>Số món ăn</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loaimon as $loai)
                        <tr>
                            <td>{{ $loai->maloai }}</td>
                            <td>{{ $loai->tenloai }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ \DB::table('monan')->where('maloai', $loai->maloai)->count() }}
                                </span>
                            </td>
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
                            <td colspan="5" class="text-center">Chưa có loại món nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $loaimon->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng loại món</span>
                <span class="info-box-number">{{ \DB::table('loaimonan')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-hamburger"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng món ăn</span>
                <span class="info-box-number">{{ \DB::table('monan')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-chart-pie"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Trung bình món/loại</span>
                <span class="info-box-number">{{ round(\DB::table('monan')->count() / max(\DB::table('loaimonan')->count(), 1), 1) }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Loại phổ biến</span>
                <span class="info-box-number">Món chính</span>
            </div>
        </div>
    </div>
</div>
@endsection
