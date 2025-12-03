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
                        'progress-grow': 'progressGrow 3s forwards ease-in-out',
                        'particle-float': 'particleFloat 3s ease-in-out infinite',
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
                        },
                        'progressGrow': {
                            '0%': { width: '0%' },
                            '50%': { width: '70%' },
                            '100%': { width: '95%' },
                        },
                        'particleFloat': {
                            '0%, 100%': { 
                                transform: 'translateY(0px) rotate(0deg)',
                                opacity: '0.7'
                            },
                            '50%': { 
                                transform: 'translateY(-20px) rotate(180deg)',
                                opacity: '1'
                            },
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
                        'duo-glow': '0 0 20px rgba(88, 204, 112, 0.3)',
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
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Enhanced Card Styles */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid #f1f3f4;
            position: relative;
            overflow: hidden;
        }

        .card::before {
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

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 0 rgba(0, 0, 0, 0.1), 0 0 20px rgba(88, 204, 112, 0.2);
            border-color: #e5e7eb;
        }

        .card:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
            border-color: #dfe3e6;
        }

        /* Enhanced Button Styles */
        .app-button {
            background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
            color: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 #3a954b;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 700;
            border: none;
            padding: 14px 28px;
            position: relative;
            overflow: hidden;
        }

        .app-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .app-button:hover::before {
            left: 100%;
        }

        .app-button:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 0 #3a954b, 0 10px 20px rgba(88, 204, 112, 0.3);
        }

        .app-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #3a954b;
        }

        .app-button-secondary {
            background: linear-gradient(135deg, #ffc800 0%, #e6b400 100%);
            box-shadow: 0 4px 0 #cc9f00;
        }

        .app-button-secondary:hover {
            box-shadow: 0 6px 0 #cc9f00, 0 10px 20px rgba(255, 200, 0, 0.3);
        }

        .app-button-secondary:active {
            box-shadow: 0 2px 0 #cc9f00;
        }

        /* Enhanced Badge Styles */
        .gamification-badge {
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid white;
            position: relative;
            overflow: hidden;
        }

        .gamification-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(88, 204, 112, 0.1) 0%, rgba(255, 200, 0, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gamification-badge:hover::before {
            opacity: 1;
        }

        .gamification-badge:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1), 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .gamification-badge:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        /* Loading Section Styles */
        #loading-section {
            transition: opacity 0.3s ease-in-out;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
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

        /* Progress indicators */
        .duo-progress {
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .duo-progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
            border-radius: 6px;
            transition: width 0.5s ease;
            box-shadow: 0 2px 4px rgba(88, 204, 112, 0.3);
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
            background: linear-gradient(135deg, #58cc70 0%, #ffc800 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #45b259 0%, #e6b400 100%);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #58cc70 0%, #ffc800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        /* Error/Success Messages */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 2px solid #10b981;
            color: #065f46;
            border-radius: 12px;
            box-shadow: 0 4px 0 rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 2px solid #ef4444;
            color: #dc2626;
            border-radius: 12px;
            box-shadow: 0 4px 0 rgba(239, 68, 68, 0.2);
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
                radial-gradient(#58cc7040 2px, transparent 2px),
                radial-gradient(#ffc80040 2px, transparent 2px);
            background-size: 40px 40px, 60px 60px; 
            background-position: 0 0, 20px 20px;
            border-radius: 30px; 
            border: 3px solid #e9ecef;
            box-shadow: 0 6px 0 #dee2e6;
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
            border: 2px solid transparent;
            background: linear-gradient(135deg, white, white) padding-box,
                        linear-gradient(135deg, #58cc70, #ffc800) border-box;
        }

        .social-icon:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Particle Effects */
        .particle {
            position: absolute;
            pointer-events: none;
            animation: particleFloat 3s ease-in-out infinite;
        }

        /* Navigation Styles */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #58cc70 0%, #ffc800 100%);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Feature Icons */
        .feature-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
            box-shadow: 0 4px 0 #3a954b;
        }

        .feature-icon:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 0 #3a954b, 0 8px 15px rgba(88, 204, 112, 0.3);
        }

        /* Stats Counter */
        .stat-number {
            background: linear-gradient(135deg, #58cc70 0%, #ffc800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        /* Floating Elements */
        .floating-element {
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
        }

        /* Section Backgrounds */
        .section-gradient {
            background: linear-gradient(135deg, #e6f7ea 0%, #fff9e6 100%);
        }

        /* Testimonial Styles */
        .testimonial-card {
            position: relative;
            overflow: visible;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 4rem;
            color: #58cc70;
            opacity: 0.2;
            font-family: serif;
        }

        /* FAQ Styles */
        .faq-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .faq-item:hover {
            border-left-color: #58cc70;
            transform: translateX(5px);
        }

        /* CTA Section */
        .cta-gradient {
            background: linear-gradient(135deg, #58cc70 0%, #45b259 50%, #ffc800 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-neutral-50">
    <!-- Loading Section -->f
     @extends('widget.loading')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <header class="flex justify-between items-center mb-16">
            <div class="text-2xl font-bold text-primary-700 flex items-center">
                <img src="{{ asset('assets/icon/icon-2.png') }}" alt="Tenang" class="h-16 w-16 floating-element">
                <span class="ml-2 gradient-text">Tenang</span>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="nav-link text-neutral-700 hover:text-primary-600 font-medium transition-colors">Beranda</a>
                <a href="#" class="nav-link text-neutral-700 hover:text-primary-600 font-medium transition-colors">Fitur</a>
                <a href="#" class="nav-link text-neutral-700 hover:text-primary-600 font-medium transition-colors">Journal</a>
                <a href="#" class="nav-link text-neutral-700 hover:text-primary-600 font-medium transition-colors">Sumber Daya</a>
                <a href="#about" class="nav-link text-neutral-700 hover:text-primary-600 font-medium transition-colors about-link">Tentang</a>
            </nav>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-6 py-3 text-primary-600 font-medium border-2 border-primary-500 rounded-duo transition-all duration-300 hover:bg-primary-50 hover:shadow-duo">
                    Masuk
                </a>
                <a href="{{ route('register') }}">
                    <button class="app-button px-6 py-3">
                        Mulai Sekarang
                    </button>
                </a>
            </div>
        </header>

        <!-- Session Messages -->
        @if(session('status'))
            <div class="mb-6 p-4 alert-success rounded-lg border flex items-center fade-in-up">
                <i class="fas fa-check-circle mr-3 text-green-600"></i>
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 alert-error rounded-lg border flex items-center shake">
                <i class="fas fa-exclamation-triangle mr-3 text-red-600"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 alert-error rounded-lg border shake">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
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
                    <button class="px-8 py-4 bg-white text-primary-600 border-2 border-primary-500 font-bold rounded-duo hover:bg-primary-50 hover:shadow-duo transition-all flex items-center">
                        <i class="fas fa-play-circle mr-3"></i>
                        Lihat Demo
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div class="text-center">
                        <div class="stat-number text-2xl">10K+</div>
                        <div class="text-sm text-neutral-500">Pengguna Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number text-2xl">95%</div>
                        <div class="text-sm text-neutral-500">Melaporkan Perbaikan</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number text-2xl">4.9★</div>
                        <div class="text-sm text-neutral-500">Rating Pengguna</div>
                    </div>
                </div>
            </div>

            <!-- Illustration Section -->
            <div class="relative fade-in-right">
                <!-- Main Illustration Container -->
                <div class="relative z-10">
                    <div class="card p-8">
                        <div class="flex items-center justify-center">
                            <div class="relative">
                                <img src="{{ asset('assets/video/icon.gif') }}" alt="Tenang App" class="w-80 h-80 rounded-duo-lg floating-element">
                                <div class="absolute -top-4 -right-4 w-16 h-16 bg-secondary-500 rounded-full flex items-center justify-center shadow-duo-lg">
                                    <i class="fas fa-heart text-white text-xl"></i>
                                </div>
                                <div class="absolute -bottom-4 -left-4 w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center shadow-duo-lg">
                                    <i class="fas fa-peace text-white text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background decorative elements -->
                <div class="floating-element absolute -top-6 -right-6 w-32 h-32 bg-primary-200 rounded-full opacity-40" style="animation-delay: 0.5s"></div>
                <div class="floating-element absolute -bottom-8 -left-8 w-24 h-24 bg-secondary-200 rounded-full opacity-40" style="animation-delay: 1s"></div>
                <div class="floating-element absolute top-1/2 -right-12 w-16 h-16 bg-primary-300 rounded-full opacity-30" style="animation-delay: 1.5s"></div>
            </div>
        </main>

        <!-- Features Preview -->
        <section class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card p-6 hover-lift fade-in-up">
                <div class="feature-icon w-14 h-14 rounded-duo flex items-center justify-center mb-4 mx-auto">
                    <i class="fas fa-brain text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3 text-center">Pelacakan Mindfulness</h3>
                <p class="text-neutral-600 text-center">Pantau kesejahteraan emosional Anda dengan check-in harian dan insight yang dipersonalisasi.</p>
            </div>
            
            <div class="card p-6 hover-lift fade-in-up" style="animation-delay: 0.2s;">
                <div class="feature-icon w-14 h-14 rounded-duo flex items-center justify-center mb-4 mx-auto">
                    <i class="fas fa-tasks text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3 text-center">Tantangan Kesehatan</h3>
                <p class="text-neutral-600 text-center">Ikuti aktivitas harian yang dirancang untuk meningkatkan kesehatan mental dan membangun ketahanan.</p>
            </div>
            
            <div class="card p-6 hover-lift fade-in-up" style="animation-delay: 0.4s;">
                <div class="feature-icon w-14 h-14 rounded-duo flex items-center justify-center mb-4 mx-auto">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3 text-center">Komunitas Support</h3>
                <p class="text-neutral-600 text-center">Terhubung dengan orang lain dalam perjalanan serupa di lingkungan yang aman dan mendukung.</p>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="mt-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-neutral-800 mb-4">Apa Kata Pengguna Kami</h2>
                <p class="text-neutral-600 max-w-2xl mx-auto">Bergabung dengan ribuan orang yang telah menemukan kedamaian dan keseimbangan dengan Tenang</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="testimonial-card card p-6 fade-in-up">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800">Sarah</h4>
                            <p class="text-sm text-neutral-500">Pengguna selama 6 bulan</p>
                        </div>
                    </div>
                    <p class="text-neutral-600">"Tenang membantu saya memahami pola mood dan mengelola stres dengan lebih baik. Journaling feature sangat membantu!"</p>
                </div>
                
                <div class="testimonial-card card p-6 fade-in-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-secondary-400 to-accent-purple rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800">Budi</h4>
                            <p class="text-sm text-neutral-500">Pengguna selama 3 bulan</p>
                        </div>
                    </div>
                    <p class="text-neutral-600">"Sebagai mahasiswa, Tenang membantu saya menjaga keseimbangan antara akademik dan kesehatan mental."</p>
                </div>
                
                <div class="testimonial-card card p-6 fade-in-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-accent-blue rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
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
        <section id="about" class="mt-32 py-16 section-gradient rounded-duo-xl">
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
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-4 mt-1 shadow-duo">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <p class="text-neutral-700 flex-1">Membuat kesehatan mental lebih mudah diakses</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-4 mt-1 shadow-duo">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <p class="text-neutral-700 flex-1">Mengurangi stigma seputar kesehatan mental</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-4 mt-1 shadow-duo">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <p class="text-neutral-700 flex-1">Memberikan alat praktis untuk kehidupan sehari-hari</p>
                            </div>
                        </div>
                    </div>
                    <div class="fade-in-right">
                        <div class="card p-8 h-full">
                            <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-duo-lg">
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
                            <div class="w-32 h-32 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-duo-lg">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-neutral-800 mb-2">Ahmad Rizki</h4>
                            <p class="text-primary-600 font-medium mb-4">Full Stack Developer</p>
                            <p class="text-neutral-600 mb-6">
                                Spesialis dalam pengembangan aplikasi web dengan fokus pada user experience 
                                dan performa. Bertanggung jawab atas arsitektur keseluruhan aplikasi Tenang.
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-primary-600">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-primary-600">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-primary-600">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Developer 2 -->
                        <div class="developer-card card p-6 text-center fade-in-up" style="animation-delay: 0.2s;">
                            <div class="w-32 h-32 bg-gradient-to-r from-secondary-400 to-accent-purple rounded-full flex items-center justify-center mx-auto mb-6 shadow-duo-lg">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-neutral-800 mb-2">Sarah Wijaya</h4>
                            <p class="text-secondary-600 font-medium mb-4">UI/UX Designer & Frontend Developer</p>
                            <p class="text-neutral-600 mb-6">
                                Menciptakan pengalaman pengguna yang intuitif dan menarik. Menggabungkan 
                                prinsip desain dengan psikologi warna untuk menciptakan antarmuka yang menenangkan.
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-secondary-600">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-secondary-600">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-secondary-600">
                                    <i class="fab fa-dribbble"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Developer 3 -->
                        <div class="developer-card card p-6 text-center fade-in-up" style="animation-delay: 0.4s;">
                            <div class="w-32 h-32 bg-gradient-to-r from-accent-blue to-accent-purple rounded-full flex items-center justify-center mx-auto mb-6 shadow-duo-lg">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-neutral-800 mb-2">Budi Santoso</h4>
                            <p class="text-accent-purple font-medium mb-4">Backend Developer & Data Analyst</p>
                            <p class="text-neutral-600 mb-6">
                                Mengelola infrastruktur backend dan menganalisis data untuk memberikan 
                                insight yang personal dan relevan bagi pengguna Tenang.
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-purple-600">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-purple-600">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-purple-600">
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
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-duo">
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

        <!-- Final CTA Section -->
        <section class="mt-20 py-16 cta-gradient rounded-duo-xl text-center text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-4xl font-bold mb-6">Siap Memulai Perjalanan Kesehatan Mental Anda?</h2>
                <p class="text-xl mb-8 opacity-95">Bergabunglah dengan komunitas Tenang hari ini dan temukan keseimbangan dalam hidup Anda</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}">
                        <button class="app-button bg-white text-primary-600 px-8 py-4 flex items-center">
                            Daftar Sekarang - Gratis
                            <i class="fas fa-arrow-right ml-3"></i>
                        </button>
                    </a>
                    <button class="px-8 py-4 bg-transparent text-white border-2 border-white font-bold rounded-duo hover:bg-white hover:text-primary-600 transition-all flex items-center">
                        <i class="fas fa-question-circle mr-3"></i>
                        Pelajari Lebih Lanjut
                    </button>
                </div>
                <p class="mt-6 text-sm opacity-90">Tidak membutuhkan kartu kredit • 100% privasi terjamin</p>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-neutral-800 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="text-2xl font-bold text-primary-400 flex items-center mb-4">
                        <img src="{{ asset('assets/icon/icon-2.png') }}" alt="Tenang" class="h-10 w-10 mr-2">
                        Tenang
                    </div>
                    <p class="text-neutral-300 mb-6 max-w-md">
                        Platform kesehatan mental yang membantu Anda menemukan keseimbangan dan kedamaian dalam hidup sehari-hari.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Fitur</a></li>
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Tentang</a></li>
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Dukungan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Bantuan</a></li>
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-neutral-300 hover:text-primary-400 transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-neutral-700 mt-8 pt-8 text-center text-neutral-400">
                <p>&copy; 2023 Tenang. Semua hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <script>
        

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

            // Create additional floating particles
            function createParticles() {
                const particlesContainer = document.getElementById('loading-section');
                for (let i = 0; i < 8; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle absolute rounded-full opacity-30';
                    particle.style.width = `${Math.random() * 12 + 4}px`;
                    particle.style.height = particle.style.width;
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.top = `${Math.random() * 100}%`;
                    particle.style.background = `hsl(${Math.random() * 360}, 70%, 60%)`;
                    particle.style.animationDelay = `${Math.random() * 3}s`;
                    particle.style.animationDuration = `${Math.random() * 4 + 2}s`;
                    particlesContainer.appendChild(particle);
                }
            }

            createParticles();
        });
    </script>
</body>
</html>