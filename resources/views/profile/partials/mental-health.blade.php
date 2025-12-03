<!-- Mood Tracking Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Mood Tracking Form -->
    <div class="mental-health-card p-5">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-4">
                <i class="fas fa-smile text-xl"></i>
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
                                            @if($mood === 'senang') fa-smile @endif
                                            @if($mood === 'sedih') fa-frown @endif
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
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            @if(auth()->user()->latestMood->mood === 'senang') bg-green-100 text-green-800 @endif
                            @if(auth()->user()->latestMood->mood === 'sedih') bg-blue-100 text-blue-800 @endif
                            @if(auth()->user()->latestMood->mood === 'cemas') bg-yellow-100 text-yellow-800 @endif
                            @if(auth()->user()->latestMood->mood === 'stress') bg-red-100 text-red-800 @endif
                            @if(auth()->user()->latestMood->mood === 'tenang') bg-teal-100 text-teal-800 @endif
                            @if(auth()->user()->latestMood->mood === 'marah') bg-orange-100 text-orange-800 @endif
                            @if(auth()->user()->latestMood->mood === 'lelah') bg-gray-100 text-gray-800 @endif">
                            <i class="
                                @if(auth()->user()->latestMood->mood === 'senang') fa-smile @endif
                                @if(auth()->user()->latestMood->mood === 'sedih') fa-frown @endif
                                @if(auth()->user()->latestMood->mood === 'cemas') fa-flushed @endif
                                @if(auth()->user()->latestMood->mood === 'stress') fa-dizzy @endif
                                @if(auth()->user()->latestMood->mood === 'tenang') fa-smile @endif
                                @if(auth()->user()->latestMood->mood === 'marah') fa-angry @endif
                                @if(auth()->user()->latestMood->mood === 'lelah') fa-tired @endif
                            mr-2"></i>
                            {{ ucfirst(auth()->user()->latestMood->mood) }}
                        </span>
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
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-neutral-600 capitalize">{{ $mood }}</span>
                            <span class="font-medium text-neutral-700">{{ $moodStats[$mood]->count }}x ({{ number_format($percentage, 1) }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill 
                                @if($mood === 'senang') bg-green-500 @endif
                                @if($mood === 'sedih') bg-blue-500 @endif
                                @if($mood === 'cemas') bg-yellow-500 @endif
                                @if($mood === 'stress') bg-red-500 @endif
                                @if($mood === 'tenang') bg-teal-500 @endif
                                @if($mood === 'marah') bg-orange-500 @endif
                                @if($mood === 'lelah') bg-gray-500 @endif
                            " style="width: {{ $percentage }}%"></div>
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
        <h4 class="font-bold text-neutral-800">Riwayat Mood 7 Hari Terakhir</h4>
        <span class="text-sm text-neutral-600">{{ auth()->user()->moodTrackings()->where('created_at', '>=', now()->subDays(7))->count() }} catatan</span>
    </div>
    
    @if(auth()->user()->moodTrackings()->where('created_at', '>=', now()->subDays(7))->count() > 0)
        <!-- Recent Mood Entries -->
        <div class="mt-4">
            <h5 class="font-medium text-neutral-700 mb-3">Catatan Mood Terbaru</h5>
            <div class="space-y-3 max-h-60 overflow-y-auto pr-2" id="mood-entries">
                @foreach(auth()->user()->moodTrackings()->latest()->take(10)->get() as $tracking)
                    <div class="flex items-center justify-between p-3 bg-white border border-neutral-200 rounded-lg mood-entry" data-id="{{ $tracking->id }}">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3
                                @if($tracking->mood === 'senang') bg-green-100 text-green-600 @endif
                                @if($tracking->mood === 'sedih') bg-blue-100 text-blue-600 @endif
                                @if($tracking->mood === 'cemas') bg-yellow-100 text-yellow-600 @endif
                                @if($tracking->mood === 'stress') bg-red-100 text-red-600 @endif
                                @if($tracking->mood === 'tenang') bg-teal-100 text-teal-600 @endif
                                @if($tracking->mood === 'marah') bg-orange-100 text-orange-600 @endif
                                @if($tracking->mood === 'lelah') bg-gray-100 text-gray-600 @endif">
                                <i class="
                                    @if($tracking->mood === 'senang') fa-smile @endif
                                    @if($tracking->mood === 'sedih') fa-frown @endif
                                    @if($tracking->mood === 'cemas') fa-flushed @endif
                                    @if($tracking->mood === 'stress') fa-dizzy @endif
                                    @if($tracking->mood === 'tenang') fa-smile @endif
                                    @if($tracking->mood === 'marah') fa-angry @endif
                                    @if($tracking->mood === 'lelah') fa-tired @endif
                                "></i>
                            </div>
                            <div>
                                <p class="font-medium text-neutral-800 capitalize">{{ $tracking->mood }}</p>
                                @if($tracking->description)
                                    <p class="text-sm text-neutral-600 truncate max-w-xs">{{ $tracking->description }}</p>
                                @endif
                                <p class="text-xs text-neutral-500">{{ $tracking->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <button type="button" class="text-red-500 hover:text-red-700 transition-colors delete-mood-btn" 
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
            <i class="fas fa-smile text-4xl text-neutral-400 mb-3"></i>
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