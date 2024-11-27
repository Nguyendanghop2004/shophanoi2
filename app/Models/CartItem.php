<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id', 'product_id', 'color_id', 'size_id', 'quantity', 'price'];



    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Mối quan hệ với model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Mối quan hệ với Color (nếu có)
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    // Mối quan hệ với Size (nếu có)
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
