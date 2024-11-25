<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['product_id', 'color_id', 'image_url'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

}
