<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'address',
        'phone_number',
        'city_id', // Thêm trường city_id
        'province_id', // Thêm trường province_id
        'wards_id', // Thêm trường wards_id
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Định nghĩa quan hệ với bảng tinhthanhpho
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'matp');
    }

    // Định nghĩa quan hệ với bảng quanhuyen
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'maqh');
    }

    // Định nghĩa quan hệ với bảng xaphuong
    public function ward()
    {
        return $this->belongsTo(Wards::class, 'wards_id', 'xaid');
    }
    
    public function discountCodes()
{
    return $this->belongsToMany(DiscountCode::class, 'discount_code_user');
}
}