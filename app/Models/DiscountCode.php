<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'usage_limit',
        'times_used',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function userLimits()
    {
        return $this->hasMany(DiscountCodeUserLimit::class);
    }

    public function products()
    {
        return $this->hasMany(DiscountCodeProduct::class);
    }
}
