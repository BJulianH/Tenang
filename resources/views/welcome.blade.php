<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Your Mental Wellness Companion</title>
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

        .gradient-bg {
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

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
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

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
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

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #4caf50 0%, #14b8a6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="gradient-calm min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <header class="flex justify-between items-center mb-16">
            <div class="text-2xl font-bold text-primary-700 flex items-center">
                <i class="fas fa-heart mr-2 text-primary-500"></i>
                Mind<span class="text-secondary-500">Well</span>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="nav-item text-neutral-700 hover:text-primary-600 font-medium transition-colors">Home</a>
                <a href="#" class="nav-item text-neutral-700 hover:text-primary-600 font-medium transition-colors">Features</a>
                <a href="#" class="nav-item text-neutral-700 hover:text-primary-600 font-medium transition-colors">Journal</a>
                <a href="#" class="nav-item text-neutral-700 hover:text-primary-600 font-medium transition-colors">Resources</a>
                <a href="#" class="nav-item text-neutral-700 hover:text-primary-600 font-medium transition-colors">About</a>
            </nav>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 text-primary-600 font-medium border border-primary-500 rounded-lg transition-all duration-300 hover:bg-primary-50">
                    Log In
                </a>
                <a href="{{ route('register') }}">
                    <button class="px-4 py-2 gradient-primary text-white font-medium rounded-lg hover:opacity-90 transition-all">
                        Get Started
                    </button>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-[70vh]">
            <!-- Text Content -->
            <div class="space-y-8 fade-in-left">
                <div class="space-y-4">
                    <h1 class="text-5xl lg:text-6xl font-bold text-neutral-800 leading-tight">
                        Your Mental
                        <span class="gradient-text">Wellness</span>
                        Companion
                    </h1>
                    <h2 class="text-2xl lg:text-3xl text-secondary-600 font-medium">
                        Journey to mindfulness starts here
                    </h2>
                </div>

                <p class="text-lg text-neutral-600 leading-relaxed">
                    Track your mood, journal your thoughts, and discover personalized wellness activities. 
                    MindWell helps you build healthy habits and find balance in your daily life through 
                    mindful practices and supportive tools.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('register') }}">
                        <button class="px-8 py-4 gradient-primary text-white font-bold rounded-lg hover:opacity-90 transition-all hover:transform hover:scale-105 flex items-center">
                            Start Your Journey
                            <i class="fas fa-heart ml-3"></i>
                        </button>
                    </a>
                    <button class="px-8 py-4 bg-white text-primary-600 border border-primary-500 font-bold rounded-lg hover:bg-primary-50 transition-all flex items-center">
                        <i class="fas fa-play-circle mr-3"></i>
                        Watch Demo
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-600">10K+</div>
                        <div class="text-sm text-neutral-500">Active Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-secondary-600">95%</div>
                        <div class="text-sm text-neutral-500">Report Improvement</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-500">4.9★</div>
                        <div class="text-sm text-neutral-500">User Rating</div>
                    </div>
                </div>
            </div>

            <!-- Illustration Section -->
            <div class="relative fade-in-right">
                <!-- Main Illustration Container -->
                <div class="relative z-10">
                    <div class="bg-white rounded-3xl p-8 card-shadow border border-neutral-200">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Mood Tracking Card -->
                            <div class="bg-primary-50 rounded-2xl p-6 border border-primary-200 hover-lift">
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center mb-4 breathe">
                                    <i class="fas fa-heart text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-primary-700 mb-2">Mood Tracking</h3>
                                <p class="text-sm text-primary-600">Daily emotional check-ins</p>
                            </div>
                            
                            <!-- Journal Card -->
                            <div class="bg-secondary-50 rounded-2xl p-6 border border-secondary-200 hover-lift">
                                <div class="w-12 h-12 bg-secondary-500 rounded-full flex items-center justify-center mb-4 breathe" style="animation-delay: 0.5s;">
                                    <i class="fas fa-book text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-secondary-700 mb-2">Journal</h3>
                                <p class="text-sm text-secondary-600">Express your thoughts</p>
                            </div>
                            
                            <!-- Meditation Card -->
                            <div class="bg-primary-100 rounded-2xl p-6 border border-primary-300 hover-lift">
                                <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center mb-4 breathe" style="animation-delay: 1s;">
                                    <i class="fas fa-wind text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-primary-800 mb-2">Meditation</h3>
                                <p class="text-sm text-primary-700">Mindful breathing exercises</p>
                            </div>
                            
                            <!-- Progress Card -->
                            <div class="bg-secondary-100 rounded-2xl p-6 border border-secondary-300 hover-lift">
                                <div class="w-12 h-12 bg-secondary-600 rounded-full flex items-center justify-center mb-4 breathe" style="animation-delay: 1.5s;">
                                    <i class="fas fa-chart-line text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-secondary-800 mb-2">Progress</h3>
                                <p class="text-sm text-secondary-700">Track your wellness journey</p>
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
            <div class="bg-white rounded-2xl p-6 card-shadow border border-neutral-200 hover-lift fade-in-up">
                <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-brain text-primary-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3">Mindful Tracking</h3>
                <p class="text-neutral-600">Monitor your emotional wellbeing with daily check-ins and personalized insights.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-6 card-shadow border border-neutral-200 hover-lift fade-in-up" style="animation-delay: 0.2s;">
                <div class="w-14 h-14 bg-secondary-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-tasks text-secondary-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3">Wellness Challenges</h3>
                <p class="text-neutral-600">Engage in daily activities designed to boost your mental health and build resilience.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-6 card-shadow border border-neutral-200 hover-lift fade-in-up" style="animation-delay: 0.4s;">
                <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-users text-primary-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-800 mb-3">Support Community</h3>
                <p class="text-neutral-600">Connect with others on similar journeys in a safe, supportive environment.</p>
            </div>
        </section>
    </div>

    <script>
        // Add breathing animation to wellness elements
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html>