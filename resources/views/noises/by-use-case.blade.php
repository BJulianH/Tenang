{{-- resources/views/noises/by-use-case.blade.php --}}
@extends('layouts.app')

@section('title', $useCase->name . ' - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="relative inline-block mb-6">
            <div class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-sm opacity-50 animate-pulse-slow"></div>
            <div class="text-6xl mb-4 relative bg-white p-6 rounded-duo-xl shadow-duo border-4 border-primary-100 inline-block">
                {{ $useCase->icon }}
            </div>
        </div>
        <h1 class="text-4xl font-bold text-neutral-800 mb-4">{{ $useCase->name }}</h1>
        <p class="text-xl text-neutral-600 max-w-2xl mx-auto leading-relaxed">{{ $useCase->description }}</p>
        <div class="mt-4 text-neutral-500 bg-white px-4 py-2 rounded-duo inline-block shadow-duo">
            <i class="fas fa-music mr-2 text-primary-500"></i>
            <span class="font-semibold">{{ $noises->total() }} curated sounds</span>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-neutral-600 bg-white px-4 py-2 rounded-duo shadow-duo">
            <li>
                <a href="{{ route('noises.index') }}" 
                   class="hover:text-primary-600 transition-colors flex items-center font-medium">
                    <i class="fas fa-soundcloud mr-2 text-primary-500"></i>
                    All Sounds
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-neutral-400 text-xs mx-2"></i></li>
            <li class="text-neutral-800 font-semibold flex items-center">
                <span class="mr-2">{{ $useCase->icon }}</span>
                {{ $useCase->name }}
            </li>
        </ol>
    </nav>

    <!-- Sounds Grid -->
    @if($noises->count())
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-neutral-800">Recommended Sounds</h2>
            <div class="text-sm text-neutral-500 bg-primary-50 px-3 py-1 rounded-duo">
                <i class="fas fa-filter mr-1 text-primary-500"></i>
                Sorted by relevance
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($noises as $noise)
            @include('noises.partials.card', ['noise' => $noise])
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $noises->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-16 card rounded-duo-xl max-w-2xl mx-auto">
        <div class="text-6xl text-neutral-300 mb-4 animate-bounce-gentle">🎵</div>
        <h3 class="text-2xl font-semibold text-neutral-600 mb-2">No sounds found for this purpose</h3>
        <p class="text-neutral-500 mb-6 max-w-md mx-auto">
            We're constantly adding new sounds. Check back later or explore other use cases.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('noises.index') }}" 
               class="app-button inline-flex items-center px-6 py-3">
                <i class="fas fa-arrow-left mr-2"></i>
                Browse All Sounds
            </a>
            <a href="{{ route('noises.by-type', 'nature') }}" 
               class="app-button app-button-secondary inline-flex items-center px-6 py-3">
                <i class="fas fa-leaf mr-2"></i>
                Try Nature Sounds
            </a>
        </div>
    </div>
    @endif

    <!-- Related Use Cases -->
    @php
        $relatedUseCases = App\Models\UseCase::where('id', '!=', $useCase->id)
            ->sorted()
            ->take(6)
            ->get();
    @endphp
    
    @if($relatedUseCases->count())
    <div class="mt-16 pt-8 border-t border-neutral-200">
        <h2 class="text-2xl font-semibold mb-6 text-neutral-800 text-center">Explore Other Purposes</h2>
        <p class="text-neutral-600 text-center mb-8 max-w-2xl mx-auto">
            Discover sounds tailored for different moments and needs in your mental wellness journey.
        </p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($relatedUseCases as $relatedUseCase)
            <a href="{{ route('noises.by-use-case', $relatedUseCase->slug) }}" 
               class="card p-4 rounded-duo-xl hover:shadow-duo-lg transition-all duration-200 text-center group relative overflow-hidden">
                <!-- Background effect on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-secondary-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="text-3xl mb-3 group-hover:scale-110 transition-transform duration-200 group-hover:animate-bounce-gentle">
                        {{ $relatedUseCase->icon }}
                    </div>
                    <h3 class="font-semibold text-neutral-800 text-sm mb-1">{{ $relatedUseCase->name }}</h3>
                    <p class="text-xs text-neutral-500">{{ $relatedUseCase->noises_count }} sounds</p>
                </div>
            </a>
            @endforeach
        </div>
        
        <!-- CTA Section -->
        <div class="text-center mt-8">
            <a href="{{ route('noises.index') }}" 
               class="app-button app-button-secondary inline-flex items-center px-6 py-3 text-lg">
                <i class="fas fa-compass mr-2"></i>
                Explore All Use Cases
            </a>
        </div>
    </div>
    @endif
</div>

<style>
    /* Custom animations untuk use case icons */
    @keyframes gentle-float {
        0%, 100% { 
            transform: translateY(0px) rotate(0deg); 
        }
        33% { 
            transform: translateY(-3px) rotate(1deg); 
        }
        66% { 
            transform: translateY(2px) rotate(-1deg); 
        }
    }

    .animate-gentle-float {
        animation: gentle-float 4s ease-in-out infinite;
    }

    /* Hover effects untuk related use cases */
    .use-case-card:hover .use-case-icon {
        animation: celebrate 0.6s ease-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi untuk main use case icon
        const mainIcon = document.querySelector('.text-6xl');
        if (mainIcon) {
            mainIcon.classList.add('animate-gentle-float');
        }

        // Interaksi untuk related use cases
        const relatedCards = document.querySelectorAll('.card a');
        
        relatedCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.text-3xl');
                if (icon) {
                    icon.style.transform = 'scale(1.15)';
                    icon.style.transition = 'transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.text-3xl');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                }
            });

            // Tambahkan class untuk tracking
            this.classList.add('use-case-card');
            const iconElement = this.querySelector('.text-3xl');
            if (iconElement) {
                iconElement.classList.add('use-case-icon');
            }
        });

        // Progress indicator untuk loading state (jika diperlukan)
        const soundsGrid = document.querySelector('.grid');
        if (soundsGrid && soundsGrid.children.length > 0) {
            // Tambahkan subtle animation untuk cards saat load
            const cards = soundsGrid.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate-slide-in');
            });
        }
    });

    // Celebration effect ketika berhasil menemukan sounds
    function celebrateDiscovery() {
        const header = document.querySelector('.text-center');
        if (header) {
            const confetti = document.createElement('div');
            confetti.innerHTML = '🎉';
            confetti.className = 'absolute text-2xl animate-celebrate';
            confetti.style.left = '50%';
            confetti.style.top = '50%';
            header.appendChild(confetti);
            
            setTimeout(() => {
                confetti.remove();
            }, 1000);
        }
    }

    // Trigger celebration jika ada sounds
    @if($noises->count() && $noises->currentPage() === 1)
    setTimeout(celebrateDiscovery, 1000);
    @endif
</script>
@endsection