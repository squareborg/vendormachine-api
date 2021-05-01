<?php

namespace App\Transformers;

use App\Models\Setting;

class SettingTransformer extends \League\Fractal\TransformerAbstract
{

    public function transform(Setting $setting)
    {
        return $setting->toArray();
    }

}
