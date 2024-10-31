<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_variant_id', 'sale_price', 'start_date', 'end_date'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}