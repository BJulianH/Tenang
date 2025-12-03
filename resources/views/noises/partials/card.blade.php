{{-- resources/views/noises/partials/card.blade.php --}}
<div class="card rounded-duo-xl overflow-hidden group hover:shadow-duo-lg transition-all duration-200">
    <div class="relative overflow-hidden">
        <!-- Sound Image/Visualization -->
        <div class="h-40 bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
            <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-duo">
                <i class="fas fa-play text-primary-500 text-2xl"></i>
            </div>
        </div>
        
        <!-- Play Button Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
            <button class="app-button rounded-full w-12 h-12 flex items-center justify-center">
                <i class="fas fa-play text-white"></i>
            </button>
        </div>
    </div>
    
    <div class="p-4">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-bold text-neutral-800 text-lg">{{ $noise->name }}</h3>
            <button class="text-neutral-400 hover:text-accent-red transition-colors">
                <i class="far fa-heart"></i>
            </button>
        </div>
        
        <p class="text-neutral-600 text-sm mb-3">{{ $noise->description }}</p>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="flex items-center text-neutral-500 text-sm">
                    <i class="fas fa-clock mr-1"></i>
                    <span>{{ $noise->duration }} min</span>
                </div>
                <div class="flex items-center text-neutral-500 text-sm">
                    <i class="fas fa-headphones mr-1"></i>
                    <span>{{ $noise->plays_count }}</span>
                </div>
            </div>
            
            <div class="flex items-center">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-sm {{ $i <= $noise->rating ? 'text-secondary-500' : 'text-neutral-300' }}"></i>
                @endfor
            </div>
        </div>
        
        <!-- Progress Bar (for currently playing) -->
        <div class="mt-3 hidden">
            <div class="duo-progress bg-neutral-200 rounded-full h-2">
                <div class="duo-progress-fill bg-primary-500 rounded-full h-2" style="width: 30%"></div>
            </div>
        </div>
    </div>
</div>