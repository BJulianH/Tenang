<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    // Tampilkan halaman settings
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    // Update profile settings
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'phone' => 'nullable|string|max:20',
            'timezone' => 'nullable|timezone',
            'locale' => 'nullable|in:id,en',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update($request->only([
            'name', 'username', 'email', 'bio', 'website', 'location',
            'date_of_birth', 'gender', 'phone', 'timezone', 'locale'
        ]));

        return redirect()->route('settings.index')
            ->with('success', 'Profile updated successfully!');
    }

    // Update social media links
    public function updateSocialLinks(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update($request->only([
            'facebook_url', 'twitter_url', 'instagram_url',
            'linkedin_url', 'github_url'
        ]));

        return redirect()->route('settings.index')
            ->with('success', 'Social links updated successfully!');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect!');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Password updated successfully!');
    }

    // Update notification settings
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $notificationSettings = [
            'email_notifications' => $request->boolean('email_notifications'),
            'push_notifications' => $request->boolean('push_notifications'),
            'community_updates' => $request->boolean('community_updates'),
            'quest_reminders' => $request->boolean('quest_reminders'),
            'new_follower' => $request->boolean('new_follower'),
            'new_comment' => $request->boolean('new_comment'),
            'new_like' => $request->boolean('new_like'),
            'weekly_digest' => $request->boolean('weekly_digest'),
            'marketing_emails' => $request->boolean('marketing_emails'),
        ];

        $user->update([
            'notification_settings' => $notificationSettings
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Notification settings updated successfully!');
    }

    // Update privacy settings
    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'profile_visibility' => $request->profile_visibility,
            'show_email' => $request->boolean('show_email'),
            'show_date_of_birth' => $request->boolean('show_date_of_birth'),
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Privacy settings updated successfully!');
    }

    // Update theme preferences
    public function updateTheme(Request $request)
    {
        $user = Auth::user();
        
        $preferences = $user->preferences ?? [];
        $preferences['theme'] = $request->theme;
        $preferences['color_scheme'] = $request->color_scheme;
        $preferences['reduce_motion'] = $request->boolean('reduce_motion');
        $preferences['high_contrast'] = $request->boolean('high_contrast');
        $preferences['large_text'] = $request->boolean('large_text');

        $user->update([
            'preferences' => $preferences
        ]);

        // Simpan theme di session untuk immediate effect
        session(['theme' => $request->theme]);

        return redirect()->route('settings.index')
            ->with('success', 'Theme preferences updated successfully!');
    }

    // Upload profile image
    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $user->update([
                'profile_image' => $path
            ]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Profile image updated successfully!');
    }

    // Upload cover image
    public function uploadCoverImage(Request $request)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = Auth::user();
        
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('cover-images', 'public');
            $user->update([
                'cover_image' => $path
            ]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Cover image updated successfully!');
    }

    // Delete account
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
            'confirmation' => 'required|accepted',
        ]);

        $user = Auth::user();
        
        // Soft delete account
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('info', 'Your account has been deleted successfully.');
    }
}