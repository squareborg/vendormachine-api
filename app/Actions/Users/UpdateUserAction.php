<?php

namespace App\Actions\Users;

use App\Models\User;
use App\DTO\UserData;

final class UpdateUserAction
{
    public function __invoke(User $user, UserData $userData): User
    {
        $user->fill($userData->except('password')->toArray());
        $user->save();
        return $user;
    }
}
