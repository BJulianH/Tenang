<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        // Generate 6-digit token
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Save to database
        $user->update([
            'reset_token' => $token,
            'reset_token_expires' => now()->addHours(1)
        ]);

        // SEND TO GMAIL
        try {
            // Log sebelum kirim
            \Log::info('Sending token to Gmail: ' . $user->email . ' | Token: ' . $token);
            
            // Kirim email
            Mail::to($user->email)->send(new PasswordResetMail($token));
            
            \Log::info('✅ Email sent to Gmail successfully!');
            
            // Redirect dengan success
            return redirect()->route('verification.notice')
                ->with([
                    'success' => '✅ Token telah dikirim ke Gmail Anda: ' . $user->email,
                    'token' => $token,
                    'sent_to' => $user->email
                ]);
                
        } catch (\Exception $e) {
            \Log::error('❌ Gmail send failed: ' . $e->getMessage());
            
            // Tetap redirect dengan token (fallback)
            return redirect()->route('verification.notice')
                ->with([
                    'warning' => '⚠️ Gagal kirim ke Gmail, gunakan token ini: ' . $token,
                    'token' => $token,
                    'error' => $e->getMessage()
                ]);
        }
    }

    return back()->with('error', '❌ Email tidak ditemukan!');
}

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:6'
        ]);

        // Cek apakah token 6 digit angka
        if (!preg_match('/^\d{6}$/', $request->token)) {
            return back()->with('error', '❌ Token harus 6 digit angka!');
        }

        $user = User::where('reset_token', $request->token)
                    ->where('reset_token_expires', '>', now())
                    ->first();

        if ($user) {
            // Token valid, redirect ke reset password
            return redirect()->route('password.reset', $request->token)
                ->with('success', '✅ Token valid! Silakan reset password Anda.')
                ->with('user_email', $user->email); // Kirim email user ke view
        }

        // Token tidak valid
        return back()->with('error', '❌ Token tidak valid atau telah kedaluwarsa!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|size:6',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('reset_token', $request->token)
                    ->where('reset_token_expires', '>', now())
                    ->first();

        if (!$user) {
            return back()->with('error', '❌ Token tidak valid atau telah kedaluwarsa!');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        return redirect()->route('login')
            ->with('success', '✅ Password berhasil direset! Silakan login dengan password baru.');
    }
}