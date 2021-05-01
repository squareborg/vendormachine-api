<?php

namespace App\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class VendorData extends DataTransferObject
{
    /** @var string */
    public $name;

    /** @var string|null */
    public $tagline;


    public static function fromRequest(Request $request)
    {
        return new self([
            'name' => $request->get('name'),
            'tagline' => $request->get('tagline'),
        ]);
    }

}
