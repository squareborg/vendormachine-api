<?php

use Illuminate\Database\Seeder;
use Laravel\Passport\Passport;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $client = Passport::client()->forceFill([
            'name' => 'Password Grant Client',
            'secret' => env('PASSPORT_PGC_SECRET'),
            'redirect' => url('/auth/callback'),
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => false,
        ]);

        $client->save();
    }
}