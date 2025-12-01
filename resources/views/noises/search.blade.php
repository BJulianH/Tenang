{{-- resources/views/noises/search.blade.php --}}
@extends('layouts.app')

@section('title', 'Search Results - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="relative mb-8">
            <div class="absolute -inset-8 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-xl opacity-30 animate-pulse-slow"></div>
            <h1 class="text-5xl font-bold text-neutral-800 mb-4 relative">Search Sounds</h1>
        </div>
        
        <!-- Search Bar -->
        <form action="{{ route('noises.search') }}" method="GET" class="max-w-2xl mx-auto relative">
            <div class="relative">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search sounds, types, moods, or purposes..." 
                       class="w-full px-6 py-4 rounded-duo-xl border-2 border-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo transition-all duration-200 text-lg">
                <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-primary-500 transition-colors">
                    <i class="fas fa-search text-xl"></i>
                </button>
            </div>
            
            <!-- Quick Search Tips -->
            <div class="mt-3 text-sm text-neutral-500 text-left">
                <i class="fas fa-lightbulb mr-1 text-secondary-500"></i>
                Try searching for: <span class="font-medium">sleep, focus, rain, meditation, nature</span>
            </div>
        </form>
        
        @if($query)
        <div class="mt-6 bg-white px-6 py-3 rounded-duo shadow-duo inline-block">
            <p class="text-neutral-700 font-semibold">
                <i class="fas fa-music mr-2 text-primary-500"></i>
                Found <span class="text-primary-600">{{ $noises->total() }}</span> results for 
                <span class="text-secondary-600">"{{ $query }}"</span>
            </p>
        </div>
        @endif
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-neutral-600 bg-white px-4 py-2 rounded-duo shadow-duo">
            <li>
                <a href="{{ route('noises.index') }}" 
                   class="hover:text-primary-600 transition-colors flex items-center font-medium">
                    <i class="fas fa-home mr-2 text-primary-500"></i>
                    All Sounds
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-neutral-400 text-xs mx-2"></i></li>
            <li class="text-neutral-800 font-semibold flex items-center">
                <i class="fas fa-search mr-2 text-accent-blue"></i>
                Search: "{{ $query }}"
            </li>
        </ol>
    </nav>

    <!-- Search Results -->
    @if($noises->count())
    <div class="mb-8">
        <!-- Results Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-neutral-800">Search Results</h2>
                <p class="text-neutral-600 mt-1">Sounds matching your search criteria</p>
            </div>
            
            <!-- Sort & Filter -->
            <div class="flex space-x-3 mt-4 lg:mt-0">
                <select class="border-2 border-neutral-300 rounded-duo px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo transition-all duration-200">
                    <option>🔥 Most Relevant</option>
                    <option>🎵 Most Popular</option>
                    <option>🆕 Newest First</option>
                    <option>⏱️ Shortest First</option>
                </select>
                
                <button class="app-button px-4 py-2 rounded-duo flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($noises as $noise)
            <div class="relative">
                <!-- Relevance Badge -->
                @if($loop->first && $noises->total() > 1)
                <div class="absolute -top-2 -left-2 z-10 bg-primary-500 text-white text-xs font-bold px-3 py-1 rounded-duo shadow-duo flex items-center">
                    <i class="fas fa-bullseye mr-1"></i>
                    Best Match
                </div>
                @endif
                
                <!-- Exact Match Badge -->
                @if(strtolower($noise->title) === strtolower($query))
                <div class="absolute -top-2 -right-2 z-10 bg-accent-blue text-white text-xs font-bold px-3 py-1 rounded-duo shadow-duo flex items-center">
                    <i class="fas fa-star mr-1"></i>
                    Exact Match
                </div>
                @endif
                
                @include('noises.partials.card', ['noise' => $noise])
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $noises->appends(['q' => $query])->links() }}
        </div>
    </div>

    <!-- Search Tips -->
    <div class="mt-12 card rounded-duo-xl p-6 bg-gradient-to-r from-primary-50 to-secondary-50">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0 w-12 h-12 bg-primary-500 rounded-duo flex items-center justify-center">
                <i class="fas fa-lightbulb text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-neutral-800 mb-2">Search Tips</h3>
                <ul class="text-neutral-600 space-y-1">
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary-500 mr-2 text-sm"></i>
                        Use specific terms like "rain" or "white noise"
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary-500 mr-2 text-sm"></i>
                        Try mood-based searches like "calm" or "focus"
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary-500 mr-2 text-sm"></i>
                        Search by duration: "5 minutes" or "short sounds"
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @else
    <!-- Empty State -->
    <div class="text-center py-16 card rounded-duo-xl max-w-3xl mx-auto">
        <div class="text-6xl text-neutral-300 mb-4 animate-bounce-gentle">🔍</div>
        <h3 class="text-3xl font-semibold text-neutral-600 mb-3">No results found</h3>
        <p class="text-neutral-500 text-lg mb-8 max-w-md mx-auto">
            We couldn't find any sounds matching <span class="font-semibold text-secondary-600">"{{ $query }}"</span>
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('noises.index') }}" 
               class="app-button inline-flex items-center px-6 py-3 text-lg">
                <i class="fas fa-soundcloud mr-2"></i>
                Browse All Sounds
            </a>
            <button onclick="history.back()" 
                    class="app-button app-button-secondary inline-flex items-center px-6 py-3 text-lg">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </button>
        </div>
        
        <!-- Search Suggestions -->
        @php
            $suggestions = ['White Noise', 'Rain Sounds', 'Meditation', 'Focus', 'Sleep', 'Nature', 'Calm', 'Ocean'];
        @endphp
        <div class="mt-8 pt-8 border-t border-neutral-200">
            <h4 class="font-semibold text-neutral-700 mb-4 text-lg flex items-center justify-center">
                <i class="fas fa-compass mr-2 text-accent-blue"></i>
                Try searching for:
            </h4>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($suggestions as $suggestion)
                <a href="{{ route('noises.search') }}?q={{ urlencode($suggestion) }}" 
                   class="bg-white px-5 py-3 rounded-duo shadow-duo hover:shadow-duo-lg transition-all duration-200 text-neutral-700 font-medium hover:text-primary-600 hover:scale-105 border-2 border-transparent hover:border-primary-200">
                    {{ $suggestion }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Popular Categories -->
        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('noises.by-type', 'nature') }}" 
               class="card p-4 rounded-duo-xl text-center group hover:shadow-duo-lg transition-all duration-200">
                <div class="w-12 h-12 bg-green-500 rounded-full mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-leaf text-white"></i>
                </div>
                <span class="text-sm font-medium text-neutral-700">Nature</span>
            </a>
            
            <a href="{{ route('noises.by-type', 'water') }}" 
               class="card p-4 rounded-duo-xl text-center group hover:shadow-duo-lg transition-all duration-200">
                <div class="w-12 h-12 bg-blue-500 rounded-full mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-water text-white"></i>
                </div>
                <span class="text-sm font-medium text-neutral-700">Water</span>
            </a>
            
            <a href="{{ route('noises.by-use-case', 'sleep') }}" 
               class="card p-4 rounded-duo-xl text-center group hover:shadow-duo-lg transition-all duration-200">
                <div class="w-12 h-12 bg-purple-500 rounded-full mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-moon text-white"></i>
                </div>
                <span class="text-sm font-medium text-neutral-700">Sleep</span>
            </a>
            
            <a href="{{ route('noises.by-use-case', 'focus') }}" 
               class="card p-4 rounded-duo-xl text-center group hover:shadow-duo-lg transition-all duration-200">
                <div class="w-12 h-12 bg-orange-500 rounded-full mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-bullseye text-white"></i>
                </div>
                <span class="text-sm font-medium text-neutral-700">Focus</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Recent Searches (Optional) -->
    @if(auth()->check() && $noises->count())
    <div class="mt-12">
        <h3 class="text-xl font-semibold text-neutral-800 mb-4 flex items-center">
            <i class="fas fa-history mr-3 text-neutral-500"></i>
            Your Recent Searches
        </h3>
        <div class="flex flex-wrap gap-2">
            @php
                $recentSearches = ['Meditation', 'Rain', 'Study', 'Calm']; // Example data
            @endphp
            @foreach($recentSearches as $recent)
            <a href="{{ route('noises.search') }}?q={{ urlencode($recent) }}" 
               class="bg-neutral-100 text-neutral-700 px-4 py-2 rounded-duo text-sm hover:bg-neutral-200 transition-colors flex items-center">
                <i class="fas fa-search mr-2 text-neutral-500 text-xs"></i>
                {{ $recent }}
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    /* Search-specific animations */
    @keyframes search-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    .search-highlight {
        background: linear-gradient(120deg, #58cc7020, #ffc80020);
        border-left: 4px solid #58cc70;
    }

    /* Exact match glow effect */
    .exact-match {
        box-shadow: 0 0 20px rgba(88, 204, 112, 0.3);
    }

    /* Relevance badge animation */
    @keyframes relevance-glow {
        0%, 100% { box-shadow: 0 4px 0 #45b259; }
        50% { box-shadow: 0 4px 0 #45b259, 0 0 20px rgba(88, 204, 112, 0.6); }
    }

    .relevance-glow {
        animation: relevance-glow 2s ease-in-out infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="q"]');
    const searchForm = document.querySelector('form');
    
    // Focus search input on load
    if (searchInput && searchInput.value) {
        searchInput.select();
    }

    // Search form enhancement
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchTerm = searchInput.value.trim();
            if (!searchTerm) {
                e.preventDefault();
                searchInput.focus();
                // Add shake animation
                searchInput.classList.add('animate-wiggle');
                setTimeout(() => {
                    searchInput.classList.remove('animate-wiggle');
                }, 500);
            }
        });
    }

    // Add search suggestions functionality
    const suggestionLinks = document.querySelectorAll('a[href*="noises.search"]');
    suggestionLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state to search
            const searchButton = document.querySelector('button[type="submit"]');
            if (searchButton) {
                const originalHtml = searchButton.innerHTML;
                searchButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Searching...';
                searchButton.disabled = true;
                
                setTimeout(() => {
                    searchButton.innerHTML = originalHtml;
                    searchButton.disabled = false;
                }, 1500);
            }
        });
    });

    // Highlight exact matches in results
    const exactMatchCards = document.querySelectorAll('.exact-match');
    exactMatchCards.forEach(card => {
        card.classList.add('exact-match');
        
        // Add celebration effect for exact matches
        if (card.querySelector('[data-exact-match]')) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.innerHTML = '🎯';
                confetti.className = 'absolute top-2 right-2 text-xl animate-celebrate';
                card.style.position = 'relative';
                card.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 1000);
            }, 500);
        }
    });

    // Add relevance glow to best match
    const bestMatchBadge = document.querySelector('.bg-primary-500');
    if (bestMatchBadge) {
        bestMatchBadge.classList.add('relevance-glow');
    }

    // Search analytics (optional)
    function trackSearch(searchTerm, resultsCount) {
        // Implement search tracking here
        console.log(`Searched for: ${searchTerm}, Found: ${resultsCount} results`);
    }

    // Track current search
    @if($query && $noises->count())
        trackSearch("{{ $query }}", {{ $noises->total() }});
    @endif
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Focus search on Ctrl+K or Cmd+K
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('input[name="q"]');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
    
    // Clear search on Escape
    if (e.key === 'Escape') {
        const searchInput = document.querySelector('input[name="q"]');
        if (searchInput && document.activeElement === searchInput) {
            searchInput.blur();
        }
    }
});

// Search input enhancements
const searchInput = document.querySelector('input[name="q"]');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        // Real-time search suggestions could be implemented here
        if (this.value.length > 2) {
            // Show loading indicator for real-time search
            this.style.backgroundImage = 'url("data:image/svg+xml,...")';
        } else {
            this.style.backgroundImage = '';
        }
    });
}
</script>
@endsection