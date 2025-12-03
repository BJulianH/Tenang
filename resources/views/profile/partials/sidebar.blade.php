<!-- Profile Card -->
<div class="profile-section p-6 card-shadow bg-white rounded-lg border border-neutral-200">
    <div class="flex flex-col items-center mb-6">
        <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="avatar-upload mb-4">
                <div class="avatar-preview w-24 h-24 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-2xl cursor-pointer">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatarUrl }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                    @else
                        {{ substr(auth()->user()->name, 0, 1) }}
                    @endif
                </div>
                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="document.getElementById('avatar-form').submit()">
            </div>
        </form>
        <h2 class="text-xl font-bold text-neutral-800">{{ auth()->user()->name }}</h2>
        <p class="text-neutral-600 text-sm mt-1">{{ auth()->user()->email }}</p>
        <div class="flex items-center mt-2">
            <i class="fas fa-fire text-secondary-500 mr-1"></i>
            <span class="text-sm text-neutral-700">{{ auth()->user()->streak ?? 0 }} hari beruntun</span>
        </div>
    </div>
    
    <div class="border-t border-neutral-200 pt-4">
        <div class="flex justify-between mb-2">
            <span class="text-neutral-600">Level</span>
            <span class="font-bold text-primary-600">Level {{ auth()->user()->level ?? 1 }}</span>
        </div>
        <div class="progress-bar mb-1">
            <div class="progress-fill bg-primary-500" style="width: {{ min(100, ((auth()->user()->level ?? 1) / 10) * 100) }}%"></div>
        </div>
        <p class="text-xs text-neutral-500 text-right">{{ min(100, ((auth()->user()->level ?? 1) / 10) * 100) }}% menuju Level {{ (auth()->user()->level ?? 1) + 1 }}</p>
    </div>
    
    <div class="border-t border-neutral-200 pt-4 mt-4">
        <div class="flex justify-between mb-2">
            <span class="text-neutral-600">Poin</span>
            <span class="font-bold text-primary-600">{{ auth()->user()->coins ?? 0 }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-neutral-600">Berlian</span>
            <span class="font-bold text-primary-600">{{ auth()->user()->diamonds ?? 0 }}</span>
        </div>
    </div>
</div>

<!-- Wellness Status Card -->
<div class="profile-section p-6 card-shadow bg-white rounded-lg border border-neutral-200 mt-6">
    <h3 class="text-lg font-bold text-neutral-800 mb-4">Status Kesehatan Mental</h3>
    
    <div class="flex items-center mb-4">
        <span class="wellness-indicator wellness-good"></span>
        <span class="text-neutral-700 font-medium">Baik</span>
    </div>
    
    <div class="space-y-3">
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-neutral-600">Tingkat Stres</span>
                <span class="font-medium text-neutral-700">Sedang</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill bg-yellow-500" style="width: 60%"></div>
            </div>
        </div>
        
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-neutral-600">Kualitas Tidur</span>
                <span class="font-medium text-neutral-700">Baik</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill bg-primary-500" style="width: 75%"></div>
            </div>
        </div>
        
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-neutral-600">Kesejahteraan Emosional</span>
                <span class="font-medium text-neutral-700">Tinggi</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill bg-secondary-500" style="width: 80%"></div>
            </div>
        </div>
    </div>
    
    <button class="w-full mt-4 py-2 bg-primary-50 text-primary-600 rounded-lg font-medium hover:bg-primary-100 transition-colors">
        Lihat Laporan Lengkap
    </button>
</div>