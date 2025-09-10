<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout
     */
    public function index()
    {
        if (!Auth::check()) {
            // Redirect về trang chủ (hoặc trang bạn muốn) và đặt flag để hiển thị swal
            return redirect('/')->with([
                'showLoginSwal' => true,
                'swal_title' => 'Bạn cần đăng nhập trước khi đặt hàng',
                'swal_text'  => 'Vui lòng đăng nhập để tiếp tục đặt hàng'
            ]);
        }
        // Lấy cart từ session, đảm bảo có cả 'items' và 'total'
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);

        // Chuẩn hoá dữ liệu để view dùng an toàn
        $items = array_values($cart['items'] ?? []);
        $total = $cart['total'] ?? 0;

        return view('checkout', compact('items', 'total'));
    }

    /**
     * Xử lý đặt hàng (demo: chỉ validate và xóa cart)
     */
    public function store(Request $request)
    {
        if(!Auth::check()){
            return redirect() -> guest(route('login'))->with('error','Bạn cần đăng nhập để đặt hàng');
        }
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'payment' => 'required|in:cod,online',
        ]);

        // Lấy cart (vẫn an toàn nếu chưa tồn tại)
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        $items = array_values($cart['items'] ?? []);
        $total = $cart['total'] ?? 0;

        if(empty($items)){
            return redirect()->back()->with('error','Giỏ hàng trống');
        }

        //Lưu vào database

        try{

            DB::beginTransaction();

            $orderId = DB::table('orders')->insertGetId([
                'id_taikhoan' => Auth::id(), // nếu không muốn user_id thì để null
                'TenNguoiNhan' => $data['name'],
                'DiaChi' => $data['address'],
                'Sdt' => $data['phone'],
                'PhuongThucThanhToan' => $data['payment'],
                'TongTien' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            foreach ($items as $it) {  
                DB::table('order_items')->insert([
                    'id_order' => $orderId,
                    'mamonan'  => $it['mamonan'],
                    'tenmonan'  => $it['tenmonan'], 
                    'gia'  => $it['giamonan'],
                    'soluong' => $it['quantity'],
                    'tonggia' => ($it['giamonan']* $it['quantity']),
                ]);
            }
    
            DB::commit();
    
            // xóa cart sau khi đặt thành công
            Session::forget('cart');
    
            // nếu thanh toán online -> redirect tới cổng, ở đây giả lập:
            if ($data['payment'] === 'online') {
                // gọi cổng thanh toán; hiện tạm trang cảm ơn
                return redirect('/')->with('success', 'Đặt hàng thành công. Chuyển tới thanh toán online.');
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            // log nếu cần
            Log::error('Order save error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi khi lưu đơn hàng.');
        }
    }
}

