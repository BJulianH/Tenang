<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - StudyHub</title>
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
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background decorative elements -->
    <div class="fixed inset-0 overflow-hidden -z-10">
        <div class="absolute top-10 left-10 w-20 h-20 bg-blue-400 rounded-full opacity-10 float"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-blue-400 rounded-full opacity-10 float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-20 w-24 h-24 bg-blue-400 rounded-full opacity-10 float" style="animation-delay: 4s;"></div>
        <div class="absolute bottom-40 right-10 w-12 h-12 bg-blue-400 rounded-full opacity-10 float" style="animation-delay: 1s;"></div>
    </div>

    <!-- Header Logo -->
    <div class="absolute top-8 left-8 z-20">
        <a href="/" class="text-2xl font-bold text-blue-600 flex items-center">
            <i class="fas fa-graduation-cap mr-2"></i>
            Study<span class="text-yellow-500">Hub</span>
        </a>
    </div>

    <!-- Back to Login -->
    <div class="absolute top-8 right-8 z-20">
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Login
        </a>
    </div>

    <!-- Main Content Container -->
    <div class="w-full max-w-md z-10">
        <div class="bg-white rounded-2xl p-8 card-shadow fade-in-up">
            <!-- Form Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Forgot Password</h2>
            </div>

            <!-- Instruction Text -->
            <div class="mb-6 text-sm text-gray-600 text-center">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            <!-- Session Status -->
            <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm hidden" id="session-status">
                <!-- Status message will appear here -->
            </div>

            <form method="POST" action="#" id="forgotPasswordForm">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            id="email" 
                            class="block mt-1 w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                            type="email" 
                            name="email" 
                            required 
                            autofocus 
                            placeholder="Enter your email address" />
                    </div>
                    <div class="text-red-600 text-sm mt-2 hidden" id="email-error">
                        <!-- Error messages will appear here -->
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Links -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <p>Remember your password? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    Sign in here
                </a>
            </p>
        </div>
    </div>

    <script>
        // Simulate Laravel Breeze functionality
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const sessionStatus = document.getElementById('session-status');
            const emailError = document.getElementById('email-error');
            const email = document.getElementById('email').value;
            
            // Reset states
            sessionStatus.classList.add('hidden');
            emailError.classList.add('hidden');
            emailError.innerHTML = '';
            
            // Basic email validation
            if (!email || !email.includes('@')) {
                emailError.innerHTML = 'Please enter a valid email address.';
                emailError.classList.remove('hidden');
                return;
            }
            
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(function() {
                // Show success message (simulating session status)
                sessionStatus.innerHTML = 'We have emailed your password reset link!';
                sessionStatus.classList.remove('hidden');
                sessionStatus.classList.add('fade-in-up');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Clear form
                document.getElementById('email').value = '';
            }, 2000);
        });

        // Add focus effects
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
        });

        // Simulate session status (for demo purposes)
        setTimeout(function() {
            // Uncomment below to simulate a session status message on page load
            // const sessionStatus = document.getElementById('session-status');
            // sessionStatus.innerHTML = 'We have emailed your password reset link!';
            // sessionStatus.classList.remove('hidden');
        }, 100);
    </script>
</body>
</html>