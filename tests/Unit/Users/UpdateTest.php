<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_the_user_profile_information()
    {
        $user = $this->createApiUser();

        $response = $this->json('PUT', route('user.update'), [
            'name' => 'John Smith',
            'email' => $user->email,
        ]);

        $response->assertOk()->assertJsonFragment(['name' => 'John Smith']);
    }
}
