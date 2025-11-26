{{-- resources/views/noises/by-type.blade.php --}}
@extends('layouts.app')

@section('title', $noiseType->name . ' - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="w-20 h-20 rounded-full mx-auto mb-4" style="background-color: {{ $noiseType->color_code }}"></div>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $noiseType->name }}</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $noiseType->description }}</p>
        <div class="mt-4 text-gray-500">
            <i class="fas fa-music mr-2"></i>
            <span>{{ $noises->total() }} sounds available</span>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('noises.index') }}" class="hover:text-blue-500">All Sounds</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li class="text-gray-800">{{ $noiseType->name }}</li>
        </ol>
    </nav>

    <!-- Sounds Grid -->
    @if($noises->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @foreach($noises as $noise)
        @include('noises.partials.card', ['noise' => $noise])
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $noises->links() }}
    </div>
    @else
    <div class="text-center py-16 bg-white rounded-xl shadow-sm">
        <div class="text-6xl text-gray-300 mb-4">🎵</div>
        <h3 class="text-2xl font-semibold text-gray-600 mb-2">No sounds found</h3>
        <p class="text-gray-500 mb-6">We couldn't find any sounds of this type.</p>
        <a href="{{ route('noises.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
            Browse All Sounds
        </a>
    </div>
    @endif

    <!-- Related Noise Types -->
    @php
        $relatedTypes = App\Models\NoiseType::where('id', '!=', $noiseType->id)
            ->active()
            ->sorted()
            ->take(6)
            ->get();
    @endphp
    
    @if($relatedTypes->count())
    <div class="mt-16">
        <h2 class="text-2xl font-semibold mb-6">Other Sound Types</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($relatedTypes as $relatedType)
            <a href="{{ route('noises.by-type', $relatedType->slug) }}" 
               class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center group border border-gray-100">
                <div class="w-12 h-12 rounded-full mx-auto mb-2 group-hover:scale-110 transition-transform" 
                     style="background-color: {{ $relatedType->color_code }}"></div>
                <h3 class="font-medium text-gray-800 text-sm">{{ $relatedType->name }}</h3>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection