<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use App\Models\HinhAnh;

class MonAnController extends Controller
{
    public function index()
    {
        $dsMonAn = MonAn::with('hinhanh')->get();
        return view('monan', ['dsMonAn' => $dsMonAn]);
    }

    public function showByLoai($maloai)
    {
        $dsMonAn = \App\Models\MonAn::where('maloai', $maloai)->get();
        $loai = \App\Models\LoaiMon::find($maloai);
        return view('monan', compact('dsMonAn', 'loai'));
    }
} 