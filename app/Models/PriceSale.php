<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSale extends Model
{
    use HasFactory;

    protected $table = 'price_sales';

    protected $fillable = [
        'product_id',
        'sale_price',
        'start_date',
        'end_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
