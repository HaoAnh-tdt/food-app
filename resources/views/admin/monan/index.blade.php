@extends('admin.layouts.app')

@section('title', 'Quản lý món ăn')
@section('page_title', 'Quản lý món ăn')

@section('breadcrumb')
    <li class="breadcrumb-item active">Quản lý món ăn</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-hamburger"></i> Danh sách món ăn
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm món ăn
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Mã món</th>
                            <th>Tên món</th>
                            <th>Loại món</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monan as $mon)
                        <tr>
                            <td>{{ $mon->mamonan }}</td>
                            <td>{{ $mon->tenmonan }}</td>
                            <td>{{ $mon->tenloai }}</td>
                            <td>{{ number_format($mon->giamonan) }} VNĐ</td>
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
                            <td colspan="6" class="text-center">Chưa có món ăn nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $monan->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-hamburger"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng món ăn</span>
                <span class="info-box-number">{{ number_format(\DB::table('monan')->count()) }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Loại món</span>
                <span class="info-box-number">{{ \DB::table('loaimonan')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-image"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Hình ảnh</span>
                <span class="info-box-number">{{ \DB::table('hinhanh')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Đánh giá</span>
                <span class="info-box-number">4.5/5</span>
            </div>
        </div>
    </div>
</div>
@endsection
