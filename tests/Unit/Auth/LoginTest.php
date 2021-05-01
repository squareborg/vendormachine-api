<?php

namespace Tests\Unit;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_registered_user_can_login_to_their_account()
    {
        $user = factory('App\Models\User')->create(['password' => bcrypt('Password?1')]);

        $response = $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => 'Password?1',
        ]);

        $response->assertOk()->assertJsonStructure(['access_token']);
    }

    /** @test */
    public function a_non_registered_user_cannot_login()
    {
        $response = $this->json('POST', route('login'), [
            'email' => 'user@vendormachine.test',
            'password' => 'Password?1',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
