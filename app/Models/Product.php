<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['brand_id', 'slug', 'product_name', 'sku', 'description', 'price'];

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

}
