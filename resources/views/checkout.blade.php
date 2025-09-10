@include('header')
<link rel="stylesheet" href="{{ asset('css/monan.css') }}">
<div class="checkout-container" style="max-width:800px; margin: 10px auto; background:#fff; padding:24px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
    <h2 style="margin-bottom:20px;">Thanh toán</h2>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf

        <div style="margin-bottom:16px;">
            <label>Họ tên người nhận</label>
            <input type="text" name="name" class="checkout-input" required>
        </div>

        <div style="margin-bottom:16px;">
            <label>Địa chỉ</label>
            <input type="text" name="address" class="checkout-input" required>
        </div>

        <div style="margin-bottom:16px;">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="checkout-input" required>
        </div>

        <h3 style="margin:20px 0 10px;">Danh sách sản phẩm</h3>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; border-bottom:1px solid #ddd; padding:8px;">Món</th>
                    <th style="text-align:center; border-bottom:1px solid #ddd; padding:8px;">Số lượng</th>
                    <th style="text-align:right; border-bottom:1px solid #ddd; padding:8px;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="padding:8px;">{{ $item['tenmonan'] }}</td>
                        <td style="padding:8px; text-align:center;">{{ $item['quantity'] }}</td>
                        <td style="padding:8px; text-align:right;">{{ number_format($item['giamonan'] * $item['quantity']) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align:right; margin-top:10px; font-size:18px;">
            Tổng cộng: <strong>{{ number_format($total) }} VNĐ</strong>
        </div>

        <div style="margin:20px 0;">
            <label>Phương thức thanh toán</label><br>
            <label><input type="radio" name="payment" value="cod" checked> Thanh toán khi nhận hàng</label><br>
            <label><input type="radio" name="payment" value="online"> Thanh toán online</label>
        </div>

        <div style="text-align:right;">
            <button type="submit" class="buy-food">Đồng ý thanh toán</button>
        </div>
    </form>
</div>

<style>
.checkout-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-top: 4px;
}
</style>

