<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách món ăn</title>
    <link rel="stylesheet" href="{{ asset('css/monan.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            <!-- <div class="food-id">Mã: {{ $monan->mamonan }}</div> -->
            <div class="food-price">{{ number_format($monan->giamonan) }} VNĐ</div>
            <form action="" method="POST" class="buy-form">
                @csrf
                <input type="hidden" name="quantity" value="1">

                <!-- <button class="buy-food">
                    <span class="buy-food__icon">🛒</span>
                    <span class="buy-food__text">Thêm Vào Giỏ</span>
                </button> -->

                <form class="buy-form" data-mamonan="{{ $monan->mamonan }}">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="button" class="buy-food add-to-cart-btn" 
                            data-mamonan="{{ $monan->mamonan }}"
                            data-tenmonan="{{ $monan->tenmonan }}"
                            data-giamonan="{{ $monan->giamonan }}"
                            data-hinhanh="{{ $monan->hinhanh ? $monan->hinhanh->tenhinhanh : '' }}">
                        <span class="buy-food__icon">🛒</span>
                        <span class="buy-food__text">Thêm Vào Giỏ</span>
                    </button>
                </form>
            </form>
        </div>
        @endforeach
    </div>
</body>



</html> 


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thêm vào giỏ hàng
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const mamonan = this.dataset.mamonan;
            const tenmonan = this.dataset.tenmonan;
            const giamonan = this.dataset.giamonan;
            const hinhanh = this.dataset.hinhanh;
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    mamonan: mamonan,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng trong giỏ hàng
                    updateCartCount();
                    alert('Đã thêm ' + tenmonan + ' vào giỏ hàng!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
            });
        });
    });

    // Cập nhật số lượng giỏ hàng
    function updateCartCount() {
        fetch('/cart')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.count;
                cartCount.style.display = data.count > 0 ? 'block' : 'none';
            }
        });
    }

    // Cập nhật số lượng khi trang load
    updateCartCount();
});
</script>


<style>
        /* Hỗ trợ nếu vẫn dùng .buy-button cũ */
    .buy-food,
    .buy-button {
    /* layout */
    display: inline-flex;
    align-items: center;
    justify-content: center;

    /* kích thước & khoảng cách */
    padding: 0.6rem 1.1rem;        /* điều chỉnh để to/nhỏ */
    gap: 0.5rem;

    /* font */
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    font-weight: 600;
    font-size: 1rem;
    line-height: 1;

    /* hiển thị */
    color: #fff;
    background: linear-gradient(180deg, #ff7a18 0%, #ff4b00 100%);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;

    /* shadow & transition */
    box-shadow: 0 6px 18px rgba(255, 75, 0, 0.18), inset 0 -2px 0 rgba(0,0,0,0.06);
    transition: transform 150ms ease, box-shadow 150ms ease, opacity 150ms ease;
    }

    /* small / large modifiers */
    .buy-food--small { padding: 0.35rem 0.7rem; font-size: 0.875rem; border-radius: 8px; }
    .buy-food--large { padding: 0.85rem 1.4rem; font-size: 1.125rem; border-radius: 12px; }

    /* icon inside (optional) */
    .buy-food__icon { font-size: 1.05em; display: inline-block; line-height: 0; }
    .buy-food__text { display: inline-block; }

    /* hover / focus / active */
    .buy-food:hover,
    .buy-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(255, 75, 0, 0.22), inset 0 -2px 0 rgba(0,0,0,0.06);
    }

    .buy-food:active,
    .buy-button:active {
    transform: translateY(0);
    box-shadow: 0 6px 14px rgba(0,0,0,0.12);
    }

    /* keyboard accessibility */
    .buy-food:focus,
    .buy-button:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(255,120,60,0.18), 0 10px 26px rgba(255,75,0,0.18);
    border-radius: 10px;
    }

    /* disabled state */
    .buy-food[disabled],
    .buy-button[disabled] {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
    }

    /* alternate style: outline / ghost (if you need a variant) */
    .buy-food--outline {
    background: transparent;
    color: #ff4b00;
    border: 2px solid rgba(255,75,0,0.12);
    box-shadow: none;
    }
    .buy-food--outline:hover { background: rgba(255,75,0,0.06); transform: translateY(-2px); }

    /* responsive: nếu màn hình quá nhỏ, giảm padding */
    @media (max-width: 360px) {
    .buy-food { padding: 0.5rem 0.9rem; font-size: 0.95rem; }
    }

</style>