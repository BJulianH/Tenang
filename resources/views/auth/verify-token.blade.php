<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Token - Tenang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#58cc70',
                            600: '#45b259',
                        },
                        secondary: {
                            500: '#ffc800',
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

        .input-field {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-family: monospace;
            letter-spacing: 10px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
        }

        .input-field:focus {
            border-color: #58cc70;
            box-shadow: 0 0 0 3px rgba(88, 204, 112, 0.1);
        }

        .token-digit {
            display: inline-block;
            width: 50px;
            height: 60px;
            margin: 0 5px;
            text-align: center;
            font-size: 28px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: white;
        }

        .token-digit:focus {
            border-color: #58cc70;
            outline: none;
            box-shadow: 0 0 0 3px rgba(88, 204, 112, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-6">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-20 h-20 bg-secondary-500 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Tenang</h1>
            <p class="mt-2 text-gray-600">Masukkan Token 6 Digit</p>
        </div>

        <!-- Form -->
        <div class="card p-8">
            <form method="POST" action="{{ route('password.verify.submit') }}" class="space-y-6" id="tokenForm">
                @csrf
                
                <div class="text-center">
                    <p class="text-gray-600 mb-6">
                        Masukkan 6-digit token yang dikirim ke email Anda
                    </p>
                </div>

                <!-- 6-Digit Token Input -->
                <div class="flex justify-center mb-6" id="tokenDigits">
                    @for($i = 1; $i <= 6; $i++)
                    <input 
                        type="text" 
                        maxlength="1" 
                        class="token-digit"
                        data-index="{{ $i-1 }}"
                        oninput="moveToNext(this)"
                        onkeydown="handleKeyDown(event, {{ $i-1 }})"
                        autocomplete="off"
                    >
                    @endfor
                </div>
                
                <!-- Hidden input untuk token lengkap -->
                <input type="hidden" name="token" id="fullToken">

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary py-3 px-4 text-lg" id="submitBtn" disabled>
                    <i class="fas fa-check-circle mr-2"></i>
                    Verifikasi Token
                </button>

                <div class="flex justify-between text-sm">
                    <a href="{{ route('password.request') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        <i class="fas fa-redo mr-1"></i>
                        Minta Token Baru
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-700">
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

        <!-- Instructions -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-duo">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Contoh Token:</strong> 123456, 789012, dll.
                        Token berupa 6 digit angka.
                    </p>
                </div>
            </div>
        </div>

        <!-- Auto-fill dari session -->
        @if(session('token'))
        <div class="bg-yellow-50 border border-yellow-200 rounded-duo p-4">
            <div class="flex items-center">
                <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                <div>
                    <p class="text-sm font-medium text-yellow-800">
                        Token terbaru: <span class="font-mono font-bold">{{ session('token') }}</span>
                    </p>
                    <button onclick="autoFillToken('{{ session('token') }}')" 
                            class="text-primary-600 hover:text-primary-700 font-medium text-sm mt-1">
                        <i class="fas fa-magic mr-1"></i>Isi otomatis
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Ambil semua input digit
        const digitInputs = document.querySelectorAll('.token-digit');
        const fullTokenInput = document.getElementById('fullToken');
        const submitBtn = document.getElementById('submitBtn');

        // Fungsi untuk pindah ke next input
        function moveToNext(input) {
            const index = parseInt(input.dataset.index);
            const value = input.value;
            
            // Hanya terima angka
            if (!/^\d$/.test(value)) {
                input.value = '';
                return;
            }
            
            // Jika ada value dan bukan digit terakhir, pindah ke next
            if (value && index < digitInputs.length - 1) {
                digitInputs[index + 1].focus();
            }
            
            // Update token lengkap
            updateFullToken();
            
            // Cek apakah semua digit sudah diisi
            checkAllDigits();
        }

        // Fungsi handle keyboard
        function handleKeyDown(event, index) {
            // Jika tekan backspace dan input kosong, pindah ke previous
            if (event.key === 'Backspace' && !digitInputs[index].value && index > 0) {
                digitInputs[index - 1].focus();
            }
            
            // Jika tekan delete, clear current
            if (event.key === 'Delete') {
                digitInputs[index].value = '';
                updateFullToken();
                checkAllDigits();
            }
        }

        // Update token lengkap
        function updateFullToken() {
            let token = '';
            digitInputs.forEach(input => {
                token += input.value;
            });
            fullTokenInput.value = token;
        }

        // Cek apakah semua digit sudah diisi
        function checkAllDigits() {
            let allFilled = true;
            digitInputs.forEach(input => {
                if (!input.value) {
                    allFilled = false;
                }
            });
            
            submitBtn.disabled = !allFilled;
            if (allFilled) {
                submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Verifikasi Token';
            } else {
                submitBtn.innerHTML = '<i class="fas fa-lock mr-2"></i> Masukkan 6 Digit Token';
            }
        }

        // Auto-fill token dari session
        function autoFillToken(token) {
            if (token.length === 6) {
                for (let i = 0; i < 6; i++) {
                    digitInputs[i].value = token[i];
                }
                updateFullToken();
                checkAllDigits();
                
                // Auto submit setelah 1 detik
                setTimeout(() => {
                    document.getElementById('tokenForm').submit();
                }, 1000);
            }
        }

        // Auto-fill jika ada token di URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            
            if (token && token.length === 6) {
                autoFillToken(token);
            }
            
            // Focus ke input pertama
            if (digitInputs[0]) {
                digitInputs[0].focus();
            }
        });
    </script>
</body>
</html>