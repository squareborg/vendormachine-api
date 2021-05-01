<?php

namespace App\Actions\Users;

use App\Models\User;
use App\DTO\PasswordData;

final class UpdatePasswordAction
{
    public function __invoke(User $user, PasswordData $data): void
    {
        $user->update(['password' => bcrypt($data->newPassword)]);
    }
}
