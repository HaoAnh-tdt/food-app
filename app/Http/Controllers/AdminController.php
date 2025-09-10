<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware để kiểm tra quyền admin
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->loai_taikhoan !== 0) {
                abort(403, 'Bạn không có quyền truy cập trang quản trị.');
            }
            return $next($request);
        });
    }

    // Trang dashboard chính
    public function dashboard()
    {
        // Thống kê tổng quan
        $totalOrders = DB::table('orders')->count();
        $totalUsers = DB::table('taikhoan')->count();
        $totalMonAn = DB::table('monan')->count();
        $totalRevenue = DB::table('orders')->sum('tongtien');

        // Đơn hàng gần đây
        $recentOrders = DB::table('orders')
            ->join('taikhoan', 'orders.id_taikhoan', '=', 'taikhoan.id')
            ->select('orders.*', 'taikhoan.tennguoidung')
            ->orderByDesc('orders.id')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('totalOrders', 'totalUsers', 'totalMonAn', 'totalRevenue', 'recentOrders'));
    }

    // Quản lý đơn hàng
    public function orders()
    {
        $orders = DB::table('orders')
            ->join('taikhoan', 'orders.id_taikhoan', '=', 'taikhoan.id')
            ->select('orders.*', 'taikhoan.tennguoidung', 'taikhoan.email')
            ->orderByDesc('orders.id')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    // Chi tiết đơn hàng
    public function orderDetail($id)
    {
        $order = DB::table('orders')
            ->join('taikhoan', 'orders.id_taikhoan', '=', 'taikhoan.id')
            ->select('orders.*', 'taikhoan.tennguoidung', 'taikhoan.email')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            abort(404);
        }

        $orderItems = DB::table('order_items')
            ->join('monan', 'order_items.mamonan', '=', 'monan.mamonan')
            ->select('order_items.*', 'monan.tenmonan', 'monan.giamonan')
            ->where('order_items.id_order', $id)
            ->get();

        return view('admin.orders.detail', compact('order', 'orderItems'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'trangthai' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang giao hàng,Đã giao hàng,Đã hủy'
        ]);

        DB::table('orders')
            ->where('id', $id)
            ->update(['trangthai' => $request->trangthai]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    // Quản lý món ăn
    public function monan()
    {
        $monan = DB::table('monan')
            ->join('loaimonan', 'monan.maloai', '=', 'loaimonan.maloai')
            ->select('monan.*', 'loaimonan.tenloai')
            ->orderByDesc('monan.mamonan')
            ->paginate(20);

        return view('admin.monan.index', compact('monan'));
    }

    // Quản lý loại món
    public function loaimon()
    {
        $loaimon = DB::table('loaimonan')
            ->orderBy('maloai')
            ->paginate(20);

        return view('admin.loaimon.index', compact('loaimon'));
    }

    // Quản lý người dùng
    public function users()
    {
        $users = DB::table('taikhoan')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }
}
