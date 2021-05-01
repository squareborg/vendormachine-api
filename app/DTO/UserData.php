<?php

namespace App\DTO;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    /** @var string|null */
    public $name;

    /** @var string */
    public $email;

    /** @var string|null */
    public $password;

    public static function fromRequest(Request $request)
    {
        return new self([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }

    public function fillable(): array
    {
        return $this->only(
            'name',
            'email',
            'password'
        )->toArray();
    }

    public function hasChanges(User $user): bool
    {
        return $user->name !== $this->name
            || $user->email !== $this->email;
    }

}
