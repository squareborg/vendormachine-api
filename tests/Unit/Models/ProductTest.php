<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function basic_test()
    {
        $random = Str::random(10);
        $product = factory('App\Models\Products\Product')->create([
            'name' => $random
        ]);
        $this->assertEquals($random, $product->name);
    }
}
