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

    .mood-option {
    transition: all 0.3s ease;
    }

    .mood-option input:checked + div {
    border-color: #4caf50;
    background-color: #f0f9f0;
    }

    .mood-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Mood Option Styles */
    .mood-option input:checked + label {
        border-color: #4caf50;
        background-color: #f0f9f0;
        transform: scale(1.02);
        box-shadow: 0 4px 6px -1px rgba(76, 175, 80, 0.1), 0 2px 4px -1px rgba(76, 175, 80, 0.06);
    }

    .mood-option input:checked + label .mood-icon-container {
        transform: scale(1.1);
    }

    .mood-option label {
        transition: all 0.3s ease;
    }

    .mood-option:hover label {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Line Chart Container */
    .line-chart-container {
        position: relative;
        width: 100%;
    }

    /* Scrollbar untuk mood entries */
    #mood-entries::-webkit-scrollbar {
        width: 6px;
    }

    #mood-entries::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #mood-entries::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    #mood-entries::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Modal Styles */
    #deleteMoodModal {
        transition: opacity 0.3s ease;
    }
    
    #deleteMoodModal .modal-content {
        transform: scale(0.7);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    #deleteMoodModal.show {
        display: flex !important;
    }
    
    #deleteMoodModal.show .modal-content {
        transform: scale(1);
        opacity: 1;
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
                                    <img src="{{ asset(auth()->user()->avatarUrl) }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
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
                                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ auth()->user()->latestMood->mood_color }}">
                                                <i class="{{ auth()->user()->latestMood->mood_icon }} mr-2"></i>
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
                    
                    <!-- Riwayat Mood 7 Hari Terakhir - Grafik Garis -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-bold text-neutral-800">Riwayat Mood 7 Hari Terakhir</h4>
                            <span class="text-sm text-neutral-600">{{ auth()->user()->moodTrackings()->where('created_at', '>=', now()->subDays(7))->count() }} catatan</span>
                        </div>
                        
                        @if(auth()->user()->moodTrackings()->where('created_at', '>=', now()->subDays(7))->count() > 0)
                            <div class="bg-white rounded-lg border border-neutral-200 p-4 overflow-hidden">
                                <div class="line-chart-container" style="height: 200px; position: relative;">
                                    <canvas id="moodLineChart" height="200"></canvas>
                                </div>
                            </div>
                            
                            <!-- Recent Mood Entries -->
                            <div class="mt-6">
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
                                                    <i class="{{ $tracking->mood_icon }}"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-neutral-800 capitalize">{{ $tracking->mood }}</p>
                                                    @if($tracking->description)
                                                        <p class="text-sm text-neutral-600 truncate max-w-xs">{{ $tracking->description }}</p>
                                                    @endif
                                                    <p class="text-xs text-neutral-500">{{ $tracking->created_at->format('d M Y H:i') }}</p>
                                                </div>
                                            </div>
                                            <button type="button" class="text-red-500 hover:text-red-700 transition-colors delete-mood-btn" data-id="{{ $tracking->id }}">
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
                    
                    <!-- Modal Konfirmasi Hapus -->
                    <div id="deleteMoodModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg p-6 max-w-sm mx-4 modal-content">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-neutral-800 mb-2">Hapus Catatan Mood</h3>
                                <p class="text-neutral-600 mb-6">Apakah Anda yakin ingin menghapus catatan mood ini? Tindakan ini tidak dapat dibatalkan.</p>
                                
                                <div class="flex space-x-3">
                                    <button type="button" id="cancelDelete" class="flex-1 px-4 py-2 border border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition-colors">
                                        Batal
                                    </button>
                                    <form id="deleteMoodForm" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tetap pertahankan bagian Aktivitas Kesehatan Mental yang sudah ada -->
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

        // Mood Tracking Functionality
    // Mood Tracking Functionality
function initializeMoodTracking() {
    // Mood selection with visual feedback
    const moodOptions = document.querySelectorAll('.mood-option');
    
    moodOptions.forEach(option => {
        const input = option.querySelector('input[type="radio"]');
        const label = option.querySelector('label');
        
        // Add visual feedback on click
        label.addEventListener('click', (e) => {
            // Remove active class from all options
            moodOptions.forEach(opt => {
                const optLabel = opt.querySelector('label');
                optLabel.classList.remove('border-primary-500', 'bg-primary-50', 'ring-2', 'ring-primary-200');
            });
            
            // Add active class to clicked option
            label.classList.add('border-primary-500', 'bg-primary-50', 'ring-2', 'ring-primary-200');
        });
        
        // Check if this option is pre-selected (from old data)
        if (input.checked) {
            label.classList.add('border-primary-500', 'bg-primary-50', 'ring-2', 'ring-primary-200');
        }
    });
    
    // Enter key submission for mood form
    const moodForm = document.getElementById('mood-form');
    const moodDescription = document.getElementById('mood_description');
    
    if (moodForm && moodDescription) {
        moodDescription.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                // Ctrl+Enter or Cmd+Enter to submit
                e.preventDefault();
                moodForm.submit();
            }
        });
        
        // Also allow Enter key when a mood is selected and textarea is focused
        moodForm.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                const selectedMood = moodForm.querySelector('input[name="mood"]:checked');
                if (selectedMood && document.activeElement === moodDescription) {
                    e.preventDefault();
                    moodForm.submit();
                }
            }
        });
    }
    
    // Initialize line chart with real data
    initializeMoodLineChart();
    
    // Initialize delete confirmation modal
    initializeDeleteModal();
}

