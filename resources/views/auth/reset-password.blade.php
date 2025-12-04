<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - StudyHub</title>
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

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }
        
        .strength-weak {
            width: 25%;
            background-color: #ef4444;
        }
        
        .strength-medium {
            width: 50%;
            background-color: #f59e0b;
        }
        
        .strength-strong {
            width: 75%;
            background-color: #3b82f6;
        }
        
        .strength-very-strong {
            width: 100%;
            background-color: #10b981;
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
        <a href="login.html" class="text-blue-600 hover:text-blue-800 font-medium transition-colors flex items-center">
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
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Reset Password</h2>
                <p class="text-gray-600">Create your new password</p>
            </div>

            <form method="POST" action="#" id="resetPasswordForm">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="demo_token">

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
                            autocomplete="username"
                            placeholder="Enter your email address" />
                    </div>
                    <div class="text-red-600 text-sm mt-2 hidden" id="email-error">
                        <!-- Error messages will appear here -->
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
                            class="block mt-1 w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Enter new password" />
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
                    <div class="text-red-600 text-sm mt-2 hidden" id="password-error">
                        <!-- Error messages will appear here -->
                    </div>
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
                        <input 
                            id="password_confirmation" 
                            class="block mt-1 w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm new password" />
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
                    <div class="text-red-600 text-sm mt-2 hidden" id="password_confirmation-error">
                        <!-- Error messages will appear here -->
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                        <i class="fas fa-redo mr-2"></i>
                        Reset Password
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

        // Toggle confirm password visibility
        document.querySelector('.password-confirm-toggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
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

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength');
            const hints = document.getElementById('password-hints');
            
            // Reset hints
            const lengthHint = document.getElementById('length');
            const uppercaseHint = document.getElementById('uppercase');
            const numberHint = document.getElementById('number');
            
            // Check password criteria
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            
            // Update hints
            lengthHint.innerHTML = `<i class="fas fa-${hasLength ? 'check' : 'times'} text-${hasLength ? 'green' : 'red'}-500 mr-1"></i><span>At least 8 characters</span>`;
            uppercaseHint.innerHTML = `<i class="fas fa-${hasUppercase ? 'check' : 'times'} text-${hasUppercase ? 'green' : 'red'}-500 mr-1"></i><span>One uppercase letter</span>`;
            numberHint.innerHTML = `<i class="fas fa-${hasNumber ? 'check' : 'times'} text-${hasNumber ? 'green' : 'red'}-500 mr-1"></i><span>One number</span>`;
            
            // Calculate strength
            let strength = 0;
            if (hasLength) strength++;
            if (hasUppercase) strength++;
            if (hasNumber) strength++;
            
            // Update strength bar
            strengthBar.className = 'password-strength';
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = 'transparent';
            } else if (strength === 1) {
                strengthBar.classList.add('strength-weak');
            } else if (strength === 2) {
                strengthBar.classList.add('strength-medium');
            } else if (strength === 3) {
                strengthBar.classList.add('strength-strong');
            }
            
            // Check password match
            checkPasswordMatch();
        });

        // Password match checker
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchIndicator = document.getElementById('password-match');
            const mismatchIndicator = document.getElementById('password-mismatch');
            
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

        // Form submission handler
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            const passwordConfirmError = document.getElementById('password_confirmation-error');
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            // Reset error states
            emailError.classList.add('hidden');
            passwordError.classList.add('hidden');
            passwordConfirmError.classList.add('hidden');
            
            // Validation
            let isValid = true;
            
            if (!email || !email.includes('@')) {
                emailError.innerHTML = 'Please enter a valid email address.';
                emailError.classList.remove('hidden');
                isValid = false;
            }
            
            if (!password) {
                passwordError.innerHTML = 'Please enter a password.';
                passwordError.classList.remove('hidden');
                isValid = false;
            }
            
            if (password !== confirmPassword) {
                passwordConfirmError.innerHTML = 'Passwords do not match.';
                passwordConfirmError.classList.remove('hidden');
                isValid = false;
            }
            
            if (!isValid) return;
            
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Resetting...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(function() {
                // Show success message
                alert('Password has been reset successfully! Redirecting to login...');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // In real application, this would redirect to login page
                // window.location.href = 'login.html';
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
    </script>
</body>
</html>