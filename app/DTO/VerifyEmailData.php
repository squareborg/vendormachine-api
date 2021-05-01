<?php

namespace App\DTO;

use App\Http\Requests\Auth\VerifyEmailRequest;
use Spatie\DataTransferObject\DataTransferObject;

class VerifyEmailData extends DataTransferObject
{
    /** @var string */
    public $email;

    /** @var string|null */
    public $token;

    public static function fromRequest(VerifyEmailRequest $request)
    {
        return new self([
            'email' => $request->get('email'),
            'token' => $request->get('token'),
        ]);
    }
}
