<?php

namespace App\DTO\Products;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class ProductData extends DataTransferObject
{
    /** @var string|null */
    public $name;

    /** @var string|null */
    public $description;

    /** @var int|null */
    public $price;

    /** @var array|null */
    public $variants;


    public static function fromRequest(Request $request)
    {
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'variants' => $request->get('variants'),
        ]);
    }
}
