<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;  

    protected $fillable = ['name'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'size_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variants', 'size_id', 'product_id');
    }
}
