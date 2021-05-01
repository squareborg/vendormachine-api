<?php

namespace App\Actions\Users;

use App\Models\User;
use App\Notifications\AccountUnsuspended;

final class UnsuspendUserAction
{
    public function __invoke(User $user): User
    {
        $user->update(['is_suspended' => false]);
        $user->notify(new AccountUnsuspended());
        return $user;
    }
}
