<?php

namespace Tests\Unit\Users;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_successfully_stores_the_users_avatar()
    {
        Storage::fake();

        $user = $this->createApiUser();
        $file = UploadedFile::fake()->image('123456.jpg');

        $response = $this->json('POST', route('user.avatar'), [
            'file' => $file
        ]);

        $response->assertOk();
        $this->assertNotNull($user->refresh()->avatar);

        Storage::assertExists("avatars/{$user->id}/avatar.jpg");
    }
}
