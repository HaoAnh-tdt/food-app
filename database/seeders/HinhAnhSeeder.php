<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HinhAnh;

class HinhAnhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hinhanh = [
            ['mahinhanh' => 'IMG001', 'tenhinhanh' => 'rau-cai-xanh.jpg', 'mamonan' => 'RAU001'],
            ['mahinhanh' => 'IMG002', 'tenhinhanh' => 'rau-muong.jpg', 'mamonan' => 'RAU002'],
            ['mahinhanh' => 'IMG003', 'tenhinhanh' => 'ca-rot.jpg', 'mamonan' => 'CU001'],
            ['mahinhanh' => 'IMG004', 'tenhinhanh' => 'khoai-tay.jpg', 'mamonan' => 'CU002'],
            ['mahinhanh' => 'IMG005', 'tenhinhanh' => 'cam-sanh.jpg', 'mamonan' => 'TRAI001'],
            ['mahinhanh' => 'IMG006', 'tenhinhanh' => 'tao-do.jpg', 'mamonan' => 'TRAI002'],
            ['mahinhanh' => 'IMG007', 'tenhinhanh' => 'hanh-la.jpg', 'mamonan' => 'GIAVI001'],
            ['mahinhanh' => 'IMG008', 'tenhinhanh' => 'thit-heo.jpg', 'mamonan' => 'THIT001'],
        ];

        foreach ($hinhanh as $img) {
            HinhAnh::create($img);
        }
    }
}
