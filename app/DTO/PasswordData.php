<?php

namespace App\DTO;

use App\Http\Requests\Users\PasswordRequest;
use Spatie\DataTransferObject\DataTransferObject;

class PasswordData extends DataTransferObject
{
    /** @var string */
    public $oldPassword;

    /** @var string */
    public $newPassword;

    public static function fromRequest(PasswordRequest $request)
    {
        return new self([
            'oldPassword' => $request->get('old_password'),
            'newPassword' => $request->get('new_password'),
        ]);
    }
}
