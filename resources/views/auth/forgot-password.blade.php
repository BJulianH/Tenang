<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Tenang</title>
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
                            500: '#ffc800',
                            600: '#e6b400',
                        },
                        accent: {
                            red: '#ff6b6b',
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
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            border: 3px solid #f1f3f4;
        }

        .btn-primary {
            background: #58cc70;
            color: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 #45b259;
            transition: all 0.2s ease;
            font-weight: 700;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #45b259;
        }

        .btn-primary:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #45b259;
        }

        .input-field {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: #58cc70;
            box-shadow: 0 0 0 3px rgba(88, 204, 112, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-6">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-lock text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Tenang</h1>
            <p class="mt-2 text-gray-600">Aplikasi Kesehatan Mental</p>
            <p class="mt-4 text-gray-700 font-medium">Lupa Password?</p>
            <p class="text-sm text-gray-600">Masukkan email Anda untuk mendapatkan reset token</p>
        </div>

        <!-- Form -->
        <div class="card p-8">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            class="pl-10 pr-4 py-3 w-full input-field focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="email@example.com"
                            value="{{ old('email') }}"
                            autofocus
                        >
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary py-3 px-4 text-lg">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Reset Token
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        <!-- Messages -->
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

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-accent-red p-4 rounded-duo">
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

        <!-- Debug Info -->
        <div class="text-center text-xs text-gray-500 mt-4">
            <p>Untuk testing: Gunakan email yang sudah terdaftar di database</p>
        </div>
    </div>
</body>
</html>