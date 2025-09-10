<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiOrderController extends Controller
{
    // GET /api/orders -> orders của user hiện tại (nếu admin trả tất cả)
    public function index(Request $request)
    {
        $user = $request->user(); // middleware token phải set user
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $type = $user->loai_taikhoan ?? null;

        if ($type == 1) {
            $orders = DB::table('orders')
                ->where('id_taikhoan', $user->id)
                ->orderByDesc('id')
                ->get();
        } else {
            $orders = DB::table('orders')->orderByDesc('id')->get();
        }

        // convert to array + optionally map items
        $arr = $orders->map(function($o) {
            // nếu you have order_items table, you can fetch items here
            $items = DB::table('order_items')->where('id_order', $o->id)->get();
            return [
                'id' => $o->id,
                'created_at' => $o->created_at,
                'total' => $o->total ?? $o->tongtien ?? null,
                'items' => $items,
                // add more fields if needed
            ];
        });

        return response()->json(['success' => true, 'data' => $arr], 200);
    }

    // GET /api/orders/{id}
    public function show(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) return response()->json(['message'=>'Unauthorized'], 401);

        $order = DB::table('orders')->where('id', $id)->first();
        if (!$order) return response()->json(['message'=>'Not found'], 404);

        // check owner if necessary
        if ($user->loai_taikhoan == 1 && $order->id_taikhoan != $user->id) {
            return response()->json(['message'=>'Forbidden'], 403);
        }

        $items = DB::table('order_items')->where('id_order', $id)->get();

        return response()->json(['success' => true, 'data' => [
            'id' => $order->id,
            'tenmonan' => $order->tenmonan,
            'giamonan' => $order->giamonan,
            'soluong' => $order->soluong,
            'tonggia' => $order->tonggia,
            'total' => $order->total ?? $order->tong_tien ?? null,
            'items' => $items,
            // other fields...
        ]], 200);
    }
}
