<?php

namespace App\Actions\vendors;

use App\DTO\VendorData;
use App\Models\Vendor;
use App\Models\Setting;
use App\Events\VendorCreated;

final class CreateVendorAction
{
    public function __invoke(VendorData $vendorData): vendor
    {
        $active = Setting::where('key','=','vendor_auto_enable')->first()->value;
        $vendor = auth()->user()->vendors()->create([
            'name' => $vendorData->name,
            'tagline' => $vendorData->tagline,
            'is_active' => (bool) $active,
        ]);

        auth()->user()->assignRole('vendor');


        event(new VendorCreated($vendor));
        return $vendor;
    }
}
