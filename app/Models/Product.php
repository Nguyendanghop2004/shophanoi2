<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['brand_id', 'slug', 'product_name', 'sku','short_description', 'description', 'price'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function colors()
    {
        return $this->hasManyThrough(
            Color::class,
            ProductVariant::class,
            'product_id', // Khóa ngoại trên bảng product_variants
            'id',         // Khóa ngoại trên bảng colors
            'id',         // Khóa trên bảng products
            'color_id'    // Khóa trên bảng product_variants
        )->distinct()->select('colors.id', 'colors.name', 'colors.sku_color'); // Chọn các cột cần thiết từ bảng colors
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id'); // Thay đổi tên model và các khóa ngoại nếu cần
    }
    // App\Models\Product.php
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_variants', 'product_id', 'size_id');
    }
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function sales()
    {
        return $this->hasOne(ProductSale::class)
                    ->where('start_date', '<=', now())
                    ->where(function ($query) {
                        $query->whereNull('end_date')
                              ->orWhere('end_date', '>=', now());
                    });
    }
    
}
