<?php

namespace App\DTO\Settings;

use Symfony\Component\HttpFoundation\Request;
use Spatie\DataTransferObject\DataTransferObject;

class SettingData extends DataTransferObject
{
    /** @var string */
    public $key;

    /** @var string */
    public $value;

    public static function fromRequest(Request $request)
    {
        return new self([
            'key' => $request->get('key'),
            'value' => $request->get('value'),
        ]);
    }
}
