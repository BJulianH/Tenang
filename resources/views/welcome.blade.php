<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenang - Teman Kesehatan Mental Anda</title>
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
                        'fadeInDown': 'fadeInDown 0.8s ease-out',
                        'fadeInLeft': 'fadeInLeft 0.8s ease-out',
                        'fadeInRight': 'fadeInRight 0.8s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'breathe': 'breathe 4s ease-in-out infinite',
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
                        'fadeInDown': {
                            'from': {
                                opacity: '0',
                                transform: 'translateY(-30px)',
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateY(0)',
                            }
                        },
                        'fadeInLeft': {
                            'from': {
                                opacity: '0',
                                transform: 'translateX(-30px)',
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateX(0)',
                            }
                        },
                        'fadeInRight': {
                            'from': {
                                opacity: '0',
                                transform: 'translateX(30px)',
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateX(0)',
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        'breathe': {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
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
            scroll-behavior: smooth;
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

        .gamification-badge {
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 3px solid white;
        }

        .gamification-badge:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        }
        .gamification-badge:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        /* Loading Section Styles */
        #loading-section {
            transition: opacity 0.3s ease-in-out;
        }

        .loading-gif {
            width: 100px;
            height: 100px;
        }

        .loading-text {
            color: #6c757d;
            font-size: 1.125rem;
            font-weight: 500;
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
        
        /* Animasi khusus untuk loading section */
        #loading-section {
            backdrop-filter: blur(8px);
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

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .fade-in-down {
            animation: fadeInDown 0.8s ease-out;
        }

        .fade-in-left {
            animation: fadeInLeft 0.8s ease-out;
        }

        .fade-in-right {
            animation: fadeInRight 0.8s ease-out;
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .breathe {
            animation: breathe 4s ease-in-out infinite;
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

        /* Developer Card Styles */
        .developer-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .developer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #58cc70 0%, #ffc800 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .developer-card:hover::before {
            transform: scaleX(1);
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="bg-neutral-50">
    <!-- Loading Section -->
    <div id="loading-section" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-all duration-500">
        <div class="text-center">
            <!-- Container dengan efek kartu Duolingo -->
            <div class="bg-white rounded-duo-xl p-8 shadow-duo-lg border-4 border-primary-100 transform transition-all duration-300 hover:scale-105">
                <!-- Gif dengan frame dekoratif -->
                <div class="relative mb-6">
                    <div class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-sm opacity-50 animate-pulse"></div>
                    <div class="relative bg-white rounded-full p-3 shadow-duo border-2 border-primary-300">
                        <div class="mx-auto w-28 h-28 rounded-full bg-primary-100 flex items-center justify-center">
                            <i class="fas fa-peace text-primary-500 text-4xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Teks loading dengan animasi -->
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-neutral-800">Tenang</h3>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <header class="flex justify-between items-center mb-16">
            <div class="text-2xl font-bold text-primary-700 flex items-center">
                <i class="fas fa-peace mr-2 text-primary-500"></i>
                Tenang
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">Beranda</a>
                <a href="#" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">Fitur</a>
                <a href="#" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">Journal</a>
                <a href="#" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">Sumber Daya</a>
                <a href="#about" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors about-link">Tentang</a>
            </nav>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 text-primary-600 font-medium border border-primary-500 rounded-duo transition-all duration-300 hover:bg-primary-50">
                    Masuk
                </a>
                <a href="{{ route('register') }}">
                    <button class="app-button px-4 py-2">
                        Mulai Sekarang
                    </button>
                </a>
            </div>
        </header>

        <!-- Session Messages -->
        @if(session('status'))
            <div class="mb-6 p-4 alert-success rounded-lg border flex items-center fade-in-up">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 alert-error rounded-lg border flex items-center shake">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 alert-error rounded-lg border shake">
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

        <!-- Main Content -->
        <main class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-[70vh]">
            <!-- Text Content -->
            <div class="space-y-8 fade-in-left">
                <div class="space-y-4">
                    <h1 class="text-5xl lg:text-6xl font-bold text-neutral-800 leading-tight">
                        Teman Kesehatan
                        <span class="gradient-text">Mental</span>
                        Anda
                    </h1>
                    <h2 class="text-2xl lg:text-3xl text-secondary-600 font-medium">
                        Perjalanan menuju mindfulness dimulai di sini
                    </h2>
                </div>

                <p class="text-lg text-neutral-600 leading-relaxed">
                    Lacak mood Anda, tuliskan pikiran dalam journal, dan temukan aktivitas kesehatan yang dipersonalisasi. 
                    Tenang membantu Anda membangun kebiasaan sehat dan menemukan keseimbangan dalam kehidupan sehari-hari 
                    melalui praktik mindfulness dan alat pendukung.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('register') }}">
                        <button class="app-button px-8 py-4 flex items-center">
                            Mulai Perjalanan Anda
                            <i class="fas fa-peace ml-3"></i>
                        </button>
                    </a>
                    <button class="px-8 py-4 bg-white text-primary-600 border border-primary-500 font-bold rounded-duo hover:bg-primary-50 transition-all flex items-center">
                        <i class="fas fa-play-circle mr-3"></i>
                        Lihat Demo
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-600">10K+</div>
                        <div class="text-sm text-neutral-500">Pengguna Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-secondary-600">95%</div>
                        <div class="text-sm text-neutral-500">Melaporkan Perbaikan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-500">4.9★</div>
                        <div class="text-sm text-neutral-500">Rating Pengguna</div>
                    </div>
                </div>
            </div>

            <!-- Illustration Section -->
            <div class="relative fade-in-right">
                <!-- Main Illustration Container -->
                <div class="relative z-10">
                    <div class="card p-8">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Mood Tracking Card -->
                            <div class="card p-6 bg-primary-50 border-primary-200 hover-lift">
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center mb-4 breathe">
                                    <i class="fas fa-heart text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-primary-700 mb-2">Pelacakan Mood</h3>
                                <p class="text-sm text-primary-600">Check-in emosional harian</p>
                            </div>
                            
                            <!-- Journal Card -->
                            <div class="card p-6 bg-secondary-50 border-secondary-200 hover-lift">
                                <div class="w-12 h-12 bg-secondary-500 rounded-full flex items-center justify-center mb-4 breathe" style="animation-delay: 0.5s;">
                                    <i class="fas fa-book text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-secondary-700 mb-2">Journal</h3>
                                <p class="text-sm text-secondary-600">Ekspresikan pikiran Anda</p>
                            </div>
                            
                            <!-- Meditation Card -->
                            <div class="card p-6 bg-primary-100 border-primary-300 hover-lift">
                                <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center mb-4 breathe" style="animation-delay: 1s;">
                                    <i class="fas fa-wind text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-primary-800 mb-2">Meditasi</h3>
                                <p class="text-sm text-primary-700">Latihan pernapasan mindfulness</p>
                            </div>
                            
                            <!-- Progress Card -->
                            <div class="card p-6 bg-secondary-100 border-secondary-300 hover-lift">
                                <div class="w-12 h-12 bg-secondary-600 rounded-full flex items-center justify-center mb-4 breathe" style="animation-delay: 1.5s;">
                                    <i class="fas fa-chart-line text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-secondary-800 mb-2">Progress</h3>
                                <p class="text-sm text-secondary-700">Lacak perjalanan kesehatan Anda</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background decorative elements -->
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-primary-200 rounded-full opacity-40 float"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-secondary-200 rounded-full opacity-40 float" style="animation-delay: 2s;"></div>
                <div class="absolute top-1/2 -right-12 w-16 h-16 bg-primary-300 rounded-full opacity-30 float" style="animation-delay: 1s;"></div>
            </div>
        </main>

        <!-- Features Preview -->
        <section class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card p-6 hover-lift fade-in-up">
                <div class="w-14 h-14 bg-primary-100 rounded-duo flex items-center justify-center mb-4">
                    <i class="fas fa-brain text-primary-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3">Pelacakan Mindfulness</h3>
                <p class="text-neutral-600">Pantau kesejahteraan emosional Anda dengan check-in harian dan insight yang dipersonalisasi.</p>
            </div>
            
            <div class="card p-6 hover-lift fade-in-up" style="animation-delay: 0.2s;">
                <div class="w-14 h-14 bg-secondary-100 rounded-duo flex items-center justify-center mb-4">
                    <i class="fas fa-tasks text-secondary-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3">Tantangan Kesehatan</h3>
                <p class="text-neutral-600">Ikuti aktivitas harian yang dirancang untuk meningkatkan kesehatan mental dan membangun ketahanan.</p>
            </div>
            
            <div class="card p-6 hover-lift fade-in-up" style="animation-delay: 0.4s;">
                <div class="w-14 h-14 bg-primary-100 rounded-duo flex items-center justify-center mb-4">
                    <i class="fas fa-users text-primary-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3">Komunitas Support</h3>
                <p class="text-neutral-600">Terhubung dengan orang lain dalam perjalanan serupa di lingkungan yang aman dan mendukung.</p>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="mt-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-neutral-800 mb-4">Apa Kata Pengguna Kami</h2>
                <p class="text-neutral-600 max-w-2xl mx-auto">Bergabung dengan ribuan orang yang telah menemukan kedamaian dan keseimbangan dengan Tenang</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card p-6 fade-in-up">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800">Sarah</h4>
                            <p class="text-sm text-neutral-500">Pengguna selama 6 bulan</p>
                        </div>
                    </div>
                    <p class="text-neutral-600">"Tenang membantu saya memahami pola mood dan mengelola stres dengan lebih baik. Journaling feature sangat membantu!"</p>
                </div>
                
                <div class="card p-6 fade-in-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-secondary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800">Budi</h4>
                            <p class="text-sm text-neutral-500">Pengguna selama 3 bulan</p>
                        </div>
                    </div>
                    <p class="text-neutral-600">"Sebagai mahasiswa, Tenang membantu saya menjaga keseimbangan antara akademik dan kesehatan mental."</p>
                </div>
                
                <div class="card p-6 fade-in-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800">Dewi</h4>
                            <p class="text-sm text-neutral-500">Pengguna selama 1 tahun</p>
                        </div>
                    </div>
                    <p class="text-neutral-600">"Meditasi harian dan tantangan kesehatan dari Tenang telah mengubah hidup saya. Sangat recommended!"</p>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="mt-32 py-16 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-duo-xl">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-neutral-800 mb-4">Tentang Tenang</h2>
                    <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                        Tenang adalah platform kesehatan mental yang dikembangkan dengan cinta dan perhatian oleh tim developer 
                        yang berdedikasi untuk membantu Anda menemukan keseimbangan dan kedamaian dalam hidup.
                    </p>
                </div>

                <!-- Our Mission -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
                    <div class="fade-in-left">
                        <h3 class="text-3xl font-bold text-primary-700 mb-6">Misi Kami</h3>
                        <p class="text-lg text-neutral-600 mb-6">
                            Kami percaya bahwa kesehatan mental adalah fondasi dari kehidupan yang bahagia dan produktif. 
                            Misi kami adalah membuat alat kesehatan mental yang mudah diakses, menyenangkan, dan efektif 
                            untuk semua orang.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <p class="text-neutral-700 flex-1">Membuat kesehatan mental lebih mudah diakses</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <p class="text-neutral-700 flex-1">Mengurangi stigma seputar kesehatan mental</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <p class="text-neutral-700 flex-1">Memberikan alat praktis untuk kehidupan sehari-hari</p>
                            </div>
                        </div>
                    </div>
                    <div class="fade-in-right">
                        <div class="card p-8 h-full">
                            <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-peace text-white text-3xl"></i>
                            </div>
                            <h4 class="text-2xl font-bold text-center text-neutral-800 mb-4">Visi Kami</h4>
                            <p class="text-neutral-600 text-center">
                                Menciptakan dunia di mana setiap orang memiliki alat dan dukungan yang mereka butuhkan 
                                untuk mencapai kesejahteraan mental yang optimal, tanpa hambatan atau stigma.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Development Team -->
                <div class="mb-16">
                    <div class="text-center mb-12">
                        <h3 class="text-3xl font-bold text-neutral-800 mb-4">Tim Pengembang</h3>
                        <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                            Bertemu dengan tim passionate di balik Tenang - para developer yang berdedikasi 
                            untuk menciptakan pengalaman kesehatan mental yang bermakna.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Developer 1 -->
                        <div class="developer-card card p-6 text-center fade-in-up">
                            <div class="w-32 h-32 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-neutral-800 mb-2">Ahmad Rizki</h4>
                            <p class="text-primary-600 font-medium mb-4">Full Stack Developer</p>
                            <p class="text-neutral-600 mb-6">
                                Spesialis dalam pengembangan aplikasi web dengan fokus pada user experience 
                                dan performa. Bertanggung jawab atas arsitektur keseluruhan aplikasi Tenang.
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="social-icon w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-200">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-200">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-200">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Developer 2 -->
                        <div class="developer-card card p-6 text-center fade-in-up" style="animation-delay: 0.2s;">
                            <div class="w-32 h-32 bg-gradient-to-r from-secondary-400 to-accent-purple rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-neutral-800 mb-2">Sarah Wijaya</h4>
                            <p class="text-secondary-600 font-medium mb-4">UI/UX Designer & Frontend Developer</p>
                            <p class="text-neutral-600 mb-6">
                                Menciptakan pengalaman pengguna yang intuitif dan menarik. Menggabungkan 
                                prinsip desain dengan psikologi warna untuk menciptakan antarmuka yang menenangkan.
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="social-icon w-10 h-10 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-secondary-200">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-secondary-200">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-secondary-200">
                                    <i class="fab fa-dribbble"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Developer 3 -->
                        <div class="developer-card card p-6 text-center fade-in-up" style="animation-delay: 0.4s;">
                            <div class="w-32 h-32 bg-gradient-to-r from-accent-blue to-accent-purple rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-neutral-800 mb-2">Budi Santoso</h4>
                            <p class="text-accent-purple font-medium mb-4">Backend Developer & Data Analyst</p>
                            <p class="text-neutral-600 mb-6">
                                Mengelola infrastruktur backend dan menganalisis data untuk memberikan 
                                insight yang personal dan relevan bagi pengguna Tenang.
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="social-icon w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-200">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-200">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-200">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Our Story -->
                <div class="card p-8 fade-in-up">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-neutral-800 mb-4">Cerita Kami</h3>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <div>
                            <p class="text-lg text-neutral-600 mb-6">
                                Tenang lahir dari pengalaman pribadi tim kami dalam menghadapi tantangan kesehatan mental. 
                                Kami menyadari bahwa meskipun ada banyak sumber daya yang tersedia, masih ada kesenjangan 
                                dalam hal aksesibilitas dan pendekatan yang ramah pengguna.
                            </p>
                            <p class="text-lg text-neutral-600">
                                Dengan menggabungkan keahlian teknis dan pemahaman mendalam tentang kebutuhan pengguna, 
                                kami menciptakan Tenang - platform yang tidak hanya fungsional tetapi juga menyenangkan 
                                untuk digunakan, mengubah perawatan kesehatan mental dari tugas menjadi kebiasaan yang 
                                dinantikan.
                            </p>
                        </div>
                        <div class="bg-primary-50 rounded-duo-lg p-6 border-4 border-primary-100">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-primary-700 mb-2">Nilai Inti Kami</h4>
                                    <p class="text-primary-600">
                                        Empati, Inovasi, Aksesibilitas, dan Privasi - empat pilar yang membentuk 
                                        setiap keputusan yang kami buat untuk Tenang.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.target === '_blank') return;
                    if (this.hasAttribute('data-no-loading')) return;
                    
                    const loadingSection = document.getElementById('loading-section');
                    loadingSection.style.display = 'flex';
                    loadingSection.style.opacity = '1';
                    loadingSection.style.transform = 'scale(1)';
                });
            });
            
            const loadingSection = document.getElementById('loading-section');
            setTimeout(() => {
                loadingSection.style.transform = 'scale(1)';
                loadingSection.style.opacity = '1';
            }, 100);
            
            // Add breathing animation to wellness elements
            const wellnessIcons = document.querySelectorAll('.breathe');
            wellnessIcons.forEach((icon, index) => {
                icon.style.animationDelay = `${index * 0.5}s`;
            });
            
            // Add scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            document.querySelectorAll('.fade-in-up, .fade-in-down, .fade-in-left, .fade-in-right').forEach(el => {
                observer.observe(el);
            });

            // Auto-remove success/error messages after 5 seconds
            setTimeout(() => {
                const messages = document.querySelectorAll('.alert-success, .alert-error');
                messages.forEach(message => {
                    message.style.opacity = '0';
                    message.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => message.remove(), 500);
                });
            }, 5000);

            // Add Duolingo-style interactions to all duo elements
            document.querySelectorAll('.app-button, .card, .gamification-badge').forEach(element => {
                element.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(2px)';
                    if (this.classList.contains('app-button') || this.classList.contains('card')) {
                        this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                    }
                });
                
                element.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(0)';
                    if (this.classList.contains('app-button') || this.classList.contains('card')) {
                        this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                    }
                });
                
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    if (this.classList.contains('app-button') || this.classList.contains('card')) {
                        this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                    }
                });
            });

            // Smooth scroll for About link
            document.querySelectorAll('.about-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const aboutSection = document.getElementById('about');
                    if (aboutSection) {
                        aboutSection.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>