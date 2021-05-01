<?php

namespace App\Actions\Users;

use App\Models\User;
use App\DTO\VerifyEmailData;

final class VerifyEmailAction
{
    public function __invoke(VerifyEmailData $dto): void
    {
        $user = User::where('email', $dto->email)->firstOrFail();

        if ($user->email_verify_token !== $dto->token) {
            throw new \Exception('Invalid token');
        }

        $user->update([
            'email_verify_token' => null,
            'email_verified_at' => now(),
        ]);
    }
}
