<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - StudyHub</title>
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
                    <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Verify Your Email</h2>
            </div>

            <!-- Instruction Text -->
            <div class="mb-6 text-sm text-gray-600 text-center">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            <!-- Success Message (Hidden by default) -->
            <div id="success-message" class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm hidden">
                <div class="flex items-start">
                    <i class="fas fa-check-circle mt-0.5 mr-3"></i>
                    <p>A new verification link has been sent to the email address you provided during registration.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between space-x-4">
                <!-- Resend Verification Form -->
                <form method="POST" action="#" id="resendVerificationForm">
                    @csrf
                    <div>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Resend Verification Email
                        </button>
                    </div>
                </form>

                <!-- Logout Form -->
                <form method="POST" action="#" id="logoutForm">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 py-2 px-3">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Log Out
                    </button>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Didn't receive the email?</p>
                        <p class="mt-1">Check your spam folder or make sure you entered the correct email address.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Resend Verification Form handler
        document.getElementById('resendVerificationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const successMessage = document.getElementById('success-message');
            
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(function() {
                // Show success message
                successMessage.classList.remove('hidden');
                successMessage.classList.add('fade-in-up');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Hide success message after 5 seconds
                setTimeout(function() {
                    successMessage.classList.add('hidden');
                }, 5000);
            }, 1500);
        });

        // Logout Form handler
        document.getElementById('logoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Logging out...';
            submitBtn.disabled = true;
            
            // Simulate logout process
            setTimeout(function() {
                alert('You have been logged out successfully!');
                // In real application, this would redirect to login page
                // window.location.href = 'login.html';
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1000);
        });

        // Simulate session status (for demo purposes)
        // Uncomment below to simulate a success message on page load
        /*
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            successMessage.classList.remove('hidden');
            successMessage.classList.add('fade-in-up');
        }, 500);
        */
    </script>
</body>
</html>