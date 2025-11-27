<?php

namespace App\Http\Controllers;

use App\Models\MoodTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MoodTrackingController extends Controller
{
    /**
     * Store a newly created mood tracking.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mood' => 'required|in:senang,sedih,cemas,stress,tenang,marah,lelah',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam menyimpan mood.')
                ->with('active_tab', 'mental-health');
        }

        try {
            $moodTracking = MoodTracking::create([
                'user_id' => Auth::id(),
                'mood' => $request->mood,
                'description' => $request->description,
            ]);

            return redirect()->back()
                ->with('success', 'Mood berhasil dicatat!')
                ->with('active_tab', 'mental-health');
        } catch (\Exception $e) {
            \Log::error('Mood tracking error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menyimpan mood: ' . $e->getMessage())
                ->with('active_tab', 'mental-health');
        }
    }

    /**
     * Remove the specified mood tracking.
     */
    public function destroy(MoodTracking $moodTracking)
    {
        try {
            // Authorization check
            if ($moodTracking->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            $moodTracking->delete();

            return redirect()->back()
                ->with('success', 'Catatan mood berhasil dihapus!')
                ->with('active_tab', 'mental-health');
        } catch (\Exception $e) {
            \Log::error('Mood delete error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus catatan mood.')
                ->with('active_tab', 'mental-health');
        }
    }
}