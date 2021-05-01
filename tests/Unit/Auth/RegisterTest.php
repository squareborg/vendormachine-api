<?php

namespace Tests\Unit\Api\Auth;

use App\Models\User;
use App\Notifications\Auth\VerifyEmail;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_register_for_an_account()
    {
        $response = $this->json('POST', route('register'), [
            'name' => 'John Doe',
            'email' => 'user@vendormachine.test',
            'password' => 'Password?1',
            'password_confirmation' => 'Password?1'
        ]);
        $response->assertOk();
        $this->assertDatabaseHas('users', ['name' => 'John Doe']);
    }

    /** @test */
    public function a_guest_must_provide_a_valid_email()
    {
        $response = $this->json('POST', route('register'), [
            'name' => 'John Doe',
            'password' => 'Password?1',
            'password_confirmation' => 'Password?1'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function a_guest_must_provide_a_password()
    {
        $response = $this->json('POST', route('register'), [
            'name' => 'John Doe',
            'email' => 'user@vendormachine.test',
            'password_confirmation' => 'Password?1'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function a_guest_must_provide_a_confirmed_password()
    {
        $response = $this->json('POST', route('register'), [
            'name' => 'John Doe',
            'email' => 'user@vendormachine.test',
            'password' => 'Password?1',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function a_verification_email_is_set()
    {
        Notification::fake();

        $this->json('POST', route('register'), [
            'name' => 'John Doe',
            'email' => 'user@vendormachine.test',
            'password' => 'Password?1',
            'password_confirmation' => 'Password?1'
        ]);

        $user = User::where('email', 'user@vendormachine.test')->first();

        Notification::assertSentTo([$user], VerifyEmail::class);
    }
}
