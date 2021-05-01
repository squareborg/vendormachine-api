<?php

namespace App\Actions\Users;

use App\DTO\UserData;
use App\Models\User;
use App\Notifications\Auth\VerifyEmail;
use Spatie\Permission\Models\Role;

final class CreateUserAction
{
    public function __invoke(UserData $userData): User
    {
        $user = User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
        ]);

        $user->assignRole('user');
        $user->generateVerificationToken();
        $user->notify(new VerifyEmail());

        return $user;
    }
}
