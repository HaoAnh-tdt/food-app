<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiMon;
use App\Models\MonAn;

class HomeController extends Controller
{
    public function index()
    {
        $dsLoaiMon = LoaiMon::all();
        $dsMonAn = MonAn::with('hinhanh')->take(4)->get();
        
        return view('home', compact('dsLoaiMon', 'dsMonAn'));
    }
} 