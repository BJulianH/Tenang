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

});
</script>

</body>
</html>
