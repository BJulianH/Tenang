<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tenang - Mental Health App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('assets/icon/icon.png') }}">

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Duolingo-inspired color palette
                        primary: {
                            50: '#e6f7ea'
                            , 100: '#c2ebd0'
                            , 200: '#9bdfb5'
                            , 300: '#70d399'
                            , 400: '#4dc982'
                            , 500: '#58cc70'
                            , 600: '#45b259'
                            , 700: '#339847'
                            , 800: '#237e36'
                            , 900: '#156427'
                        , }
                        , secondary: {
                            50: '#fff9e6'
                            , 100: '#ffefbf'
                            , 200: '#ffe599'
                            , 300: '#ffdb70'
                            , 400: '#ffd14c'
                            , 500: '#ffc800', // Duolingo yellow
                            600: '#e6b400'
                            , 700: '#cc9f00'
                            , 800: '#b38b00'
                            , 900: '#997700'
                        , }
                        , accent: {
                            blue: '#4a8cff'
                            , red: '#ff6b6b'
                            , purple: '#9b59b6'
                            , orange: '#ff9f43'
                        , }
                        , neutral: {
                            50: '#f8f9fa'
                            , 100: '#e9ecef'
                            , 200: '#dee2e6'
                            , 300: '#ced4da'
                            , 400: '#adb5bd'
                            , 500: '#6c757d'
                            , 600: '#495057'
                            , 700: '#343a40'
                            , 800: '#212529'
                            , 900: '#121416'
                        , }
                    }
                    , fontFamily: {
                        'sans': ['Nunito', 'Inter', 'ui-sans-serif', 'system-ui']
                        , 'duo': ['Nunito', 'sans-serif']
                    , }
                    , animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                        , 'bounce-gentle': 'bounce-gentle 2s infinite'
                        , 'wiggle': 'wiggle 1s ease-in-out infinite'
                        , 'celebrate': 'celebrate 0.6s ease-out'
                        , 'slide-in': 'slideIn 0.3s ease-out'
                    , }
                    , keyframes: {
                        'bounce-gentle': {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                                , animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)'
                            }
                            , '50%': {
                                transform: 'translateY(-8px)'
                                , animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)'
                            }
                        , }
                        , 'wiggle': {
                            '0%, 100%': {
                                transform: 'rotate(-5deg)'
                            }
                            , '50%': {
                                transform: 'rotate(5deg)'
                            }
                        , }
                        , 'celebrate': {
                            '0%': {
                                transform: 'scale(1)'
                            }
                            , '50%': {
                                transform: 'scale(1.2)'
                            }
                            , '100%': {
                                transform: 'scale(1)'
                            }
                        , }
                        , 'slideIn': {
                            '0%': {
                                transform: 'translateX(-100%)'
                            }
                            , '100%': {
                                transform: 'translateX(0)'
                            }
                        , }
                    }
                    , borderRadius: {
                        'duo': '16px'
                        , 'duo-lg': '24px'
                        , 'duo-xl': '32px'
                    , }
                    , boxShadow: {
                        'duo': '0 4px 0 rgba(0, 0, 0, 0.1)'
                        , 'duo-lg': '0 6px 0 rgba(0, 0, 0, 0.1)'
                        , 'duo-pressed': '0 2px 0 rgba(0, 0, 0, 0.1)'
                    , }
                    , screens: {
                        'xs': '475px'
                    , }
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

        .sidebar {
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }

        /* Responsive Sidebar Styles */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px !important;
            }

            .sidebar .sidebar-text {
                display: none;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                height: 100vh;
                z-index: 40;
                background: white;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 30;
            }

            .mobile-overlay.active {
                display: block;
            }
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 3px solid #f1f3f4;
            /* abu abu tipis */
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
            /* sedikit lebih gelap saat hover */
        }

        .card:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
            border-color: #dfe3e6;
            /* klik = lebih solid */
        }

        /* Tambahkan di section styles layout app Anda */
        .error-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        .error-character {
            width: 120px;
            height: 120px;
            background: #58cc70;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 6px 0 #45b259;
            margin: 0 auto 2rem;
        }

        .error-character::before {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            top: 30px;
            left: 20px;
            box-shadow: 30px 0 white;
        }

        .error-character::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 15px;
            background: #ff6b6b;
            border-radius: 15px 15px 0 0;
            bottom: 25px;
            left: 45px;
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

        /* Progress indicators */
        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.5s ease;
        }

        .streak-flame {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Dot pattern background */
        .striped-dotted-main {
            background-color: #f8f9fa;
            background-image:
                radial-gradient(#808080b7 2px, transparent 2px);
            background-size: 40px 40px, 60px 60px;
            background-position: 0 0, 20px 20px;
            border-radius: 30px;
            border: 3px solid rgb(182, 182, 182);
            box-shadow: 0 6px 0 rgba(182, 182, 182);
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

        /* Duolingo-style badges */
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

        /* Sidebar items */
        .sidebar-item {
            border-radius: 12px;
            transition: all 0.2s ease;
            background: white;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px rgba(0, 0, 0, 0.171) solid;
        }

        .sidebar-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.05);
        }

        .sidebar-item.active {
            background: #58cc70;
            color: white;
            box-shadow: 0 4px 0 #45b259;
        }

        /* Celebration animation for achievements */
        .celebrate {
            animation: celebrate 0.6s ease-out;
        }

        /* Duolingo-style character/illustration */
        .app-character {
            width: 80px;
            height: 80px;
            background: #ffc800;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 4px 0 #e6b400;
        }

        .app-character::before {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 50%;
            top: 20px;
            left: 15px;
            box-shadow: 20px 0 white;
        }

        .app-character::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 10px;
            background: #ff6b6b;
            border-radius: 10px 10px 0 0;
            bottom: 20px;
            left: 30px;
        }

        /* Progress bars */
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

            0%,
            100% {
                opacity: 0.3;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        /* Animasi progress bar */
        .progress-animation {
            animation: progress-grow 3s forwards ease-in-out;
            width: 0%;
        }

        @keyframes progress-grow {
            0% {
                width: 0%;
            }

            50% {
                width: 70%;
            }

            100% {
                width: 95%;
            }
        }

        /* Animasi khusus untuk loading section */
        #loading-section {
            backdrop-filter: blur(8px);
        }

        /* Mobile Header Styles */
        .mobile-header {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
                align-items: center;
                padding: 1rem;
                background: white;
                border-bottom: 2px solid #e9ecef;
            }

            .top-nav-elements {
                display: none;
            }

            .mobile-nav-elements {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
        }

        @media (max-width: 640px) {
            .gamification-badge span {
                display: none;
            }

            .gamification-badge {
                padding: 0.5rem;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .quest-item {
            transition: all 0.3s ease;
        }

        .quest-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .quest-item.completed {
            background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e8 100%);
            border-color: #58cc70;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Celebration particles */
        .celebration-particle {
            animation: celebrateParticle 1s ease-out forwards;
            pointer-events: none;
        }

        @keyframes celebrateParticle {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            50% {
                opacity: 0.8;
                transform: translateY(-20px) scale(1.2);
            }

            100% {
                opacity: 0;
                transform: translateY(-40px) scale(0.5);
            }
        }

        /* Modal animations */
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

    </style>
    <!-- Additional Styles Section -->
    @yield('styles')
</head>
<body class="bg-neutral-50">
    <!-- Loading Section -->
    @extends('widget.loading')

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay"></div>

    <div class="flex h-screen bg-neutral-50">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-30 flex flex-col justify-center align-middle bg-neutral-50">
            <!-- Logo/Menu Toggle for Mobile -->
            <div class="mobile-header lg:hidden">
                <button id="mobile-menu-toggle" class="app-button p-2 rounded-duo text-neutral-700 mr-4">
                    <i class="fas fa-bars"></i>
                </button>
                {{-- <h1 class="text-xl font-bold text-primary-600">Tenang</h1> --}}
            </div>

            <!-- Navigation Menu -->
            <div class="flex-1 py-4 flex flex-col justify-center align-middle">
                <ul class="space-y-3 px-4">

                    <li>
                        <a href="{{ route('dashboard') }}" class="sidebar-item flex flex-col items-center p-3 rounded-duo text-neutral-800 
                {{ request()->routeIs('dashboard') ? 'active font-bold text-primary-600' : '' }}">
                            <i class="fas fa-home w-6 text-center text-xl"></i>
                            <span class="sidebar-text mt-2 text-sm">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('journal.index') }}" class="sidebar-item flex flex-col items-center p-3 rounded-duo text-neutral-800 
                {{ request()->routeIs('journal.*') ? 'active font-bold text-primary-600' : '' }}">
                            <i class="fas fa-book w-6 text-center text-xl"></i>
                            <span class="sidebar-text mt-2 text-sm">Journal</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('community.index') }}" class="sidebar-item flex flex-col items-center p-3 rounded-duo text-neutral-800 
                {{ request()->routeIs('community.*') ? 'active font-bold text-primary-600' : '' }}">
                            <i class="fas fa-users w-6 text-center text-xl"></i>
                            <span class="sidebar-text mt-2 text-sm">Community</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quests.index.view') }}" class="sidebar-item flex flex-col items-center p-3 rounded-duo text-neutral-800 
        {{ request()->routeIs('quests.index.view') ? 'active font-bold text-primary-600' : '' }}">
                            <i class="fas fa-flag-checkered w-6 text-center text-xl"></i>
                            <span class="sidebar-text mt-2 text-sm">Quests</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('noises.index') }}" class="sidebar-item flex flex-col items-center p-3 rounded-duo text-neutral-800 
        {{ request()->routeIs('noises.index') ? 'active font-bold text-primary-600' : '' }}">
                            <i class="fas fa-music w-6 text-center text-xl"></i>
                            <span class="sidebar-text mt-2 text-sm">noises</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.index') }}" class="sidebar-item flex flex-col items-center p-3 rounded-duo text-neutral-800 
                {{ request()->routeIs('settings.*') ? 'active font-bold text-primary-600' : '' }}">
                            <i class="fas fa-cog w-6 text-center text-xl"></i>
                            <span class="sidebar-text mt-2 text-sm">Settings</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col overflow-hidden bg-neutral-50">
            <!-- Top Navigation Bar -->
            <header class="z-10 bg-neutral-50">
                <div class="hidden lg:flex items-center justify-between px-6 py-4 top-nav-elements">
                    <!-- Search Bar -->
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="app-button p-2 rounded-duo text-neutral-700 mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64 bg-neutral-50">
                            <i class="fas fa-search absolute left-3 top-3 text-neutral-400"></i>
                        </div>
                    </div>

                    <!-- Gamification Elements & User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Diamonds -->
                        <div class="gamification-badge flex items-center px-3 py-2 rounded-duo">
                            <i class="fas fa-gem text-accent-blue mr-2 bounce-gentle"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->diamonds ?? 125 }}</span>
                        </div>

                        <!-- Coins -->
                        <div class="gamification-badge flex items-center px-3 py-2 rounded-duo">
                            <i class="fas fa-coins text-secondary-500 mr-2 bounce-gentle" style="animation-delay: 0.2s"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->coins ?? 540 }}</span>
                        </div>

                        <!-- Streak -->
                        <div class="gamification-badge flex items-center px-3 py-2 rounded-duo">
                            <i class="fas fa-fire streak-flame text-accent-red mr-2"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->streak ?? 7 }} days</span>
                        </div>

                        <!-- Level -->
                        <div class="gamification-badge flex items-center px-3 py-2 rounded-duo">
                            <i class="fas fa-trophy text-accent-purple mr-2 bounce-gentle" style="animation-delay: 0.4s"></i>
                            <span class="font-bold text-neutral-800">Level {{ auth()->user()->level ?? 5 }}</span>
                        </div>

                        <!-- Notifications -->
                        <button class="app-button p-2 rounded-duo text-neutral-700">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-accent-red rounded-full"></span>
                        </button>

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <a href="{{ route('profile') }}" class="block">
                                <button id="profile-toggle" class="app-button flex items-center space-x-2 p-2 rounded-duo">
                                    <div class="w-8 h-8 rounded-full bg-secondary-400 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr(auth()->user()->name, 0, 1) ?? 'U' }}
                                    </div>
                                    <span class="text-neutral-800 font-bold">{{ auth()->user()->name ?? 'User' }}</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Header -->
                <div class="lg:hidden flex items-center justify-between px-4 py-3 mobile-nav-elements">
                    <div class="flex items-center space-x-3">
                        <button id="mobile-menu-toggle-2" class="app-button p-2 rounded-duo text-neutral-700">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-lg font-bold text-primary-600">Tenang</h1>
                    </div>

                    <div class="flex items-center space-x-2">
                        <!-- Mobile gamification badges (simplified) -->
                        <div class="gamification-badge flex items-center p-2 rounded-duo">
                            <i class="fas fa-fire text-accent-red"></i>
                        </div>
                        <div class="gamification-badge flex items-center p-2 rounded-duo">
                            <i class="fas fa-gem text-accent-blue"></i>
                        </div>
                        <button class="app-button p-2 rounded-duo text-neutral-700">
                            <i class="fas fa-bell"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6 mb-4 lg:mr-4 striped-dotted-main bg-white">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts Section -->
    @yield('scripts')

    <script>
        // Sidebar toggle functionality for desktop
        document.getElementById('sidebar-toggle') ? .addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        });

        // Mobile menu toggle functionality
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');

            // Prevent body scroll when menu is open
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        }

        document.getElementById('mobile-menu-toggle') ? .addEventListener('click', toggleMobileMenu);
        document.getElementById('mobile-menu-toggle-2') ? .addEventListener('click', toggleMobileMenu);
        document.getElementById('mobile-overlay') ? .addEventListener('click', toggleMobileMenu);

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleMobileMenu();
                }

                // Update active state
                document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add Duolingo-style interactions to all duo elements
        document.querySelectorAll('.app-button, .card, .gamification-badge, .sidebar-item').forEach(element => {
            element.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
                if (this.classList.contains('app-button') || this.classList.contains('duo-card')) {
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                }
            });

            element.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('app-button') || this.classList.contains('duo-card')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });

            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('app-button') || this.classList.contains('duo-card')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
        });

        function showNotification(message, type = 'info') {
            // Remove existing notifications
            document.querySelectorAll('.custom-notification').forEach(n => n.remove());

            const colors = {
                success: 'bg-primary-500 text-white shadow-duo'
                , error: 'bg-accent-red text-white shadow-duo'
                , warning: 'bg-secondary-500 text-neutral-900 shadow-duo'
                , info: 'bg-accent-blue text-white shadow-duo'
            };

            const icons = {
                success: 'fa-check-circle'
                , error: 'fa-exclamation-circle'
                , warning: 'fa-exclamation-triangle'
                , info: 'fa-info-circle'
            };

            // Create element
            const notification = document.createElement('div');
            notification.className = `
        custom-notification
        fixed top-24 right-8 
        px-5 py-4 rounded-duo-lg z-[9999]
        transform transition-all duration-300
        animate-slide-in
        border-2 border-white
        flex items-center gap-3
        ${colors[type] || colors.info}
    `;

            notification.innerHTML = `
        <i class="fas ${icons[type]} text-xl"></i>
        <span class="font-semibold">${message}</span>
    `;

            document.body.appendChild(notification);

            // Auto remove
            setTimeout(() => {
                notification.style.opacity = "0";
                notification.style.transform = "translateX(100%)";
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

    </script>
</body>
</html>
