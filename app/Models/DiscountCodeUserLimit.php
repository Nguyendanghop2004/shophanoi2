<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeUserLimit extends Model
{
    use HasFactory;
    public $timestamps = false; // Tắt timestamps cho bảng này
    protected $fillable = [
        'discount_code_id',
        'user_id',
        'usage_limit',
        'times_used',
    ];

    // Quan hệ với bảng DiscountCode
    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
