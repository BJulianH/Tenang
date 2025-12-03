<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MoodTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user()->load(['moodTrackings' => function($query) {
            $query->latest()->take(10);
        }]);
        
        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'bio' => 'nullable|string|max:500',
        ], [
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengupdate profil.')
                ->with('active_tab', 'edit-profile');
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->birthdate,
                'bio' => $request->bio,
            ]);

            return redirect()->back()
                ->with('success', 'Profil berhasil diperbarui!')
                ->with('active_tab', 'edit-profile');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->with('active_tab', 'edit-profile');
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'new_password.min' => 'Kata sandi minimal harus 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengubah kata sandi.')
                ->with('active_tab', 'change-password');
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Kata sandi saat ini tidak sesuai.')
                ->with('active_tab', 'change-password');
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->back()
                ->with('success', 'Kata sandi berhasil diubah!')
                ->with('active_tab', 'change-password');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah kata sandi: ' . $e->getMessage())
                ->with('active_tab', 'change-password');
        }
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'File harus berupa gambar (JPEG, PNG, JPG, GIF, WEBP) dengan ukuran maksimal 2MB.')
                ->with('active_tab', 'edit-profile');
        }

        $user = Auth::user();

        try {
            if ($request->hasFile('avatar')) {
                // Pastikan folder avatars exists
                if (!Storage::disk('public')->exists('avatars')) {
                    Storage::disk('public')->makeDirectory('avatars');
                }

                // Hapus avatar lama jika ada
                if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                    Storage::disk('public')->delete('avatars/' . $user->avatar);
                }

                // Generate nama file yang unik
                $avatarName = $user->id . '_avatar_' . time() . '.' . $request->avatar->getClientOriginalExtension();
                
                // Simpan avatar baru
                $path = $request->avatar->storeAs('avatars', $avatarName, 'public');

                $user->update([
                    'avatar' => $avatarName
                ]);

                return redirect()->back()
                    ->with('success', 'Foto profil berhasil diubah!')
                    ->with('active_tab', 'edit-profile');
            }
        } catch (\Exception $e) {
            \Log::error('Avatar upload error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengubah foto profil: ' . $e->getMessage())
                ->with('active_tab', 'edit-profile');
        }

        return redirect()->back()
            ->with('error', 'Tidak ada file yang diunggah.')
            ->with('active_tab', 'edit-profile');
    }
}