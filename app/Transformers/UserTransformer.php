<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */

    protected $defaultIncludes = [
        'vendors',
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'avatar' => $user->avatarUrl(),
            'name' => $user->name,
            'email' => $user->email,
            'is_suspended' => $user->is_suspended,
            'is_admin' => $user->hasRole('admin'),
            'is_vendor' => $user->hasRole('vendor'),
            'is_verified' => !is_null($user->email_verified_at)
        ];
    }

    public function includeVendors(User $user)
    {
        return $this->collection($user->vendors ,new VendorTransformer());
    }
}
