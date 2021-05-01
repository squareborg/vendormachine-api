<?php

namespace App\Actions\Products;

use App\DTO\Products\ProductData;
use App\Models\Products\Product;
use App\Events\Vendors\Products\ProductUpdated;

final class UpdateProductAction
{
    public function __invoke(ProductData $productData, Product $product): product
    {
        $product->update([
            'name' => $productData->name,
            'description' => $productData->description
        ]);
        $product->variants()->first()->update([
            'price' => $productData->variants['data'][0]['price']
        ]);
        event(new ProductUpdated($product));
        return $product->refresh();
    }
}
