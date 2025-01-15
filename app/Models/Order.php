<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
   
    protected $fillable = [
       

        'user_id', 'name','reason', 'phone_number', 'address','city_id','province_id','wards_id', 'email', 'note', 'total_price', 'status','payment_method','order_code','created_at', 'updated_at',
    ];
    public function city()
{
    return $this->belongsTo(City::class, 'city_id', 'matp');
}

public function province()
{
    return $this->belongsTo(Province::class, 'province_id', 'maqh');
}

public function ward()
{
    return $this->belongsTo(Wards::class, 'wards_id', 'xaid');
}


    public function Orderitems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function isCancellable()
    {
        return in_array($this->status, ['chờ xác nhận', 'đã xác nhận']);
    }
    public function confirm()
    {
        $this->update(['status' => 'đã nhận hàng']);
    }
    public function assignedShipper()
    {
        return $this->belongsTo(Admin::class, 'assigned_shipper_id');
    }
}
