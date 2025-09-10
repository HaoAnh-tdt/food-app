@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Quản lý đơn hàng')

@section('breadcrumb')
    <li class="breadcrumb-item active">Quản lý đơn hàng</li>
@endsection

@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">
@endpush

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart"></i> Danh sách đơn hàng
                </h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm đơn hàng
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="orders-table" class="table table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->tennguoidung }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ number_format($order->tongtien) }} VNĐ</td>
                            <td>
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
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-sm btn-info">
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
                            <td colspan="7" class="text-center">Chưa có đơn hàng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Chờ xác nhận</span>
                <span class="info-box-number">{{ \DB::table('orders')->where('trangthai', 'Chờ xác nhận')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Đã xác nhận</span>
                <span class="info-box-number">{{ \DB::table('orders')->where('trangthai', 'Đã xác nhận')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fas fa-truck"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Đang giao hàng</span>
                <span class="info-box-number">{{ \DB::table('orders')->where('trangthai', 'Đang giao hàng')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-check-double"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Đã giao hàng</span>
                <span class="info-box-number">{{ \DB::table('orders')->where('trangthai', 'Đã giao hàng')->count() }}</span>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<!-- DataTables + extensions -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

<!-- Buttons (export) -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#orders-table').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10,25,50,100],[10,25,50,100]],
        order: [[0, 'desc']], // sắp theo cột 0 (Mã món) giảm dần
        dom: 'Bfrtip', // buttons, filter, table, pagination
        buttons: [
            { extend: 'copy', text: 'Sao chép' },
            { extend: 'csv', text: 'CSV' },
            { extend: 'excel', text: 'Excel' },
            { extend: 'pdf', text: 'PDF' },
            { extend: 'print', text: 'In' },
            { extend: 'colvis', text: 'Tùy chọn cột' }
        ],
        language: {
            search: "Tìm:",
            lengthMenu: "Hiển thị _MENU_ bản ghi",
            info: "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
            infoEmpty: "Không có dữ liệu",
            infoFiltered: "(lọc từ _MAX_ bản ghi)",
            zeroRecords: "Không tìm thấy kết quả",
            paginate: {
                first: "Đầu",
                last: "Cuối",
                next: "Sau",
                previous: "Trước"
            },
            buttons: {
                copy: 'Sao chép',
                print: 'In'
            }
        }
    });

    // đưa nút buttons vào vị trí đẹp (nếu cần)
    table.buttons().container().appendTo('#monan-table_wrapper .col-md-6:eq(0)');
});
</script>


@endpush

@endsection
