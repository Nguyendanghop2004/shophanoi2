<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'color_id', 'size_id', 'product_code', 'stock_quantity', 'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sales()
    {
        return $this->hasMany(PriceSale::class);
    }

    // Quan hệ với bảng tag_collections
    public function tagCollections()
    {
        return $this->belongsToMany(TagCollection::class, 'product_variant_tag_collection', 'product_variant_id', 'tag_collection_id');
    }

    // Quan hệ với bảng tag_materials
    public function tagMaterials()
    {
        return $this->belongsToMany(TagMaterial::class, 'product_variant_tag_material', 'product_variant_id', 'tag_material_id');
    }
}
