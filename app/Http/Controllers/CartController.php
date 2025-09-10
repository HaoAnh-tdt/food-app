<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Dùng session, không phụ thuộc CartItem model để tránh lỗi autoload
use App\Models\MonAn;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'mamonan' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $monan = MonAn::find($request->mamonan);
        if (!$monan) {
            return response()->json(['error' => 'Món ăn không tồn tại'], 404);
        }

        // Lưu trong session
        $cart = Session::get('cart', ['items' => [],'total' => 0]);
        $key = (string) $monan->mamonan;
        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] += (int) $request->quantity;
        } else {
            $cart['items'][$key] = [
                'mamonan' => $monan->mamonan,
                'tenmonan' => $monan->tenmonan,
                'giamonan' => $monan->giamonan,
                'hinhanh' => $monan->hinhanh ? $monan->hinhanh->tenhinhanh : null,
                'quantity' => (int) $request->quantity,
            ];
        }
        Session::put('cart', $cart);

        $cart['total'] = $this->recalcTotalFromItems($cart['items']);
        Session::put('cart', $cart);

        $count = 0;
        foreach ($cart['items'] as $it) { $count += $it['quantity']; }

        // trả về total để client cập nhật badge nếu cần
        return response()->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng', 'total' => $cart['total'],'count'=>$count]);
    
    }

    public function getCart()
    {
        $cart = Session::get('cart', ['items' => []]);
        $items = array_values($cart['items']);
        $total = 0;
        $count = 0;
        foreach ($items as $it) {
            $total += $it['giamonan'] * $it['quantity'];
            $count += $it['quantity'];
        }
        return response()->json([
            'items' => $items,
            'total' => $total,
            'count' => $count,
        ]);
    }

    public function view()
    {
        $cart = Session::get('cart', ['items' => []]);
        $items = array_values($cart['items']);
        $total = 0;
        foreach ($items as $it) {
            $total += $it['giamonan'] * $it['quantity'];
        }

        if (request()->boolean('partial')) {
            return view('cart_partial', [
                'items' => $items,
                'total' => $total,
            ]);
        }

        return view('cart', [
            'items' => $items,
            'total' => $total,
        ]);

    }

    public function removeFromCart($id)
    {
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        $key = (string) $id; // mamonan
        if (isset($cart['items'][$key])) {
            unset($cart['items'][$key]);
            // đảm bảo items là mảng
            $cart['items'] = $cart['items'] ?? [];
            // tính lại total và lưu session
            $cart['total'] = $this->recalcTotalFromItems($cart['items']);
            Session::put('cart', $cart);
        }
        return response()->json(['success' => true, 'total' => $cart['total']]);
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        $key = (string) $id; // mamonan
        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] = (int) $request->quantity;
            // tính lại total và lưu session
            $cart['total'] = $this->recalcTotalFromItems($cart['items']);
            Session::put('cart', $cart);
            return response()->json(['success' => true, 'total' => $cart['total']]);
        }
        return response()->json(['error' => 'Không tìm thấy item'], 404);
    }
    
    private function recalcTotalFromItems(array $items): int
    {
        $sum = 0;
        foreach ($items as $it) {
            $price = isset($it['giamonan']) ? (int)$it['giamonan'] : 0;
            $qty   = isset($it['quantity']) ? (int)$it['quantity'] : 0;
            $sum += $price * $qty;
        }
        return $sum;
    }
}