@extends('layouts.app')

@section('title', 'Profil - MindWell')

@section('styles')
<style>
    .profile-section {
        background: linear-gradient(135deg, #f8fdf8 0%, #ffffff 100%);
        border-radius: 16px;
        border: 1px solid #e8f0e5;
    }
    
    .tab-button {
        transition: all 0.3s ease;
        border-bottom: 2px solid transparent;
        cursor: pointer;
    }
    
    .tab-button.active {
        color: #4caf50;
        border-bottom-color: #4caf50;
        background-color: #f0f9f0;
    }
    
    .tab-button:hover:not(.active) {
        color: #3d8b40;
        border-bottom-color: #bce5bc;
        background-color: #f8fdf8;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .input-field {
        transition: all 0.3s ease;
    }
    
    .input-field:focus {
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        border-color: #4caf50;
    }
    
    .avatar-upload {
        position: relative;
        display: inline-block;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4caf50 0%, #2e6b34 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid #dcf2dc;
        overflow: hidden;
    }
    
    .avatar-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(46, 107, 52, 0.2);
    }
    
    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-upload input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .mental-health-card {
        background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
        border: 1px solid #ccfbef;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .mental-health-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(20, 184, 166, 0.1);
    }
    
    .progress-bar {
        height: 8px;
        background-color: #e8f0e5;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    .wellness-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    
    .wellness-excellent { background-color: #4caf50; }
    .wellness-good { background-color: #8fd18f; }
    .wellness-fair { background-color: #ffb74d; }
    .wellness-poor { background-color: #ff9800; }
    .wellness-critical { background-color: #f44336; }

    /* Error states */
    .border-red-500 {
        border-color: #f44336;
    }
    
    .text-red-500 {
        color: #f44336;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Notifikasi -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">Profil Saya</h1>
        <p class="text-neutral-600 mt-2">Kelola informasi profil dan pantau kondisi kesehatan mental Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Profil -->
        <div class="lg:col-span-1">
            <div class="profile-section p-6 card-shadow">
                <div class="flex flex-col items-center mb-6">
                    <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="avatar-upload mb-4">
                            <div class="avatar-preview">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatarUrl }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                                @else
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                @endif
                            </div>
                            <input type="file" id="avatar" name="avatar" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
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
            <div class="profile-section p-6 card-shadow mt-6">
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
        </div>
        
        <!-- Main Content Area -->
        <div class="lg:col-span-2">
            <div class="profile-section p-6 card-shadow">
                <!-- Tab Navigation -->
                <div class="flex border-b border-neutral-200 mb-6 overflow-x-auto">
                    <button class="tab-button py-3 px-4 font-medium text-neutral-700 active flex-shrink-0" data-tab="edit-profile">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profil
                    </button>
                    <button class="tab-button py-3 px-4 font-medium text-neutral-700 flex-shrink-0" data-tab="change-password">
                        <i class="fas fa-lock mr-2"></i>Ubah Kata Sandi
                    </button>
                    <button class="tab-button py-3 px-4 font-medium text-neutral-700 flex-shrink-0" data-tab="mental-health">
                        <i class="fas fa-brain mr-2"></i>Kesehatan Mental
                    </button>
                </div>
                
                <!-- Edit Profile Tab -->
                <div id="edit-profile" class="tab-content active">
                    <h3 class="text-xl font-bold text-neutral-800 mb-6">Informasi Profil</h3>
                    
                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-neutral-700 mb-2">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="birthdate" class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Lahir</label>
                                <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', auth()->user()->birthdate ? auth()->user()->birthdate->format('Y-m-d') : '') }}" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('birthdate') border-red-500 @enderror">
                                @error('birthdate')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="bio" class="block text-sm font-medium text-neutral-700 mb-2">Bio</label>
                                <textarea id="bio" name="bio" rows="3" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('bio') border-red-500 @enderror" 
                                    placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', auth()->user()->bio) }}</textarea>
                                @error('bio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="button" class="px-6 py-3 border border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition-colors mr-4" onclick="resetForm('profile-form')">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-3 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Change Password Tab -->
                <div id="change-password" class="tab-content">
                    <h3 class="text-xl font-bold text-neutral-800 mb-6">Ubah Kata Sandi</h3>
                    
                    <form id="password-form" action="{{ route('profile.password.update') }}" method="POST" class="max-w-md">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-neutral-700 mb-2">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-10 @error('current_password') border-red-500 @enderror">
                                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password" class="block text-sm font-medium text-neutral-700 mb-2">Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-10 @error('new_password') border-red-500 @enderror">
                                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-neutral-500">
                                <p>Kata sandi harus mengandung setidaknya:</p>
                                <ul class="list-disc ml-4 mt-1">
                                    <li>8 karakter</li>
                                    <li>1 huruf besar</li>
                                    <li>1 angka</li>
                                    <li>1 karakter khusus</li>
                                </ul>
                            </div>
                            @error('new_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-neutral-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-10">
                                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password" data-target="new_password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="button" class="px-6 py-3 border border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition-colors mr-4" onclick="resetForm('password-form')">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-3 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                                Ubah Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Mental Health Tab -->
                <div id="mental-health" class="tab-content">
                    <h3 class="text-xl font-bold text-neutral-800 mb-6">Informasi Kesehatan Mental</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="mental-health-card p-5">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-4">
                                    <i class="fas fa-heartbeat text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-neutral-800">Kesehatan Emosional</h4>
                                    <p class="text-sm text-neutral-600">Berdasarkan 30 hari terakhir</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="wellness-indicator wellness-good"></span>
                                    <span class="text-neutral-700 font-medium">Baik</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary-600">7.5</p>
                                    <p class="text-xs text-neutral-500">dari 10</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mental-health-card p-5">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600 mr-4">
                                    <i class="fas fa-bed text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-neutral-800">Kualitas Tidur</h4>
                                    <p class="text-sm text-neutral-600">Rata-rata mingguan</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="wellness-indicator wellness-good"></span>
                                    <span class="text-neutral-700 font-medium">Baik</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-secondary-600">6.8</p>
                                    <p class="text-xs text-neutral-500">jam per malam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h4 class="font-bold text-neutral-800 mb-4">Riwayat Mood 30 Hari Terakhir</h4>
                        <div class="bg-white rounded-lg border border-neutral-200 p-4">
                            <div class="h-40 flex items-end justify-between">
                                <div class="text-center">
                                    <div class="h-32 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Sen</span>
                                </div>
                                <div class="text-center">
                                    <div class="h-24 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Sel</span>
                                </div>
                                <div class="text-center">
                                    <div class="h-28 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Rab</span>
                                </div>
                                <div class="text-center">
                                    <div class="h-20 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Kam</span>
                                </div>
                                <div class="text-center">
                                    <div class="h-30 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Jum</span>
                                </div>
                                <div class="text-center">
                                    <div class="h-26 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Sab</span>
                                </div>
                                <div class="text-center">
                                    <div class="h-22 w-6 bg-primary-300 rounded-t mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500">Min</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - initializing tabs');
        
        // Initialize tabs
        initializeTabs();
        
        // Initialize password toggles
        initializePasswordToggles();
        
        // Check if there's an active tab from session
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'edit-profile';
        switchTab(activeTab);
    });

    function initializeTabs() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        console.log('Found tab buttons:', tabButtons.length);
        console.log('Found tab contents:', tabContents.length);
        
        // Function to switch tabs
        function switchTab(tabId) {
            console.log('Switching to tab:', tabId);
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            
            // Add active class to current button and content
            const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
            const activeContent = document.getElementById(tabId);
            
            if (activeButton && activeContent) {
                activeButton.classList.add('active');
                activeContent.classList.add('active');
                console.log('Tab switched successfully');
            } else {
                console.error('Tab element not found:', tabId);
            }
        }
        
        // Add click event listeners to tab buttons
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                console.log('Tab clicked:', tabId);
                switchTab(tabId);
                
                // Update URL without reloading page
                const url = new URL(window.location);
                url.searchParams.set('tab', tabId);
                window.history.pushState({}, '', url);
            });
        });
        
        // Make switchTab function globally available
        window.switchTab = switchTab;
    }

    function initializePasswordToggles() {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    }

    // Reset form functions
    function resetForm(formId) {
        document.getElementById(formId).reset();
    }

    // Auto-submit avatar form when file is selected
    document.getElementById('avatar')?.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            document.getElementById('avatar-form').submit();
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'edit-profile';
        switchTab(activeTab);
    });
</script>
@endsection