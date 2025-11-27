<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MindWell - Mental Health App')</title>
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
                        'serif': ['ui-serif', 'Georgia'],
                        'mono': ['ui-monospace', 'SFMono-Regular'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'breathe': 'breathe 4s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        breathe: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
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

        .sidebar {
            transition: all 0.3s ease;
            background: linear-gradient(180deg, #f0f9f0 0%, #ffffff 100%);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(46, 107, 52, 0.1), 0 2px 4px -1px rgba(46, 107, 52, 0.06);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

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
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .striped-dotted-main {
            background-color: #fafdf9; 
            background-image: radial-gradient(#8ba886 1px, transparent 2px);
            background-size: 50px 50px; 
            border-radius: 16px; 
            border: 1px solid #d4e2d0; /* neutral-300 */
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

        /* Glass morphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 242, 220, 0.3);
        }

        /* Gradient backgrounds */
        .gradient-primary {
            background: linear-gradient(135deg, #4caf50 0%, #2e6b34 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        }

        .gradient-calm {
            background: linear-gradient(135deg, #f0f9f0 0%, #dcf2dc 100%);
        }
    </style>

    <!-- Additional Styles Section -->
    @yield('styles')
</head>
<body class="bg-neutral-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-white w-30 shadow-md flex flex-col justify-center align-middle border-r border-neutral-200">
            <!-- Navigation Menu -->
            <div class="flex-1 py-4 flex flex-col justify-center align-middle">
                <ul class="space-y-2 px-4">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-neutral-700 rounded-lg bg-primary-50 text-primary-600 border border-primary-100">
                            <i class="fas fa-home w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-heart w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Mood Tracking</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('journal.index') }}" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-book w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Journal</span>
                        </a>
                    </li>

                    <li>
                        <a href="" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-tasks w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Daily Challenges</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-award w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Achievements</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-chart-line w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Progress</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Community</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex items-center p-3 text-neutral-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <i class="fas fa-cog w-6 text-center"></i>
                            <span class="sidebar-text ml-3 font-medium">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm z-10 border-b border-neutral-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Search Bar -->
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="p-2 rounded-lg text-neutral-500 hover:bg-primary-50 hover:text-primary-600 transition-colors mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64 bg-neutral-50">
                            <i class="fas fa-search absolute left-3 top-3 text-neutral-400"></i>
                        </div>
                    </div>

                    <!-- Gamification Elements & User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Diamonds -->
                        <div class="flex items-center bg-gradient-to-r from-primary-100 to-secondary-100 px-3 py-2 rounded-lg border border-primary-200">
                            <i class="fas fa-gem text-primary-600 mr-2"></i>
                            <span class="font-bold text-primary-700">{{ auth()->user()->diamonds ?? 125 }}</span>
                        </div>

                        <!-- Coins -->
                        <div class="flex items-center bg-gradient-to-r from-accent-gold/20 to-yellow-100 px-3 py-2 rounded-lg border border-yellow-200">
                            <i class="fas fa-coins text-yellow-600 mr-2"></i>
                            <span class="font-bold text-yellow-700">{{ auth()->user()->coins ?? 540 }}</span>
                        </div>

                        <!-- Streak -->
                        <div class="flex items-center bg-gradient-to-r from-secondary-100 to-primary-100 px-3 py-2 rounded-lg border border-secondary-200">
                            <i class="fas fa-fire streak-flame text-secondary-600 mr-2"></i>
                            <span class="font-bold text-secondary-700">{{ auth()->user()->streak ?? 7 }} days</span>
                        </div>

                        <!-- Level -->
                        <div class="flex items-center bg-gradient-to-r from-primary-100 to-green-100 px-3 py-2 rounded-lg border border-primary-200">
                            <i class="fas fa-trophy text-primary-600 mr-2"></i>
                            <span class="font-bold text-primary-700">Level {{ auth()->user()->level ?? 5 }}</span>
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 text-neutral-500 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-secondary-500 rounded-full"></span>
                        </button>

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <a href="{{ route('profile') }}" class="block">
                                <button id="profile-toggle" class="flex items-center space-x-2 focus:outline-none **hover-lift** transition duration-300 ease-in-out p-2 rounded-lg">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr(auth()->user()->name, 0, 1) ?? 'U' }}
                                    </div>
                                    <span class="text-neutral-700 font-medium">{{ auth()->user()->name ?? 'User' }}</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6 mb-4 mr-4 striped-dotted-main">
                <!-- Page-specific content will be injected here -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts Section -->
    @yield('scripts')

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('collapsed');
            
            if (sidebar.classList.contains('collapsed')) {
                mainContent.classList.add('lg:ml-0');
            } else {
                mainContent.classList.remove('lg:ml-0');
            }
        });

        // Add hover effects to cards
        document.querySelectorAll('.hover-lift').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>