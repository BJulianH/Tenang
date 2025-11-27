<?php
// app/Http/Controllers/NoiseController.php

namespace App\Http\Controllers;

use App\Models\Noise;
use App\Models\NoiseType;
use App\Models\UseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoiseController extends Controller
{
    public function index(Request $request)
    {
        $query = Noise::with(['type', 'useCases'])
                    ->approved() // Pastikan menggunakan scope yang benar
                    ->sorted();

        // Filter by type if provided
        if ($request->has('type')) {
            $query->whereHas('type', function($q) use ($request) {
                $q->where('slug', $request->type)
                  ->active(); // Pastikan type aktif
            });
        }

        // Filter by use case if provided
        if ($request->has('use_case')) {
            $query->whereHas('useCases', function($q) use ($request) {
                $q->where('slug', $request->use_case);
            });
        }

        $noises = $query->paginate(12);
        
        $popularNoises = Noise::with(['type'])
                            ->approved()
                            ->popular() // Gunakan scope popular
                            ->take(6)
                            ->get();
        
        $noiseTypes = NoiseType::withCount(['noises' => function($q) {
                            $q->approved();
                        }])
                        ->active() // Gunakan scope active
                        ->sorted()
                        ->get();
        
        $useCases = UseCase::withCount(['noises' => function($q) {
                        $q->approved();
                    }])
                    ->sorted()
                    ->get();

        return view('noises.index', compact('noises', 'popularNoises', 'noiseTypes', 'useCases'));
    }

    public function show(Noise $noise)
    {
        // Increment view count
        $noise->increment('view_count');
        
        $noise->load(['type', 'useCases']);
        
        $relatedNoises = Noise::with(['type'])
                            ->where('id', '!=', $noise->id)
                            ->where('noise_type_id', $noise->noise_type_id)
                            ->approved()
                            ->take(6)
                            ->get();

        return view('noises.show', compact('noise', 'relatedNoises'));
    }

    public function byType($typeSlug)
    {
        $noiseType = NoiseType::where('slug', $typeSlug)->firstOrFail();
        
        $noises = Noise::with(['type', 'useCases'])
                    ->where('noise_type_id', $noiseType->id)
                    ->approved()
                    ->sorted()
                    ->paginate(12);

        return view('noises.by-type', compact('noises', 'noiseType'));
    }

    public function byUseCase($useCaseSlug)
    {
        $useCase = UseCase::where('slug', $useCaseSlug)->firstOrFail();
        
        $noises = $useCase->noises()
                    ->with(['type', 'useCases'])
                    ->approved()
                    ->sorted()
                    ->paginate(12);

        return view('noises.by-use-case', compact('noises', 'useCase'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $noises = Noise::with(['type', 'useCases'])
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%")
                          ->orWhereJsonContains('tags', $query);
                    })
                    ->approved()
                    ->sorted()
                    ->paginate(12);

        return view('noises.search', compact('noises', 'query'));
    }

    public function incrementPlayCount(Noise $noise)
    {
        $noise->increment('play_count');
        
        return response()->json([
            'success' => true,
            'play_count' => $noise->play_count
        ]);
    }

    public function toggleFavorite(Noise $noise)
    {
        $user = auth()->user();
        
        if ($user->favoriteNoises()->where('noise_id', $noise->id)->exists()) {
            $user->favoriteNoises()->detach($noise->id);
            $isFavorited = false;
        } else {
            $user->favoriteNoises()->attach($noise->id);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'favorites_count' => $noise->favoritedBy()->count()
        ]);
    }

    public function toggleSave(Noise $noise)
    {
        $user = auth()->user();
        
        if ($user->savedNoises()->where('noise_id', $noise->id)->exists()) {
            $user->savedNoises()->detach($noise->id);
            $isSaved = false;
        } else {
            $user->savedNoises()->attach($noise->id);
            $isSaved = true;
        }

        return response()->json([
            'success' => true,
            'is_saved' => $isSaved,
            'saves_count' => $noise->savedBy()->count()
        ]);
    }
}