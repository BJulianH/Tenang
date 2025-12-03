{{-- resources/views/noises/show.blade.php --}}
@extends('layouts.app')

@section('title', $noise->title . ' - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-neutral-600 bg-white px-4 py-2 rounded-duo shadow-duo">
                <li>
                    <a href="{{ route('noises.index') }}" 
                       class="hover:text-primary-600 transition-colors flex items-center font-medium">
                        <i class="fas fa-soundcloud mr-2 text-primary-500"></i>
                        Sounds
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-neutral-400 text-xs mx-2"></i></li>
                <li>
                    <a href="{{ route('noises.by-type', $noise->type->slug) }}" 
                       class="hover:text-primary-600 transition-colors flex items-center">
                        <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $noise->type->color_code }}"></div>
                        {{ $noise->type->name }}
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-neutral-400 text-xs mx-2"></i></li>
                <li class="text-neutral-800 font-semibold flex items-center">
                    <i class="fas fa-music mr-2 text-primary-500"></i>
                    {{ $noise->title }}
                </li>
            </ol>
        </nav>

        <!-- Main Card -->
        <div class="card rounded-duo-xl overflow-hidden mb-8">
            <!-- Header with Gradient Background -->
            <div class="p-8 relative overflow-hidden" style="background: linear-gradient(135deg, {{ $noise->type->color_code }}15, {{ $noise->type->color_code }}05)">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                    <div class="text-6xl">{{ $noise->type->icon ?? '🎵' }}</div>
                </div>
                
                <div class="flex flex-col md:flex-row md:items-start md:space-x-6 relative z-10">
                    <!-- Color Indicator -->
                    <div class="w-24 h-24 rounded-duo-lg mb-4 md:mb-0 flex-shrink-0 shadow-duo border-4 border-white flex items-center justify-center" 
                         style="background-color: {{ $noise->type->color_code }}">
                        <i class="fas fa-music text-white text-2xl"></i>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                            <div class="flex-1">
                                <h1 class="text-4xl font-bold text-neutral-800 mb-3">{{ $noise->title }}</h1>
                                <p class="text-lg text-neutral-600 leading-relaxed mb-4">{{ $noise->description }}</p>
                            </div>
                            <div class="flex space-x-3 mb-4 md:mb-0">
                                <button class="noise-favorite-btn app-button px-4 py-3 rounded-duo flex items-center transition-all duration-200" 
                                        data-noise-id="{{ $noise->id }}">
                                    <i class="far fa-heart mr-2"></i>
                                    <span>Favorite</span>
                                </button>
                                <button class="noise-save-btn app-button app-button-secondary px-4 py-3 rounded-duo flex items-center transition-all duration-200" 
                                        data-noise-id="{{ $noise->id }}">
                                    <i class="far fa-bookmark mr-2"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-6 text-sm">
                            <div class="flex items-center bg-white px-3 py-2 rounded-duo shadow-duo">
                                <i class="fas fa-play text-primary-500 mr-2"></i>
                                <span class="font-semibold text-neutral-700">{{ number_format($noise->play_count) }} plays</span>
                            </div>
                            <div class="flex items-center bg-white px-3 py-2 rounded-duo shadow-duo">
                                <i class="fas fa-eye text-accent-blue mr-2"></i>
                                <span class="font-semibold text-neutral-700">{{ number_format($noise->view_count) }} views</span>
                            </div>
                            <div class="flex items-center bg-white px-3 py-2 rounded-duo shadow-duo">
                                <i class="fas fa-clock text-accent-purple mr-2"></i>
                                <span class="font-semibold text-neutral-700">{{ gmdate('i:s', $noise->duration) }}</span>
                            </div>
                            <div class="flex items-center bg-white px-3 py-2 rounded-duo shadow-duo">
                                <i class="fas fa-tag mr-2" style="color: {{ $noise->type->color_code }}"></i>
                                <span class="font-semibold text-neutral-700">{{ $noise->type->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio Player -->
            <div class="border-t border-neutral-200 p-8 bg-gradient-to-r from-neutral-50 to-white">
                <div class="max-w-2xl mx-auto">
                    <div class="card rounded-duo-xl p-6 bg-white">
                        <audio id="noise-player" class="w-full rounded-duo" controls>
                            <source src="{{ asset('storage/' . $noise->audio_file) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        
                        <!-- Custom Controls -->
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                            <button id="play-btn" class="app-button px-8 py-4 rounded-duo-lg text-lg font-bold flex items-center transition-all duration-200">
                                <i class="fas fa-play mr-3"></i>
                                <span>Play Sound</span>
                            </button>
                            
                            <div class="flex space-x-4">
                                <button class="control-btn p-4 rounded-duo bg-white shadow-duo text-neutral-600 hover:text-primary-500 hover:scale-110 transition-all duration-200">
                                    <i class="fas fa-redo text-lg"></i>
                                </button>
                                <button class="control-btn p-4 rounded-duo bg-white shadow-duo text-neutral-600 hover:text-accent-blue hover:scale-110 transition-all duration-200">
                                    <i class="fas fa-volume-up text-lg"></i>
                                </button>
                                <button class="control-btn p-4 rounded-duo bg-white shadow-duo text-neutral-600 hover:text-accent-purple hover:scale-110 transition-all duration-200">
                                    <i class="fas fa-download text-lg"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Progress Stats -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div class="bg-primary-50 p-4 rounded-duo">
                                <div class="text-2xl font-bold text-primary-600">{{ $noise->completion_rate }}%</div>
                                <div class="text-sm text-neutral-600">Completion Rate</div>
                            </div>
                            <div class="bg-secondary-50 p-4 rounded-duo">
                                <div class="text-2xl font-bold text-secondary-600">{{ $noise->avg_rating }}/5</div>
                                <div class="text-sm text-neutral-600">Average Rating</div>
                            </div>
                            <div class="bg-accent-purple/10 p-4 rounded-duo">
                                <div class="text-2xl font-bold text-accent-purple">{{ $noise->favorites_count }}</div>
                                <div class="text-sm text-neutral-600">Favorites</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Use Cases & Tags -->
            <div class="border-t border-neutral-200 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Use Cases -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-neutral-800 flex items-center">
                            <i class="fas fa-bullseye mr-3 text-primary-500"></i>
                            Best For
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($noise->useCases as $useCase)
                            <a href="{{ route('noises.by-use-case', $useCase->slug) }}" 
                               class="bg-white px-4 py-3 rounded-duo shadow-duo hover:shadow-duo-lg transition-all duration-200 flex items-center group border-2 border-transparent hover:border-primary-200">
                                <span class="text-xl mr-3 group-hover:scale-110 transition-transform">{{ $useCase->icon }}</span>
                                <span class="font-medium text-neutral-700">{{ $useCase->name }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-neutral-800 flex items-center">
                            <i class="fas fa-tags mr-3 text-accent-purple"></i>
                            Tags & Moods
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($noise->tags as $tag)
                            <span class="bg-gradient-to-r from-primary-50 to-secondary-50 text-neutral-700 px-4 py-2 rounded-duo text-sm font-medium shadow-duo border border-primary-100">
                                #{{ $tag }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Sounds -->
        @if($relatedNoises->count())
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-neutral-800">You Might Also Like</h2>
                <div class="text-sm text-neutral-500 bg-primary-50 px-3 py-1 rounded-duo">
                    <i class="fas fa-random mr-1 text-primary-500"></i>
                    Similar sounds
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedNoises as $relatedNoise)
                @include('noises.partials.card', ['noise' => $relatedNoise])
                @endforeach
            </div>
        </div>
        @endif

        <!-- Achievement Section -->
        <div class="mt-12 card rounded-duo-xl p-8 text-center bg-gradient-to-r from-primary-50 to-secondary-50">
            <div class="text-4xl mb-4">🎉</div>
            <h3 class="text-2xl font-bold text-neutral-800 mb-2">Sound Mastered!</h3>
            <p class="text-neutral-600 mb-4">You've completed this sound session. Keep going to unlock achievements!</p>
            <div class="flex justify-center space-x-4">
                <div class="bg-white p-4 rounded-duo shadow-duo text-center">
                    <div class="text-2xl font-bold text-primary-600">5</div>
                    <div class="text-sm text-neutral-600">Sessions</div>
                </div>
                <div class="bg-white p-4 rounded-duo shadow-duo text-center">
                    <div class="text-2xl font-bold text-secondary-600">15min</div>
                    <div class="text-sm text-neutral-600">Total Time</div>
                </div>
                <div class="bg-white p-4 rounded-duo shadow-duo text-center">
                    <div class="text-2xl font-bold text-accent-purple">🔥</div>
                    <div class="text-sm text-neutral-600">3 Day Streak</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom audio player styling */
    #noise-player {
        height: 50px;
        border-radius: 16px !important;
    }

    #noise-player::-webkit-media-controls-panel {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 16px;
    }

    #noise-player::-webkit-media-controls-play-button {
        background-color: #58cc70;
        border-radius: 50%;
    }

    #noise-player::-webkit-media-controls-current-time-display,
    #noise-player::-webkit-media-controls-time-remaining-display {
        color: #495057;
        font-weight: 600;
    }

    /* Favorite button active state */
    .noise-favorite-btn.active {
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e) !important;
        color: white !important;
    }

    .noise-favorite-btn.active i {
        color: white !important;
    }

    /* Save button active state */
    .noise-save-btn.active {
        background: linear-gradient(135deg, #ffc800, #ffd700) !important;
        color: white !important;
    }

    .noise-save-btn.active i {
        color: white !important;
    }

    /* Control buttons hover effects */
    .control-btn:hover {
        transform: scale(1.1) !important;
    }

    /* Progress animation */
    @keyframes progress-pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .progress-pulse {
        animation: progress-pulse 2s ease-in-out infinite;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audioPlayer = document.getElementById('noise-player');
    const playBtn = document.getElementById('play-btn');
    const favoriteBtn = document.querySelector('.noise-favorite-btn');
    const saveBtn = document.querySelector('.noise-save-btn');
    
    // Play/Pause functionality
    playBtn.addEventListener('click', function() {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playBtn.innerHTML = '<i class="fas fa-pause mr-3"></i><span>Pause Sound</span>';
            playBtn.classList.add('progress-pulse');
            
            // Increment play count
            fetch(`/noises/{{ $noise->id }}/play`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    // Update play count display
                    const playCountElement = document.querySelector('[data-play-count]');
                    if (playCountElement) {
                        const currentCount = parseInt(playCountElement.textContent.replace(/,/g, ''));
                        playCountElement.textContent = (currentCount + 1).toLocaleString();
                    }
                }
            });
        } else {
            audioPlayer.pause();
            playBtn.innerHTML = '<i class="fas fa-play mr-3"></i><span>Play Sound</span>';
            playBtn.classList.remove('progress-pulse');
        }
    });

    audioPlayer.addEventListener('ended', function() {
        playBtn.innerHTML = '<i class="fas fa-play mr-3"></i><span>Play Again</span>';
        playBtn.classList.remove('progress-pulse');
        
        // Show celebration
        showCompletionCelebration();
    });

    // Favorite functionality
    favoriteBtn.addEventListener('click', function() {
        this.classList.toggle('active');
        this.innerHTML = this.classList.contains('active') 
            ? '<i class="fas fa-heart mr-2"></i><span>Favorited</span>'
            : '<i class="far fa-heart mr-2"></i><span>Favorite</span>';
        
        // API call to toggle favorite
        toggleFavorite({{ $noise->id }});
    });

    // Save functionality
    saveBtn.addEventListener('click', function() {
        this.classList.toggle('active');
        this.innerHTML = this.classList.contains('active') 
            ? '<i class="fas fa-bookmark mr-2"></i><span>Saved</span>'
            : '<i class="far fa-bookmark mr-2"></i><span>Save</span>';
        
        // API call to toggle save
        toggleSave({{ $noise->id }});
    });

    // Control buttons functionality
    document.querySelectorAll('.control-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Volume control
    const volumeBtn = document.querySelector('.fa-volume-up').closest('.control-btn');
    volumeBtn.addEventListener('click', function() {
        // Toggle mute/unmute
        audioPlayer.muted = !audioPlayer.muted;
        const icon = this.querySelector('i');
        icon.className = audioPlayer.muted ? 'fas fa-volume-mute text-lg' : 'fas fa-volume-up text-lg';
    });

    // Repeat functionality
    const repeatBtn = document.querySelector('.fa-redo').closest('.control-btn');
    repeatBtn.addEventListener('click', function() {
        audioPlayer.currentTime = 0;
        audioPlayer.play();
    });

    function toggleFavorite(noiseId) {
        fetch(`/noises/${noiseId}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
    }

    function toggleSave(noiseId) {
        fetch(`/noises/${noiseId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
    }

    function showCompletionCelebration() {
        const achievementSection = document.querySelector('.bg-gradient-to-r');
        if (achievementSection) {
            achievementSection.scrollIntoView({ behavior: 'smooth' });
            
            // Add celebration effect
            const confetti = document.createElement('div');
            confetti.innerHTML = '🎉';
            confetti.className = 'absolute text-4xl animate-celebrate';
            confetti.style.top = '50%';
            confetti.style.left = '50%';
            confetti.style.transform = 'translate(-50%, -50%)';
            achievementSection.style.position = 'relative';
            achievementSection.appendChild(confetti);
            
            setTimeout(() => {
                confetti.remove();
            }, 2000);
        }
    }

    // Initialize button states based on user data
    @if(auth()->check())
        @if(auth()->user()->hasFavorited($noise))
            favoriteBtn.classList.add('active');
            favoriteBtn.innerHTML = '<i class="fas fa-heart mr-2"></i><span>Favorited</span>';
        @endif
        
        @if(auth()->user()->hasSaved($noise))
            saveBtn.classList.add('active');
            saveBtn.innerHTML = '<i class="fas fa-bookmark mr-2"></i><span>Saved</span>';
        @endif
    @endif
});
</script>
@endsection