// Mood Line Chart dengan Data Real
function initializeMoodLineChart() {
    const canvas = document.getElementById('moodLineChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Get real mood data from the page
    const moodData = getRealMoodChartData();
    
    if (moodData.values.filter(v => v !== null).length === 0) {
        canvas.parentElement.innerHTML = '<p class="text-center text-neutral-500 py-8">Belum ada data mood untuk ditampilkan dalam grafik.</p>';
        return;
    }
    
    // Mood value mapping for chart
    const moodValues = {
        'senang': 6,
        'tenang': 5,
        'lelah': 4,
        'cemas': 3,
        'sedih': 2,
        'marah': 1,
        'stress': 0
    };
    
    // Mood colors
    const moodColors = {
        'senang': '#4caf50',
        'tenang': '#14b8a6', 
        'lelah': '#6b7280',
        'cemas': '#eab308',
        'sedih': '#3b82f6',
        'marah': '#f97316',
        'stress': '#ef4444'
    };
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(76, 175, 80, 0.3)');
    gradient.addColorStop(1, 'rgba(76, 175, 80, 0.05)');
    
    // Draw chart
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: moodData.labels,
            datasets: [{
                label: 'Tingkat Mood',
                data: moodData.values,
                borderColor: '#4caf50',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: moodData.colors,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                spanGaps: true // Allow gaps in data
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const moodText = moodData.moods[context.dataIndex];
                            return moodText ? `Mood: ${moodText}` : 'Tidak ada data';
                        }
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 6,
                    ticks: {
                        callback: function(value) {
                            const moodLabels = {
                                0: 'Stress',
                                1: 'Marah', 
                                2: 'Sedih',
                                3: 'Cemas',
                                4: 'Lelah',
                                5: 'Tenang',
                                6: 'Senang'
                            };
                            return moodLabels[value];
                        },
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// Get real mood data from user's actual entries
function getRealMoodChartData() {
    const moodValues = {
        'senang': 6,
        'tenang': 5,
        'lelah': 4,
        'cemas': 3,
        'sedih': 2,
        'marah': 1,
        'stress': 0
    };
    
    const moodColors = {
        'senang': '#4caf50',
        'tenang': '#14b8a6',
        'lelah': '#6b7280',
        'cemas': '#eab308',
        'sedih': '#3b82f6',
        'marah': '#f97316',
        'stress': '#ef4444'
    };
    
    // Get mood entries from the page
    const moodEntries = document.querySelectorAll('.mood-entry');
    const moodDataMap = new Map();
    
    // Process each mood entry
    moodEntries.forEach(entry => {
        const moodText = entry.querySelector('.font-medium').textContent.toLowerCase();
        const dateText = entry.querySelector('.text-xs').textContent;
        
        // Parse date - assuming format like "15 Mar 2024 14:30"
        const date = new Date(dateText);
        const dateKey = date.toDateString();
        
        // Only include entries from last 7 days
        const sevenDaysAgo = new Date();
        sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
        
        if (date >= sevenDaysAgo) {
            moodDataMap.set(dateKey, {
                mood: moodText,
                value: moodValues[moodText],
                color: moodColors[moodText],
                date: date
            });
        }
    });
    
    // Generate last 7 days data
    const labels = [];
    const values = [];
    const colors = [];
    const moods = [];
    
    for (let i = 6; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        date.setHours(0, 0, 0, 0);
        
        const dateKey = date.toDateString();
        labels.push(date.getDate() + '/' + (date.getMonth() + 1));
        
        if (moodDataMap.has(dateKey)) {
            const data = moodDataMap.get(dateKey);
            values.push(data.value);
            colors.push(data.color);
            moods.push(data.mood);
        } else {
            values.push(null);
            colors.push('#cbd5e1'); // gray-300 for no data
            moods.push(null);
        }
    }
    
    return { labels, values, colors, moods };
}

// Delete Confirmation Modal
function initializeDeleteModal() {
    const modal = document.getElementById('deleteMoodModal');
    const cancelBtn = document.getElementById('cancelDelete');
    const deleteForm = document.getElementById('deleteMoodForm');
    let currentMoodId = null;
    
    // Open modal when delete button is clicked
    document.querySelectorAll('.delete-mood-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentMoodId = this.getAttribute('data-id');
            const deleteUrl = `{{ route('mood.tracking.destroy', '') }}/${currentMoodId}`;
            deleteForm.action = deleteUrl;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when cancel button is clicked
    cancelBtn.addEventListener('click', function() {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
        currentMoodId = null;
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            currentMoodId = null;
        }
    });
    
    // Handle form submission
    deleteForm.addEventListener('submit', function(e) {
        // The form will submit normally, no need for AJAX unless you want it
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    });
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            currentMoodId = null;
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeMoodTracking();
    
    // Add event listener for mood form submission
    const moodForm = document.getElementById('mood-form');
    if (moodForm) {
        moodForm.addEventListener('submit', function(e) {
            const selectedMood = this.querySelector('input[name="mood"]:checked');
            if (!selectedMood) {
                e.preventDefault();
                showToast('Pilih mood terlebih dahulu!', 'error');
                return;
            }
            
            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        });
    }
});

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium z-50 transform translate-x-full transition-transform duration-300 ${
        type === 'error' ? 'bg-red-500' : 
        type === 'success' ? 'bg-green-500' : 'bg-blue-500'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>
@endsection