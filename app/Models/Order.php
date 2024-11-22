<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'user_id', 'name', 'phone_number', 'address', 'email', 'note', 'total_price', 'status','payment_method','order_code','created_at', 'updated_at',
    ];

    public function Orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
