@extends('layouts.app')

@section('title', 'Profil - Tenang')

@section('styles')
<style>
    .profile-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .profile-section:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    .tab-button {
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        border-radius: 12px 12px 0 0;
        padding: 12px 20px;
        font-weight: 600;
    }
    
    .tab-button.active {
        color: #58cc70;
        border-bottom-color: #58cc70;
        background: linear-gradient(135deg, #f0f9f0, #ffffff);
        box-shadow: 0 2px 0 rgba(88, 204, 112, 0.2);
    }
    
    .tab-button:hover:not(.active) {
        color: #45b259;
        border-bottom-color: #c2ebd0;
        background-color: #f8fdf8;
        transform: translateY(-2px);
    }
    
    .tab-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }
    
    .tab-content.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .input-field {
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        background: white;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .input-field:focus {
        box-shadow: 0 0 0 3px rgba(88, 204, 112, 0.1);
        border-color: #58cc70;
        transform: translateY(-2px);
    }
    
    .avatar-upload {
        position: relative;
        display: inline-block;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 4px solid #dcf2dc;
        overflow: hidden;
        box-shadow: 0 4px 0 rgba(69, 178, 89, 0.3);
    }
    
    .avatar-preview:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 6px 0 rgba(69, 178, 89, 0.3);
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
        background: white;
        border: 2px solid #f1f3f4;
        border-radius: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }
    
    .mental-health-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }
    
    .progress-bar {
        height: 12px;
        background-color: #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 8px;
        transition: width 0.5s ease;
        background: linear-gradient(90deg, #58cc70, #45b259);
    }
    
    .wellness-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .wellness-excellent { 
        background: linear-gradient(135deg, #58cc70, #45b259); 
    }
    .wellness-good { 
        background: linear-gradient(135deg, #8fd18f, #6bbf6b); 
    }
    .wellness-fair { 
        background: linear-gradient(135deg, #ffc800, #e6b400); 
    }
    .wellness-poor { 
        background: linear-gradient(135deg, #ff9f43, #ff8c1a); 
    }
    .wellness-critical { 
        background: linear-gradient(135deg, #ff6b6b, #e55c5c); 
    }

    /* Button Styles */
    .btn-primary {
        background: #58cc70;
        color: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 #45b259;
        transition: all 0.2s ease;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #45b259;
    }

    .btn-primary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #45b259;
    }

    .btn-secondary {
        background: #ffc800;
        color: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 #e6b400;
        transition: all 0.2s ease;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #e6b400;
    }

    .btn-secondary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #e6b400;
    }

    .btn-outline {
        background: white;
        color: #495057;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        font-weight: 600;
        padding: 12px 24px;
    }

    .btn-outline:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #58cc70;
        color: #58cc70;
    }

    /* Gamification Elements */
    .gamification-badge {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        border: 2px solid #f1f3f4;
        padding: 12px 16px;
    }

    .gamification-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* Interactive Elements */
    .interactive-btn {
        transition: all 0.2s ease;
        border-radius: 12px;
        padding: 8px 16px;
    }

    .interactive-btn:hover {
        transform: translateY(-2px);
        background: #f8f9fa;
    }

    /* Notification Styles */
    .notification-success {
        background: linear-gradient(135deg, #58cc70, #45b259);
        border: 2px solid #45b259;
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 0 rgba(69, 178, 89, 0.3);
    }

    .notification-error {
        background: linear-gradient(135deg, #ff6b6b, #e55c5c);
        border: 2px solid #e55c5c;
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 0 rgba(229, 92, 92, 0.3);
    }

    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* Mood Chart */
    .mood-bar {
        transition: all 0.3s ease;
        border-radius: 8px 8px 0 0;
    }

    .mood-bar:hover {
        transform: scaleY(1.1);
        opacity: 0.9;
    }

    /* Loading Animation */
    .loading-dots {
        display: inline-flex;
        gap: 4px;
    }

    .loading-dots span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #58cc70;
        animation: loading-bounce 1.4s infinite ease-in-out;
    }

    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

    @keyframes loading-bounce {
        0%, 80%, 100% {
            transform: scale(0.8);
            opacity: 0.5;
        }
        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Pulse Animation */
    @keyframes pulse-gentle {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .pulse-gentle {
        animation: pulse-gentle 2s infinite;
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #58cc70;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #45b259;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Notifikasi -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-duo notification-success">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-duo notification-error">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800 flex items-center">
            <i class="fas fa-user-circle text-primary-500 mr-3"></i>
            Profil Saya
        </h1>
        <p class="text-neutral-600 text-lg mt-2">Kelola informasi profil dan pantau kondisi kesehatan mental Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Profil -->
        <div class="lg:col-span-1 space-y-6">
            <div class="profile-section p-6">
                <div class="flex flex-col items-center mb-6">
                    <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="avatar-upload mb-4">
                            <div class="avatar-preview pulse-gentle">
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
                    <div class="flex items-center mt-2 gamification-badge">
                        <i class="fas fa-fire text-accent-red mr-2 streak-flame"></i>
                        <span class="text-sm font-bold text-neutral-700">{{ auth()->user()->streak ?? 0 }} hari beruntun</span>
                    </div>
                </div>
                
                <div class="border-t border-neutral-200 pt-4">
                    <div class="flex justify-between mb-3">
                        <span class="text-neutral-600 font-medium">Level</span>
                        <span class="font-bold text-primary-600">Level {{ auth()->user()->level ?? 1 }}</span>
                    </div>
                    <div class="progress-bar mb-2">
                        <div class="progress-fill" style="width: {{ min(100, ((auth()->user()->level ?? 1) / 10) * 100) }}%"></div>
                    </div>
                    <p class="text-xs text-neutral-500 text-right">{{ min(100, ((auth()->user()->level ?? 1) / 10) * 100) }}% menuju Level {{ (auth()->user()->level ?? 1) + 1 }}</p>
                </div>
                
                <div class="border-t border-neutral-200 pt-4 mt-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-600 font-medium">Poin</span>
                        <div class="flex items-center gamification-badge px-3 py-1">
                            <i class="fas fa-coins text-secondary-500 mr-2"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->coins ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-600 font-medium">Berlian</span>
                        <div class="flex items-center gamification-badge px-3 py-1">
                            <i class="fas fa-gem text-accent-blue mr-2"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->diamonds ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Wellness Status Card -->
            <div class="profile-section p-6">
                <h3 class="text-lg font-bold text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-heartbeat text-accent-red mr-2"></i>
                    Status Kesehatan Mental
                </h3>
                
                <div class="flex items-center mb-4 p-3 bg-green-50 rounded-duo border-2 border-green-200">
                    <span class="wellness-indicator wellness-good"></span>
                    <span class="text-neutral-700 font-bold">Kondisi Baik</span>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-neutral-600 font-medium">Tingkat Stres</span>
                            <span class="font-bold text-neutral-700">Sedang</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-yellow-500" style="width: 60%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-neutral-600 font-medium">Kualitas Tidur</span>
                            <span class="font-bold text-neutral-700">Baik</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-primary-500" style="width: 75%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-neutral-600 font-medium">Kesejahteraan Emosional</span>
                            <span class="font-bold text-neutral-700">Tinggi</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-secondary-500" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
                
                <button class="w-full mt-4 btn-outline py-3 rounded-duo font-bold">
                    <i class="fas fa-chart-line mr-2"></i>
                    Lihat Laporan Lengkap
                </button>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="lg:col-span-2">
            <div class="profile-section p-6">
                <!-- Tab Navigation -->
                <div class="flex border-b border-neutral-200 mb-6 overflow-x-auto custom-scrollbar">
                    <button class="tab-button active flex items-center font-medium text-neutral-700" data-tab="edit-profile">
                        <i class="fas fa-user-edit mr-2"></i>
                        <span>Edit Profil</span>
                    </button>
                    <button class="tab-button flex items-center font-medium text-neutral-700" data-tab="change-password">
                        <i class="fas fa-lock mr-2"></i>
                        <span>Ubah Kata Sandi</span>
                    </button>
                    <button class="tab-button flex items-center font-medium text-neutral-700" data-tab="mental-health">
                        <i class="fas fa-brain mr-2"></i>
                        <span>Kesehatan Mental</span>
                    </button>
                </div>
                
                <!-- Edit Profile Tab -->
                <div id="edit-profile" class="tab-content active">
                    <h3 class="text-xl font-bold text-neutral-800 mb-6 flex items-center">
                        <i class="fas fa-user-cog text-primary-500 mr-2"></i>
                        Informasi Profil
                    </h3>
                    
                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-neutral-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                    class="w-full input-field @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap Anda">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-bold text-neutral-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                    class="w-full input-field @error('email') border-red-500 @enderror"
                                    placeholder="email@contoh.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-bold text-neutral-700 mb-2">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                    class="w-full input-field @error('phone') border-red-500 @enderror"
                                    placeholder="+62 xxx xxxx xxxx">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="birthdate" class="block text-sm font-bold text-neutral-700 mb-2">Tanggal Lahir</label>
                                <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', auth()->user()->birthdate ? auth()->user()->birthdate->format('Y-m-d') : '') }}" 
                                    class="w-full input-field @error('birthdate') border-red-500 @enderror">
                                @error('birthdate')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="bio" class="block text-sm font-bold text-neutral-700 mb-2">Bio</label>
                                <textarea id="bio" name="bio" rows="3" 
                                    class="w-full input-field @error('bio') border-red-500 @enderror" 
                                    placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', auth()->user()->bio) }}</textarea>
                                @error('bio')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end space-x-4">
                            <button type="button" class="btn-outline px-6 py-3" onclick="resetForm('profile-form')">
                                <i class="fas fa-undo mr-2"></i>
                                Reset
                            </button>
                            <button type="submit" class="btn-primary px-6 py-3">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Change Password Tab -->
                <div id="change-password" class="tab-content">
                    <h3 class="text-xl font-bold text-neutral-800 mb-6 flex items-center">
                        <i class="fas fa-key text-primary-500 mr-2"></i>
                        Ubah Kata Sandi
                    </h3>
                    
                    <form id="password-form" action="{{ route('profile.password.update') }}" method="POST" class="max-w-md">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-bold text-neutral-700 mb-2">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" 
                                    class="w-full input-field pr-10 @error('current_password') border-red-500 @enderror"
                                    placeholder="Masukkan kata sandi saat ini">
                                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password interactive-btn" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password" class="block text-sm font-bold text-neutral-700 mb-2">Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" 
                                    class="w-full input-field pr-10 @error('new_password') border-red-500 @enderror"
                                    placeholder="Buat kata sandi baru">
                                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password interactive-btn" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="mt-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                                <p class="text-sm font-bold text-neutral-700 mb-2">Kata sandi harus mengandung:</p>
                                <ul class="text-xs text-neutral-600 space-y-1">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2 text-xs"></i>
                                        Minimal 8 karakter
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2 text-xs"></i>
                                        Setidaknya 1 huruf besar
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2 text-xs"></i>
                                        Setidaknya 1 angka
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2 text-xs"></i>
                                        Setidaknya 1 karakter khusus
                                    </li>
                                </ul>
                            </div>
                            @error('new_password')
                                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password_confirmation" class="block text-sm font-bold text-neutral-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                    class="w-full input-field pr-10"
                                    placeholder="Konfirmasi kata sandi baru">
                                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password interactive-btn" data-target="new_password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end space-x-4">
                            <button type="button" class="btn-outline px-6 py-3" onclick="resetForm('password-form')">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn-primary px-6 py-3">
                                <i class="fas fa-lock mr-2"></i>
                                Ubah Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Mental Health Tab -->
                <div id="mental-health" class="tab-content">
                    <h3 class="text-xl font-bold text-neutral-800 mb-6 flex items-center">
                        <i class="fas fa-brain text-primary-500 mr-2"></i>
                        Informasi Kesehatan Mental
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="mental-health-card p-5">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-4 shadow-duo">
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
                                    <span class="text-neutral-700 font-bold">Baik</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary-600">7.5</p>
                                    <p class="text-xs text-neutral-500">dari 10</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mental-health-card p-5">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600 mr-4 shadow-duo">
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
                                    <span class="text-neutral-700 font-bold">Baik</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-secondary-600">6.8</p>
                                    <p class="text-xs text-neutral-500">jam per malam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h4 class="font-bold text-neutral-800 mb-4 flex items-center">
                            <i class="fas fa-chart-bar text-accent-blue mr-2"></i>
                            Riwayat Mood 30 Hari Terakhir
                        </h4>
                        <div class="bg-white rounded-duo border-2 border-neutral-200 p-4">
                            <div class="h-40 flex items-end justify-between">
                                @foreach([32, 24, 28, 20, 30, 26, 22] as $height)
                                <div class="text-center">
                                    <div class="h-{{ $height }} w-6 bg-gradient-to-t from-primary-500 to-primary-300 rounded-t mood-bar mx-auto mb-1"></div>
                                    <span class="text-xs text-neutral-500 font-medium">{{ ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'][$loop->index] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-neutral-800 mb-4 flex items-center">
                            <i class="fas fa-tasks text-accent-purple mr-2"></i>
                            Aktivitas Kesehatan Mental
                        </h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-primary-50 rounded-duo border-2 border-primary-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-3 shadow-duo">
                                        <i class="fas fa-meditation"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-neutral-800">Meditasi</h5>
                                        <p class="text-sm text-neutral-600">10 menit hari ini</p>
                                    </div>
                                </div>
                                <span class="text-primary-600 font-bold">Selesai</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-white rounded-duo border-2 border-neutral-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600 mr-3 shadow-duo">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-neutral-800">Tantangan Harian</h5>
                                        <p class="text-sm text-neutral-600">Tulis 3 hal yang disyukuri</p>
                                    </div>
                                </div>
                                <button class="btn-secondary px-4 py-2 rounded-duo text-sm font-bold">
                                    <i class="fas fa-play mr-1"></i> Mulai
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-white rounded-duo border-2 border-neutral-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-accent-purple bg-opacity-10 flex items-center justify-center text-accent-purple mr-3 shadow-duo">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-neutral-800">Jurnal Mood</h5>
                                        <p class="text-sm text-neutral-600">Catat perasaan Anda hari ini</p>
                                    </div>
                                </div>
                                <button class="btn-primary px-4 py-2 rounded-duo text-sm font-bold">
                                    <i class="fas fa-edit mr-1"></i> Tulis
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
        console.log('DOM loaded - initializing profile page');
        
        // Initialize tabs
        initializeTabs();
        
        // Initialize password toggles
        initializePasswordToggles();
        
        // Add Duolingo-style interactions
        initializeDuolingoInteractions();
        
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

    function initializeDuolingoInteractions() {
        // Add button press effects
        document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline, .gamification-badge').forEach(element => {
            element.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary')) {
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
        });

        // Add hover effects to mental health cards
        document.querySelectorAll('.mental-health-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // Reset form functions
    function resetForm(formId) {
        document.getElementById(formId).reset();
        
        // Show notification
        showNotification('Form telah direset', 'info');
    }

    // Auto-submit avatar form when file is selected
    document.getElementById('avatar')?.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            // Show loading state
            const avatarPreview = document.querySelector('.avatar-preview');
            avatarPreview.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div>';
            
            document.getElementById('avatar-form').submit();
        }
    });

    // Enhanced notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-duo shadow-lg text-white max-w-sm transform translate-x-full transition-transform duration-300 font-bold ${
            type === 'success' ? 'notification-success' :
            type === 'error' ? 'notification-error' :
            'bg-blue-500'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} mr-3 text-lg"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'edit-profile';
        switchTab(activeTab);
    });

    // Form submission enhancements
    document.getElementById('profile-form')?.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Menyimpan...';
        
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }, 2000);
    });

    document.getElementById('password-form')?.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Mengubah...';
        
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }, 2000);
    });
</script>
@endsection