<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
       

        'user_id', 'name','reason', 'phone_number', 'address','city_id','province_id','wards_id', 'email', 'note', 'total_price', 'status','payment_method','order_code','created_at', 'updated_at',
    ];

    public function Orderitems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function isCancellable()
    {
        return in_array($this->status, ['chờ_xác_nhận', 'đã_xác_nhận']);
    }
   
}
