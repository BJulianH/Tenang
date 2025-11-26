<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MindWell</title>
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
                        // Social Media Colors
                        social: {
                            google: '#DB4437',
                            facebook: '#1877F2',
                            google_hover: '#c23321',
                            facebook_hover: '#166fe5',
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

        /* Social Button Animations */
        .social-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.15);
        }

        .social-btn:active {
            transform: translateY(0);
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
    </style>
</head>
<body class="login-bg max-h-full overflow-hidden">
    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Left Panel - Visualization (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 gradient-primary text-white p-8 lg:p-12 flex-col justify-between relative overflow-hidden">
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
                    <i class="fas fa-heart mr-2"></i>
                    Mind<span class="text-secondary-300">Well</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 flex-1 flex flex-col justify-center fade-in-up">
                <div class="max-w-md">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6">Welcome Back</h1>
                    <p class="text-xl opacity-90 mb-8">
                        Continue your mental wellness journey with personalized tracking and mindful activities.
                    </p>
                    
                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe">
                                <i class="fas fa-heartbeat text-secondary-300"></i>
                            </div>
                            <span>Mood Tracking & Analytics</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe" style="animation-delay: 0.5s;">
                                <i class="fas fa-book-open text-secondary-300"></i>
                            </div>
                            <span>Personalized Journaling</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe" style="animation-delay: 1s;">
                                <i class="fas fa-medal text-secondary-300"></i>
                            </div>
                            <span>Wellness Challenges & Achievements</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-center lg:text-left opacity-80 text-sm">
                <p>© 2023 MindWell. Supporting mental wellness worldwide.</p>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative">
            <!-- Background untuk mobile (mirip dengan bagian kiri) -->
            <div class="lg:hidden absolute inset-0 gradient-primary -z-10 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full"></div>
                <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full"></div>
                <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full"></div>
                <div class="absolute bottom-40 right-10 w-12 h-12 bg-white rounded-full"></div>
            </div>

            <!-- Mobile Header (Logo di mobile) -->
            <div class="lg:hidden absolute top-8 left-8 z-20">
                <a href="/" class="text-2xl font-bold text-primary-600 flex items-center">
                    <i class="fas fa-heart mr-2"></i>
                    Mind<span class="text-secondary-500">Well</span>
                </a>
            </div>

            <div class="w-full max-w-md z-10">
                <!-- Login Form Container -->
                <div class="bg-white rounded-2xl p-8 card-shadow fade-in-up border border-neutral-200">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4 breathe">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-neutral-800 mb-2">Welcome Back</h2>
                        <p class="text-neutral-600">Sign in to continue your wellness journey</p>
                    </div>

                    <!-- Session Status -->
                    <div class="mb-4 p-4 bg-primary-50 text-primary-700 rounded-lg text-sm border border-primary-200">
                        <i class="fas fa-info-circle mr-2"></i>
                        Welcome back! Please login to continue.
                    </div>

                    <!-- Form menggunakan route login yang sesuai -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-primary-500"></i>
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-neutral-400"></i>
                                </div>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50"
                                    placeholder="Enter your email">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-lock mr-2 text-primary-500"></i>
                                Password
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
                                    class="w-full pl-10 pr-10 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50"
                                    placeholder="Enter your password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                                    <i class="fas fa-eye-slash text-neutral-400 hover:text-neutral-600"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="remember"
                                    class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <span class="ml-2 text-sm text-neutral-600">Remember me</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium transition-colors">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full gradient-primary text-white py-3 px-4 rounded-lg font-semibold hover:opacity-90 transition-all hover:transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 mb-6">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In to MindWell
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center mb-6">
                        <div class="flex-1 border-t border-neutral-300"></div>
                        <span class="px-3 text-neutral-500 text-sm">Or sign in with</span>
                        <div class="flex-1 border-t border-neutral-300"></div>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="space-y-3 mb-6">
                        <!-- Google Login Button -->
                        <a href="" class="w-full social-btn bg-white border border-neutral-300 text-neutral-700 py-3 px-4 rounded-lg font-medium hover:bg-neutral-50 flex items-center justify-center transition-all">
                        <div class="w-5 h-5 flex items-center justify-center mr-3">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M16.51 9.20455V9.10045H9.18V10.8995H13.49C13.12 12.6995 11.62 13.8995 9.18 13.8995C6.43 13.8995 4.18 11.6645 4.18 8.91445C4.18 6.16445 6.43 3.92945 9.18 3.92945C10.39 3.92945 11.5 4.34945 12.37 5.17945L14.43 3.11945C13.02 1.70445 11.18 0.999545 9.18 0.999545C4.19 0.999545 0.18 4.99955 0.18 9.99955C0.18 14.9995 4.19 18.9995 9.18 18.9995C13.69 18.9995 17.18 15.8995 17.18 10.9995C17.18 10.5995 16.86 10.2045 16.51 10.2045V9.20455Z" fill="#EA4335"/>
                                <path d="M1.18 5.31955L3.73 7.15955C4.36 5.23955 6.58 3.92955 9.18 3.92955C10.39 3.92955 11.5 4.34955 12.37 5.17955L14.43 3.11955C13.02 1.70455 11.18 0.999545 9.18 0.999545C5.69 0.999545 2.73 2.79955 1.18 5.31955Z" fill="#FBBC05"/>
                                <path d="M9.18 18.9995C11.11 18.9995 12.89 18.2995 14.31 17.0995L11.87 15.0495C11.06 15.6495 10.03 16.0295 9.18 16.0295C6.78 16.0295 4.76 14.4695 3.94 12.2695L1.39 14.1895C2.93 16.8995 5.83 18.9995 9.18 18.9995Z" fill="#34A853"/>
                                <path d="M16.51 9.20455V9.10045H9.18V10.8995H13.49C13.17 12.2495 12.19 13.2995 10.95 13.8995L13.42 15.8495C15.27 14.0995 16.51 11.4995 16.51 9.20455Z" fill="#4285F4"/>
                            </svg>
                        </div>
                        <span>Continue with Google</span>
                    </a>

                        <!-- Facebook Login Button -->
                        <a href="" class="w-full social-btn bg-social-facebook text-white py-3 px-4 rounded-lg font-medium hover:bg-social-facebook_hover flex items-center justify-center transition-all">
                            <i class="fab fa-facebook-f mr-3"></i>
                            <span>Continue with Facebook</span>
                        </a>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center">
                        <p class="text-neutral-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                                Sign up now
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        // Add focus effects
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-primary-500', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-primary-500', 'ring-opacity-50');
            });
        });

        // Add breathing animation to wellness elements
        document.addEventListener('DOMContentLoaded', function() {
            const wellnessIcons = document.querySelectorAll('.breathe');
            wellnessIcons.forEach((icon, index) => {
                icon.style.animationDelay = `${index * 0.5}s`;
            });
        });

        // Social login button effects
        document.querySelectorAll('.social-btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>