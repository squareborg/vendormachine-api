<?php

namespace Tests\Unit\Auth;

use App\Notifications\Auth\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_successfully_verifies_an_email_address_with_a_valid_token()
    {
        $user = factory('App\Models\User')->create(['email_verified_at' => null]);
        $user->generateVerificationToken();

        $response = $this->json('POST', route('verify.email'), [
            'email' => $user->email,
            'token' => $user->email_verify_token,
        ]);

        $response->assertOk();
        $user->refresh();

        $this->assertNotNull($user->email_verified_at);
    }

    /** @test */
    public function it_does_not_verify_an_email_address_with_an_invalid_token()
    {
        $user = factory('App\Models\User')->create(['email_verified_at' => null]);
        $user->generateVerificationToken();

        $response = $this->json('POST', route('verify.email'), [
            'email' => $user->email,
            'token' => 'INVALID_TOKEN',
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $user->refresh();

        $this->assertNull($user->email_verified_at);
    }

    /** @test */
    public function it_successfully_resends_the_verify_email()
    {
        Notification::fake();

        $user = factory('App\Models\User')->create(['email_verified_at' => null]);

        $response = $this->json('POST', route('verify.email.resend'), [
            'email' => $user->email,
        ]);

        $response->assertOk();

        Notification::assertSentTo([$user], VerifyEmail::class);
    }
}
