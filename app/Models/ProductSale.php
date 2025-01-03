<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'product_sales';

    // Các cột có thể ghi
    protected $fillable = [
        'product_id',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    /**
     * Liên kết với model Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
