<?php

namespace App\Actions\Users;

use App\Models\User;

final class DeleteUserAction
{
    public function __invoke(User $user): void
    {
        $user->delete();
    }
}
