<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function basic_test()
    {
        $random = Str::random(10);
        $vendor = factory('App\Models\Vendor')->create([
            'name' => $random
        ]);
        $this->assertEquals($random, $vendor->name);
    }
}
