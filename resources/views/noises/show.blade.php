{{-- resources/views/noises/show.blade.php --}}
@extends('layouts.app')

@section('title', $noise->title . ' - Mental Health Sounds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('noises.index') }}" class="hover:text-blue-500">Sounds</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><a href="{{ route('noises.by-type', $noise->type->slug) }}" class="hover:text-blue-500">{{ $noise->type->name }}</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li class="text-gray-800">{{ $noise->title }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="p-8" style="background: linear-gradient(135deg, {{ $noise->type->color_code }}20, transparent)">
                <div class="flex flex-col md:flex-row md:items-start md:space-x-6">
                    <!-- Color Indicator -->
                    <div class="w-20 h-20 rounded-lg mb-4 md:mb-0 flex-shrink-0" 
                         style="background-color: {{ $noise->type->color_code }}"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $noise->title }}</h1>
                                <p class="text-gray-600 mb-4">{{ $noise->description }}</p>
                            </div>
                            <div class="flex space-x-3 mb-4 md:mb-0">
                                <button class="noise-favorite-btn bg-white border border-gray-300 rounded-lg px-4 py-2 hover:border-red-300 transition-colors" 
                                        data-noise-id="{{ $noise->id }}">
                                    <i class="far fa-heart mr-2"></i>
                                    <span>Favorite</span>
                                </button>
                                <button class="noise-save-btn bg-white border border-gray-300 rounded-lg px-4 py-2 hover:border-yellow-300 transition-colors" 
                                        data-noise-id="{{ $noise->id }}">
                                    <i class="far fa-bookmark mr-2"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-play text-blue-500 mr-2"></i>
                                <span>{{ number_format($noise->play_count) }} plays</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-eye text-gray-500 mr-2"></i>
                                <span>{{ number_format($noise->view_count) }} views</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-500 mr-2"></i>
                                <span>{{ gmdate('i:s', $noise->duration) }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-volume-up text-gray-500 mr-2"></i>
                                <span>{{ $noise->type->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio Player -->
            <div class="border-t border-gray-200 p-8">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <audio id="noise-player" class="w-full" controls>
                            <source src="{{ asset('storage/' . $noise->audio_file) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <button id="play-btn" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                                <i class="fas fa-play mr-2"></i>
                                <span>Play Sound</span>
                            </button>
                            
                            <div class="flex space-x-3">
                                <button class="p-3 text-gray-600 hover:text-blue-500 transition-colors">
                                    <i class="fas fa-redo"></i>
                                </button>
                                <button class="p-3 text-gray-600 hover:text-blue-500 transition-colors">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Use Cases & Tags -->
            <div class="border-t border-gray-200 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Use Cases -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Best For</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($noise->useCases as $useCase)
                            <span class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg flex items-center">
                                <span class="mr-2">{{ $useCase->icon }}</span>
                                {{ $useCase->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($noise->tags as $tag)
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
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
            <h2 class="text-2xl font-semibold mb-6">Related Sounds</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedNoises as $relatedNoise)
                @include('noises.partials.card', ['noise' => $relatedNoise])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audioPlayer = document.getElementById('noise-player');
    const playBtn = document.getElementById('play-btn');
    
    playBtn.addEventListener('click', function() {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playBtn.innerHTML = '<i class="fas fa-pause mr-2"></i><span>Pause</span>';
            
            // Increment play count
            fetch(`/noises/{{ $noise->id }}/play`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        } else {
            audioPlayer.pause();
            playBtn.innerHTML = '<i class="fas fa-play mr-2"></i><span>Play</span>';
        }
    });

    audioPlayer.addEventListener('ended', function() {
        playBtn.innerHTML = '<i class="fas fa-play mr-2"></i><span>Play</span>';
    });
});
</script>
@endsection