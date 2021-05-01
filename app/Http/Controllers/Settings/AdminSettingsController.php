<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\SettingTransformer;
use App\DTO\Settings\SettingData;
use App\Actions\Settings\UpdateSettingAction;
use App\Models\Setting;


class AdminSettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::all();
        return fractal()->collection($settings)
            ->transformWith(new SettingTransformer());
    }

    public function show(Request $request , $key)
    {
        return fractal()->item(Setting::where('key', $key)->first())
            ->transformWith(new SettingTransformer());
    }

    public function update(Request $request, $key, UpdateSettingAction $updateSettingsAction)
    {
        $setting = $updateSettingsAction(SettingData::fromRequest($request));
        return fractal()->item($setting)
            ->transformWith(new SettingTransformer());
    }

}
