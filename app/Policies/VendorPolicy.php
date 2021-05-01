<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy
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
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the vendor.
     *
     * @param User $user
     * @param Vendor $vendor
     * @return mixed
     */
    public function show(User $user, Vendor $vendor)
    {
        return true;
    }

    /**
     * Determine whether the user can update the vendor.
     *
     * @param User $user
     * @param Vendor $vendor
     * @return mixed
     */
    public function update(User $user, Vendor $vendor)
    {
        return (int) $vendor->user_id === (int) $user->id;
    }

    /**
     * Determine whether the user can delete the vendor.
     *
     * @param User $user
     * @param Vendor $vendor
     * @return mixed
     */
    public function delete(User $user, Vendor $vendor)
    {
        return (int) $vendor->user_id === (int) $user->id;
    }

    /**
     * Determine whether the user is the vendor owner
     *
     * @param User $user
     * @param Vendor $vendor
     * @return bool
     */
    public function owner(User $user, Vendor $vendor)
    {
        return $vendor->user_id === $user->id;
    }

    public function manageProducts(User $user, Vendor $vendor)
    {
        return $user->can('owner', $vendor);
    }
}
