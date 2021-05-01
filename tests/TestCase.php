<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed --class=OAuthClientSeeder');
        $this->artisan('db:seed --class=RolesAndPermissionsSeeder');
        $this->artisan('db:seed --class=SettingsSeeder');
    }

    public function createLoggedInUser()
    {
        $user = factory(User::class)->create();
        auth()->login($user);
        return $user;
    }

    public function createApiUser()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
        return $user;
    }

    public function createAdminApiUser()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user, 'api');
        return $user;
    }
}
