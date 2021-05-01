<?php

namespace App\Actions\Settings;

use App\Models\Setting;
use App\DTO\Settings\SettingData;

final class UpdateSettingAction
{
    public function __invoke(SettingData $data): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $data->key],
            ['value' => $data->value]
        );
    }
}
