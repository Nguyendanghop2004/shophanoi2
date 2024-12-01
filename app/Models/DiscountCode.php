<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;
  
    protected $fillable = ['code', 'discount_type', 'discount_value', 'min_quantity', 'min_total', 'start_date', 'end_date', 'usage_limit'];

    // Quan hệ với bảng UserDiscountCode
    public function userDiscountCodes()
    {
        return $this->hasMany(UserDiscountCode::class);
    }

    // Quan hệ với bảng User thông qua UserDiscountCode (Nếu cần thiết)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_discount_codes')
                    ->withTimestamps();
    }
}
