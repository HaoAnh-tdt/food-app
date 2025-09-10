{{-- resources/views/orders/partial_show.blade.php --}}
<div class="order-detail-modal">
    <h3>Chi tiết đơn #{{ $order->id }}</h3>

    <p><strong>Khách:</strong> {{ $order->TenNguoiNhan }} | {{ $order->Sdt }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->DiaChi }}</p>
    <p><strong>Thanh toán:</strong> {{ $order->PhuongThucThanhToan }}</p>
    <hr>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Món</th>
                <th style="text-align:center; padding:8px; border-bottom:1px solid #eee;">Số lượng</th>
                <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">Giá</th>
                <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $it)
            <tr>
                <td style="padding:8px;">{{ $it->tenmonan }}</td>
                <td style="padding:8px; text-align:center;">{{ $it->soluong }}</td>
                <td style="padding:8px; text-align:right;">{{ number_format($it->gia) }} VNĐ</td>
                <td style="padding:8px; text-align:right;">{{ number_format($it->tonggia) }} VNĐ</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="text-align:right; margin-top:10px; font-weight:700;">
        Tổng: {{ number_format($order->TongTien) }} VNĐ
    </div>
</div>
