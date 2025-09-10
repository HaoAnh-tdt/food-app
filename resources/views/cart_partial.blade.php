<div class="modal-overlay" id="cartModal">
  <div class="modal">
    <button class="modal-close" onclick="document.getElementById('cart-modal').style.display='none'">&times;</button>
            @if(empty($items))
                <p>Giỏ hàng trống.</p>
            @else
                <table style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Món</th>
                            <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">Giá</th>
                            <th style="text-align:center; padding:8px; border-bottom:1px solid #eee;">Số lượng</th>
                            <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">Thành tiền</th>
                            <th style="padding:8px; border-bottom:1px solid #eee;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr data-id="{{ $item['mamonan'] }}">
                            <td style="padding:8px; display:flex; align-items:center; gap:10px;">
                                @if($item['hinhanh'])
                                    <img src="{{ asset('images/monan/'.$item['hinhanh']) }}" alt="{{ $item['tenmonan'] }}" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                                @else
                                    <div style="width:60px; height:60px; background:#f3f3f3; border-radius:8px; display:flex; align-items:center; justify-content:center;">N/A</div>
                                @endif
                                <div>
                                    <div style="font-weight:600;">{{ $item['tenmonan'] }}</div>
                                    <div style="font-size:12px; color:#666;">Mã: {{ $item['mamonan'] }}</div>
                                </div>
                            </td>
                            <td style="padding:8px; text-align:right;">{{ number_format($item['giamonan']) }} VNĐ</td>
                            <td style="padding:8px; text-align:center;">
                                <button class="qty-btn" data-action="decrease">-</button>
                                <input type="number" min="1" value="{{ $item['quantity'] }}" class="qty-input" style="width:48px; text-align:center;" />
                                <button class="qty-btn" data-action="increase">+</button>
                            </td>
                            <td class="row-total" style="padding:8px; text-align:right;">{{ number_format($item['giamonan'] * $item['quantity']) }} VNĐ</td>
                            <td style="padding:8px; text-align:center;"><button class="remove-btn" style="color:#ff4b00;">Xóa</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:16px; text-align:right; font-size:18px;">
                    Tổng cộng: <strong id="cart-total">{{ number_format($total) }} VNĐ</strong>
                </div>

                <div style="margin-top:16px; text-align:right; display:flex; gap:8px; justify-content:flex-end;">
                    <a style="text-decoration: none; " href="/monan" class="buy-food buy-food--outline">Tiếp tục mua hàng</a>
                    <a style="text-decoration: none; " href="/checkout" class="buy-food buy-food--outline">Đặt hàng</a>
                </div>


                <style>
                /* Overlay nền mờ */
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5); /* nền tối */
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
            }

            /* Hộp modal */
            .modal {
                background: #fff;
                border-radius: 12px;
                max-width: 800px;
                width: 90%;
                max-height: 90%;
                overflow-y: auto;
                box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                animation: fadeInUp 0.3s ease;
                padding: 20px;
                position: relative;
            }

            /* Nút đóng */
            .modal-close {
                position: absolute;
                top: 12px;
                right: 12px;
                background: transparent;
                border: none;
                font-size: 22px;
                cursor: pointer;
                color: #555;
                transition: color 0.2s;
            }
            .modal-close:hover {
                color: #000;
            }

            /* Bảng giỏ hàng */
            .modal table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            .modal th {
                background: #f8f8f8;
                font-weight: 600;
                color: #444;
            }
            .modal th, .modal td {
                padding: 10px;
                border-bottom: 1px solid #eee;
            }

            /* Input và nút số lượng */
            .qty-btn {
                width: 28px;
                height: 28px;
                border: 1px solid #ddd;
                background: #f9f9f9;
                cursor: pointer;
                border-radius: 6px;
                font-size: 16px;
                font-weight: bold;
                transition: background 0.2s;
            }
            .qty-btn:hover {
                background: #ececec;
            }
            .qty-input {
                width: 48px;
                text-align: center;
                border: 1px solid #ddd;
                border-radius: 6px;
                margin: 0 4px;
                padding: 4px;
            }

            /* Nút xóa */
            .remove-btn {
                background: transparent;
                border: none;
                color: #ff4b00;
                cursor: pointer;
                font-weight: 500;
            }
            .remove-btn:hover {
                text-decoration: underline;
            }

            /* Khu vực tổng cộng */
            #cart-total {
                color: #e63946;
                font-size: 20px;
            }

            /* Nút hành động */
            .buy-food {
                background: #ff4b00;
                color: #fff;
                border: none;
                padding: 10px 18px;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.2s;
            }
            .buy-food:hover {
                background: #e63f00;
            }
            .buy-food--outline {
                background: transparent;
                border: 2px solid #ff4b00;
                color: #ff4b00;
            }
            .buy-food--outline:hover {
                background: #ff4b00;
                color: #fff;
            }

            /* Animation xuất hiện modal */
            @keyframes fadeInUp {
                from {
                    transform: translateY(20px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            </style>
            @endif

