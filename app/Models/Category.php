<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'parent_id',
    ];
    protected $dates = ['deleted_at'];

    public function products()
{
    return $this->belongsToMany(Product::class, 'category_product');
    
}

    public function sliders()
    {
        return $this->hasMany(Slider::class, 'category_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function productss()
    {
        return $this->hasMany(Product::class);
    }
  
    

   
}
