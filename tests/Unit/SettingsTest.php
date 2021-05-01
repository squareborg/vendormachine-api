<?php

namespace Tests\Unit;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_stores_a_setting()
    {
        $user = $this->createAdminApiUser();
        $data = [
            'key' => 'test',
            'value' => 'test',
        ];
        $response = $this->actingAs($user, 'api')->put(route('setting.update', [$data['key']]), $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('settings', [
            'key' => 'test',
            'value' => 'test'
        ]);

    }

}
