<?php

namespace App\Models\Products;

use Sqware\Auth\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasUuid;

    protected $fillable = [
        'price',
        'product_id',
        'sku',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute_instances()
    {
        return $this->hasMany(ProductAttributeInstance::class)->with('product_attribute');
    }

}
