<?php

namespace App\Transformers;

use App\Models\Vendor;
use League\Fractal\TransformerAbstract;

class VendorTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Vendor $vendor
     * @return array
     */
    public function transform(Vendor $vendor)
    {
        return [
            'id' => $vendor->id,
            'name' => $vendor->name,
            'tagline' => $vendor->tagline,
            'is_suspended' => $vendor->is_suspended,
        ];
    }
}
