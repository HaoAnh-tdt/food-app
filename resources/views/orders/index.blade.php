@include('header')

<!-- Modal container -->
<div id="order-modal" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.45);">
  <div id="order-modal-card" style="width:min(900px,95%); max-height:90vh; overflow:auto; background:#fff; border-radius:10px; padding:18px; position:relative;">
    <button id="order-modal-close" style="position:absolute; right:12px; top:8px; font-size:22px; border:none; background:transparent; cursor:pointer;">&times;</button>
    <div id="order-modal-body">Đang tải...</div>
  </div>
</div>

<div class="orders-wrap">
  <div class="orders-card">
    <h2 class="orders-title">Danh sách đơn hàng</h2>

    <div class="table-responsive">
      <table class="orders-table">
        <thead>
          <tr>
            <th class="col-id">#</th>
            <th class="col-customer">Khách</th>
            <th class="col-total">Tổng</th>
            <th class="col-payment">Phương thức</th>
            <th class="col-actions">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
            <tr>
              <td class="col-id">{{ $o->id }}</td>
              <td class="col-customer">
                <div class="customer-name">{{ $o->TenNguoiNhan }}</div>
                <div class="customer-phone">{{ $o->Sdt }}</div>
              </td>
              <td class="col-total">{{ number_format($o->TongTien) }} VNĐ</td>
              <td class="col-payment">{{ $o->PhuongThucThanhToan }}</td>
              <td class="col-actions">
                <a href="#" class="btn btn-primary btn-sm open-order" data-id="{{ $o->id }}">Xem</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


<script>
document.addEventListener('click', function(e){
  // open
  const btn = e.target.closest && e.target.closest('.open-order');
  if (btn) {
    e.preventDefault();
    const id = btn.getAttribute('data-id');
    openOrderModal(id);
  }

  // close btn
  if (e.target && e.target.id === 'order-modal-close') {
    closeOrderModal();
  }

  // click backdrop close
  if (e.target && e.target.id === 'order-modal') {
    closeOrderModal();
  }
});

function openOrderModal(id) {
  const overlay = document.getElementById('order-modal');
  const body = document.getElementById('order-modal-body');
  if (!overlay || !body) return;

  overlay.style.display = 'flex';
  body.innerHTML = 'Đang tải...';

  fetch(`/orders/${id}?partial=1`, { headers: {'X-Requested-With':'XMLHttpRequest'} })
    .then(res => {
      if (!res.ok) throw new Error('Lỗi tải dữ liệu');
      return res.text();
    })
    .then(html => {
      body.innerHTML = html;
      // optional: scroll top modal
      document.getElementById('order-modal-card').scrollTop = 0;
    })
    .catch(err => {
      body.innerHTML = '<p style="color:#c53030;">Không thể tải chi tiết đơn.</p>';
      console.error(err);
    });
}

function closeOrderModal() {
  const overlay = document.getElementById('order-modal');
  if (!overlay) return;
  overlay.style.display = 'none';
  document.getElementById('order-modal-body').innerHTML = '';
}
</script>



<style>
    /* Container & card */
.orders-wrap {
  max-width: 1100px;
  margin: 40px auto;
  padding: 0 16px;
}
.orders-card {
  background: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 8px 28px rgba(22, 28, 37, 0.06);
  border: 1px solid rgba(22,28,37,0.04);
}

/* Title */
.orders-title {
  margin: 0 0 18px;
  font-size: 20px;
  font-weight: 700;
  color: #111827; /* near-black */
}

/* Responsive wrapper for table */
.table-responsive {
  overflow-x: auto;
}

/* Table base */
.orders-table {
  width: 100%;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

/* Head */
.orders-table thead th {
  text-align: left;
  padding: 12px 14px;
  font-size: 13px;
  font-weight: 700;
  color: #374151;
  background: linear-gradient(180deg, rgba(250,250,250,1), rgba(245,245,245,1));
  border-bottom: 1px solid #e6e6e6;
}

/* Cells */
.orders-table tbody td {
  padding: 12px 14px;
  vertical-align: middle;
  font-size: 14px;
  color: #374151;
  border-bottom: 1px solid #f1f1f1;
}

/* Zebra rows */
.orders-table tbody tr:nth-child(odd) {
  background: #ffffff;
}
.orders-table tbody tr:nth-child(even) {
  background: #fbfbfb;
}

/* Hover highlight */
.orders-table tbody tr:hover {
  background: #fff7ed; /* soft highlight */
  transform: translateZ(0);
}

/* Customer small meta */
.customer-name {
  font-weight: 600;
  color: #111827;
}
.customer-phone {
  font-size: 13px;
  color: #6b7280;
  margin-top: 4px;
}

/* Buttons */
.btn {
  display: inline-block;
  padding: 8px 12px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  border: none;
}
.btn-primary {
  background: #ff4b00;
  color: #fff;
  box-shadow: 0 6px 16px rgba(255,75,0,0.12);
}
.btn-primary:hover {
  background: #e63f00;
}

/* Column sizing helpers */
.col-id { width: 60px; }
.col-actions { width: 110px; text-align: right; }
.col-total { width: 140px; text-align: right; }
.col-payment { width: 160px; }

/* Small screens: convert rows to cards */
@media (max-width: 760px) {
  .orders-table thead { display: none; }
  .orders-table, .orders-table tbody, .orders-table tr, .orders-table td { display: block; width: 100%; }
  .orders-table tr { margin-bottom: 12px; border-radius: 10px; box-shadow: 0 6px 16px rgba(2,6,23,0.04); overflow: hidden; }
  .orders-table td {
    padding: 12px 14px;
    border-bottom: 0;
  }
  .orders-table td.col-actions { text-align: left; padding-bottom: 16px; }
  .orders-table td.col-id { font-weight:700; color:#111827; }
  .orders-table td.col-customer { display: flex; flex-direction: column; gap:4px; }
  .orders-table td.col-total { font-weight:700; color:#e11d48; }
}

</style>