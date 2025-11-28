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
                        // Primary Green Palette - calming and soothing
                        primary: {
                            50: '#f0f9f0',
                            100: '#dcf2dc',
                            200: '#bce5bc',
                            300: '#8fd18f',
                            400: '#5cb85c',
                            500: '#4caf50', // Main brand color
                            600: '#3d8b40',
                            700: '#2e6b34',
                            800: '#25572a',
                            900: '#1e4621',
                        },
                        // Secondary Teal Palette - complementary calming colors
                        secondary: {
                            50: '#f0fdfa',
                            100: '#ccfbef',
                            200: '#99f6e0',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        // Accent colors for gamification
                        accent: {
                            gold: '#ffd700',
                            silver: '#c0c0c0',
                            bronze: '#cd7f32',
                            diamond: '#b9f2ff',
                        },
                        // Neutral colors for text and backgrounds
                        neutral: {
                            50: '#fafdf9',
                            100: '#f5f9f3',
                            200: '#e8f0e5',
                            300: '#d4e2d0',
                            400: '#aec5a8',
                            500: '#8ba886',
                            600: '#6a8a65',
                            700: '#546e50',
                            800: '#40573d',
                            900: '#2f3f2d',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'breathe': 'breathe 4s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'shake': 'shake 0.5s ease-in-out',
                    },
                    keyframes: {
                        breathe: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        shake: {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '25%': { transform: 'translateX(-5px)' },
                            '75%': { transform: 'translateX(5px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafdf9; /* neutral-50 */
        }

        .login-bg {
            background: linear-gradient(135deg, #f0f9f0 0%, #dcf2dc 100%);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(46, 107, 52, 0.1), 0 2px 4px -1px rgba(46, 107, 52, 0.06);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 242, 220, 0.3);
        }

        .gradient-primary {
            background: linear-gradient(135deg, #4caf50 0%, #2e6b34 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        }

        .gradient-calm {
            background: linear-gradient(135deg, #f0f9f0 0%, #dcf2dc 100%);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
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

        /* Loading animation */
        .loading-dots {
            display: inline-block;
        }

        .loading-dots:after {
            content: '...';
            animation: dots 1.5s steps(4, end) infinite;
        }

        @keyframes dots {
            0%, 20% {
                color: rgba(0, 0, 0, 0);
                text-shadow:
                    .25em 0 0 rgba(0, 0, 0, 0),
                    .5em 0 0 rgba(0, 0, 0, 0);
            }
            40% {
                color: white;
                text-shadow:
                    .25em 0 0 rgba(0, 0, 0, 0),
                    .5em 0 0 rgba(0, 0, 0, 0);
            }
            60% {
                text-shadow:
                    .25em 0 0 white,
                    .5em 0 0 rgba(0, 0, 0, 0);
            }
            80%, 100% {
                text-shadow:
                    .25em 0 0 white,
                    .5em 0 0 white;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f9f0;
        }

        ::-webkit-scrollbar-thumb {
            background: #8fd18f;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #5cb85c;
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
    </style>
</head>
<body class="login-bg max-h-full overflow-hidden">
    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Left Panel - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative order-2 lg:order-1">
            <!-- Background untuk mobile -->
            <div class="lg:hidden absolute inset-0 gradient-primary -z-10 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full"></div>
                <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full"></div>
                <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full"></div>
                <div class="absolute bottom-40 right-10 w-12 h-12 bg-white rounded-full"></div>
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
                <div class="bg-white rounded-2xl p-8 card-shadow fade-in-up border border-neutral-200">
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
                        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm border border-green-200 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-lg text-sm border border-red-200 flex items-center shake">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-lg text-sm border border-red-200 shake">
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
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50 @error('name') input-error @enderror" placeholder="Masukkan nama lengkap Anda">
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
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50 @error('email') input-error @enderror" placeholder="Masukkan email Anda">
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
                                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50 @error('password') input-error @enderror" placeholder="Buat kata sandi">
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
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50" placeholder="Konfirmasi kata sandi Anda">
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
                                <input type="checkbox" name="terms" class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500 mt-1" required>
                                <span class="ml-2 text-sm text-neutral-600">
                                    Saya setuju dengan
                                    <button type="button" id="termsBtn" class="text-primary-600 hover:text-primary-700 underline font-medium transition-colors">Syarat Layanan</button>
                                    dan
                                    <button type="button" id="privacyBtn" class="text-primary-600 hover:text-primary-700 underline font-medium transition-colors">Kebijakan Privasi</button>
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

                            <button type="submit" id="submitBtn" class="px-6 py-3 gradient-primary text-white font-semibold rounded-lg hover:opacity-90 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed">
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
        <div class="hidden lg:flex lg:w-1/2 gradient-primary text-white p-8 lg:p-12 flex-col justify-between relative overflow-hidden order-1 lg:order-2">
            <!-- Background decorative elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
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
                                <i class="fas fa-heartbeat text-secondary-300"></i>
                            </div>
                            <span>Pelacakan Mood & Analitik Harian</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe" style="animation-delay: 0.5s;">
                                <i class="fas fa-book-open text-secondary-300"></i>
                            </div>
                            <span>Journaling Personal</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe" style="animation-delay: 1s;">
                                <i class="fas fa-medal text-secondary-300"></i>
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
            <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl modal-content">
                <!-- Header -->
                <div class="px-6 py-4 bg-primary-50 border-b border-primary-100">
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
                <div class="px-6 py-4 max-h-96 overflow-y-auto modal-scrollbar">
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
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-neutral-50 border-t border-neutral-200 flex justify-end">
                    <button id="understandPrivacy" class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Mengerti
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
            <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl modal-content">
                <!-- Header -->
                <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-100">
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
                <div class="px-6 py-4 max-h-96 overflow-y-auto modal-scrollbar">
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
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-neutral-50 border-t border-neutral-200 flex justify-end">
                    <button id="understandTerms" class="px-6 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
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

            // Password Elements
            const passwordInput = document.getElementById("password");
            const passwordConfirmInput = document.getElementById("password_confirmation");
            const passwordToggle = document.querySelector(".password-toggle");
            const passwordConfirmToggle = document.querySelector(".password-confirm-toggle");
            const submitBtn = document.getElementById("submitBtn");
            const submitText = document.getElementById("submitText");
            const submitLoading = document.getElementById("submitLoading");

            // Modal Functions
            function openModal(modal) {
                modal.classList.remove("hidden");
                document.body.style.overflow = "hidden";
                
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

            // Event Listeners for Modals
            privacyBtn.addEventListener("click", () => openModal(privacyModal));
            termsBtn.addEventListener("click", () => openModal(termsModal));

            closePrivacy.addEventListener("click", () => closeModal(privacyModal));
            closeTerms.addEventListener("click", () => closeModal(termsModal));
            understandPrivacy.addEventListener("click", () => closeModal(privacyModal));
            understandTerms.addEventListener("click", () => closeModal(termsModal));

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
                const messages = document.querySelectorAll('[class*="bg-"]');
                messages.forEach(message => {
                    if (message.classList.contains('bg-green-50') || message.classList.contains('bg-red-50')) {
                        message.style.opacity = '0';
                        message.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => message.remove(), 500);
                    }
                });
            }, 5000);
        });
    </script>
</body>
</html>