<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tenang</title>
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
                        },
                        // Social Media Colors
                        social: {
                            google: '#DB4437',
                            facebook: '#1877F2',
                            google_hover: '#c23321',
                            facebook_hover: '#166fe5',
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

        /* Social Button Animations */
        .social-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
            border: 2px solid #e9ecef;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        }

        .social-btn:active {
            transform: translateY(1px);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .social-btn:hover::before {
            left: 100%;
        }

        /* Loading Section Styles */
        #loading-section {
            transition: opacity 0.3s ease-in-out;
        }

        .loading-dots .dot {
            display: inline-block;
            animation: dot-pulse 1.5s infinite ease-in-out;
        }
        
        .loading-dots .dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .loading-dots .dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes dot-pulse {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        
        /* Animasi progress bar */
        .progress-animation {
            animation: progress-grow 3s forwards ease-in-out;
            width: 0%;
        }
        
        @keyframes progress-grow {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 95%; }
        }
        
        /* Progress indicators */
        .duo-progress {
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
        }

        .duo-progress-fill {
            height: 100%;
            background: #58cc70;
            border-radius: 6px;
            transition: width 0.5s ease;
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
        <!-- Left Panel - Visualization (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-8 lg:p-12 flex-col justify-between relative overflow-hidden">
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
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6">Selamat Datang Kembali</h1>
                    <p class="text-xl opacity-90 mb-8">
                        Lanjutkan perjalanan kesehatan mentalmu dengan pelacakan personal dan aktivitas mindfulness.
                    </p>
                    
                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe">
                                <i class="fas fa-heartbeat text-white"></i>
                            </div>
                            <span>Pelacakan Mood & Analitik</span>
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

        <!-- Right Panel - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative">
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
                <!-- Login Form Container -->
                <div class="card p-8 fade-in-up">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4 breathe">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-neutral-800 mb-2">Selamat Datang</h2>
                        <p class="text-neutral-600">Masuk untuk melanjutkan perjalananmu</p>
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

                    <!-- Form menggunakan route login yang sesuai -->
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

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
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    class="w-full pl-10 pr-4 py-3 form-input @error('email') input-error @enderror"
                                    placeholder="Masukkan email Anda">
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
                                <input 
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full pl-10 pr-10 py-3 form-input @error('password') input-error @enderror"
                                    placeholder="Masukkan kata sandi Anda">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                                    <i class="fas fa-eye-slash text-neutral-400 hover:text-neutral-600"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="remember"
                                    class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <span class="ml-2 text-sm text-neutral-600">Ingat saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium transition-colors">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            id="submitBtn"
                            class="w-full app-button py-3 px-4 mb-6 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submitText">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk ke Tenang
                            </span>
                            <span id="submitLoading" class="hidden">
                                <i class="fas fa-spinner loading-spinner mr-2"></i>
                                Sedang masuk...
                            </span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center mb-6">
                        <div class="flex-1 border-t border-neutral-300"></div>
                        <span class="px-3 text-neutral-500 text-sm">Atau masuk dengan</span>
                        <div class="flex-1 border-t border-neutral-300"></div>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="space-y-3 mb-6">
                        <!-- Google Login Button -->
                        <a href="" class="w-full social-btn bg-white text-neutral-700 py-3 px-4 font-medium flex items-center justify-center">
                            <div class="w-5 h-5 flex items-center justify-center mr-3">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M16.51 9.20455V9.10045H9.18V10.8995H13.49C13.12 12.6995 11.62 13.8995 9.18 13.8995C6.43 13.8995 4.18 11.6645 4.18 8.91445C4.18 6.16445 6.43 3.92945 9.18 3.92945C10.39 3.92945 11.5 4.34945 12.37 5.17945L14.43 3.11945C13.02 1.70445 11.18 0.999545 9.18 0.999545C4.19 0.999545 0.18 4.99955 0.18 9.99955C0.18 14.9995 4.19 18.9995 9.18 18.9995C13.69 18.9995 17.18 15.8995 17.18 10.9995C17.18 10.5995 16.86 10.2045 16.51 10.2045V9.20455Z" fill="#EA4335"/>
                                    <path d="M1.18 5.31955L3.73 7.15955C4.36 5.23955 6.58 3.92955 9.18 3.92955C10.39 3.92955 11.5 4.34955 12.37 5.17955L14.43 3.11955C13.02 1.70455 11.18 0.999545 9.18 0.999545C5.69 0.999545 2.73 2.79955 1.18 5.31955Z" fill="#FBBC05"/>
                                    <path d="M9.18 18.9995C11.11 18.9995 12.89 18.2995 14.31 17.0995L11.87 15.0495C11.06 15.6495 10.03 16.0295 9.18 16.0295C6.78 16.0295 4.76 14.4695 3.94 12.2695L1.39 14.1895C2.93 16.8995 5.83 18.9995 9.18 18.9995Z" fill="#34A853"/>
                                    <path d="M16.51 9.20455V9.10045H9.18V10.8995H13.49C13.17 12.2495 12.19 13.2995 10.95 13.8995L13.42 15.8495C15.27 14.0995 16.51 11.4995 16.51 9.20455Z" fill="#4285F4"/>
                                </svg>
                            </div>
                            <span>Lanjutkan dengan Google</span>
                        </a>

                        <!-- Facebook Login Button -->
                        <a href="" class="w-full social-btn bg-social-facebook text-white py-3 px-4 font-medium flex items-center justify-center">
                            <i class="fab fa-facebook-f mr-3"></i>
                            <span>Lanjutkan dengan Facebook</span>
                        </a>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center">
                        <p class="text-neutral-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelector('.password-toggle').addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });

            // Form submission handling
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                const submitText = document.getElementById('submitText');
                const submitLoading = document.getElementById('submitLoading');
                
                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                
                // Basic client-side validation
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                
                if (!email || !password) {
                    e.preventDefault();
                    
                    // Show error message
                    if (!email) {
                        document.getElementById('email').classList.add('input-error', 'shake');
                    }
                    if (!password) {
                        document.getElementById('password').classList.add('input-error', 'shake');
                    }
                    
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
            document.getElementById('email').addEventListener('input', function() {
                this.classList.remove('input-error', 'shake');
            });

            document.getElementById('password').addEventListener('input', function() {
                this.classList.remove('input-error', 'shake');
            });

            // Add breathing animation to wellness elements
            const wellnessIcons = document.querySelectorAll('.breathe');
            wellnessIcons.forEach((icon, index) => {
                icon.style.animationDelay = `${index * 0.5}s`;
            });

            // Add Duolingo-style interactions to all duo elements
            document.querySelectorAll('.app-button, .card, .social-btn').forEach(element => {
                element.addEventListener('mousedown', function() {
                    if (this.classList.contains('app-button') || this.classList.contains('card') || this.classList.contains('social-btn')) {
                        this.style.transform = 'translateY(2px)';
                        if (this.classList.contains('app-button') || this.classList.contains('social-btn')) {
                            this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                        }
                    }
                });
                
                element.addEventListener('mouseup', function() {
                    if (this.classList.contains('app-button') || this.classList.contains('card') || this.classList.contains('social-btn')) {
                        this.style.transform = 'translateY(0)';
                        if (this.classList.contains('app-button')) {
                            this.style.boxShadow = '0 4px 0 #45b259';
                        } else if (this.classList.contains('social-btn')) {
                            this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                        }
                    }
                });
                
                element.addEventListener('mouseleave', function() {
                    if (this.classList.contains('app-button') || this.classList.contains('card') || this.classList.contains('social-btn')) {
                        this.style.transform = 'translateY(0)';
                        if (this.classList.contains('app-button')) {
                            this.style.boxShadow = '0 4px 0 #45b259';
                        } else if (this.classList.contains('social-btn')) {
                            this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                        }
                    }
                });
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
        });
    </script>
</body>
</html>