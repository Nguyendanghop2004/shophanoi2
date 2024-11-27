<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id','color_name','size_name', 'quantity', 'price', 'created_at', 'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class); // Nếu có model Variant
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
