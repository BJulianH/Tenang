<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Tenang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f7ea',
                            100: '#c2ebd0',
                            200: '#9bdfb5',
                            300: '#70d399',
                            400: '#4dc982',
                            500: '#58cc70',
                            600: '#45b259',
                            700: '#339847',
                            800: '#237e36',
                            900: '#156427',
                        },
                        secondary: {
                            50: '#fff9e6',
                            100: '#ffefbf',
                            200: '#ffe599',
                            300: '#ffdb70',
                            400: '#ffd14c',
                            500: '#ffc800',
                            600: '#e6b400',
                            700: '#cc9f00',
                            800: '#b38b00',
                            900: '#997700',
                        },
                        accent: {
                            blue: '#4a8cff',
                            red: '#ff6b6b',
                            purple: '#9b59b6',
                            orange: '#ff9f43',
                        },
                        neutral: {
                            50: '#f8f9fa',
                            100: '#e9ecef',
                            200: '#dee2e6',
                            300: '#ced4da',
                            400: '#adb5bd',
                            500: '#6c757d',
                            600: '#495057',
                            700: '#343a40',
                            800: '#212529',
                            900: '#121416',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    borderRadius: {
                        'duo': '16px',
                    },
                    boxShadow: {
                        'duo': '0 4px 0 rgba(0, 0, 0, 0.1)',
                        'duo-lg': '0 6px 0 rgba(0, 0, 0, 0.1)',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 3px solid #f1f3f4;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        }

        .app-button {
            background: #58cc70;
            color: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 #45b259;
            transition: all 0.2s ease;
            font-weight: 700;
            border: none;
            padding: 12px 24px;
        }

        .app-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #45b259;
        }

        .app-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #45b259;
        }

        .app-button-secondary {
            background: #ffc800;
            box-shadow: 0 4px 0 #e6b400;
        }

        .app-button-secondary:hover {
            box-shadow: 0 6px 0 #e6b400;
        }

        .token-box {
            background: linear-gradient(135deg, #58cc70, #45b259);
            color: white;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            border: 3px solid #45b259;
            box-shadow: 0 4px 0 #339847;
        }

        .success-animation {
            animation: celebrate 0.6s ease-out;
        }

        @keyframes celebrate {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-neutral-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-6">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center mb-4 success-animation">
                <i class="fas fa-paper-plane text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-neutral-800">Tenang</h1>
            <p class="mt-2 text-neutral-600 text-lg">Aplikasi Kesehatan Mental</p>
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-neutral-800">Token Terkirim!</h2>
                <p class="mt-2 text-neutral-600">Cek email Anda untuk mendapatkan token reset password</p>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card p-8">
            <div class="text-center space-y-6">
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto border-4 border-green-200">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                
                <!-- Message -->
                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-neutral-800">Email Terkirim!</h3>
                    <p class="text-neutral-600">
                        Kami telah mengirimkan token reset password ke email Anda. 
                        Token akan kedaluwarsa dalam 1 jam.
                    </p>
                </div>

                <!-- Token Display -->
                @if(session('token'))
                <div class="space-y-3">
                    <p class="text-sm font-medium text-neutral-700">Token Anda:</p>
                    <div class="token-box">
                        {{ session('token') }}
                    </div>
                    <p class="text-xs text-neutral-500">
                        Salin token ini jika email tidak diterima
                    </p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="space-y-4 pt-4">
                    @if(session('token'))
                    <a href="{{ route('password.verify') }}?token={{ session('token') }}" 
                       class="w-full app-button py-4 px-6 text-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt mr-3"></i>
                        Verifikasi Token Sekarang
                    </a>
                    @endif

                    <a href="{{ route('password.verify') }}" 
                       class="w-full app-button-secondary py-4 px-6 text-lg flex items-center justify-center">
                        <i class="fas fa-key mr-3"></i>
                        Masukkan Token Manual
                    </a>

                    <div class="flex space-x-4 pt-2">
                        <a href="{{ route('password.request') }}" 
                           class="flex-1 text-center text-primary-600 hover:text-primary-700 font-medium py-2 text-sm">
                            <i class="fas fa-redo mr-1"></i>
                            Minta Token Baru
                        </a>
                        <a href="{{ route('login') }}" 
                           class="flex-1 text-center text-neutral-600 hover:text-neutral-700 py-2 text-sm">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Kembali Login
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Messages -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-duo">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-duo">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-duo">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Information Box -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-duo">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 font-medium">Tips Penting</p>
                    <ul class="text-sm text-blue-600 mt-1 space-y-1">
                        <li>• Cek folder <strong>spam</strong> jika email tidak ditemukan</li>
                        <li>• Token berlaku <strong>1 jam</strong> sejak dikirim</li>
                        <li>• Simpan token dengan aman</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Support Info -->
        <div class="text-center">
            <p class="text-xs text-neutral-500">
                Butuh bantuan? <a href="#" class="text-primary-600 hover:text-primary-700">Hubungi support</a>
            </p>
        </div>
    </div>

    <script>
        // Auto-copy token when clicked
        document.addEventListener('DOMContentLoaded', function() {
            const tokenElement = document.querySelector('.token-box');
            if (tokenElement) {
                tokenElement.addEventListener('click', function() {
                    const token = this.textContent.trim();
                    navigator.clipboard.writeText(token).then(function() {
                        // Show copied feedback
                        const originalText = tokenElement.innerHTML;
                        tokenElement.innerHTML = '<i class="fas fa-check mr-2"></i>Token Disalin!';
                        tokenElement.style.background = 'linear-gradient(135deg, #ffc800, #e6b400)';
                        
                        setTimeout(function() {
                            tokenElement.innerHTML = originalText;
                            tokenElement.style.background = 'linear-gradient(135deg, #58cc70, #45b259)';
                        }, 2000);
                    });
                });
            }
        });
    </script>
</body>
</html>