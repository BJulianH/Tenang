<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('user_id', auth()->id())->get();
        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $setting = Setting::updateOrCreate(
            ['user_id' => auth()->id(), 'key' => $request->key],
            ['value' => $request->value]
        );

        return response()->json($setting);
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->json(['message' => 'Pengaturan dihapus.']);
    }
}
