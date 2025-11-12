<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - StudyHub</title>
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

    <!-- Main Content Container -->
    <div class="w-full max-w-md z-10">
        <div class="bg-white rounded-2xl p-8 card-shadow fade-in-up">
            <!-- Form Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Confirm Password</h2>
            </div>

            <!-- Instruction Text -->
            <div class="mb-6 text-sm text-gray-600 text-center">
                This is a secure area of the application. Please confirm your password before continuing.
            </div>

            <form method="POST" action="#" id="confirmPasswordForm">
                @csrf

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
                            class="block mt-1 w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password" />
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle">
                            <i class="fas fa-eye-slash text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    <div class="text-red-600 text-sm mt-2 hidden" id="password-error">
                        <!-- Error messages will appear here -->
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        Confirm
                    </button>
                </div>
            </form>
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

        // Form submission handler
        document.getElementById('confirmPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const passwordError = document.getElementById('password-error');
            const password = document.getElementById('password').value;
            
            // Reset error state
            passwordError.classList.add('hidden');
            passwordError.innerHTML = '';
            
            // Basic password validation
            if (!password) {
                passwordError.innerHTML = 'Please enter your password.';
                passwordError.classList.remove('hidden');
                return;
            }
            
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Confirming...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(function() {
                // For demo purposes, assume password is correct
                // In real application, this would be handled by Laravel backend
                
                // Show success (in real app, this would redirect)
                alert('Password confirmed successfully! Redirecting...');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Clear form
                document.getElementById('password').value = '';
            }, 1500);
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

        // Simulate error message (for demo purposes)
        // Uncomment below to see how error messages would appear
        /*
        setTimeout(function() {
            const passwordError = document.getElementById('password-error');
            passwordError.innerHTML = 'The provided password is incorrect.';
            passwordError.classList.remove('hidden');
        }, 1000);
        */
    </script>
</body>
</html>