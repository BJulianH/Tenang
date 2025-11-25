<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - StudyHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-bg {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .card-shadow {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
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

            0%,
            100% {
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

            0%,
            20% {
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

            80%,
            100% {
                text-shadow:
                    .25em 0 0 white,
                    .5em 0 0 white;
            }
        }

    </style>
</head>
<body class="login-bg max-h-full overflow-hidden">
    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Left Panel - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative order-2 lg:order-1">
            <!-- Background untuk mobile -->
            <div class="lg:hidden absolute inset-0 bg-blue-400 -z-10 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full"></div>
                <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full"></div>
                <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full"></div>
                <div class="absolute bottom-40 right-10 w-12 h-12 bg-white rounded-full"></div>
            </div>

            <!-- Mobile Header -->
            <div class="lg:hidden absolute top-8 left-8 z-20">
                <a href="/" class="text-2xl font-bold text-blue-600 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Study<span class="text-yellow-500">Hub</span>
                </a>
            </div>

            <div class="w-full max-w-md z-10">
                <!-- Register Form Container -->
                <div class="bg-white rounded-2xl p-8 card-shadow fade-in-up">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
                        <p class="text-gray-600">Join thousands of learners worldwide</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                    <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror" placeholder="Enter your full name">
                            </div>
                            @error('name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror" placeholder="Enter your email">
                            </div>
                            @error('email')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror" placeholder="Create a password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                                    <i class="fas fa-eye-slash text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                            <div id="password-strength" class="password-strength"></div>
                            <div id="password-hints" class="text-xs text-gray-500 mt-2">
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
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Confirm your password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-confirm-toggle">
                                    <i class="fas fa-eye-slash text-gray-400 hover:text-gray-600"></i>
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
                                <input type="checkbox" name="terms" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" required>
                                <span class="ml-2 text-sm text-gray-600">
                                    I agree to the
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                        Terms of Service
                                    </a>
                                    and
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                        Privacy Policy
                                    </a>
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <button type="submit" id="submitBtn" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submitText">Register</span>
                                <span id="submitLoading" class="hidden">
                                    <span class="loading-dots">Registering</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Panel - Visualization (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-blue-400 text-white p-8 lg:p-12 flex-col justify-between relative overflow-hidden order-1 lg:order-2">
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
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Study<span class="text-yellow-300">Hub</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 flex-1 flex flex-col justify-center fade-in-up">
                <div class="max-w-md">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6">Join Us</h1>
                    <p class="text-xl opacity-90 mb-8">
                        Start your learning journey with personalized courses and AI-powered tutors.
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-robot text-yellow-300"></i>
                            </div>
                            <span>AI-Powered Learning Assistant</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-book-open text-yellow-300"></i>
                            </div>
                            <span>Personalized Study Paths</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-chart-line text-yellow-300"></i>
                            </div>
                            <span>Progress Tracking & Analytics</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-center lg:text-left opacity-80 text-sm">
                <p>© 2023 StudyHub. Empowering learners worldwide.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const passwordToggle = document.querySelector('.password-toggle');
            const passwordConfirmToggle = document.querySelector('.password-confirm-toggle');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            // Toggle password visibility
            function setupPasswordToggle(button, input) {
                if (button && input) {
                    button.addEventListener('click', function() {
                        const icon = this.querySelector('i');
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        }
                    });
                }
            }

            setupPasswordToggle(passwordToggle, passwordInput);
            setupPasswordToggle(passwordConfirmToggle, passwordConfirmInput);

            // Password strength checker
            function checkPasswordStrength() {
                const password = passwordInput.value;
                const strengthBar = document.getElementById('password-strength');

                if (!strengthBar) return;

                // Reset strength bar
                strengthBar.className = 'password-strength';
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = 'transparent';

                // Reset hints
                const lengthHint = document.getElementById('length');
                const uppercaseHint = document.getElementById('uppercase');
                const numberHint = document.getElementById('number');

                // Check password criteria
                const hasLength = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

                // Update hints
                if (lengthHint) {
                    lengthHint.innerHTML = `<i class="fas fa-${hasLength ? 'check' : 'times'} ${hasLength ? 'text-green-500' : 'text-red-500'} mr-1"></i><span>At least 8 characters</span>`;
                }
                if (uppercaseHint) {
                    uppercaseHint.innerHTML = `<i class="fas fa-${hasUppercase ? 'check' : 'times'} ${hasUppercase ? 'text-green-500' : 'text-red-500'} mr-1"></i><span>One uppercase letter</span>`;
                }
                if (numberHint) {
                    numberHint.innerHTML = `<i class="fas fa-${hasNumber ? 'check' : 'times'} ${hasNumber ? 'text-green-500' : 'text-red-500'} mr-1"></i><span>One number</span>`;
                }

                // Only show strength bar if there's input
                if (password.length > 0) {
                    // Calculate strength score
                    let strength = 0;
                    if (hasLength) strength++;
                    if (hasUppercase) strength++;
                    if (hasNumber) strength++;
                    if (hasSpecial) strength++;

                    // Apply strength classes
                    if (strength === 1) {
                        strengthBar.classList.add('strength-weak');
                    } else if (strength === 2) {
                        strengthBar.classList.add('strength-medium');
                    } else if (strength === 3) {
                        strengthBar.classList.add('strength-strong');
                    } else if (strength >= 4) {
                        strengthBar.classList.add('strength-very-strong');
                    }
                }

                checkPasswordMatch();
            }

            // Password match checker
            function checkPasswordMatch() {
                const password = passwordInput ? .value || '';
                const confirmPassword = passwordConfirmInput ? .value || '';
                const matchIndicator = document.getElementById('password-match');
                const mismatchIndicator = document.getElementById('password-mismatch');

                if (!matchIndicator || !mismatchIndicator) return;

                if (confirmPassword.length === 0) {
                    matchIndicator.classList.add('hidden');
                    mismatchIndicator.classList.add('hidden');
                } else if (password === confirmPassword) {
                    matchIndicator.classList.remove('hidden');
                    mismatchIndicator.classList.add('hidden');
                } else {
                    matchIndicator.classList.add('hidden');
                    mismatchIndicator.classList.remove('hidden');
                }
            }

            // Event listeners for real-time validation
            if (passwordInput) {
                passwordInput.addEventListener('input', checkPasswordStrength);
                passwordInput.addEventListener('keyup', checkPasswordStrength);
                passwordInput.addEventListener('change', checkPasswordStrength);
            }

            if (passwordConfirmInput) {
                passwordConfirmInput.addEventListener('input', checkPasswordMatch);
                passwordConfirmInput.addEventListener('keyup', checkPasswordMatch);
                passwordConfirmInput.addEventListener('change', checkPasswordMatch);
            }

            // Form submission handling
            const registerForm = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    // Basic validation before showing loading state
                    const password = passwordInput ? .value || '';
                    const confirmPassword = passwordConfirmInput ? .value || '';

                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Please make sure your passwords match.');
                        return;
                    }

                    // Show loading state
                    if (submitBtn && submitText && submitLoading) {
                        submitBtn.disabled = true;
                        submitText.classList.add('hidden');
                        submitLoading.classList.remove('hidden');
                    }
                });
            }

            // Add focus effects to inputs
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
                });
            });

            // Initialize strength check on page load if there's existing value
            if (passwordInput && passwordInput.value) {
                checkPasswordStrength();
            }
        });

    </script>
</body>
</html>
