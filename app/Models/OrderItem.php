<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_name','color_name','size_name', 'quantity', 'price','image_url','product_id','size_id','color_id', 'created_at', 'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id'); // Đảm bảo dùng đúng khóa ngoại 'variant_id'
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
