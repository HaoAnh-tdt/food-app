<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use App\Models\HinhAnh;
use App\Models\LoaiMon;

class MonAnController extends Controller
{
    public function index()
    {
        $dsMonAn = MonAn::with('hinhanh')->get();
        return view('monan', ['dsMonAn' => $dsMonAn]);
    }

    public function showByLoai($maloai)
    {
        $dsMonAn = MonAn::where('maloai', $maloai)->with('hinhanh')->get();
        $loai = LoaiMon::find($maloai);
        return view('monan', compact('dsMonAn', 'loai'));
    }
} 