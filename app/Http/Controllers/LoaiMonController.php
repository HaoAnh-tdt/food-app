<?php

namespace App\Http\Controllers;


use App\Models\LoaiMon;

class LoaiMonController extends Controller
{
    public function index()
    {
        $dsLoaiMon = LoaiMon::all();
        return view('header', ['dsLoaiMon'  => $dsLoaiMon]);
    }
} 