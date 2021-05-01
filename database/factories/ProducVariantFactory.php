
<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Products\ProductVariant;
use Faker\Generator as Faker;

$factory->define(ProductVariant::class, function (Faker $faker) {
    return [
        'price' => random_int(100,10000),
        'sku' => $faker->bankAccountNumber,
        'product_id' => factory('App\Models\Products\Product'),
    ];
});
