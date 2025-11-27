{{-- resources/views/noises/search.blade.php --}}
@extends('layouts.app')

@section('title', 'Search Results - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Search Results</h1>
        
        <!-- Search Bar -->
        <form action="{{ route('noises.search') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search sounds..." 
                       class="w-full px-6 py-4 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-blue-500">
                    <i class="fas fa-search text-xl"></i>
                </button>
            </div>
        </form>
        
        @if($query)
        <p class="text-gray-600 mt-4">
            Found {{ $noises->total() }} results for "{{ $query }}"
        </p>
        @endif
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('noises.index') }}" class="hover:text-blue-500">All Sounds</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li class="text-gray-800">Search: "{{ $query }}"</li>
        </ol>
    </nav>

    <!-- Search Results -->
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
        <div class="text-6xl text-gray-300 mb-4">🔍</div>
        <h3 class="text-2xl font-semibold text-gray-600 mb-2">No results found</h3>
        <p class="text-gray-500 mb-6">We couldn't find any sounds matching "{{ $query }}"</p>
        <div class="space-y-4">
            <a href="{{ route('noises.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors inline-block mr-4">
                Browse All Sounds
            </a>
            <button onclick="history.back()" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors inline-block">
                Go Back
            </button>
        </div>
        
        <!-- Search Suggestions -->
        @php
            $suggestions = ['White Noise', 'Rain Sounds', 'Meditation', 'Focus', 'Sleep'];
        @endphp
        <div class="mt-8">
            <h4 class="font-semibold text-gray-700 mb-3">Try searching for:</h4>
            <div class="flex flex-wrap justify-center gap-2">
                @foreach($suggestions as $suggestion)
                <a href="{{ route('noises.search') }}?q={{ urlencode($suggestion) }}" 
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-200 transition-colors">
                    {{ $suggestion }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection