<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiMon extends Model
{
    use HasFactory;
    protected $table = 'loaimonan';
    protected $primaryKey = 'maloai';
    public $timestamps = false;
    protected $fillable = ['maloai', 'tenloai'];
} 