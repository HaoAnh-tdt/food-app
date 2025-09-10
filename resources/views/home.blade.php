<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/monan.css') }}">

<!-- <link rel="stylesheet" href="https://food-app-1lws.onrender.com/css/monan.css">
<link rel="stylesheet" href="https://food-app-1lws.onrender.com/css/home.css"> -->

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
            @if(isset($dsLoaiMon))
            @foreach($dsLoaiMon as $loai)
                <div class="category-item">
                    <div class="category-icon">🥬</div>
                    <div>{{ $loai->tenloai }}</div>
                </div>
            @endforeach
        @endif
</div>
<div class="hot-sale">
    <div class="hot-sale-left">
        <div style="font-weight:bold; color:#d84315; margin-bottom:8px;">Bán chạy nhất hôm nay</div>
        <div style="color:#666; margin-bottom:10px;">Ưu đãi đặc biệt - Giảm giá 20%<br>Mua sắm thoải mái chỉ từ 20.000 VNĐ</div>
        <img src="/public/images/monan/garan2.jpg" style="width:100%; border-radius:10px;">
    </div>
    <div class="hot-sale-products">
        @if(isset($dsMonAn))
            @foreach($dsMonAn as $monan)
            <div class="product-card">
                @if($monan->hinhanh)
                    <img src="/images/monan/{{ $monan->hinhanh->tenhinhanh }}" class="product-img" alt="{{ $monan->tenmonan }}">
                @else
                    <div class="no-img">Không có ảnh</div>
                @endif
                <div class="product-name">{{ $monan->tenmonan }}</div>
                <div class="product-price">{{ number_format($monan->giamonan) }} VNĐ</div>
                <button class="product-btn">Thêm vào giỏ</button>
            </div>
            @endforeach
        @endif
    </div>
</div>

