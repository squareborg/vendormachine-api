<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class SuspendTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_suspends_the_user()
    {
        $banUser = factory(User::class)->create();
        $this->createAdminApiUser();

        $response = $this->json('POST', route('users.suspend', ['user' => $banUser]));

        $response->assertOk()->assertJsonFragment(['is_suspended' => true]);
        $this->assertDatabaseHas('users', ['id' => $banUser->id, 'is_suspended' => true]);
    }

    /** @test */
    public function it_unsuspends_the_user()
    {
        $banUser = factory(User::class)->create(['is_suspended' => true]);
        $this->createAdminApiUser();

        $response = $this->json('POST', route('users.unsuspend', ['user' => $banUser]));
        $response->assertOk()->assertJsonFragment(['is_suspended' => false]);
        $this->assertDatabaseHas('users', ['id' => $banUser->id, 'is_suspended' => false]);


    }

     /** @test */
     public function a_regular_user_cannot_suspend_a_user()
     {
         $banUser = factory(User::class)->create(['is_suspended' => false]);
         $this->createApiUser();

         $response = $this->json('POST', route('users.suspend', ['user' => $banUser]), [
             'is_suspended' => true,
         ]);
         $this->assertDatabaseHas('users', ['id' => $banUser->id, 'is_suspended' => false]);


         $response->assertStatus(Response::HTTP_FORBIDDEN);
     }
}
