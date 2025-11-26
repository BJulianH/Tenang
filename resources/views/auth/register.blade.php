<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MindWell</title>
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

        /* Error message styling */
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
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
                    <i class="fas fa-heart mr-2"></i>
                    Mind<span class="text-secondary-500">Well</span>
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
                        <h2 class="text-3xl font-bold text-neutral-800 mb-2">Join MindWell</h2>
                        <p class="text-neutral-600">Start your mental wellness journey today</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                    <div class="mb-4 p-4 bg-primary-50 text-primary-700 rounded-lg text-sm border border-primary-200">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-user mr-2 text-primary-500"></i>
                                Full Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-neutral-400"></i>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50 @error('name') border-red-500 @enderror" placeholder="Enter your full name">
                            </div>
                            @error('name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

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
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50 @error('email') border-red-500 @enderror" placeholder="Enter your email">
                            </div>
                            @error('email')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
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
                                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50 @error('password') border-red-500 @enderror" placeholder="Create a password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                                    <i class="fas fa-eye-slash text-neutral-400 hover:text-neutral-600"></i>
                                </button>
                            </div>
                            <div id="password-strength" class="password-strength"></div>
                            <div id="password-hints" class="text-xs text-neutral-500 mt-2">
                                <div id="length" class="flex items-center mb-1">
                                    <i class="fas fa-times text-red-500 mr-1"></i>
                                    <span>At least 8 characters</span>
                                </div>
                                <div id="uppercase" class="flex items-center mb-1">
                                    <i class="fas fa-times text-red-500 mr-1"></i>
                                    <span>One uppercase letter</span>
                                </div>
                                <div id="number" class="flex items-center">
                                    <i class="fas fa-times text-red-500 mr-1"></i>
                                    <span>One number</span>
                                </div>
                            </div>
                            @error('password')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-2">
                                <i class="fas fa-lock mr-2 text-primary-500"></i>
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-neutral-400"></i>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-neutral-50" placeholder="Confirm your password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-confirm-toggle">
                                    <i class="fas fa-eye-slash text-neutral-400 hover:text-neutral-600"></i>
                                </button>
                            </div>
                            <div id="password-match" class="text-xs mt-2 hidden">
                                <i class="fas fa-check text-green-500 mr-1"></i>
                                <span class="text-green-500">Passwords match</span>
                            </div>
                            <div id="password-mismatch" class="text-xs mt-2 hidden">
                                <i class="fas fa-times text-red-500 mr-1"></i>
                                <span class="text-red-500">Passwords do not match</span>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms" class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500 mt-1" required>
                                <span class="ml-2 text-sm text-neutral-600">
                                    I agree to the
                                    <a href="#" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                                        Terms of Service
                                    </a>
                                    and
                                    <a href="#" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                                        Privacy Policy
                                    </a>
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a class="underline text-sm text-neutral-600 hover:text-neutral-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('login') }}">
                                {{ __('Already have an account?') }}
                            </a>

                            <button type="submit" id="submitBtn" class="px-6 py-3 gradient-primary text-white font-semibold rounded-lg hover:opacity-90 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submitText">Create Account</span>
                                <span id="submitLoading" class="hidden">
                                    <span class="loading-dots">Creating Account</span>
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
                    <i class="fas fa-heart mr-2"></i>
                    Mind<span class="text-secondary-300">Well</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 flex-1 flex flex-col justify-center fade-in-up">
                <div class="max-w-md">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6">Welcome</h1>
                    <p class="text-xl opacity-90 mb-8">
                        Begin your journey to better mental health and mindfulness.
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 breathe">
                                <i class="fas fa-heartbeat text-secondary-300"></i>
                            </div>
                            <span>Daily Mood Tracking & Analytics</span>
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
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Elemen password & toggle
            const passwordInput = document.getElementById("password");
            const passwordConfirmInput = document.getElementById("password_confirmation");
            const passwordToggle = document.querySelector(".password-toggle");
            const passwordConfirmToggle = document.querySelector(".password-confirm-toggle");

            const submitBtn = document.getElementById("submitBtn");
            const submitText = document.getElementById("submitText");
            const submitLoading = document.getElementById("submitLoading");

            // Toggle visibility
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

            // Cek kekuatan password
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

                len.innerHTML = `<i class="fas fa-${hasLen ? "check text-green-500" : "times text-red-500"} mr-1"></i>At least 8 characters`;
                up.innerHTML = `<i class="fas fa-${hasUp ? "check text-green-500" : "times text-red-500"} mr-1"></i>One uppercase letter`;
                num.innerHTML = `<i class="fas fa-${hasNum ? "check text-green-500" : "times text-red-500"} mr-1"></i>One number`;

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

            // Cek apakah konfirmasi password sama
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

            // Loading state saat tombol submit ditekan
            const form = document.querySelector("form");
            form?.addEventListener("submit", (e) => {
                const pwd = passwordInput?.value || "";
                const conf = passwordConfirmInput?.value || "";
                if (pwd !== conf) {
                    e.preventDefault();
                    alert("Please make sure your passwords match.");
                    return;
                }
                submitBtn.disabled = true;
                submitText.classList.add("hidden");
                submitLoading.classList.remove("hidden");
            });

            // Add breathing animation to wellness elements
            const wellnessIcons = document.querySelectorAll('.breathe');
            wellnessIcons.forEach((icon, index) => {
                icon.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>
</body>
</html>