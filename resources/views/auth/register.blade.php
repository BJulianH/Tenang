<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Tenang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Duolingo-inspired color palette
                        primary: {
                            50: '#e6f7ea',
                            100: '#c2ebd0',
                            200: '#9bdfb5',
                            300: '#70d399',
                            400: '#4dc982',
                            500: '#58cc70',
                            600: '#45b259',
                            700: '#339847',
                            800: '#237e36',
                            900: '#156427',
                        },
                        secondary: {
                            50: '#fff9e6',
                            100: '#ffefbf',
                            200: '#ffe599',
                            300: '#ffdb70',
                            400: '#ffd14c',
                            500: '#ffc800', // Duolingo yellow
                            600: '#e6b400',
                            700: '#cc9f00',
                            800: '#b38b00',
                            900: '#997700',
                        },
                        accent: {
                            blue: '#4a8cff',
                            red: '#ff6b6b',
                            purple: '#9b59b6',
                            orange: '#ff9f43',
                        },
                        neutral: {
                            50: '#f8f9fa',
                            100: '#e9ecef',
                            200: '#dee2e6',
                            300: '#ced4da',
                            400: '#adb5bd',
                            500: '#6c757d',
                            600: '#495057',
                            700: '#343a40',
                            800: '#212529',
                            900: '#121416',
                        }
                    },
                    fontFamily: {
                        'sans': ['Nunito', 'Inter', 'ui-sans-serif', 'system-ui'],
                        'duo': ['Nunito', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-gentle': 'bounce-gentle 2s infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                        'celebrate': 'celebrate 0.6s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'fadeInUp': 'fadeInUp 0.8s ease-out',
                        'breathe': 'breathe 4s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'shake': 'shake 0.5s ease-in-out',
                    },
                    keyframes: {
                        'bounce-gentle': {
                            '0%, 100%': { 
                                transform: 'translateY(0)',
                                animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)'
                            },
                            '50%': { 
                                transform: 'translateY(-8px)',
                                animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)'
                            },
                        },
                        'wiggle': {
                            '0%, 100%': { transform: 'rotate(-5deg)' },
                            '50%': { transform: 'rotate(5deg)' },
                        },
                        'celebrate': {
                            '0%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.2)' },
                            '100%': { transform: 'scale(1)' },
                        },
                        'slideIn': {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        },
                        'fadeInUp': {
                            'from': {
                                opacity: '0',
                                transform: 'translateY(30px)',
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateY(0)',
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        'breathe': {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
                        },
                        'shake': {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '25%': { transform: 'translateX(-5px)' },
                            '75%': { transform: 'translateX(5px)' },
                        }
                    },
                    borderRadius: {
                        'duo': '16px',
                        'duo-lg': '24px',
                        'duo-xl': '32px',
                    },
                    boxShadow: {
                        'duo': '0 4px 0 rgba(0, 0, 0, 0.1)',
                        'duo-lg': '0 6px 0 rgba(0, 0, 0, 0.1)',
                        'duo-pressed': '0 2px 0 rgba(0, 0, 0, 0.1)',
                    },
                    screens: {
                        'xs': '475px',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 3px solid #f1f3f4;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
        }

        .card:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
            border-color: #dfe3e6;
        }

        .app-button {
            background: #58cc70;
            color: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 #45b259;
            transition: all 0.2s ease;
            font-weight: 700;
            border: none;
            padding: 12px 24px;
        }

        .app-button:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 0 #45b259;
        }

        .app-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #45b259;
        }

        .app-button-secondary {
            background: #ffc800;
            box-shadow: 0 4px 0 #e6b400;
        }

        .app-button-secondary:hover {
            box-shadow: 0 6px 0 #e6b400;
        }

        .app-button-secondary:active {
            box-shadow: 0 2px 0 #e6b400;
        }

        .app-button:disabled {
            background: #9ca3af;
            box-shadow: 0 4px 0 #6b7280;
            cursor: not-allowed;
            transform: none;
        }

        .app-button:disabled:hover {
            transform: none;
            box-shadow: 0 4px 0 #6b7280;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .breathe {
            animation: breathe 4s ease-in-out infinite;
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
            transition: all 0.3s ease;
            width: 0%;
        }

        .strength-weak {
            width: 25% !important;
            background-color: #ef4444 !important;
        }

        .strength-medium {
            width: 50% !important;
            background-color: #f59e0b !important;
        }

        .strength-strong {
            width: 75% !important;
            background-color: #3b82f6 !important;
        }

        .strength-very-strong {
            width: 100% !important;
            background-color: #10b981 !important;
        }

        /* Error States */
        .input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }

        .input-error:focus {
            ring-color: #ef4444 !important;
            border-color: #ef4444 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .success-message {
            color: #10b981;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Loading States */
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #58cc70;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #45b259;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #58cc70 0%, #ffc800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Error/Success Messages */
        .alert-success {
            background-color: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
            border-radius: 12px;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05);
        }

        .alert-error {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #dc2626;
            border-radius: 12px;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05);
        }

        /* Modal Styles */
        .modal-overlay {
            transition: opacity 0.3s ease;
        }

        .modal-content {
            transition: all 0.3s ease;
        }

        .modal-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .modal-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 3px;
        }

        .modal-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .modal-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Modal Animation Classes */
        .modal-enter {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }

        .modal-enter-active {
            opacity: 1;
            transform: translateY(0) scale(1);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .modal-leave {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .modal-leave-active {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .overlay-enter {
            opacity: 0;
        }

        .overlay-enter-active {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .overlay-leave {
            opacity: 1;
        }

        .overlay-leave-active {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* Dot pattern background */
        .striped-dotted-main {
            background-color: #f8f9fa; 
            background-image: 
                radial-gradient(#808080b7 2px, transparent 2px);
            background-size: 40px 40px, 60px 60px; 
            background-position: 0 0, 20px 20px;
            border-radius: 30px; 
            border: 3px solid rgb(182, 182,  182);
            box-shadow: 0 6px 0 rgba(182, 182, 182);
        }

        /* Form input styles */
        .form-input {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05);
            border: 2px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #58cc70;
            box-shadow: 0 0 0 3px rgba(88, 204, 112, 0.1);
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            color: #6b7280;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .scroll-indicator.hidden {
            opacity: 0;
            transform: translateX(-50%) translateY(10px);
        }

        /* Progress bar for modal reading */
        .reading-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #e5e7eb;
        }

        .reading-progress-fill {
            height: 100%;
            background: #58cc70;
            border-radius: 0 2px 2px 0;
            transition: width 0.3s ease;
            width: 0%;
        }

        /* Checkbox animation */
        .checkbox-confirmed {
            animation: celebrate 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-neutral-50 max-h-full overflow-hidden">
    <!-- Loading Section -->
        <div id="loading-section" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-all duration-500">
        <div class="text-center">
            <!-- Container dengan efek kartu Duolingo -->
            <div class="bg-white rounded-duo-xl p-8 shadow-duo-lg border-4 border-primary-100 transform transition-all duration-300 hover:scale-105">
                <!-- Gif dengan frame dekoratif -->
                <div class="relative mb-6">
                    <div class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-sm opacity-50 animate-pulse"></div>
                    <div class="relative bg-white rounded-full p-3 shadow-duo border-2 border-primary-300">
                        <img src="{{ asset('assets/video/icon.gif') }}" alt="Loading" class="mx-auto w-28 h-28 rounded-full">
                    </div>
                </div>
                
                <!-- Teks loading dengan animasi -->
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-neutral-800">MindWell</h3>
                    <p class="text-neutral-600 font-medium flex items-center justify-center space-x-2">
                        <span>Loading your journey</span>
                        <span class="loading-dots">
                            <span class="dot">.</span>
                            <span class="dot">.</span>
                            <span class="dot">.</span>
                        </span>
                    </p>
                    
                    <!-- Progress bar Duolingo style -->
                    <div class="w-48 mx-auto mt-4">
                        <div class="duo-progress bg-neutral-200 rounded-full h-3">
                            <div class="duo-progress-fill bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full h-3 progress-animation"></div>
                        </div>
                    </div>
                    
                    <!-- Quote motivasional -->
                    <p class="text-sm text-neutral-500 mt-4 italic max-w-xs">
                        "Every step forward is progress"
                    </p>
                </div>
            </div>
            
            <!-- Elemen dekoratif floating -->
            <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-accent-blue rounded-full opacity-20 animate-bounce-gentle"></div>
            <div class="absolute bottom-1/4 right-1/4 w-6 h-6 bg-accent-purple rounded-full opacity-20 animate-bounce-gentle" style="animation-delay: 0.3s"></div>
            <div class="absolute top-1/3 right-1/3 w-4 h-4 bg-accent-red rounded-full opacity-20 animate-bounce-gentle" style="animation-delay: 0.6s"></div>
        </div>
    </div>
    
    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Left Panel - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative order-2 lg:order-1">
            <!-- Background untuk mobile -->
            <div class="lg:hidden absolute inset-0 bg-gradient-to-br from-primary-100 to-secondary-100 -z-10 opacity-30">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full animate-bounce-gentle"></div>
                <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full animate-bounce-gentle" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full animate-bounce-gentle" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-40 right-10 w-12 h-12 bg-white rounded-full animate-bounce-gentle" style="animation-delay: 1.5s;"></div>
            </div>

            <!-- Mobile Header -->
            <div class="lg:hidden absolute top-8 left-8 z-20">
                <a href="/" class="text-2xl font-bold text-primary-600 flex items-center">
                    <i class="fas fa-peace mr-2"></i>
                    Tenang
                </a>
            </div>

            <div class="w-full max-w-md z-10">
                <!-- Register Form Container -->
                <div class="card p-8 fade-in-up">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4 breathe">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-neutral-800 mb-2">Bergabung dengan Tenang</h2>
                        <p class="text-neutral-600">Mulai perjalanan kesehatan mentalmu hari ini</p>
                    </div>

                    <!-- Session Messages -->
                    @if(session('status'))
                        <div class="mb-4 p-4 alert-success rounded-lg text-sm flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 alert-error rounded-lg text-sm flex items-center shake">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 alert-error rounded-lg text-sm shake">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-medium">Harap perbaiki error berikut:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-user mr-2 text-primary-500"></i>
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-neutral-400"></i>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full pl-10 pr-4 py-3 form-input @error('name') input-error @enderror" placeholder="Masukkan nama lengkap Anda">
                            </div>
                            @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle text-xs"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-primary-500"></i>
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-neutral-400"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full pl-10 pr-4 py-3 form-input @error('email') input-error @enderror" placeholder="Masukkan email Anda">
                            </div>
                            @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle text-xs"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-lock mr-2 text-primary-500"></i>
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-neutral-400"></i>
                                </div>
                                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 form-input @error('password') input-error @enderror" placeholder="Buat kata sandi">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                                    <i class="fas fa-eye-slash text-neutral-400 hover:text-neutral-600"></i>
                                </button>
                            </div>
                            <div id="password-strength" class="password-strength"></div>
                            <div id="password-hints" class="text-xs text-neutral-500 mt-2">
                                <div id="length" class="flex items-center mb-1">
                                    <i class="fas fa-times text-red-500 mr-1"></i>
                                    <span>Minimal 8 karakter</span>
                                </div>
                                <div id="uppercase" class="flex items-center mb-1">
                                    <i class="fas fa-times text-red-500 mr-1"></i>
                                    <span>Satu huruf besar</span>
                                </div>
                                <div id="number" class="flex items-center">
                                    <i class="fas fa-times text-red-500 mr-1"></i>
                                    <span>Satu angka</span>
                                </div>
                            </div>
                            @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle text-xs"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-lock mr-2 text-primary-500"></i>
                                Konfirmasi Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-neutral-400"></i>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 form-input" placeholder="Konfirmasi kata sandi Anda">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-confirm-toggle">
                                    <i class="fas fa-eye-slash text-neutral-400 hover:text-neutral-600"></i>
                                </button>
                            </div>
                            <div id="password-match" class="text-xs mt-2 hidden">
                                <i class="fas fa-check text-green-500 mr-1"></i>
                                <span class="text-green-500">Kata sandi cocok</span>
                            </div>
                            <div id="password-mismatch" class="text-xs mt-2 hidden">
                                <i class="fas fa-times text-red-500 mr-1"></i>
                                <span class="text-red-500">Kata sandi tidak cocok</span>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms" id="termsCheckbox" class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500 mt-1" required disabled>
                                <span class="ml-2 text-sm text-neutral-600">
                                    Saya setuju dengan
                                    <button type="button" id="termsBtn" class="text-primary-600 hover:text-primary-700 underline font-medium transition-colors">Syarat Layanan</button>
                                    dan
                                    <button type="button" id="privacyBtn" class="text-primary-600 hover:text-primary-700 underline font-medium transition-colors">Kebijakan Privasi</button>
                                    <span id="termsStatus" class="text-xs text-orange-500 ml-2 hidden">
                                        (Harap baca kedua dokumen terlebih dahulu)
                                    </span>
                                    <span id="termsConfirmed" class="text-xs text-green-500 ml-2 hidden">
                                        <i class="fas fa-check mr-1"></i>Sudah dibaca dan disetujui
                                    </span>
                                </span>
                            </label>
                            @error('terms')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle text-xs"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a class="underline text-sm text-neutral-600 hover:text-neutral-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('login') }}">
                                Sudah punya akun?
                            </a>

                            <button type="submit" id="submitBtn" class="app-button px-6 py-3 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <span id="submitText">Buat Akun</span>
                                <span id="submitLoading" class="hidden">
                                    <i class="fas fa-spinner loading-spinner mr-2"></i>
                                    Membuat Akun...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Panel - Visualization (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-8 lg:p-12 flex-col justify-between relative overflow-hidden order-1 lg:order-2">
            <!-- Background decorative elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-20">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full float"></div>
                <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full float" style="animation-delay: 2s;"></div>
                <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full float" style="animation-delay: 4s;"></div>
                <div class="absolute bottom-40 right-10 w-12 h-12 bg-white rounded-full float" style="animation-delay: 1s;"></div>
            </div>

            <!-- Header -->
            <div class="relative z-10">
                <a href="/" class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-peace mr-2"></i>
                    Tenang
                </a>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 flex-1 flex flex-col justify-center fade-in-up">
                <div class="max-w-md">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6">Selamat Datang</h1>
                    <p class="text-xl opacity-90 mb-8">
                        Mulai perjalanan menuju kesehatan mental dan mindfulness yang lebih baik.
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe">
                                <i class="fas fa-heartbeat text-white"></i>
                            </div>
                            <span>Pelacakan Mood & Analitik Harian</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe" style="animation-delay: 0.5s;">
                                <i class="fas fa-book-open text-white"></i>
                            </div>
                            <span>Journaling Personal</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe" style="animation-delay: 1s;">
                                <i class="fas fa-medal text-white"></i>
                            </div>
                            <span>Tantangan & Pencapaian Kesehatan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-center lg:text-left opacity-80 text-sm">
                <p>© 2024 Tenang. Menjaga kesehatan mental Indonesia.</p>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-neutral-500 bg-opacity-75 modal-overlay"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform card modal-content">
                <!-- Header -->
                <div class="px-6 py-4 bg-primary-50 border-b border-primary-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-neutral-800">Kebijakan Privasi</h3>
                                <p class="text-sm text-neutral-600">Terakhir diperbarui: {{ date('d M Y') }}</p>
                            </div>
                        </div>
                        <button id="closePrivacy" class="w-8 h-8 rounded-full hover:bg-neutral-100 flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-neutral-500"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 py-4 max-h-96 overflow-y-auto modal-scrollbar" id="privacyContent">
                    <div class="prose prose-sm max-w-none">
                        <h4>1. Informasi yang Kami Kumpulkan</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami mengumpulkan informasi yang Anda berikan secara langsung saat mendaftar dan menggunakan layanan Tenang, termasuk:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Data pribadi (nama, email)</li>
                            <li>Data kesehatan mental (mood, journal entries)</li>
                            <li>Data penggunaan aplikasi</li>
                            <li>Informasi teknis (perangkat, browser, IP address)</li>
                        </ul>

                        <h4>2. Penggunaan Informasi</h4>
                        <p class="text-neutral-700 mb-4">
                            Informasi yang kami kumpulkan digunakan untuk:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Menyediakan dan mempersonalisasi layanan</li>
                            <li>Meningkatkan kualitas layanan dan pengalaman pengguna</li>
                            <li>Analisis tren kesehatan mental yang anonym</li>
                            <li>Komunikasi terkait layanan dan pembaruan</li>
                            <li>Memastikan keamanan akun Anda</li>
                        </ul>

                        <h4>3. Perlindungan Data</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami menerapkan standar keamanan tinggi untuk melindungi data Anda:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Semua data disimpan secara terenkripsi</li>
                            <li>Akses data dibatasi hanya untuk pihak yang berwenang</li>
                            <li>Protokol keamanan mengikuti standar industri</li>
                            <li>Audit keamanan berkala</li>
                        </ul>

                        <h4>4. Berbagi Informasi</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami tidak menjual atau menyewakan data pribadi Anda. Informasi dapat dibagikan hanya dalam kondisi:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Dengan persetujuan eksplisit dari Anda</li>
                            <li>Untuk mematuhi kewajiban hukum</li>
                            <li>Melindungi hak dan keselamatan pengguna lain</li>
                            <li>Dengan penyedia layanan yang membantu operasional kami (dengan kontrak kerahasiaan)</li>
                        </ul>

                        <h4>5. Hak Anda</h4>
                        <p class="text-neutral-700 mb-4">
                            Anda memiliki hak untuk:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Mengakses data pribadi Anda</li>
                            <li>Memperbaiki data yang tidak akurat</li>
                            <li>Menghapus data pribadi</li>
                            <li>Membatasi pemrosesan data</li>
                            <li>Menerima salinan data dalam format terstruktur</li>
                        </ul>

                        <h4>6. Penyimpanan Data</h4>
                        <p class="text-neutral-700 mb-4">
                            Data disimpan selama diperlukan untuk menyediakan layanan atau sesuai dengan ketentuan hukum. Anda dapat meminta penghapusan data kapan saja.
                        </p>

                        <h4>7. Cookies dan Teknologi Serupa</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami menggunakan cookies untuk meningkatkan pengalaman pengguna, menganalisis traffic, dan personalisasi konten.
                        </p>

                        <h4>8. Perubahan Kebijakan</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Perubahan signifikan akan diumumkan melalui aplikasi, email, atau notifikasi lainnya.
                        </p>

                        <h4>9. Kontak</h4>
                        <p class="text-neutral-700">
                            Untuk pertanyaan tentang kebijakan privasi atau penggunaan data, hubungi kami di <strong>privacy@tenang.com</strong>.
                        </p>

                        <!-- Extra content to ensure scrolling is needed -->
                        <div class="mt-8 pt-8 border-t border-neutral-200">
                            <h4>10. Komitmen Kami</h4>
                            <p class="text-neutral-700 mb-4">
                                Kami berkomitmen untuk melindungi privasi Anda dan memastikan bahwa data pribadi Anda dikelola dengan transparansi dan tanggung jawab.
                            </p>
                            <p class="text-neutral-700">
                                Dengan menggunakan layanan Tenang, Anda mempercayai kami dengan informasi pribadi Anda, dan kami sangat serius dalam menjaga kepercayaan tersebut.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reading Progress -->
                <div class="reading-progress">
                    <div id="privacyProgress" class="reading-progress-fill"></div>
                </div>

                <!-- Scroll Indicator -->
                <div id="privacyScrollIndicator" class="scroll-indicator">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Scroll ke bawah untuk melanjutkan membaca
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-neutral-50 border-t border-neutral-200 flex justify-end">
                    <button id="understandPrivacy" class="app-button px-6 py-2" disabled>
                        <span id="privacyButtonText">Mengerti</span>
                        <span id="privacyButtonLoading" class="hidden">
                            <i class="fas fa-spinner loading-spinner mr-2"></i>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms of Service Modal -->
    <div id="termsModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-neutral-500 bg-opacity-75 modal-overlay"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform card modal-content">
                <!-- Header -->
                <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-secondary-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-file-contract text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-neutral-800">Syarat Layanan</h3>
                                <p class="text-sm text-neutral-600">Terakhir diperbarui: {{ date('d M Y') }}</p>
                            </div>
                        </div>
                        <button id="closeTerms" class="w-8 h-8 rounded-full hover:bg-neutral-100 flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-neutral-500"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 py-4 max-h-96 overflow-y-auto modal-scrollbar" id="termsContent">
                    <div class="prose prose-sm max-w-none">
                        <h4>1. Penerimaan Syarat</h4>
                        <p class="text-neutral-700 mb-4">
                            Dengan mendaftar dan menggunakan layanan Tenang, Anda menyetujui semua syarat dan ketentuan yang tercantum di bawah ini. Jika Anda tidak setuju, harap jangan menggunakan layanan kami.
                        </p>

                        <h4>2. Akun Pengguna</h4>
                        <p class="text-neutral-700 mb-4">
                            Saat membuat akun, Anda setuju untuk:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Menyediakan informasi yang akurat, lengkap, dan terkini</li>
                            <li>Menjaga kerahasiaan informasi akun dan password</li>
                            <li>Bertanggung jawab penuh atas semua aktivitas yang terjadi di akun Anda</li>
                            <li>Segera melaporkan aktivitas mencurigakan atau pelanggaran keamanan</li>
                            <li>Memastikan Anda berusia minimal 13 tahun (atau sesuai ketentuan hukum setempat)</li>
                        </ul>

                        <h4>3. Penggunaan Layanan</h4>
                        <p class="text-neutral-700 mb-4">
                            Anda setuju untuk menggunakan layanan Tenang secara bertanggung jawab dan tidak:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Menyalahgunakan layanan untuk tujuan ilegal, berbahaya, atau tidak sah</li>
                            <li>Mengganggu atau mencoba mengganggu operasional layanan</li>
                            <li>Mencoba mengakses data pengguna lain tanpa izin</li>
                            <li>Menyebarkan malware, virus, atau kode berbahaya</li>
                            <li>Melakukan scraping atau pengumpulan data otomatis</li>
                            <li>Melanggar hak kekayaan intelektual orang lain</li>
                            <li>Menyebarkan konten yang bersifat ujaran kebencian, diskriminatif, atau tidak pantas</li>
                        </ul>

                        <h4>4. Batasan Layanan</h4>
                        <p class="text-neutral-700 mb-4">
                            <strong>Penting:</strong> Tenang adalah alat pendukung kesehatan mental dan bukan pengganti perawatan medis profesional. Layanan kami tidak memberikan diagnosis medis, pengobatan, atau terapi pengganti.
                        </p>
                        <p class="text-neutral-700 mb-4">
                            Dalam keadaan darurat medis atau krisis kesehatan mental, segera hubungi:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Layanan darurat setempat (119)</li>
                            <li>Dokter atau profesional kesehatan mental</li>
                            <li>Layanan crisis helpline</li>
                        </ul>

                        <h4>5. Hak Kekayaan Intelektual</h4>
                        <p class="text-neutral-700 mb-4">
                            Semua konten, fitur, fungsi, dan materi dalam aplikasi Tenang (termasuk tapi tidak terbatas pada teks, grafis, logo, dan kode) adalah milik kami atau pemberi lisensi kami dan dilindungi oleh hukum hak cipta dan hak kekayaan intelektual lainnya.
                        </p>

                        <h4>6. Konten Pengguna</h4>
                        <p class="text-neutral-700 mb-4">
                            Anda mempertahankan kepemilikan atas konten yang Anda buat di Tenang. Dengan mengirimkan konten, Anda memberikan kami lisensi untuk menggunakan, menampilkan, dan menyimpan konten tersebut untuk menyediakan layanan.
                        </p>

                        <h4>7. Pembatasan Tanggung Jawab</h4>
                        <p class="text-neutral-700 mb-4">
                            Layanan disediakan "sebagaimana adanya" tanpa jaminan apapun. Kami tidak bertanggung jawab atas:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Kerugian tidak langsung, insidental, atau konsekuensial</li>
                            <li>Keakuratan atau kelengkapan konten yang dihasilkan pengguna</li>
                            <li>Interupsi atau gangguan layanan di luar kendali kami</li>
                            <li>Tindakan atau kelalaian pengguna lain</li>
                        </ul>

                        <h4>8. Penghentian Layanan</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami dapat menghentikan atau menangguhkan akses Anda jika:
                        </p>
                        <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1">
                            <li>Melanggar syarat layanan ini</li>
                            <li>Menimbulkan risiko atau tanggung jawab hukum bagi kami</li>
                            <li>Pembuatan akun untuk tujuan penipuan</li>
                            <li>Penggunaan yang tidak sah atau berbahaya</li>
                        </ul>

                        <h4>9. Perubahan Syarat</h4>
                        <p class="text-neutral-700 mb-4">
                            Kami berhak mengubah syarat layanan kapan saja. Perubahan akan diberitahukan melalui aplikasi, email, atau notifikasi lainnya. Penggunaan berkelanjutan setelah perubahan berarti penerimaan Anda terhadap syarat baru.
                        </p>

                        <h4>10. Hukum yang Berlaku</h4>
                        <p class="text-neutral-700">
                            Syarat layanan ini diatur oleh hukum Indonesia. Setiap sengketa akan diselesaikan di pengadilan yang berwenang di Indonesia.
                        </p>

                        <!-- Extra content to ensure scrolling is needed -->
                        <div class="mt-8 pt-8 border-t border-neutral-200">
                            <h4>11. Komitmen Kami</h4>
                            <p class="text-neutral-700 mb-4">
                                Kami berkomitmen untuk memberikan pengalaman yang aman, mendukung, dan bermanfaat bagi semua pengguna Tenang.
                            </p>
                            <p class="text-neutral-700">
                                Dengan menyetujui syarat layanan ini, Anda menjadi bagian dari komunitas yang peduli dengan kesehatan mental dan kesejahteraan bersama.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reading Progress -->
                <div class="reading-progress">
                    <div id="termsProgress" class="reading-progress-fill"></div>
                </div>

                <!-- Scroll Indicator -->
                <div id="termsScrollIndicator" class="scroll-indicator">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Scroll ke bawah untuk melanjutkan membaca
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-neutral-50 border-t border-neutral-200 flex justify-end">
                    <button id="understandTerms" class="app-button-secondary px-6 py-2" disabled>
                        <span id="termsButtonText">Mengerti</span>
                        <span id="termsButtonLoading" class="hidden">
                            <i class="fas fa-spinner loading-spinner mr-2"></i>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Loading section functionality
        function hideLoading() {
            const loadingSection = document.getElementById('loading-section');
            loadingSection.style.opacity = '0';
            loadingSection.style.transform = 'scale(0.95)';
            setTimeout(() => {
                loadingSection.style.display = 'none';
            }, 500);
        }

        window.addEventListener('load', function() {
            setTimeout(hideLoading, 1500);
        });

        document.addEventListener("DOMContentLoaded", () => {
            // State management
            let privacyRead = false;
            let termsRead = false;

            // Modal Elements
            const privacyModal = document.getElementById("privacyModal");
            const termsModal = document.getElementById("termsModal");
            const privacyBtn = document.getElementById("privacyBtn");
            const termsBtn = document.getElementById("termsBtn");
            const closePrivacy = document.getElementById("closePrivacy");
            const closeTerms = document.getElementById("closeTerms");
            const understandPrivacy = document.getElementById("understandPrivacy");
            const understandTerms = document.getElementById("understandTerms");
            const modalOverlays = document.querySelectorAll(".modal-overlay");

            // Form Elements
            const termsCheckbox = document.getElementById("termsCheckbox");
            const termsStatus = document.getElementById("termsStatus");
            const termsConfirmed = document.getElementById("termsConfirmed");
            const submitBtn = document.getElementById("submitBtn");

            // Password Elements
            const passwordInput = document.getElementById("password");
            const passwordConfirmInput = document.getElementById("password_confirmation");
            const passwordToggle = document.querySelector(".password-toggle");
            const passwordConfirmToggle = document.querySelector(".password-confirm-toggle");
            const submitText = document.getElementById("submitText");
            const submitLoading = document.getElementById("submitLoading");

            // Update form state based on reading status
            function updateFormState() {
                if (privacyRead && termsRead) {
                    termsCheckbox.disabled = false;
                    termsCheckbox.checked = true;
                    termsStatus.classList.add('hidden');
                    termsConfirmed.classList.remove('hidden');
                    termsCheckbox.classList.add('checkbox-confirmed');
                    submitBtn.disabled = false;
                } else {
                    termsStatus.classList.remove('hidden');
                    termsConfirmed.classList.add('hidden');
                }
            }

            // Modal Functions
            function openModal(modal) {
                modal.classList.remove("hidden");
                document.body.style.overflow = "hidden";
                
                // Reset scroll position
                const content = modal.querySelector('.modal-scrollbar');
                if (content) {
                    content.scrollTop = 0;
                }
                
                // Trigger animation
                setTimeout(() => {
                    const overlay = modal.querySelector(".modal-overlay");
                    const content = modal.querySelector(".modal-content");
                    overlay.classList.add("overlay-enter-active");
                    content.classList.add("modal-enter-active");
                }, 10);
            }

            function closeModal(modal) {
                const overlay = modal.querySelector(".modal-overlay");
                const content = modal.querySelector(".modal-content");
                
                overlay.classList.remove("overlay-enter-active");
                content.classList.remove("modal-enter-active");
                
                overlay.classList.add("overlay-leave-active");
                content.classList.add("modal-leave-active");
                
                setTimeout(() => {
                    modal.classList.add("hidden");
                    document.body.style.overflow = "";
                    overlay.classList.remove("overlay-leave-active");
                    content.classList.remove("modal-leave-active");
                }, 200);
            }

            // Scroll detection for modals
            function setupScrollDetection(modal, progressBar, scrollIndicator, understandButton, type) {
                const content = modal.querySelector('.modal-scrollbar');
                if (!content) return;

                content.addEventListener('scroll', function() {
                    const scrollTop = content.scrollTop;
                    const scrollHeight = content.scrollHeight;
                    const clientHeight = content.clientHeight;
                    const scrollPercentage = (scrollTop / (scrollHeight - clientHeight)) * 100;

                    // Update progress bar
                    if (progressBar) {
                        progressBar.style.width = `${Math.min(scrollPercentage, 100)}%`;
                    }

                    // Hide scroll indicator when near bottom
                    if (scrollIndicator) {
                        if (scrollPercentage > 80) {
                            scrollIndicator.classList.add('hidden');
                        } else {
                            scrollIndicator.classList.remove('hidden');
                        }
                    }

                    // Enable understand button when scrolled to bottom
                    if (understandButton && scrollPercentage >= 95) {
                        understandButton.disabled = false;
                    }
                });
            }

            // Event Listeners for Modals
            privacyBtn.addEventListener("click", () => {
                openModal(privacyModal);
                setupScrollDetection(privacyModal, 
                    document.getElementById('privacyProgress'),
                    document.getElementById('privacyScrollIndicator'),
                    understandPrivacy,
                    'privacy'
                );
            });

            termsBtn.addEventListener("click", () => {
                openModal(termsModal);
                setupScrollDetection(termsModal,
                    document.getElementById('termsProgress'),
                    document.getElementById('termsScrollIndicator'),
                    understandTerms,
                    'terms'
                );
            });

            closePrivacy.addEventListener("click", () => closeModal(privacyModal));
            closeTerms.addEventListener("click", () => closeModal(termsModal));

            // Understand button handlers
            understandPrivacy.addEventListener("click", () => {
                privacyRead = true;
                updateFormState();
                closeModal(privacyModal);
                
                // Show confirmation animation
                const buttonText = document.getElementById('privacyButtonText');
                const buttonLoading = document.getElementById('privacyButtonLoading');
                
                buttonText.classList.add('hidden');
                buttonLoading.classList.remove('hidden');
                
                setTimeout(() => {
                    buttonLoading.classList.add('hidden');
                    buttonText.classList.remove('hidden');
                    understandPrivacy.disabled = true;
                }, 1000);
            });

            understandTerms.addEventListener("click", () => {
                termsRead = true;
                updateFormState();
                closeModal(termsModal);
                
                // Show confirmation animation
                const buttonText = document.getElementById('termsButtonText');
                const buttonLoading = document.getElementById('termsButtonLoading');
                
                buttonText.classList.add('hidden');
                buttonLoading.classList.remove('hidden');
                
                setTimeout(() => {
                    buttonLoading.classList.add('hidden');
                    buttonText.classList.remove('hidden');
                    understandTerms.disabled = true;
                }, 1000);
            });

            // Close modal when clicking overlay
            modalOverlays.forEach(overlay => {
                overlay.addEventListener("click", function(e) {
                    if (e.target === this) {
                        const modal = this.closest('.fixed.inset-0');
                        if (modal) closeModal(modal);
                    }
                });
            });

            // Close modal with Escape key
            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape") {
                    if (!privacyModal.classList.contains("hidden")) {
                        closeModal(privacyModal);
                    } else if (!termsModal.classList.contains("hidden")) {
                        closeModal(termsModal);
                    }
                }
            });

            // Password Toggle Functions
            const setupToggle = (button, input) => {
                if (!button || !input) return;
                button.addEventListener("click", () => {
                    const icon = button.querySelector("i");
                    const pwdVisible = input.type === "text";
                    input.type = pwdVisible ? "password" : "text";
                    icon.classList.toggle("fa-eye");
                    icon.classList.toggle("fa-eye-slash");
                });
            };

            setupToggle(passwordToggle, passwordInput);
            setupToggle(passwordConfirmToggle, passwordConfirmInput);

            // Password Strength Check
            const updateStrength = () => {
                const bar = document.getElementById("password-strength");
                if (!passwordInput || !bar) return;

                const pwd = passwordInput.value;
                bar.className = "password-strength";

                const len = document.getElementById("length");
                const up = document.getElementById("uppercase");
                const num = document.getElementById("number");

                const hasLen = pwd.length >= 8;
                const hasUp = /[A-Z]/.test(pwd);
                const hasNum = /[0-9]/.test(pwd);
                const hasSpec = /[!@#$%^&*(),.?":{}|<>]/.test(pwd);

                len.innerHTML = `<i class="fas fa-${hasLen ? "check text-green-500" : "times text-red-500"} mr-1"></i>Minimal 8 karakter`;
                up.innerHTML = `<i class="fas fa-${hasUp ? "check text-green-500" : "times text-red-500"} mr-1"></i>Satu huruf besar`;
                num.innerHTML = `<i class="fas fa-${hasNum ? "check text-green-500" : "times text-red-500"} mr-1"></i>Satu angka`;

                if (!pwd.length) return;

                let score = 0;
                if (hasLen) score++;
                if (hasUp) score++;
                if (hasNum) score++;
                if (hasSpec) score++;

                if (score === 1) bar.classList.add("strength-weak");
                else if (score === 2) bar.classList.add("strength-medium");
                else if (score === 3) bar.classList.add("strength-strong");
                else if (score >= 4) bar.classList.add("strength-very-strong");

                checkMatch();
            };

            // Password Match Check
            const checkMatch = () => {
                const match = document.getElementById("password-match");
                const mismatch = document.getElementById("password-mismatch");

                if (!match || !mismatch) return;
                const pwd = passwordInput?.value || "";
                const conf = passwordConfirmInput?.value || "";

                if (!conf.length) {
                    match.classList.add("hidden");
                    mismatch.classList.add("hidden");
                    return;
                }

                if (pwd === conf) {
                    match.classList.remove("hidden");
                    mismatch.classList.add("hidden");
                } else {
                    match.classList.add("hidden");
                    mismatch.classList.remove("hidden");
                }
            };

            passwordInput?.addEventListener("input", updateStrength);
            passwordConfirmInput?.addEventListener("input", checkMatch);

            // Form submission handling
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                const submitText = document.getElementById('submitText');
                const submitLoading = document.getElementById('submitLoading');
                
                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                
                // Basic client-side validation
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;
                const terms = document.querySelector('input[name="terms"]').checked;
                
                let hasError = false;

                if (!name) {
                    document.getElementById('name').classList.add('input-error', 'shake');
                    hasError = true;
                }
                if (!email) {
                    document.getElementById('email').classList.add('input-error', 'shake');
                    hasError = true;
                }
                if (!password) {
                    document.getElementById('password').classList.add('input-error', 'shake');
                    hasError = true;
                }
                if (!passwordConfirm) {
                    document.getElementById('password_confirmation').classList.add('input-error', 'shake');
                    hasError = true;
                }
                if (password !== passwordConfirm) {
                    document.getElementById('password_confirmation').classList.add('input-error', 'shake');
                    hasError = true;
                }
                if (!terms) {
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                    
                    // Reset loading state
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        submitLoading.classList.add('hidden');
                        
                        // Remove shake animation after it completes
                        setTimeout(() => {
                            document.querySelectorAll('.shake').forEach(el => {
                                el.classList.remove('shake');
                            });
                        }, 500);
                    }, 1000);
                }
            });

            // Real-time validation
            document.getElementById('name').addEventListener('input', function() {
                this.classList.remove('input-error', 'shake');
            });

            document.getElementById('email').addEventListener('input', function() {
                this.classList.remove('input-error', 'shake');
            });

            document.getElementById('password').addEventListener('input', function() {
                this.classList.remove('input-error', 'shake');
            });

            document.getElementById('password_confirmation').addEventListener('input', function() {
                this.classList.remove('input-error', 'shake');
            });

            // Add breathing animation to wellness elements
            const wellnessIcons = document.querySelectorAll('.breathe');
            wellnessIcons.forEach((icon, index) => {
                icon.style.animationDelay = `${index * 0.5}s`;
            });

            // Auto-remove success/error messages after 5 seconds
            setTimeout(() => {
                const messages = document.querySelectorAll('[class*="alert-"]');
                messages.forEach(message => {
                    message.style.opacity = '0';
                    message.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => message.remove(), 500);
                });
            }, 5000);

            // Add Duolingo-style interactions to all duo elements
            document.querySelectorAll('.app-button, .card, .form-input').forEach(element => {
                element.addEventListener('mousedown', function() {
                    if (this.classList.contains('app-button') || this.classList.contains('card')) {
                        this.style.transform = 'translateY(2px)';
                        this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                    }
                });
                
                element.addEventListener('mouseup', function() {
                    if (this.classList.contains('app-button') || this.classList.contains('card')) {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = this.classList.contains('app-button') ? '0 4px 0 #45b259' : '0 4px 0 rgba(0, 0, 0, 0.1)';
                    }
                });
                
                element.addEventListener('mouseleave', function() {
                    if (this.classList.contains('app-button') || this.classList.contains('card')) {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = this.classList.contains('app-button') ? '0 4px 0 #45b259' : '0 4px 0 rgba(0, 0, 0, 0.1)';
                    }
                });
            });

            // Initialize form state
            updateFormState();
        });
    </script>
</body>
</html>