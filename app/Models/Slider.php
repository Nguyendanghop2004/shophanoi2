<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'image_path',
        'link_url',
        'is_active',
        'position',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}