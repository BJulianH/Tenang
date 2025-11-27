<?php

namespace App\Http\Controllers;

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
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengupdate profil.');
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'bio' => $request->bio,
            ]);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
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
                ->with('error', 'Terjadi kesalahan dalam mengubah kata sandi.');
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi saat ini tidak sesuai.');
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->back()->with('success', 'Kata sandi berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah kata sandi: ' . $e->getMessage());
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

                // Debug: cek apakah file benar-benar tersimpan
                \Log::info('Avatar saved:', [
                    'path' => $path,
                    'full_path' => storage_path('app/public/' . $path),
                    'exists' => Storage::disk('public')->exists($path)
                ]);

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

    public function getMoodChartData()
    {
        $user = Auth::user();
        
        $moodData = $user->moodTrackings()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, mood, COUNT(*) as count')
            ->groupBy('date', 'mood')
            ->orderBy('date')
            ->get();
        
        $moodValues = [
            'senang' => 6,
            'tenang' => 5,
            'lelah' => 4,
            'cemas' => 3,
            'sedih' => 2,
            'marah' => 1,
            'stress' => 0
        ];
        
        // Process data for chart
        $chartData = [];
        $labels = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            
            $dayMood = $moodData->where('date', $date)->first();
            $chartData[] = $dayMood ? $moodValues[$dayMood->mood] : null;
        }
        
        return response()->json([
            'labels' => $labels,
            'data' => $chartData
        ]);
    }
}