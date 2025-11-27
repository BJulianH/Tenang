<?php
// app/Http/Controllers/NoiseTypeController.php

namespace App\Http\Controllers;

use App\Models\NoiseType;
use Illuminate\Http\Request;

class NoiseTypeController extends Controller
{
    public function index()
    {
        $noiseTypes = NoiseType::withCount(['noises' => function($q) {
                            $q->approved();
                        }])
                        ->active() // Gunakan scope active
                        ->sorted()
                        ->get();

        return view('noise-types.index', compact('noiseTypes'));
    }

    public function show($typeSlug)
    {
        $noiseType = NoiseType::where('slug', $typeSlug)
                            ->active() // Pastikan type aktif
                            ->firstOrFail();
        
        $noises = $noiseType->noises()
                    ->with(['useCases'])
                    ->approved()
                    ->sorted()
                    ->paginate(12);

        return view('noise-types.show', compact('noiseType', 'noises'));
    }
}