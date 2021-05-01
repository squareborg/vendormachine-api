<?php

namespace Tests\Unit\Users;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordTest extends TestCase
{
    /** @test */
    public function it_successfully_updates_when_the_old_password_is_correct()
    {
        $user = factory('App\Models\User')->create(['password' => bcrypt('Password?1')]);

        $response = $this->actingAs($user, 'api')->json('PUT', route('user.password'), [
            'old_password' => 'Password?1',
            'new_password' => 'Password?2',
            'new_password_confirmation' => 'Password?2',
        ]);

        $response->assertOk();
    }

    /** @test */
    public function it_fails_when_the_old_password_is_incorrect()
    {
        $user = factory('App\Models\User')->create(['password' => bcrypt('Password?1')]);

        $response = $this->actingAs($user, 'api')->json('PUT', route('user.password'), [
            'old_password' => 'Password',
            'new_password' => 'Password?2',
            'new_password_confirmation' => 'Password?2',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
