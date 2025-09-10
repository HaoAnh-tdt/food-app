<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonAn;
use App\Models\LoaiMon;

class MonAnApiController extends Controller
{
    // Trả tất cả món ăn (không phân trang)
    public function index()
    {
        // Lấy toàn bộ, kèm quan hệ hinhanh
        $dsMonAn = MonAn::with('hinhanh')->get();

        // Chuẩn hóa dữ liệu trả về cho client
        $data = $dsMonAn->map(function ($monan) {
            // Giả sử $monan->hinhanh có thuộc tính tenhinhanh
            $img = null;
            if ($monan->hinhanh) {
                // đổi base URL nếu cần (http/https + domain)
                $img = asset('images/monan/' . $monan->hinhanh->tenhinhanh);
            }

            return [
                'id' => $monan->id,
                'mamonan' => $monan->mamonan,
                'tenmonan' => $monan->tenmonan,
                'mota' => $monan->mota ?? '',
                'giamonan' => $monan->giamonan,
                'hinhanh' => $img,
                'maloai' => $monan->maloai,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    // Lấy món theo loại (ví dụ)
    public function showByLoai($maloai)
    {
        $loai = LoaiMon::find($maloai);
        if (!$loai) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy loại'], 404);
        }

        $dsMonAn = MonAn::where('maloai', $maloai)->with('hinhanh')->get();

        $data = $dsMonAn->map(function ($monan) {
            $img = $monan->hinhanh ? asset('images/monan/' . $monan->hinhanh->tenhinhanh) : null;
            return [
                'id' => $monan->id,
                'mamonan' => $monan->mamonan,
                'tenmonan' => $monan->tenmonan,
                'giamonan' => $monan->giamonan,
                'hinhanh' => $img,
            ];
        });

        return response()->json(['status' => 'success', 'loai' => $loai->tenloai ?? '', 'data' => $data]);
    }
}
