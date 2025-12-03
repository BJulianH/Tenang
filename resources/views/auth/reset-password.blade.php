<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Reset Password - Tenang</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 4px solid #f1f3f4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #f1f3f4;
        }
        
        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #58cc70;
            margin-bottom: 5px;
        }
        
        .subtitle {
            color: #6c757d;
            font-size: 16px;
        }
        
        .token-display {
            background: linear-gradient(135deg, #58cc70, #45b259);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            font-size: 42px;
            font-weight: bold;
            margin: 25px 0;
            letter-spacing: 10px;
            font-family: 'Courier New', monospace;
            border: 4px solid #45b259;
            box-shadow: 0 6px 0 #339847;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .token-digits {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        
        .token-digit {
            width: 60px;
            height: 80px;
            background: linear-gradient(135deg, #58cc70, #45b259);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            border-radius: 12px;
            border: 3px solid #45b259;
            box-shadow: 0 4px 0 #339847;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #ffc800, #e6b400);
            color: white;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 16px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 6px 0 #cc9f00;
            transition: all 0.2s ease;
            border: none;
        }
        
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 0 #cc9f00;
        }
        
        .info-box {
            background: #e6f7ea;
            border-left: 5px solid #58cc70;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .warning-box {
            background: #fff3cd;
            border-left: 5px solid #ffc800;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 3px solid #f1f3f4;
            color: #6c757d;
            font-size: 14px;
        }
        
        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        
        .step-number {
            background: #58cc70;
            color: white;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
            font-size: 14px;
        }
        
        .step-content {
            flex: 1;
            font-size: 14px;
        }
        
        @media only screen and (max-width: 500px) {
            .container {
                padding: 25px;
                margin: 10px;
            }
            
            .token-display {
                font-size: 32px;
                padding: 20px;
                letter-spacing: 8px;
            }
            
            .token-digit {
                width: 45px;
                height: 60px;
                font-size: 28px;
            }
            
            .button {
                padding: 14px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">Tenang</div>
            <div class="subtitle">Aplikasi Kesehatan Mental</div>
            <h1 style="color: #333; margin-top: 15px; font-size: 22px;">Token Reset Password</h1>
        </div>
        
        <!-- Greeting -->
        <p style="margin-bottom: 15px; font-size: 16px;">Halo,</p>
        <p style="margin-bottom: 20px; font-size: 16px;">
            Anda meminta reset password. Berikut adalah token 6-digit Anda:
        </p>
        
        <!-- Token Display -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Token 6-Digit
    </label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-shield-alt text-gray-400"></i>
        </div>
            <input 
                type="text" 
                class="pl-10 pr-4 py-3 w-full token-display rounded-duo text-center text-2xl font-bold tracking-widest"
                value="{{ $token }}"
                readonly
                disabled
            >
        </div>
        <p class="mt-1 text-xs text-gray-500">Token 6-digit telah dikirim ke email Anda</p>
    </div>
        
        <!-- Token dalam bentuk digit terpisah -->
        <div class="token-digits">
            @for($i = 0; $i < 6; $i++)
            <div class="token-digit">{{ substr($token, $i, 1) }}</div>
            @endfor
        </div>
        
        <!-- Instructions -->
        <div class="info-box">
            <h3 style="color: #156427; margin-bottom: 15px; font-size: 16px;">📝 Cara Menggunakan Token:</h3>
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <strong>Masukkan 6-digit token</strong> di atas ke halaman verifikasi
                </div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <strong>Klik tombol "Verifikasi Token"</strong> di bawah
                </div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <strong>Buat password baru</strong> untuk akun Anda
                </div>
            </div>
        </div>
        
        <!-- Action Button -->
        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ url('/verify-token?token=' . $token) }}" class="button">
                🔑 Verifikasi Token Sekarang
            </a>
        </div>
        
        <!-- Warning -->
        <div class="warning-box">
            <h3 style="color: #856404; margin-bottom: 10px; font-size: 15px;">⏰ Penting:</h3>
            <p style="margin: 0; color: #856404;">
                Token ini akan <strong>kedaluwarsa dalam 1 jam</strong>. 
                Jangan bagikan token ini kepada siapapun.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 8px;">&copy; {{ date('Y') }} Tenang. All rights reserved.</p>
            <p style="font-size: 12px; color: #adb5bd;">
                Email ini dikirim secara otomatis. Mohon tidak membalas.
            </p>
        </div>
    </div>
</body>
</html>