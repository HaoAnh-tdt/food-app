<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'session_id', 'mamonan', 'tenmonan', 'giamonan', 'hinhanh', 'quantity'
    ];

    public function monan()
    {
        return $this->belongsTo(MonAn::class, 'mamonan', 'mamonan');
    }
}