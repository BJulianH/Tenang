{{-- resources/views/noises/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Relaxing Sounds for Mental Health')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <div class="relative mb-8">
            <div class="absolute -inset-8 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-xl opacity-30 animate-pulse-slow"></div>
            <h1 class="text-5xl font-bold text-neutral-800 mb-4 relative">Find Your Peace</h1>
        </div>
        <p class="text-xl text-neutral-600 mb-8 max-w-2xl mx-auto leading-relaxed">
            Discover sounds that help you relax, focus, and sleep better. Curated for your mental wellness journey.
        </p>
        
        <!-- Search Bar -->
        <form action="{{ route('noises.search') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="text" name="q" placeholder="Search sounds, types, or purposes..." 
                       class="w-full px-6 py-4 rounded-duo-xl border-2 border-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo transition-all duration-200">
                <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-primary-500 transition-colors">
                    <i class="fas fa-search text-xl"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Filters - Use Cases -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-neutral-800">What do you need today?</h2>
            <div class="text-sm text-neutral-500 bg-primary-50 px-3 py-1 rounded-duo">
                <i class="fas fa-bullseye mr-1 text-primary-500"></i>
                Choose your purpose
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($useCases as $useCase)
            <a href="{{ route('noises.by-use-case', $useCase->slug) }}" 
               class="card p-6 rounded-duo-xl hover:shadow-duo-lg transition-all duration-200 text-center group relative overflow-hidden">
                <!-- Hover gradient effect -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-secondary-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200 group-hover:animate-bounce-gentle">
                        {{ $useCase->icon }}
                    </div>
                    <h3 class="font-semibold text-neutral-800 text-lg mb-2">{{ $useCase->name }}</h3>
                    <div class="bg-primary-100 text-primary-700 text-sm font-medium px-3 py-1 rounded-duo inline-block">
                        {{ $useCase->noises_count }} sounds
                    </div>
                </div>
            </a>
            @endforeach
            <a href="{{ route('noises.sounds.index') }}" 
               class="card p-6 rounded-duo-xl hover:shadow-duo-lg transition-all duration-200 text-center group relative overflow-hidden">
                <!-- Hover gradient effect -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-secondary-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200 group-hover:animate-bounce-gentle">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3 class="font-semibold text-neutral-800 text-lg mb-2">create your noise?</h3>
                    <div class="bg-secondary text-primary-700 text-sm font-medium px-3 py-1 rounded-duo inline-block">
                        be creative and be calm
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Popular Sounds -->
    @if($popularNoises->count())
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-neutral-800">🔥 Community Favorites</h2>
            <div class="flex items-center text-sm text-neutral-500 bg-secondary-50 px-3 py-1 rounded-duo">
                <i class="fas fa-fire mr-1 text-accent-red"></i>
                Most played this week
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularNoises as $noise)
            <div class="relative">
                <!-- Popular badge -->
                <div class="absolute -top-2 -left-2 z-10 bg-accent-red text-white text-xs font-bold px-3 py-1 rounded-duo shadow-duo flex items-center">
                    <i class="fas fa-fire mr-1"></i>
                    Popular
                </div>
                @include('noises.partials.card', ['noise' => $noise])
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Sound Types -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-neutral-800">🎵 Sound Categories</h2>
            <div class="text-sm text-neutral-500 bg-accent-purple/10 px-3 py-1 rounded-duo">
                <i class="fas fa-tags mr-1 text-accent-purple"></i>
                Browse by type
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($noiseTypes as $type)
            <a href="{{ route('noises.by-type', $type->slug) }}" 
               class="card p-4 rounded-duo-xl hover:shadow-duo-lg transition-all duration-200 text-center group relative overflow-hidden">
                <!-- Background effect -->
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" 
                     style="background-color: {{ $type->color_code }}20"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-full mx-auto mb-3 group-hover:scale-110 transition-transform duration-200 flex items-center justify-center shadow-duo border-2 border-white"
                         style="background-color: {{ $type->color_code }}">
                        <i class="fas fa-music text-white text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-neutral-800 text-sm mb-1">{{ $type->name }}</h3>
                    <p class="text-xs text-neutral-500 font-medium">{{ $type->noises_count }} sounds</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- All Sounds -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-neutral-800">All Sounds Collection</h2>
                <p class="text-neutral-600 mt-1">Explore our complete library of relaxing sounds</p>
            </div>
            <div class="flex space-x-3">
                <select class="border-2 border-neutral-300 rounded-duo px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo transition-all duration-200">
                    <option>🔥 Popular</option>
                    <option>🆕 Newest</option>
                    <option>🔤 A-Z</option>
                    <option>⏱️ Shortest</option>
                </select>
                <button class="app-button px-4 py-2 rounded-duo flex items-center">
                    <i class="fas fa-random mr-2"></i>
                    Shuffle
                </button>
            </div>
        </div>

        @if($noises->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($noises as $noise)
            @include('noises.partials.card', ['noise' => $noise])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $noises->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-16 card rounded-duo-xl max-w-2xl mx-auto">
            <div class="text-6xl text-neutral-300 mb-4 animate-bounce-gentle">🎵</div>
            <h3 class="text-2xl font-semibold text-neutral-600 mb-2">No sounds found</h3>
            <p class="text-neutral-500 mb-6">Try adjusting your search or filters to find what you're looking for.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button onclick="document.querySelector('input[name=q]').focus()" 
                        class="app-button inline-flex items-center px-6 py-3">
                    <i class="fas fa-search mr-2"></i>
                    Search Again
                </button>
                <a href="{{ route('noises.index') }}" 
                   class="app-button app-button-secondary inline-flex items-center px-6 py-3">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset Filters
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- CTA Section -->
    <div class="text-center mt-16 p-8 card rounded-duo-xl bg-gradient-to-r from-primary-50 to-secondary-50 border-2 border-primary-200">
        <h2 class="text-3xl font-bold text-neutral-800 mb-4">Start Your Sound Journey</h2>
        <p class="text-neutral-600 text-lg mb-6 max-w-2xl mx-auto">
            Join thousands of users who have found peace and focus through our curated sound experiences.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button class="app-button px-8 py-4 text-lg font-bold">
                <i class="fas fa-play-circle mr-2"></i>
                Try Random Sound
            </button>
            <a href="{{ route('community.index') }}" 
               class="app-button app-button-secondary px-8 py-4 text-lg font-bold">
                <i class="fas fa-users mr-2"></i>
                Join Community
            </a>
        </div>
    </div>
</div>

<style>
    /* Custom animations untuk halaman index */
    @keyframes float-slow {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(1deg); }
    }

    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }

    /* Stagger animation untuk grid items */
    .stagger-item {
        opacity: 0;
        transform: translateY(20px);
        animation: staggerFadeIn 0.6s ease forwards;
    }

    @keyframes staggerFadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Gradient text effect */
    .gradient-text {
        background: linear-gradient(135deg, #58cc70, #ffc800);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Stagger animation untuk grid items
        const staggerItems = document.querySelectorAll('.card');
        staggerItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('stagger-item');
        });

        // Interactive search bar
        const searchInput = document.querySelector('input[name=q]');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-primary-500', 'scale-105');
                this.parentElement.classList.remove('scale-100');
            });
            
            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-primary-500', 'scale-105');
                this.parentElement.classList.add('scale-100');
            });
        }

        // Shuffle button functionality
        const shuffleButton = document.querySelector('button:contains("Shuffle")');
        if (shuffleButton) {
            shuffleButton.addEventListener('click', function() {
                // Add shuffle animation
                this.classList.add('animate-wiggle');
                setTimeout(() => {
                    this.classList.remove('animate-wiggle');
                }, 1000);
                
                // Redirect to random sound (you'll need to implement this route)
            });
        }

        // Add hover effects to use case cards
        const useCaseCards = document.querySelectorAll('a[href*="by-use-case"]');
        useCaseCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.text-4xl');
                if (icon) {
                    icon.style.transform = 'scale(1.2) rotate(5deg)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.text-4xl');
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        });

        // Celebration effect untuk pertama kali load
        if (!localStorage.getItem('Tenang_sounds_visited')) {
            setTimeout(() => {
                const hero = document.querySelector('.text-center');
                if (hero) {
                    const confetti = document.createElement('div');
                    confetti.innerHTML = '🎉';
                    confetti.className = 'absolute text-3xl animate-celebrate';
                    confetti.style.left = '50%';
                    confetti.style.top = '50%';
                    confetti.style.transform = 'translate(-50%, -50%)';
                    hero.style.position = 'relative';
                    hero.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 2000);
                }
                localStorage.setItem('Tenang_sounds_visited', 'true');
            }, 1500);
        }
    });
</script>
@endsection