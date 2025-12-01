{{-- resources/views/noises/by-type.blade.php --}}
@extends('layouts.app')

@section('title', $noiseType->name . ' - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="relative inline-block mb-6">
            <div class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-sm opacity-50"></div>
            <div class="w-24 h-24 rounded-full mx-auto relative bg-white shadow-duo border-4 flex items-center justify-center" 
                 style="border-color: {{ $noiseType->color_code }}">
                <i class="fas fa-music text-3xl" style="color: {{ $noiseType->color_code }}"></i>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-neutral-800 mb-4">{{ $noiseType->name }}</h1>
        <p class="text-xl text-neutral-600 max-w-2xl mx-auto">{{ $noiseType->description }}</p>
        <div class="mt-4 text-neutral-500 bg-white px-4 py-2 rounded-duo inline-block shadow-duo">
            <i class="fas fa-music mr-2 text-primary-500"></i>
            <span class="font-semibold">{{ $noises->total() }} sounds available</span>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-neutral-600">
            <li>
                <a href="{{ route('noises.index') }}" 
                   class="hover:text-primary-600 transition-colors flex items-center">
                    <i class="fas fa-home mr-1"></i>
                    All Sounds
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-neutral-400 text-xs"></i></li>
            <li class="text-neutral-800 font-semibold">{{ $noiseType->name }}</li>
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
    <!-- Empty State -->
    <div class="text-center py-16 card rounded-duo-xl max-w-2xl mx-auto">
        <div class="text-6xl text-neutral-300 mb-4 animate-bounce-gentle">🎵</div>
        <h3 class="text-2xl font-semibold text-neutral-600 mb-2">No sounds found</h3>
        <p class="text-neutral-500 mb-6">We couldn't find any sounds of this type.</p>
        <a href="{{ route('noises.index') }}" 
           class="app-button inline-flex items-center px-6 py-3">
            <i class="fas fa-arrow-left mr-2"></i>
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
        <h2 class="text-2xl font-semibold mb-6 text-neutral-800">Explore Other Sound Types</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($relatedTypes as $relatedType)
            <a href="{{ route('noises.by-type', $relatedType->slug) }}" 
               class="card p-4 rounded-duo-xl hover:shadow-duo-lg transition-all duration-200 text-center group">
                <div class="relative mb-3">
                    <div class="absolute -inset-2 bg-gradient-to-r from-primary-100 to-secondary-100 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-12 h-12 rounded-full mx-auto relative bg-white shadow-duo border-2 flex items-center justify-center group-hover:scale-110 transition-transform" 
                         style="border-color: {{ $relatedType->color_code }}">
                        <i class="fas fa-music text-sm" style="color: {{ $relatedType->color_code }}"></i>
                    </div>
                </div>
                <h3 class="font-medium text-neutral-800 text-sm">{{ $relatedType->name }}</h3>
                <p class="text-xs text-neutral-500 mt-1">{{ $relatedType->noises_count }} sounds</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    /* Custom styling untuk breadcrumb aktif */
    .breadcrumb-active {
        color: #58cc70;
        font-weight: 600;
    }

    /* Animasi untuk icon musik di empty state */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

<script>
    // Tambahkan efek interaktif untuk related types
    document.addEventListener('DOMContentLoaded', function() {
        const relatedCards = document.querySelectorAll('.card a');
        
        relatedCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.fa-music');
                if (icon) {
                    icon.style.transform = 'scale(1.2)';
                    icon.style.transition = 'transform 0.2s ease';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.fa-music');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                }
            });
        });

        // Animasi untuk header icon
        const headerIcon = document.querySelector('.text-center .fa-music');
        if (headerIcon) {
            setInterval(() => {
                headerIcon.style.transform = 'rotate(5deg)';
                setTimeout(() => {
                    headerIcon.style.transform = 'rotate(-5deg)';
                }, 1000);
            }, 2000);
        }
    });
</script>
@endsection