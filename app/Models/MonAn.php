<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonAn extends Model
{
    use HasFactory;
    protected $table = 'monan';
    protected $primaryKey = 'mamonan';
    public $timestamps = false;
    protected $fillable = ['mamonan', 'tenmonan', 'giamonan', 'maloai', 'mota'];

    public function hinhanh()
    {
        return $this->belongsTo(HinhAnh::class, 'mamonan', 'mamonan');
    }

    public function loai()
    {
        return $this->belongsTo(\App\Models\LoaiMon::class, 'maloai', 'maloai');
    }
}
