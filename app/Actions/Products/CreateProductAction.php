<?php

namespace App\Actions\Products;

use App\Exceptions\Vendor\ManageProductsPermissionDeniedException;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Products\Product;
use App\Events\ProductCreated;

final class CreateProductAction
{
    public function __invoke(array $data): Product
    {
        $user = User::find($data['user_id']);
        $vendor = Vendor::find($data['vendor_id']);
        if ($user->can('manageProducts', $vendor)){
            $vendor = Vendor::find($data['vendor_id']);
            $product = $vendor->products()->create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            $product->variants()->create([
                'price' => $data['price']
            ]);

            event(new ProductCreated($product));
            return $product;
        } else {
            throw new ManageProductsPermissionDeniedException('User is not allowed to manage this vendors products');
        }

    }
}
