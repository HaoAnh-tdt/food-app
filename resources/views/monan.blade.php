<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách món ăn</title>
    <link rel="stylesheet" href="{{ asset('css/monan.css') }}">
</head>
<body>
    @include('header')
    <h1>Danh sách món ăn</h1>
    <div class="card-container">
        @foreach($dsMonAn as $monan)
        <div class="food-card">
            @if($monan->hinhanh)
                <img class="food-img" src="{{ asset('images/monan/'.$monan->hinhanh->tenhinhanh) }}" alt="{{ $monan->tenmonan }}">
            @else
                <div class="no-img">Không có ảnh</div>
            @endif
            <div class="food-name">{{ $monan->tenmonan }}</div>
            <div class="food-id">Mã: {{ $monan->mamonan }}</div>
            <div class="food-price">{{ number_format($monan->giamonan) }} VNĐ</div>
            <form action="" method="POST" class="buy-form">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="buy-button">Mua</button>
            </form>
        </div>
        @endforeach
    </div>
</body>
</html> 