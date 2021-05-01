
<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Products\ProductAttribute;
use App\Models\Products\ProductVariant;
use App\Models\Products\ProductAttributeInstance;
use Faker\Generator as Faker;

$factory->define(ProductAttributeInstance::class, function (Faker $faker) {
    return [
        'product_attribute_id' => ProductAttribute::first()->id,
        'product_variant_id' =>  factory(ProductVariant::class),
    ];
});
