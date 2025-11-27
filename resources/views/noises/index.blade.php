{{-- resources/views/noises/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Relaxing Sounds for Mental Health')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Find Your Peace</h1>
        <p class="text-xl text-gray-600 mb-8">Discover sounds that help you relax, focus, and sleep better</p>
        
        <!-- Search Bar -->
        <form action="{{ route('noises.search') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="text" name="q" placeholder="Search sounds..." 
                       class="w-full px-6 py-4 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-blue-500">
                    <i class="fas fa-search text-xl"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Filters -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">What do you need?</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($useCases as $useCase)
            <a href="{{ route('noises.by-use-case', $useCase->slug) }}" 
               class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center">
                <div class="text-3xl mb-2">{{ $useCase->icon }}</div>
                <h3 class="font-semibold text-gray-800">{{ $useCase->name }}</h3>
                <p class="text-sm text-gray-600">{{ $useCase->noises_count }} sounds</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Popular Sounds -->
    @if($popularNoises->count())
    <div class="mb-12">
        <h2 class="text-2xl font-semibold mb-6">Popular Sounds</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularNoises as $noise)
            @include('noises.partials.card', ['noise' => $noise])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Sound Types -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold mb-6">Sound Types</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($noiseTypes as $type)
            <a href="{{ route('noises.by-type', $type->slug) }}" 
               class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center group">
                <div class="w-12 h-12 rounded-full mx-auto mb-2 group-hover:scale-110 transition-transform" 
                     style="background-color: {{ $type->color_code }}"></div>
                <h3 class="font-medium text-gray-800">{{ $type->name }}</h3>
                <p class="text-xs text-gray-600">{{ $type->noises_count }} sounds</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- All Sounds -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">All Sounds</h2>
            <div class="flex space-x-2">
                <select class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Sort by: Popular</option>
                    <option>Sort by: Newest</option>
                    <option>Sort by: Name</option>
                </select>
            </div>
        </div>

        @if($noises->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($noises as $noise)
            @include('noises.partials.card', ['noise' => $noise])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $noises->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-music text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600">No sounds found</h3>
            <p class="text-gray-500">Try adjusting your search or filters</p>
        </div>
        @endif
    </div>
</div>
@endsection