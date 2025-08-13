<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MonAn;

class MonAnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $monAn = [
            ['mamonan' => 'RAU001', 'tenmonan' => 'Rau cải xanh', 'giamonan' => 15000, 'maloai' => 'RAU', 'mota' => 'Rau cải xanh tươi ngon'],
            ['mamonan' => 'RAU002', 'tenmonan' => 'Rau muống', 'giamonan' => 12000, 'maloai' => 'RAU', 'mota' => 'Rau muống sạch'],
            ['mamonan' => 'CU001', 'tenmonan' => 'Cà rốt', 'giamonan' => 25000, 'maloai' => 'CU', 'mota' => 'Cà rốt tươi ngọt'],
            ['mamonan' => 'CU002', 'tenmonan' => 'Khoai tây', 'giamonan' => 30000, 'maloai' => 'CU', 'mota' => 'Khoai tây chất lượng'],
            ['mamonan' => 'TRAI001', 'tenmonan' => 'Cam sành', 'giamonan' => 45000, 'maloai' => 'TRAI', 'mota' => 'Cam sành ngọt mát'],
            ['mamonan' => 'TRAI002', 'tenmonan' => 'Táo đỏ', 'giamonan' => 55000, 'maloai' => 'TRAI', 'mota' => 'Táo đỏ giòn ngọt'],
            ['mamonan' => 'GIAVI001', 'tenmonan' => 'Hành lá', 'giamonan' => 8000, 'maloai' => 'GIAVI', 'mota' => 'Hành lá tươi'],
            ['mamonan' => 'THIT001', 'tenmonan' => 'Thịt heo', 'giamonan' => 120000, 'maloai' => 'THIT', 'mota' => 'Thịt heo tươi ngon'],
        ];

        foreach ($monAn as $mon) {
            MonAn::create($mon);
        }
    }
}
