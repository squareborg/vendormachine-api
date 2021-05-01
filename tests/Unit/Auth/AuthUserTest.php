<?php

namespace Tests\Unit\Api\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_the_authenticated_user()
    {
        $user = $this->createApiUser();

        $response = $this->json('GET', route('me'));
        $response->assertOk()->assertJsonFragment(['id' => $user->id]);
    }
}
