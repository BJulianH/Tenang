<?php

namespace App\Http\Controllers;

use App\Models\Meditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MeditationController extends Controller
{
    public function index()
    {
        $meditations = Meditation::all();
        return response()->json($meditations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'media_url' => 'required|string',
            'type' => 'in:audio,video',
        ]);

        $meditation = Meditation::create($request->all());
        return response()->json($meditation);
    }

    public function show(Meditation $meditation)
    {
        return response()->json($meditation);
    }

    public function update(Request $request, Meditation $meditation)
    {
        $meditation->update($request->all());
        return response()->json($meditation);
    }

    public function destroy(Meditation $meditation)
    {
        $meditation->delete();
        return response()->json(['message' => 'Meditasi dihapus.']);
    }
}
