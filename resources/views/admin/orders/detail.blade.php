@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('page_title', 'Chi tiết đơn hàng #' . $order->id)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Quản lý đơn hàng</a></li>
    <li class="breadcrumb-item active">Chi tiết</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Chi tiết đơn hàng
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Món ăn</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                        <tr>
                            <td>{{ $item->tenmonan }}</td>
                            <td>{{ number_format($item->giamonan) }} VNĐ</td>
                            <td>{{ $item->soluong }}</td>
                            <td>{{ number_format($item->giamonan * $item->soluong) }} VNĐ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Tổng cộng:</th>
                            <th>{{ number_format($order->tongtien) }} VNĐ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i> Thông tin khách hàng
                </h3>
            </div>
            <div class="card-body">
                <p><strong>Tên:</strong> {{ $order->tennguoidung }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->sdt }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->diachi }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Thông tin đơn hàng
                </h3>
            </div>
            <div class="card-body">
                <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái:</strong> 
                    @switch($order->trangthai)
                        @case('Chờ xác nhận')
                            <span class="badge badge-warning">{{ $order->trangthai }}</span>
                            @break
                        @case('Đã xác nhận')
                            <span class="badge badge-info">{{ $order->trangthai }}</span>
                            @break
                        @case('Đang giao hàng')
                            <span class="badge badge-primary">{{ $order->trangthai }}</span>
                            @break
                        @case('Đã giao hàng')
                            <span class="badge badge-success">{{ $order->trangthai }}</span>
                            @break
                        @case('Đã hủy')
                            <span class="badge badge-danger">{{ $order->trangthai }}</span>
                            @break
                        @default
                            <span class="badge badge-secondary">{{ $order->trangthai }}</span>
                    @endswitch
                </p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->tongtien) }} VNĐ</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Cập nhật trạng thái
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="trangthai">Trạng thái:</label>
                        <select name="trangthai" id="trangthai" class="form-control">
                            <option value="Chờ xác nhận" {{ $order->trangthai == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="Đã xác nhận" {{ $order->trangthai == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="Đang giao hàng" {{ $order->trangthai == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="Đã giao hàng" {{ $order->trangthai == 'Đã giao hàng' ? 'selected' : '' }}>Đã giao hàng</option>
                            <option value="Đã hủy" {{ $order->trangthai == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-print"></i> Thao tác
                </h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fas fa-print"></i> In đơn hàng
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
