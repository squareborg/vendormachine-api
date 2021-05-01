<?php

namespace App\Models\Products;

use Sqware\Auth\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor;

class Product extends Model
{
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'name',
        'price',
        'sku',
        'vendor_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
