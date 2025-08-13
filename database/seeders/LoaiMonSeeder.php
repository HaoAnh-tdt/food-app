<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LoaiMon;

class LoaiMonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loaiMon = [
            ['maloai' => 'RAU', 'tenloai' => 'Rau xanh'],
            ['maloai' => 'CU', 'tenloai' => 'Củ quả'],
            ['maloai' => 'TRAI', 'tenloai' => 'Trái cây'],
            ['maloai' => 'GIAVI', 'tenloai' => 'Gia vị'],
            ['maloai' => 'THIT', 'tenloai' => 'Thịt tươi'],
        ];

        foreach ($loaiMon as $loai) {
            LoaiMon::create($loai);
        }
    }
}
