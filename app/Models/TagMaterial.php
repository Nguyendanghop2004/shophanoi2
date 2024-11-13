<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Tên của material
    ];

    // Quan hệ với Product (một material có thể gắn với nhiều sản phẩm)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag_materials');
    }
}
