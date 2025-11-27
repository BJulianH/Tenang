{{-- resources/views/noises/partials/card.blade.php --}}
<div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden group">
    <!-- Image/Color Placeholder -->
    <div class="h-32 relative" style="background-color: {{ $noise->type->color_code ?? '#e5e7eb' }}">
        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-opacity"></div>
        <div class="absolute bottom-3 left-3">
            <span class="bg-white bg-opacity-90 px-2 py-1 rounded-full text-xs font-medium text-gray-700">
                {{ $noise->type->name }}
            </span>
        </div>
        <button class="absolute top-3 right-3 noise-play-btn" data-noise-id="{{ $noise->id }}">
            <div class="bg-white rounded-full p-2 shadow-md hover:shadow-lg transition-shadow">
                <i class="fas fa-play text-blue-500"></i>
            </div>
        </button>
    </div>

    <!-- Content -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $noise->title }}</h3>
        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $noise->description }}</p>
        
        <!-- Tags -->
        @if($noise->tags)
        <div class="flex flex-wrap gap-1 mb-3">
            @foreach(array_slice($noise->tags, 0, 2) as $tag)
            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{{ $tag }}</span>
            @endforeach
            @if(count($noise->tags) > 2)
            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">+{{ count($noise->tags) - 2 }}</span>
            @endif
        </div>
        @endif

        <!-- Use Cases -->
        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
            <div class="flex space-x-1">
                @foreach($noise->useCases->take(2) as $useCase)
                <span>{{ $useCase->icon }}</span>
                @endforeach
            </div>
            <div class="flex items-center space-x-4">
                <span><i class="fas fa-play mr-1"></i>{{ $noise->play_count }}</span>
                <span><i class="fas fa-clock mr-1"></i>{{ gmdate('i:s', $noise->duration) }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="{{ route('noises.show', $noise) }}" 
               class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                Details
            </a>
            <div class="flex space-x-2">
                <button class="noise-favorite-btn text-gray-400 hover:text-red-500 transition-colors" 
                        data-noise-id="{{ $noise->id }}">
                    <i class="far fa-heart"></i>
                </button>
                <button class="noise-save-btn text-gray-400 hover:text-yellow-500 transition-colors" 
                        data-noise-id="{{ $noise->id }}">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
        </div>
    </div>
</div>