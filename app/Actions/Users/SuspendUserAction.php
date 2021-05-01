<?php

namespace App\Actions\Users;

use App\Models\User;
use App\Notifications\AccountSuspended;

final class SuspendUserAction
{
    public function __invoke(User $user): User
    {
        $user->update(['is_suspended' => true]);
        $user->notify(new AccountSuspended());
        return $user;
    }
}
