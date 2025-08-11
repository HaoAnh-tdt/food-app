<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/monan.css') }}">
@include('header')
<div class="banner">
    <div>
        <div class="banner-title">Rau Tươi Giảm Giá Lớn</div>
        <div class="banner-desc">Tiết kiệm tới 50% cho đơn hàng đầu tiên của bạn</div>
        <button class="banner-btn">Đặt ngay</button>
    </div>
    <img src="/public/images/monan/garan1.jpg" class="banner-img" alt="Banner Rau Tươi">
</div>
<div class="categories">
    @foreach($dsLoaiMon as $loai)
        <div class="category-item">
            <div class="category-icon">🥬</div>
            <div>{{ $loai->tenloai }}</div>
        </div>
    @endforeach
</div>
<div class="hot-sale">
    <div class="hot-sale-left">
        <div style="font-weight:bold; color:#d84315; margin-bottom:8px;">Bán chạy nhất hôm nay</div>
        <div style="color:#666; margin-bottom:10px;">Ưu đãi đặc biệt - Giảm giá 20%<br>Mua sắm thoải mái chỉ từ 20.000 VNĐ</div>
        <img src="/public/images/monan/garan2.jpg" style="width:100%; border-radius:10px;">
    </div>
    <div class="hot-sale-products">
        @foreach($dsMonAn as $monan)
        <div class="product-card">
            <img src="/images/monan/{{ $monan -> hinhanh -> tenhinhanh }}" class="product-img" alt="Ngô ngọt">
            <div class="product-name">{{ $monan -> tenmonan }}</div>
            <div class="product-price">{{ $monan -> giamonan }}</div>
            <button class="product-btn">Thêm vào giỏ</button>
        </div>
        @endforeach
    </div>
</div>

