<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Vendor;
use Faker\Generator as Faker;

$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'user_id' => factory('App\Models\User'),
    ];
});
