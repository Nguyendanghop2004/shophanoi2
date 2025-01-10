<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeProduct extends Model
{
    use HasFactory;
    public $timestamps = false; // Tắt timestamps cho bảng này
    protected $fillable = [
        'discount_code_id',
        'product_id',
    ];

    // Quan hệ với bảng DiscountCode
    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    // Quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
