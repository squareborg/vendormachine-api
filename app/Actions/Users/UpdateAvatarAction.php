<?php

namespace App\Actions\Users;

use App\Models\User;
use App\DTO\AvatarData;
use Illuminate\Support\Facades\Storage;

final class UpdateAvatarAction
{
    public function __invoke(User $user, AvatarData $data): User
    {
        $disk = config('filesystems.default');
        $filename = "avatar.{$data->file->getClientOriginalExtension()}";
        $avatar = $data->file->storeAs("avatars/{$user->id}", $filename, $disk);

        $user->update(['avatar' => $avatar]);
        return $user;
    }
}
