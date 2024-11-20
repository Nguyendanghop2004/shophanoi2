<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;

<<<<<<< HEAD

  

    protected $fillable = ['id','product_id','color_id', 'image_url'];
=======
    protected $fillable = ['product_id', 'color_id', 'image_url'];
>>>>>>> a0f733b19ba5ab006b56754f39358142a745e601


    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
