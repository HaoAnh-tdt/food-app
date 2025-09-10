<link rel="stylesheet" href="{{ asset('css/header.css') }}">

<!-- <link rel="stylesheet" href="https://food-app-1lws.onrender.com/css/header.css"> -->
<style>
  li{
    list-style: none;
  }
</style>
<header class="main-header">
    <nav class="navbar">
        <div class="logo">FoodApp</div>
        <ul class="nav-links">
            <li><a href="/" class="nav-link">Trang chủ</a></li>
            <li class="dropdown">
                <a href="#" class="nav-link">Loại món ăn</a>
                <ul class="dropdown-menu">
                    <li><a href="/monan" class="dropdown-item">Tất cả</a></li>
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
        <a href="#" id="open-cart" class="cart-link" aria-label="Giỏ hàng" style="position:relative; display:inline-flex; align-items:center; gap:6px; text-decoration:none;">
            <span style="font-size:20px; line-height:1;">🛒</span>
            <span id="cart-count" class="cart-count" style="display:none; min-width:18px; height:18px; padding:0 6px; border-radius:9px; background:#ff4b00; color:#fff; font-size:12px; font-weight:700; line-height:18px; text-align:center;">0</span>
        </a>
        @if(Auth::check())
        @php
          $type = Auth::user()->loai_taikhoan ?? null;
        @endphp
            <li class="dropdown">
                <a href="#" class="nav-link">Xin chào, {{ Auth::user()->tennguoidung }}</a>
                <ul class="dropdown-menu">
                <li><a href="/profile" class="dropdown-item">Thông tin tài khoản</a></li>
                @if($type === 1) {{-- khách hàng --}}
                    <li><a href="/orders" class="dropdown-item">Lịch sử mua hàng</a></li>
                @elseif($type === 0) {{-- admin --}}
                    <li><a href="/admin" class="dropdown-item">Trang quản trị</a></li>
                @elseif($type === 2) {{-- nhân viên --}}
                    <li><a href="/staff" class="dropdown-item">Bảng nhân viên</a></li>
                @else
                    <li><a href="/orders" class="dropdown-item">Lịch sử mua hàng</a></li>
                @endif
                    <li>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="background:none; border:none; cursor:pointer; width:100%; text-align:left;">
                            Đăng xuất
                        </button>
                      </form>
                    </li>
                </ul>
            </li>
        @else
            <a href="/login" class="nav-link">Đăng nhập</a>
        @endif
    </nav>
</header> 

<div id="cart-modal" style="position:fixed; inset:0; display:none; z-index:9999;">
    <div id="cart-backdrop" style="position:absolute; inset:0; background:rgba(0,0,0,0.45);"></div>
    <div id="cart-body" style="position:relative; z-index:1; width:min(920px,95%); max-height:90vh; margin:40px auto; overflow:auto; background:transparent; padding:0;"></div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</div>




@if(session('showLoginSwal'))
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'thông báo',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đăng nhập',
            cancelButtonText: 'OK',
            allowOutsideClick: true
        }).then(function(result) {
            if (result.isConfirmed) {
                // Chuyển tới trang login khi bấm "Đăng nhập"
                window.location.href = "{{ route('login') }}";
            } else {
                // Nếu bấm "OK" (cancel) thì chỉ đóng popup
            }
        });
    });
    </script>
@endif



<script>
(function(){
  function csrfToken(){ const el=document.querySelector('meta[name="csrf-token"]'); return el?el.getAttribute('content'):''; }
  function formatCurrency(n){ return new Intl.NumberFormat('vi-VN').format(n)+' VNĐ'; }
  function updateBadge(){ fetch('/cart').then(r=>r.json()).then(d=>{const el=document.getElementById('cart-count'); if(!el) return; el.textContent=d.count; el.style.display=d.count>0?'block':'none';}); }

  function openCart(){
    const modal=document.getElementById('cart-modal');
    const body=document.getElementById('cart-body');
    modal.style.display='block';
    body.innerHTML='Đang tải...';
    fetch('/cart/view?partial=1').then(r=>r.text()).then(html=>{ body.innerHTML=html; }).then(()=>{ updateBadge(); }).catch(()=>{ body.innerHTML='Lỗi tải giỏ hàng'; });
  }
  function closeCart(){ document.getElementById('cart-modal').style.display='none'; }

  document.addEventListener('click', function(e){
    if (e.target.closest && e.target.closest('#open-cart')){ e.preventDefault(); openCart(); return; }
    if (e.target.id==='cart-backdrop'){ closeCart(); return; }

    const row=e.target.closest('tr[data-id]');
    if(!row) return;
    const id=row.getAttribute('data-id');

    if (e.target.classList.contains('qty-btn')){
      const input=row.querySelector('.qty-input');
      const action=e.target.getAttribute('data-action');
      let val=parseInt(input.value||'1',10); val=isNaN(val)?1:val; if(action==='increase') val+=1; if(action==='decrease') val=Math.max(1,val-1); input.value=val;
      fetch(`/cart/${id}/quantity`,{ method:'PATCH', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken() }, body: JSON.stringify({ quantity: val }) })
        .then(r=>r.json()).then(()=> refreshRowAndTotal(row)).catch(()=> alert('Có lỗi khi cập nhật số lượng'));
    }
    if (e.target.classList.contains('remove-btn')){
      fetch(`/cart/${id}`,{ method:'DELETE', headers:{ 'X-CSRF-TOKEN': csrfToken() } })
        .then(r=>r.json()).then(()=>{ row.remove(); refreshTotalOnly(); }).catch(()=> alert('Có lỗi khi xóa món'));
    }
  });

  function refreshRowAndTotal(row){
    fetch('/cart').then(r=>r.json()).then(d=>{
      const id=row.getAttribute('data-id');
      const item=d.items.find(it=> String(it.mamonan)===String(id));
      if(item){ row.querySelector('.row-total').textContent = formatCurrency(item.giamonan*item.quantity); }
      const totalEl=document.getElementById('cart-total'); if(totalEl){ totalEl.textContent = formatCurrency(d.total); }
      updateBadge();
    });
  }
  function refreshTotalOnly(){
    fetch('/cart').then(r=>r.json()).then(d=>{
      const tbody=document.querySelector('#cart-body tbody');
      if(tbody && tbody.children.length===0){ document.getElementById('cart-body').innerHTML='<p>Giỏ hàng trống.</p>'; }
      const totalEl=document.getElementById('cart-total'); if(totalEl){ totalEl.textContent = formatCurrency(d.total); }
      updateBadge();
    });
  }

  // Cập nhật badge khi load
  updateBadge();
})();
</script>

