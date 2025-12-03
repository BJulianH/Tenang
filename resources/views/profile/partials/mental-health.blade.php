<!-- Mood Tracking Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Mood Tracking Form -->
    <div class="mental-health-card p-5">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-4">
                <i class="fas fa-smile-beam text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-neutral-800">Lacak Mood Anda</h4>
                <p class="text-sm text-neutral-600">Bagaimana perasaan Anda hari ini?</p>
            </div>
        </div>
        
        <form id="mood-form" action="{{ route('mood.tracking.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-neutral-700 mb-3">Pilih Mood</label>
                <div class="grid grid-cols-2 gap-3" id="mood-options">
                    @foreach(['senang', 'sedih', 'cemas', 'stress', 'tenang', 'marah', 'lelah'] as $mood)
                        <div class="mood-option" data-mood="{{ $mood }}">
                            <input type="radio" name="mood" value="{{ $mood }}" class="sr-only" id="mood-{{ $mood }}">
                            <label for="mood-{{ $mood }}" class="flex items-center p-3 border-2 border-neutral-200 rounded-lg cursor-pointer hover:bg-neutral-50 transition-all duration-200 h-full">
                                <div class="flex items-center w-full">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 transition-all duration-200
                                        @if($mood === 'senang') bg-green-100 text-green-600 @endif
                                        @if($mood === 'sedih') bg-blue-100 text-blue-600 @endif
                                        @if($mood === 'cemas') bg-yellow-100 text-yellow-600 @endif
                                        @if($mood === 'stress') bg-red-100 text-red-600 @endif
                                        @if($mood === 'tenang') bg-teal-100 text-teal-600 @endif
                                        @if($mood === 'marah') bg-orange-100 text-orange-600 @endif
                                        @if($mood === 'lelah') bg-gray-100 text-gray-600 @endif">
                                        <i class="fas 
                                            @if($mood === 'senang') fa-smile-beam @endif
                                            @if($mood === 'sedih') fa-sad-tear @endif
                                            @if($mood === 'cemas') fa-flushed @endif
                                            @if($mood === 'stress') fa-dizzy @endif
                                            @if($mood === 'tenang') fa-smile @endif
                                            @if($mood === 'marah') fa-angry @endif
                                            @if($mood === 'lelah') fa-tired @endif
                                        "></i>
                                    </div>
                                    <span class="text-sm font-medium text-neutral-700">{{ ucfirst($mood) }}</span>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('mood')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="mood_description" class="block text-sm font-medium text-neutral-700 mb-2">Deskripsi Mood (Opsional)</label>
                <textarea name="description" id="mood_description" rows="3" 
                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                    placeholder="Ceritakan lebih detail tentang perasaan Anda hari ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full px-4 py-3 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                <i class="fas fa-save mr-2"></i>Simpan Mood
            </button>
        </form>
    </div>
    
    <!-- Latest Mood & Stats -->
    <div class="mental-health-card p-5">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600 mr-4">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-neutral-800">Statistik Mood</h4>
                <p class="text-sm text-neutral-600">Ringkasan 7 hari terakhir</p>
            </div>
        </div>
        
        <!-- Latest Mood -->
        @if(auth()->user()->latestMood)
            <div class="mb-6 p-4 bg-neutral-50 rounded-lg border border-neutral-200">
                <h5 class="font-medium text-neutral-700 mb-2">Mood Terakhir</h5>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full {{ auth()->user()->latestMood->mood_bg_color }} flex items-center justify-center {{ auth()->user()->latestMood->mood_text_color }} mr-3">
                            <i class="{{ auth()->user()->latestMood->mood_icon }}"></i>
                        </div>
                        <div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ auth()->user()->latestMood->mood_color }}">
                                <i class="{{ auth()->user()->latestMood->mood_icon }} mr-2"></i>
                                {{ ucfirst(auth()->user()->latestMood->mood) }}
                            </span>
                        </div>
                    </div>
                    <span class="text-sm text-neutral-500">{{ auth()->user()->latestMood->created_at->format('d M Y') }}</span>
                </div>
                @if(auth()->user()->latestMood->description)
                    <p class="text-sm text-neutral-600 mt-2">"{{ auth()->user()->latestMood->description }}"</p>
                @endif
            </div>
        @endif
        
        <!-- Mood Statistics -->
        <div class="space-y-3">
            @php
                $moodStats = auth()->user()->moodTrackings()
                    ->where('created_at', '>=', now()->subDays(7))
                    ->selectRaw('mood, COUNT(*) as count')
                    ->groupBy('mood')
                    ->get()
                    ->keyBy('mood');
                
                $totalMoods = $moodStats->sum('count');
            @endphp
            
            @foreach(['senang', 'tenang', 'lelah', 'cemas', 'sedih', 'marah', 'stress'] as $mood)
                @if(isset($moodStats[$mood]))
                    @php
                        $percentage = $totalMoods > 0 ? ($moodStats[$mood]->count / $totalMoods) * 100 : 0;
                        $colors = [
                            'senang' => ['bg' => 'bg-green-500', 'text' => 'text-green-600', 'icon' => 'fa-smile-beam'],
                            'sedih' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'icon' => 'fa-sad-tear'],
                            'cemas' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-600', 'icon' => 'fa-flushed'],
                            'stress' => ['bg' => 'bg-red-500', 'text' => 'text-red-600', 'icon' => 'fa-dizzy'],
                            'tenang' => ['bg' => 'bg-teal-500', 'text' => 'text-teal-600', 'icon' => 'fa-smile'],
                            'marah' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-600', 'icon' => 'fa-angry'],
                            'lelah' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-600', 'icon' => 'fa-tired'],
                        ];
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <div class="flex items-center">
                                <i class="fas {{ $colors[$mood]['icon'] }} mr-2 {{ $colors[$mood]['text'] }}"></i>
                                <span class="text-neutral-600 capitalize">{{ $mood }}</span>
                            </div>
                            <span class="font-medium text-neutral-700">{{ $moodStats[$mood]->count }}x ({{ number_format($percentage, 1) }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill {{ $colors[$mood]['bg'] }}" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endif
            @endforeach
                
            @if($totalMoods === 0)
                <p class="text-neutral-500 text-sm text-center py-4">Belum ada data mood tracking.</p>
            @endif
        </div>
    </div>
</div>

<!-- Recent Mood Entries -->
<div class="bg-white rounded-lg border border-neutral-200 p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h4 class="font-bold text-neutral-800">Riwayat Mood 7 Hari Terakhir</h4>
            <p class="text-sm text-neutral-600">{{ auth()->user()->moodTrackings()->where('created_at', '>=', now()->subDays(7))->count() }} catatan</p>
        </div>
        <div class="flex items-center space-x-3">
            <div id="selected-count" class="hidden">
                <span class="text-sm text-neutral-600"><span id="count">0</span> dipilih</span>
            </div>
            <button type="button" id="delete-selected-moods" class="px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors hidden">
                <i class="fas fa-trash mr-2"></i>Hapus Dipilih
            </button>
            <button type="button" id="select-all-moods" class="px-4 py-2 border border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition-colors">
                <i class="fas fa-check-square mr-2"></i>Pilih Semua
            </button>
        </div>
    </div>
    
    @if(auth()->user()->moodTrackings()->where('created_at', '>=', now()->subDays(7))->count() > 0)
        <!-- Recent Mood Entries -->
        <div class="mt-4">
            <div class="space-y-3 max-h-96 overflow-y-auto pr-2" id="mood-entries">
                @foreach(auth()->user()->moodTrackings()->latest()->take(20)->get() as $tracking)
                    <div class="flex items-center justify-between p-4 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors mood-entry" data-id="{{ $tracking->id }}">
                        <div class="flex items-center flex-1">
                            <input type="checkbox" name="selected_moods[]" value="{{ $tracking->id }}" class="w-5 h-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500 mood-checkbox mr-4">
                            <div class="flex items-center flex-1">
                                <div class="w-12 h-12 rounded-full {{ $tracking->mood_bg_color }} flex items-center justify-center {{ $tracking->mood_text_color }} mr-4">
                                    <i class="{{ $tracking->mood_icon }} text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-bold text-neutral-800 capitalize text-lg">{{ $tracking->mood }}</p>
                                            @if($tracking->description)
                                                <p class="text-sm text-neutral-600 mt-1 line-clamp-2">{{ $tracking->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-neutral-500">{{ $tracking->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-neutral-400">{{ $tracking->created_at->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $tracking->mood_color }}">
                                            <i class="{{ $tracking->mood_icon }} mr-1"></i>
                                            {{ ucfirst($tracking->mood) }}
                                        </span>
                                        <span class="mx-2 text-neutral-300">•</span>
                                        <span class="text-xs text-neutral-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $tracking->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="ml-4 text-red-500 hover:text-red-700 transition-colors delete-single-mood-btn" 
                                data-id="{{ $tracking->id }}" 
                                data-url="{{ route('mood.tracking.destroy', $tracking) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg border border-neutral-200 p-8 text-center">
            <i class="fas fa-smile-beam text-4xl text-neutral-400 mb-3"></i>
            <p class="text-neutral-500">Belum ada riwayat mood tracking.</p>
            <p class="text-sm text-neutral-400 mt-1">Gunakan form di atas untuk mulai mencatat mood Anda.</p>
        </div>
    @endif
</div>

<!-- Aktivitas Kesehatan Mental -->
<div class="bg-white rounded-lg border border-neutral-200 p-6">
    <h4 class="font-bold text-neutral-800 mb-4">Aktivitas Kesehatan Mental</h4>
    <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-primary-50 rounded-lg">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-3">
                    <i class="fas fa-meditation"></i>
                </div>
                <div>
                    <h5 class="font-medium text-neutral-800">Meditasi</h5>
                    <p class="text-sm text-neutral-600">10 menit hari ini</p>
                </div>
            </div>
            <span class="text-primary-600 font-medium">Selesai</span>
        </div>
        
        <div class="flex items-center justify-between p-4 bg-white border border-neutral-200 rounded-lg">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-600 mr-3">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <h5 class="font-medium text-neutral-800">Tantangan Harian</h5>
                    <p class="text-sm text-neutral-600">Tulis 3 hal yang disyukuri</p>
                </div>
            </div>
            <button class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
                Mulai
            </button>
        </div>
        
        <div class="flex items-center justify-between p-4 bg-white border border-neutral-200 rounded-lg">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-600 mr-3">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h5 class="font-medium text-neutral-800">Jurnal Mood</h5>
                    <p class="text-sm text-neutral-600">Catat perasaan Anda hari ini</p>
                </div>
            </div>
            <button class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
                Tulis
            </button>
        </div>
    </div>
</div>
@include('profile.partials.modals.delete-mood')