<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\User;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'vendor_auto_enable',
            'value' => true,
        ]);
    }
}
