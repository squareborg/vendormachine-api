<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Products\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create vendors.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user is the product owner
     *
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function owner(User $user, Product $product)
    {
        return $product->vendor->user_id === $user->id;
    }
}
