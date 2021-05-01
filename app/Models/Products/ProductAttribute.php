<?php

namespace App\Models\Products;

use Sqware\Auth\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
