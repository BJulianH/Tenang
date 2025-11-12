<?php

namespace App\Http\Controllers;

use App\Models\MoodRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MoodRateController extends Controller
{
    public function index()
    {
        $moods = MoodRate::where('user_id', auth::id())->latest('date')->get();
        return response()->json($moods);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rate' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string',
        ]);

        $mood = MoodRate::create([
            'user_id' => auth::id(),
            'rate' => $request->rate,
            'note' => $request->note,
            'date' => now()->toDateString(),
        ]);

        return response()->json($mood);
    }

    public function show(MoodRate $moodRate)
    {
        return response()->json($moodRate);
    }

    public function destroy(MoodRate $moodRate)
    {
        $moodRate->delete();
        return response()->json(['message' => 'Data mood dihapus.']);
    }
}
