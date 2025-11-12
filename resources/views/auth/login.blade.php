<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StudyHub</title>
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

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
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
    </style>
</head>
<body class="login-bg max-h-full overflow-hidden">
    <div class="flex flex-col lg:flex-row h-screen"> <!-- Ganti h-full dengan h-screen -->
        <!-- Left Panel - Visualization (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-blue-400 text-white p-8 lg:p-12 flex-col justify-between relative overflow-hidden">
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
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6">Welcome Back</h1>
                    <p class="text-xl opacity-90 mb-8">
                        Continue your learning journey with personalized courses and AI-powered tutors.
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

        <!-- Right Panel - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative">
            <!-- Background untuk mobile (mirip dengan bagian kiri) -->
            <div class="lg:hidden absolute inset-0 bg-blue-400 -z-10 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full"></div>
                <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full"></div>
                <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full"></div>
                <div class="absolute bottom-40 right-10 w-12 h-12 bg-white rounded-full"></div>
            </div>

            <!-- Mobile Header (Logo di mobile) -->
            <div class="lg:hidden absolute top-8 left-8 z-20">
                <a href="/" class="text-2xl font-bold text-blue-600 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Study<span class="text-yellow-500">Hub</span>
                </a>
            </div>

            <div class="w-full max-w-md z-10">
                <!-- Login Form Container -->
                <div class="bg-white rounded-2xl p-8 card-shadow fade-in-up">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign In</h2>
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    <!-- Session Status -->
                    <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded-lg text-sm">
                        Welcome back! Please login to continue.
                    </div>

                    <form method="POST" action="#">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter your email">
                            </div>
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
                                <input 
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter your password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                                    <i class="fas fa-eye-slash text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="remember"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all hover:transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-6 flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-3 text-gray-500 text-sm">OR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            <span class="text-sm font-medium">Google</span>
                        </button>
                        <button class="flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fab fa-github text-gray-800 mr-2"></i>
                            <span class="text-sm font-medium">GitHub</span>
                        </button>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center mt-6">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a  href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Sign up now
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Pastikan tidak ada scroll */
        html, body {
            overflow: hidden;
            height: 100%;
        }
        
        /* Animasi untuk floating circles */
        .float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Animasi untuk form */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
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
        
        /* Shadow untuk card */
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

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
                this.parentElement.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
        });

        // Prevent form submission for demo
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login functionality would be implemented here!');
        });
    </script>
</body>
</html>