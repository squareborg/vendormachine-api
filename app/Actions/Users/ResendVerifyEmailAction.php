<?php

namespace App\Actions\Users;

use App\Models\User;
use App\DTO\VerifyEmailData;
use App\Notifications\Auth\VerifyEmail;

final class ResendVerifyEmailAction
{
    public function __invoke(VerifyEmailData $dto): void
    {
        $user = User::where('email', $dto->email)->firstOrFail();
        $user->generateVerificationToken();
        $user->notify(new VerifyEmail());
    }
}
