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
        
        /* Checkbox container style when clicking triggers modal */
        .checkbox-trigger-container {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .checkbox-trigger-container:hover {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 4px;
        }

        /* Loading dots */
        .loading-dots {
            display: inline-flex;
        }
        
        .loading-dots .dot {
            animation: dotPulse 1.5s infinite;
            opacity: 0;
        }
        
        .loading-dots .dot:nth-child(1) {
            animation-delay: 0s;
        }
        
        .loading-dots .dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .loading-dots .dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes dotPulse {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }
        
        /* Duolingo progress bar */
        .duo-progress-fill {
            transition: width 2s ease-in-out;
        }
        
        .progress-animation {
            animation: progressFill 2s ease-in-out infinite;
            width: 100%;
        }
        
        @keyframes progressFill {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        /* Tooltip untuk checkbox */
        .checkbox-tooltip {
            position: relative;
            display: inline-block;
        }
        
        .checkbox-tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }
        
        .checkbox-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        
        /* Custom untuk modal triggers */
        .checkbox-modal-trigger {
            cursor: pointer;
        }
        
        .checkbox-modal-trigger:disabled {
            cursor: not-allowed;
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
                            <div class="checkbox-trigger-container">
                                <label class="flex items-start cursor-pointer">
                                    <div class="checkbox-tooltip relative">
                                        <input type="checkbox" name="terms" id="termsCheckbox" 
                                               class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500 mt-1 checkbox-modal-trigger" 
                                               disabled>
                                        <span class="tooltip-text">Klik untuk membaca Syarat Layanan & Kebijakan Privasi</span>
                                    </div>
                                    <span class="ml-2 text-sm text-neutral-600">
                                        Saya setuju dengan
                                        <button type="button" id="policyBtn" class="text-primary-600 hover:text-primary-700 underline font-medium transition-colors">Syarat Layanan & Kebijakan Privasi</button>
                                        <span id="termsStatus" class="text-xs text-orange-500 ml-2">
                                            (Harap baca dokumen terlebih dahulu)
                                        </span>
                                        <span id="termsConfirmed" class="text-xs text-green-500 ml-2 hidden">
                                            <i class="fas fa-check mr-1"></i>Sudah dibaca dan disetujui
                                        </span>
                                    </span>
                                </label>
                            </div>
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

    <!-- Combined Policy Modal (Syarat Layanan & Kebijakan Privasi) -->
    <div id="policyModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-neutral-500 bg-opacity-75 modal-overlay"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform card modal-content">
                <!-- Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-primary-50 to-secondary-50 border-b border-primary-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-file-contract text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-neutral-800">Syarat Layanan & Kebijakan Privasi</h3>
                                <p class="text-sm text-neutral-600">Terakhir diperbarui: {{ date('d M Y') }}</p>
                            </div>
                        </div>
                        <button id="closePolicy" class="w-8 h-8 rounded-full hover:bg-neutral-100 flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-neutral-500"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 py-4 max-h-96 overflow-y-auto modal-scrollbar" id="policyContent">
                    <div class="prose prose-sm max-w-none">
                        <!-- Introduction -->
                        <h4 class="text-lg font-semibold text-primary-700 mb-3">1. Pengantar dan Penerimaan</h4>
                        <p class="text-neutral-700 mb-4">
                            Dengan mendaftar dan menggunakan layanan Tenang, Anda menyetujui semua syarat layanan dan ketentuan privasi yang tercantum di bawah ini. Mohon baca dokumen ini dengan seksama sebelum menggunakan layanan kami.
                        </p>

                        <!-- Syarat Layanan Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-primary-700 mb-3">2. Syarat Layanan</h4>
                            
                            <h5 class="font-medium text-neutral-800 mb-2">2.1. Akun Pengguna</h5>
                            <p class="text-neutral-700 mb-3">
                                Saat membuat akun, Anda setuju untuk:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Menyediakan informasi yang akurat, lengkap, dan terkini</li>
                                <li>Menjaga kerahasiaan informasi akun dan password</li>
                                <li>Bertanggung jawab penuh atas semua aktivitas yang terjadi di akun Anda</li>
                                <li>Segera melaporkan aktivitas mencurigakan atau pelanggaran keamanan</li>
                                <li>Memastikan Anda berusia minimal 13 tahun (atau sesuai ketentuan hukum setempat)</li>
                            </ul>

                            <h5 class="font-medium text-neutral-800 mb-2">2.2. Penggunaan Layanan</h5>
                            <p class="text-neutral-700 mb-3">
                                Anda setuju untuk menggunakan layanan Tenang secara bertanggung jawab dan tidak:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Menyalahgunakan layanan untuk tujuan ilegal, berbahaya, atau tidak sah</li>
                                <li>Mengganggu atau mencoba mengganggu operasional layanan</li>
                                <li>Mencoba mengakses data pengguna lain tanpa izin</li>
                                <li>Menyebarkan malware, virus, atau kode berbahaya</li>
                                <li>Melakukan scraping atau pengumpulan data otomatis</li>
                                <li>Melanggar hak kekayaan intelektual orang lain</li>
                                <li>Menyebarkan konten yang bersifat ujaran kebencian, diskriminatif, atau tidak pantas</li>
                            </ul>

                            <h5 class="font-medium text-neutral-800 mb-2">2.3. Batasan Layanan</h5>
                            <p class="text-neutral-700 mb-3">
                                <strong class="text-red-500">Penting:</strong> Tenang adalah alat pendukung kesehatan mental dan <strong>bukan pengganti perawatan medis profesional</strong>. Layanan kami tidak memberikan diagnosis medis, pengobatan, atau terapi pengganti.
                            </p>
                            <p class="text-neutral-700 mb-3">
                                Dalam keadaan darurat medis atau krisis kesehatan mental, segera hubungi:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Layanan darurat setempat (119)</li>
                                <li>Dokter atau profesional kesehatan mental</li>
                                <li>Layanan crisis helpline</li>
                            </ul>
                        </div>

                        <!-- Kebijakan Privasi Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-primary-700 mb-3">3. Kebijakan Privasi</h4>
                            
                            <h5 class="font-medium text-neutral-800 mb-2">3.1. Informasi yang Kami Kumpulkan</h5>
                            <p class="text-neutral-700 mb-3">
                                Kami mengumpulkan informasi yang Anda berikan secara langsung saat mendaftar dan menggunakan layanan Tenang, termasuk:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Data pribadi (nama, email)</li>
                                <li>Data kesehatan mental (mood, journal entries) - disimpan secara terenkripsi</li>
                                <li>Data penggunaan aplikasi</li>
                                <li>Informasi teknis (perangkat, browser, IP address)</li>
                            </ul>

                            <h5 class="font-medium text-neutral-800 mb-2">3.2. Penggunaan Informasi</h5>
                            <p class="text-neutral-700 mb-3">
                                Informasi yang kami kumpulkan digunakan untuk:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Menyediakan dan mempersonalisasi layanan</li>
                                <li>Meningkatkan kualitas layanan dan pengalaman pengguna</li>
                                <li>Analisis tren kesehatan mental yang anonym</li>
                                <li>Komunikasi terkait layanan dan pembaruan</li>
                                <li>Memastikan keamanan akun Anda</li>
                            </ul>

                            <h5 class="font-medium text-neutral-800 mb-2">3.3. Perlindungan Data</h5>
                            <p class="text-neutral-700 mb-3">
                                Kami menerapkan standar keamanan tinggi untuk melindungi data Anda:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Semua data disimpan secara terenkripsi</li>
                                <li>Akses data dibatasi hanya untuk pihak yang berwenang</li>
                                <li>Protokol keamanan mengikuti standar industri</li>
                                <li>Audit keamanan berkala</li>
                            </ul>

                            <h5 class="font-medium text-neutral-800 mb-2">3.4. Berbagi Informasi</h5>
                            <p class="text-neutral-700 mb-3">
                                Kami tidak menjual atau menyewakan data pribadi Anda. Informasi dapat dibagikan hanya dalam kondisi:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Dengan persetujuan eksplisit dari Anda</li>
                                <li>Untuk mematuhi kewajiban hukum</li>
                                <li>Melindungi hak dan keselamatan pengguna lain</li>
                                <li>Dengan penyedia layanan yang membantu operasional kami (dengan kontrak kerahasiaan)</li>
                            </ul>
                        </div>

                        <!-- Hak Pengguna Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-primary-700 mb-3">4. Hak Anda</h4>
                            <p class="text-neutral-700 mb-3">
                                Sebagai pengguna Tenang, Anda memiliki hak untuk:
                            </p>
                            <ul class="list-disc list-inside text-neutral-700 mb-4 space-y-1 ml-4">
                                <li>Mengakses data pribadi Anda</li>
                                <li>Memperbaiki data yang tidak akurat</li>
                                <li>Menghapus data pribadi (hak untuk dilupakan)</li>
                                <li>Membatasi pemrosesan data</li>
                                <li>Menerima salinan data dalam format terstruktur</li>
                                <li>Menarik persetujuan pemrosesan data kapan saja</li>
                            </ul>
                        </div>

                        <!-- Ketentuan Umum -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-primary-700 mb-3">5. Ketentuan Umum</h4>
                            
                            <h5 class="font-medium text-neutral-800 mb-2">5.1. Penyimpanan Data</h5>
                            <p class="text-neutral-700 mb-3">
                                Data disimpan selama diperlukan untuk menyediakan layanan atau sesuai dengan ketentuan hukum. Anda dapat meminta penghapusan data kapan saja melalui pengaturan akun atau dengan menghubungi kami.
                            </p>

                            <h5 class="font-medium text-neutral-800 mb-2">5.2. Perubahan Syarat</h5>
                            <p class="text-neutral-700 mb-3">
                                Kami berhak mengubah syarat layanan dan kebijakan privasi kapan saja. Perubahan signifikan akan diumumkan melalui aplikasi, email, atau notifikasi lainnya. Penggunaan berkelanjutan setelah perubahan berarti penerimaan Anda terhadap syarat baru.
                            </p>

                            <h5 class="font-medium text-neutral-800 mb-2">5.3. Hukum yang Berlaku</h5>
                            <p class="text-neutral-700 mb-3">
                                Syarat layanan dan kebijakan privasi ini diatur oleh hukum Indonesia. Setiap sengketa akan diselesaikan di pengadilan yang berwenang di Indonesia.
                            </p>

                            <h5 class="font-medium text-neutral-800 mb-2">5.4. Kontak</h5>
                            <p class="text-neutral-700">
                                Untuk pertanyaan tentang kebijakan privasi, syarat layanan, atau penggunaan data, hubungi kami di <strong class="text-primary-600">privacy@tenang.com</strong>.
                            </p>
                        </div>

                        <!-- Komitmen Section -->
                        <div class="mt-8 pt-8 border-t border-neutral-200">
                            <h4 class="text-lg font-semibold text-primary-700 mb-3">6. Komitmen Kami</h4>
                            <p class="text-neutral-700 mb-4">
                                Kami berkomitmen untuk melindungi privasi Anda dan memastikan bahwa data pribadi Anda dikelola dengan transparansi dan tanggung jawab. Tenang dirancang sebagai ruang yang aman dan mendukung untuk perjalanan kesehatan mental Anda.
                            </p>
                            <p class="text-neutral-700">
                                Dengan menyetujui dokumen ini, Anda menjadi bagian dari komunitas yang peduli dengan kesehatan mental dan kesejahteraan bersama.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reading Progress -->
                <div class="reading-progress">
                    <div id="policyProgress" class="reading-progress-fill"></div>
                </div>

                <!-- Scroll Indicator -->
                <div id="policyScrollIndicator" class="scroll-indicator">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Scroll ke bawah untuk melanjutkan membaca
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-neutral-50 border-t border-neutral-200 flex justify-end">
                    <button id="understandPolicy" class="app-button px-6 py-2" disabled>
                        <span id="policyButtonText">Saya Mengerti & Menyetujui</span>
                        <span id="policyButtonLoading" class="hidden">
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
            let policyRead = false;

            // Modal Elements
            const policyModal = document.getElementById("policyModal");
            const policyBtn = document.getElementById("policyBtn");
            const closePolicy = document.getElementById("closePolicy");
            const understandPolicy = document.getElementById("understandPolicy");
            const modalOverlay = document.querySelector(".modal-overlay");

            // Form Elements
            const termsCheckbox = document.getElementById("termsCheckbox");
            const termsStatus = document.getElementById("termsStatus");
            const termsConfirmed = document.getElementById("termsConfirmed");
            const submitBtn = document.getElementById("submitBtn");
            const checkboxContainer = document.querySelector('.checkbox-trigger-container');

            // Password Elements
            const passwordInput = document.getElementById("password");
            const passwordConfirmInput = document.getElementById("password_confirmation");
            const passwordToggle = document.querySelector(".password-toggle");
            const passwordConfirmToggle = document.querySelector(".password-confirm-toggle");
            const submitText = document.getElementById("submitText");
            const submitLoading = document.getElementById("submitLoading");

            // Update form state based on reading status
            function updateFormState() {
                if (policyRead) {
                    termsCheckbox.disabled = false;
                    termsCheckbox.checked = true;
                    termsStatus.classList.add('hidden');
                    termsConfirmed.classList.remove('hidden');
                    termsCheckbox.classList.add('checkbox-confirmed');
                    submitBtn.disabled = false;
                    
                    // Change cursor back to default
                    checkboxContainer.style.cursor = 'default';
                    checkboxContainer.classList.remove('checkbox-trigger-container');
                } else {
                    termsStatus.classList.remove('hidden');
                    termsConfirmed.classList.add('hidden');
                    termsCheckbox.disabled = true;
                    termsCheckbox.checked = false;
                    submitBtn.disabled = true;
                    
                    // Ensure checkbox container is clickable
                    checkboxContainer.style.cursor = 'pointer';
                    checkboxContainer.classList.add('checkbox-trigger-container');
                }
            }

            // Modal Functions
            function openModal() {
                policyModal.classList.remove("hidden");
                document.body.style.overflow = "hidden";
                
                // Reset scroll position
                const content = policyModal.querySelector('.modal-scrollbar');
                if (content) {
                    content.scrollTop = 0;
                    // Reset progress bar
                    document.getElementById('policyProgress').style.width = '0%';
                }
                
                // Reset understand button state
                understandPolicy.disabled = true;
                understandPolicy.classList.add('disabled:opacity-50');
                
                // Show scroll indicator initially
                document.getElementById('policyScrollIndicator').classList.remove('hidden');
                
                // Trigger animation
                setTimeout(() => {
                    const overlay = policyModal.querySelector(".modal-overlay");
                    const content = policyModal.querySelector(".modal-content");
                    overlay.classList.add("overlay-enter-active");
                    content.classList.add("modal-enter-active");
                }, 10);
            }

            function closeModal() {
                const overlay = policyModal.querySelector(".modal-overlay");
                const content = policyModal.querySelector(".modal-content");
                
                overlay.classList.remove("overlay-enter-active");
                content.classList.remove("modal-enter-active");
                
                overlay.classList.add("overlay-leave-active");
                content.classList.add("modal-leave-active");
                
                setTimeout(() => {
                    policyModal.classList.add("hidden");
                    document.body.style.overflow = "";
                    overlay.classList.remove("overlay-leave-active");
                    content.classList.remove("modal-leave-active");
                }, 200);
            }

            // Scroll detection for modal
            function setupScrollDetection() {
                const content = policyModal.querySelector('.modal-scrollbar');
                if (!content) return;

                content.addEventListener('scroll', function() {
                    const scrollTop = content.scrollTop;
                    const scrollHeight = content.scrollHeight;
                    const clientHeight = content.clientHeight;
                    const scrollPercentage = (scrollTop / (scrollHeight - clientHeight)) * 100;

                    // Update progress bar
                    const progressBar = document.getElementById('policyProgress');
                    if (progressBar) {
                        progressBar.style.width = `${Math.min(scrollPercentage, 100)}%`;
                    }

                    // Show/hide scroll indicator
                    const scrollIndicator = document.getElementById('policyScrollIndicator');
                    if (scrollIndicator) {
                        if (scrollPercentage > 80) {
                            scrollIndicator.classList.add('hidden');
                        } else if (scrollPercentage > 10) {
                            scrollIndicator.classList.remove('hidden');
                        }
                    }

                    // Enable understand button when scrolled to bottom
                    if (understandPolicy && scrollPercentage >= 95) {
                        understandPolicy.disabled = false;
                        understandPolicy.classList.remove('disabled:opacity-50');
                    }
                });
            }

            // Event Listeners for Modal
            // 1. Click on the "Syarat Layanan & Kebijakan Privasi" text link
            policyBtn.addEventListener("click", () => {
                openModal();
                setupScrollDetection();
            });

            // 2. Click on checkbox container (label and checkbox area)
            checkboxContainer.addEventListener("click", (e) => {
                // Prevent the default checkbox behavior when it's disabled
                e.preventDefault();
                e.stopPropagation();
                
                // Only open modal if policy hasn't been read yet
                if (!policyRead) {
                    openModal();
                    setupScrollDetection();
                }
            });

            // 3. Click directly on the checkbox
            termsCheckbox.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                if (!policyRead) {
                    openModal();
                    setupScrollDetection();
                }
            });

            // 4. Close modal button
            closePolicy.addEventListener("click", () => closeModal());

            // 5. Understand button handler
            understandPolicy.addEventListener("click", () => {
                policyRead = true;
                updateFormState();
                
                // Show confirmation animation
                const buttonText = document.getElementById('policyButtonText');
                const buttonLoading = document.getElementById('policyButtonLoading');
                
                buttonText.classList.add('hidden');
                buttonLoading.classList.remove('hidden');
                
                setTimeout(() => {
                    closeModal();
                    buttonLoading.classList.add('hidden');
                    buttonText.classList.remove('hidden');
                    understandPolicy.disabled = true;
                    understandPolicy.classList.add('disabled:opacity-50');
                }, 800);
            });

            // 6. Close modal when clicking overlay
            modalOverlay.addEventListener("click", function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // 7. Close modal with Escape key
            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape" && !policyModal.classList.contains("hidden")) {
                    closeModal();
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
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>