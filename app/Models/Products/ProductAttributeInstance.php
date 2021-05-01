<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeInstance extends Model
{
    protected $fillable = [
        'product_attribute_id',
        'product_variant_id',
        'value',
    ];

    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function product_attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
