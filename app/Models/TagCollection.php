<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Tên của collection
    ];

    // Quan hệ với Product (một collection có thể gắn với nhiều sản phẩm)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag_collections');
    }
}
