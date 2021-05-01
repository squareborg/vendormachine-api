<?php

namespace App\DTO;

use App\Http\Requests\Users\AvatarRequest;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AvatarData extends DataTransferObject
{
    /** @var \Illuminate\Http\UploadedFile */
    public $file;

    public static function fromRequest(AvatarRequest $request)
    {
        return new self([
            'file' => $request->file('file'),
        ]);
    }
}
