<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku_color'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'color_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'color_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variants', 'color_id', 'product_id');
    }
}
