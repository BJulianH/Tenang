<?php

namespace App\Http\Controllers; // Pastikan namespace ini

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.profile', compact('user'));
    }

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

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
        ], [
            'new_password.regex' => 'Kata sandi harus mengandung setidaknya 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter khusus.',
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
                // Hapus avatar lama jika ada
                if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                    Storage::delete('public/avatars/' . $user->avatar);
                }

                // Generate nama file yang unik
                $avatarName = $user->id . '_avatar_' . time() . '.' . $request->avatar->getClientOriginalExtension();
                
                // Simpan avatar baru
                $request->avatar->storeAs('public/avatars', $avatarName);

                $user->update([
                    'avatar' => $avatarName
                ]);

                return redirect()->back()
                    ->with('success', 'Foto profil berhasil diubah!')
                    ->with('active_tab', 'edit-profile');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah foto profil: ' . $e->getMessage())
                ->with('active_tab', 'edit-profile');
        }

        return redirect()->back()
            ->with('error', 'Tidak ada file yang diunggah.')
            ->with('active_tab', 'edit-profile');
    }
}