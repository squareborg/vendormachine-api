<?php

namespace Tests\Unit;

use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_user_can_store_there_vendor_account()
    {
        $user = $this->createApiUser();
        $vendor = factory(Vendor::class)->make();
        $data = [
            'name' => $vendor->name
        ];
        $response = $this->actingAs($user, 'api')->post(route('vendors.store'), $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('vendors', [
            'name' => $vendor->name,
            'user_id' => $user->id
        ]);
    }
}


