<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<header class="main-header">
    <nav class="navbar">
        <div class="logo">FoodApp</div>
        <ul class="nav-links">
            <li><a href="/" class="nav-link">Trang chủ</a></li>
            <li class="dropdown">
                <a href="#" class="nav-link">Loại món ăn</a>
                <ul class="dropdown-menu">
                    @if(isset($dsLoaiMon))
                        @foreach($dsLoaiMon as $loai)
                            <li><a href="/monan/{{ $loai->maloai }}" class="dropdown-item">{{ $loai->tenloai }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </li>
            <li><a href="/gioi-thieu" class="nav-link">Giới thiệu</a></li>
            <li><a href="/danh-gia" class="nav-link">Đánh giá</a></li>
        </ul>
    </nav>
</header> 