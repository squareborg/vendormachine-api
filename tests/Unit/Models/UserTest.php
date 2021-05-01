<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_an_verification_token()
    {
        $user = factory('App\Models\User')->create();
        $user->generateVerificationToken();

        $this->assertNotNull($user->email_verify_token);
    }
}
