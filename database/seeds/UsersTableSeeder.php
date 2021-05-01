<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect(config('seeder.users'));

        $users->each(function ($user) {
            factory('App\Models\User')->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
            ])->assignRole($user['role']);
        });
    }
}
