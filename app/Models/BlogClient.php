<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'content',
        'title',
        'unique',
        'slug',
        'image',
        'status'
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
   
}
