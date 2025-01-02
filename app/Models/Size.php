<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Quan hệ với bảng ProductVariant.
     */
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'size_id');
    }

    /**
     * Quan hệ với bảng Product thông qua bảng ProductVariant.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variants', 'size_id', 'product_id');
    }
}
