<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the user's settings.
     */
    public function index(): JsonResponse
    {
        $settings = Setting::where('user_id', Auth::id())->get();
        
        return response()->json([
            'success' => true,
            'data' => $settings,
            'message' => 'Settings retrieved successfully.'
        ]);
    }

    /**
     * Store or update a setting.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'nullable|string',
        ]);

        try {
            $setting = Setting::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'key' => $validated['key']
                ],
                [
                    'value' => $validated['value']
                ]
            );

            return response()->json([
                'success' => true,
                'data' => $setting,
                'message' => 'Setting saved successfully.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save setting.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified setting.
     */
    public function show(Setting $setting): JsonResponse
    {
        // Authorization check
        if ($setting->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to setting.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $setting,
            'message' => 'Setting retrieved successfully.'
        ]);
    }

    /**
     * Update the specified setting.
     */
    public function update(Request $request, Setting $setting): JsonResponse
    {
        // Authorization check
        if ($setting->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to setting.'
            ], 403);
        }

        $validated = $request->validate([
            'value' => 'required|string',
        ]);

        try {
            $setting->update([
                'value' => $validated['value']
            ]);

            return response()->json([
                'success' => true,
                'data' => $setting,
                'message' => 'Setting updated successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update setting.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified setting.
     */
    public function destroy(Setting $setting): JsonResponse
    {
        // Authorization check
        if ($setting->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to setting.'
            ], 403);
        }

        try {
            $setting->delete();

            return response()->json([
                'success' => true,
                'message' => 'Setting deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete setting.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific setting by key.
     */
    public function getByKey(string $key): JsonResponse
    {
        $setting = Setting::where('user_id', Auth::id())
                            ->where('key', $key)
                            ->first();

        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Setting not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $setting,
            'message' => 'Setting retrieved successfully.'
        ]);
    }
}