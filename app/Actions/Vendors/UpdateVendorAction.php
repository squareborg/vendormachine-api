<?php

namespace App\Actions\vendors;

use App\DTO\VendorData;
use App\Models\Vendor;
use App\Events\VendorUpdated;

final class UpdateVendorAction
{
    public function __invoke(VendorData $vendorData, Vendor $vendor): vendor
    {
        $vendor->update($vendorData->toArray());
        event(new VendorUpdated($vendor));
        return $vendor->refresh();
    }
}
