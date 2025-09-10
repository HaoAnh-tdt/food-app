<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Danh sách tất cả đơn (dùng cho admin). Bạn có thể thêm middleware admin.
    public function index()
    {        // Bắt buộc phải login để xem orders
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem đơn hàng.');
        }

        $user = Auth::user();
        $type = $user->loai_taikhoan ?? null; // 1 = khách, 0 = admin, 2 = nhân viên

        if ($type == 1) {
            // Khách hàng: chỉ xem đơn của chính họ
            $orders = DB::table('orders')
                ->where('id_taikhoan', $user->id)
                ->orderByDesc('id')
                ->get();
        } else {
            // Admin / nhân viên: xem tất cả (nếu muốn staff chỉ xem 1 số, chỉnh lại ở đây)
            $orders = DB::table('orders')
                ->orderByDesc('id')
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    // Danh sách đơn của user hiện tại
    public function myOrders()
    {
        $userId = Auth::id();
        $orders = DB::table('orders')->where('id_taikhoan', $userId)->orderByDesc('id')->get();
        return view('orders.my', compact('orders'));
    }

    // Hiển thị chi tiết đơn
    public function show($id)
    {
        $order = DB::table('orders')->where('id', $id)->first();
        if (!$order) abort(404);
        $items = DB::table('order_items')->where('id_order', $id)->get();
    
        if (request()->boolean('partial')) {
            return view('orders.partial_show', compact('order', 'items'));
        }
    
        return view('orders.show', compact('order', 'items'));
    }
    
}
