<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description', 'background_image'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }

    // public function posts()
    // {
    //     return $this->belongsToMany(Post::class, 'post_tags');
    // }
}
