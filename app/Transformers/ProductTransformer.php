<?php

namespace App\Transformers;

use App\Models\Products\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['variants'];

    /**
     * A Fractal transformer.
     *
     * @param Product $data
     * @return array
     */
    public function transform(Product $data)
    {
        return [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data->description,
            'vendor_id' => $data->vendor_id,
        ];
    }

    public function includeVariants(Product $data)
    {
        return $this->collection($data->variants, new ProductVariantTransformer);
    }
}
