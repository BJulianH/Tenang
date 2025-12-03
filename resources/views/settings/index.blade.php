@extends('layouts.app')

@section('title', 'Settings - Tenang')

@section('styles')
<style>
    .settings-tab {
        @apply py-3 px-4 rounded-duo text-neutral-700 transition-all duration-200;
    }
    
    .settings-tab:hover {
        @apply bg-primary-50 text-primary-600 transform -translate-y-1;
    }
    
    .settings-tab.active {
        @apply bg-primary-500 text-white shadow-duo;
    }
    
    .settings-section {
        animation: fadeIn 0.3s ease-out;
    }
    
    .profile-image-upload {
        border: 2px dashed #58cc70;
        transition: all 0.3s ease;
    }
    
    .profile-image-upload:hover {
        border-color: #45b259;
        background: #f8f9fa;
    }
    
    .theme-preview {
        @apply rounded-duo overflow-hidden border-3 border-neutral-200 transition-all duration-200;
    }
    
    .theme-preview:hover {
        @apply border-primary-300 transform scale-105;
    }
    
    .theme-preview.active {
        @apply border-primary-500 ring-2 ring-primary-300;
    }
    
    .danger-zone {
        @apply border-2 border-accent-red bg-red-50 rounded-duo;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
        border: 2px solid transparent;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
        background-color: #58cc70;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(28px);
    }
    
    .preview-card {
        @apply bg-white rounded-duo shadow-duo p-4 border-2 border-neutral-200;
        transition: all 0.3s ease;
    }
    
    .theme-light .preview-card {
        @apply bg-white text-neutral-800;
    }
    
    .theme-dark .preview-card {
        @apply bg-neutral-800 text-white border-neutral-700;
    }
    
    .theme-system .preview-card {
        background: linear-gradient(135deg, white 50%, #1a202c 50%);
        color: #1a202c;
    }
    .sidebar-item-settings {
            border-radius: 12px;
            transition: all 0.2s ease;
            background: white;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05);
            border:1px rgba(0, 0, 0, 0.171) solid;
        }

        .sidebar-item-settings:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.05);
        }

        .sidebar-item-settings.active {
            background: #58cc70;
            color: white;
            box-shadow: 0 4px 0 #45b259;
        }
</style>
@endsection

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    <!-- Sidebar Navigation -->
    <div class="lg:w-1/4">
        <div class="card p-4 sticky top-6">
            <nav class="space-y-2">
                <button onclick="showSection('profile')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-profile">
                    <i class="fas fa-user w-5"></i>
                    <span>Profile</span>
                </button>
                
                <button onclick="showSection('account')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-account">
                    <i class="fas fa-key w-5"></i>
                    <span>Account</span>
                </button>
                
                <button onclick="showSection('social')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-social">
                    <i class="fas fa-share-alt w-5"></i>
                    <span>Social Links</span>
                </button>
                
                <button onclick="showSection('notifications')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-notifications">
                    <i class="fas fa-bell w-5"></i>
                    <span>Notifications</span>
                </button>
                
                <button onclick="showSection('privacy')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-privacy">
                    <i class="fas fa-lock w-5"></i>
                    <span>Privacy</span>
                </button>
                
                <button onclick="showSection('theme')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-theme">
                    <i class="fas fa-palette w-5"></i>
                    <span>Theme & Appearance</span>
                </button>
                
                <button onclick="showSection('danger')" 
                        class=" sidebar-item-settings bg-primary-700 text-white flex flex-col items-center p-3 rounded-duo text-neutral-800 w-[100%]"
                        id="tab-danger">
                    <i class="fas fa-exclamation-triangle w-5"></i>
                    <span>Danger Zone</span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:w-3/4">
        @if(session('success'))
            <div class="mb-6 p-4 bg-primary-50 border-l-4 border-primary-500 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-primary-500 mr-3"></i>
                    <p class="text-primary-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-accent-red rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-accent-red mr-3"></i>
                    <div>
                        <p class="font-semibold text-red-800">Please fix the following errors:</p>
                        <ul class="mt-2 text-red-700">
                            @foreach($errors->all() as $error)
                                <li class="ml-4">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Profile Section -->
        <div id="profile-section" class="settings-section">
            <div class="card p-6">
                <h2 class="text-2xl font-bold mb-6 text-neutral-800">Profile Settings</h2>
                
                <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Bio</label>
                        <textarea name="bio" rows="3" 
                                  class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('bio', $user->bio) }}</textarea>
                        <p class="text-sm text-neutral-500 mt-1">Tell us a little about yourself</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Gender</label>
                            <select name="gender" class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                <option value="prefer_not_to_say" {{ old('gender', $user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $user->location) }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Website</label>
                            <input type="url" name="website" value="{{ old('website', $user->website) }}" 
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Timezone</label>
                            <select name="timezone" class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select Timezone</option>
                                @foreach(timezone_identifiers_list() as $timezone)
                                    <option value="{{ $timezone }}" {{ old('timezone', $user->timezone) == $timezone ? 'selected' : '' }}>
                                        {{ $timezone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="app-button px-8">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </form>
                
                <!-- Profile Image Upload -->
                <div class="mt-8 pt-8 border-t border-neutral-200">
                    <h3 class="text-lg font-semibold mb-4 text-neutral-800">Profile Images</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Profile Image -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Profile Picture</label>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-neutral-300">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                             alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-2xl font-bold text-primary-600">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <form action="{{ route('settings.profile-image.upload') }}" 
                                      method="POST" 
                                      enctype="multipart/form-data"
                                      class="flex-1">
                                    @csrf
                                    <label class="block">
                                        <input type="file" 
                                               name="profile_image" 
                                               accept="image/*" 
                                               class="hidden"
                                               onchange="this.form.submit()">
                                        <div class="profile-image-upload p-4 rounded-duo text-center cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt text-primary-500 text-xl mb-2"></i>
                                            <p class="text-sm text-neutral-600">Click to upload new photo</p>
                                            <p class="text-xs text-neutral-500 mt-1">JPG, PNG up to 2MB</p>
                                        </div>
                                    </label>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Cover Image -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Cover Photo</label>
                            <div class="h-32 rounded-duo overflow-hidden border-2 border-neutral-300 mb-3">
                                @if($user->cover_image)
                                    <img src="{{ asset('storage/' . $user->cover_image) }}" 
                                         alt="Cover" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center">
                                        <i class="fas fa-mountain text-primary-300 text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <form action="{{ route('settings.cover-image.upload') }}" 
                                  method="POST" 
                                  enctype="multipart/form-data">
                                @csrf
                                <label class="block">
                                    <input type="file" 
                                           name="cover_image" 
                                           accept="image/*" 
                                           class="hidden"
                                           onchange="this.form.submit()">
                                    <div class="profile-image-upload p-3 rounded-duo text-center cursor-pointer">
                                        <i class="fas fa-image text-primary-500 mr-2"></i>
                                        <span class="text-sm text-neutral-600">Upload new cover photo</span>
                                    </div>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Section (Hidden by default) -->
        <div id="account-section" class="settings-section hidden">
            <div class="card p-6">
                <h2 class="text-2xl font-bold mb-6 text-neutral-800">Account Settings</h2>
                
                <!-- Password Update -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-neutral-800">Change Password</h3>
                    <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">New Password</label>
                            <input type="password" name="new_password" required
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" required
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="app-button px-6">
                                <i class="fas fa-key mr-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Account Information -->
                <div class="border-t border-neutral-200 pt-6">
                    <h3 class="text-lg font-semibold mb-4 text-neutral-800">Account Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100">
                            <span class="text-neutral-600">Account Created</span>
                            <span class="font-medium">{{ $user->created_at->format('F d, Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100">
                            <span class="text-neutral-600">Last Login</span>
                            <span class="font-medium">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->diffForHumans() }}
                                @else
                                    Never
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100">
                            <span class="text-neutral-600">Account Type</span>
                            <span class="font-medium capitalize">{{ $user->account_type ?? 'Free' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-neutral-100">
                            <span class="text-neutral-600">Account Status</span>
                            <span class="font-medium">
                                @if($user->is_active)
                                    <span class="text-primary-600">Active</span>
                                @else
                                    <span class="text-accent-red">Inactive</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-neutral-600">Verified</span>
                            <span class="font-medium">
                                @if($user->is_verified)
                                    <i class="fas fa-check-circle text-primary-500"></i> Verified
                                @else
                                    <i class="fas fa-times-circle text-neutral-400"></i> Not Verified
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Links Section (Hidden by default) -->
        <div id="social-section" class="settings-section hidden">
            <div class="card p-6">
                <h2 class="text-2xl font-bold mb-6 text-neutral-800">Social Media Links</h2>
                
                <form action="{{ route('settings.social.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fab fa-facebook-f text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">Facebook</label>
                                <input type="url" name="facebook_url" 
                                       value="{{ old('facebook_url', $user->facebook_url) }}"
                                       placeholder="https://facebook.com/yourprofile"
                                       class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fab fa-twitter text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">Twitter / X</label>
                                <input type="url" name="twitter_url" 
                                       value="{{ old('twitter_url', $user->twitter_url) }}"
                                       placeholder="https://twitter.com/yourprofile"
                                       class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                <i class="fab fa-instagram text-pink-600"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">Instagram</label>
                                <input type="url" name="instagram_url" 
                                       value="{{ old('instagram_url', $user->instagram_url) }}"
                                       placeholder="https://instagram.com/yourprofile"
                                       class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fab fa-linkedin-in text-blue-700"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">LinkedIn</label>
                                <input type="url" name="linkedin_url" 
                                       value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                       placeholder="https://linkedin.com/in/yourprofile"
                                       class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center">
                                <i class="fab fa-github text-neutral-800"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">GitHub</label>
                                <input type="url" name="github_url" 
                                       value="{{ old('github_url', $user->github_url) }}"
                                       placeholder="https://github.com/yourprofile"
                                       class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="app-button px-8">
                            <i class="fas fa-save mr-2"></i> Save Social Links
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifications Section (Hidden by default) -->
        <div id="notifications-section" class="settings-section hidden">
            <div class="card p-6">
                <h2 class="text-2xl font-bold mb-6 text-neutral-800">Notification Settings</h2>
                
                <form action="{{ route('settings.notifications.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Email Notifications -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Email Notifications</h3>
                            <div class="space-y-4">
                                @php
                                    $notifications = $user->notification_settings ?? [];
                                @endphp
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Email Notifications</p>
                                        <p class="text-sm text-neutral-500">Receive notifications via email</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="email_notifications" 
                                               value="1" {{ isset($notifications['email_notifications']) && $notifications['email_notifications'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Push Notifications</p>
                                        <p class="text-sm text-neutral-500">Receive push notifications</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="push_notifications" 
                                               value="1" {{ isset($notifications['push_notifications']) && $notifications['push_notifications'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Community Updates</p>
                                        <p class="text-sm text-neutral-500">Updates from your communities</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="community_updates" 
                                               value="1" {{ isset($notifications['community_updates']) && $notifications['community_updates'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Quest Reminders</p>
                                        <p class="text-sm text-neutral-500">Daily quest reminders</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="quest_reminders" 
                                               value="1" {{ isset($notifications['quest_reminders']) && $notifications['quest_reminders'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Weekly Digest</p>
                                        <p class="text-sm text-neutral-500">Weekly summary of your activity</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="weekly_digest" 
                                               value="1" {{ isset($notifications['weekly_digest']) && $notifications['weekly_digest'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity Notifications -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Activity Notifications</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">New Followers</p>
                                        <p class="text-sm text-neutral-500">When someone follows you</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="new_follower" 
                                               value="1" {{ isset($notifications['new_follower']) && $notifications['new_follower'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">New Comments</p>
                                        <p class="text-sm text-neutral-500">When someone comments on your posts</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="new_comment" 
                                               value="1" {{ isset($notifications['new_comment']) && $notifications['new_comment'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">New Likes</p>
                                        <p class="text-sm text-neutral-500">When someone likes your content</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="new_like" 
                                               value="1" {{ isset($notifications['new_like']) && $notifications['new_like'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Marketing -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Marketing</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3">
                                    <div>
                                        <p class="font-medium text-neutral-800">Marketing Emails</p>
                                        <p class="text-sm text-neutral-500">Promotions, new features, and updates</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="marketing_emails" 
                                               value="1" {{ isset($notifications['marketing_emails']) && $notifications['marketing_emails'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-6 mt-6 border-t border-neutral-200">
                        <button type="submit" class="app-button px-8">
                            <i class="fas fa-bell mr-2"></i> Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Privacy Section (Hidden by default) -->
        <div id="privacy-section" class="settings-section hidden">
            <div class="card p-6">
                <h2 class="text-2xl font-bold mb-6 text-neutral-800">Privacy Settings</h2>
                
                <form action="{{ route('settings.privacy.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Profile Visibility -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Profile Visibility</h3>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-neutral-300 rounded-duo cursor-pointer hover:border-primary-300">
                                    <input type="radio" name="profile_visibility" value="public" 
                                           {{ old('profile_visibility', $user->profile_visibility) == 'public' ? 'checked' : '' }}
                                           class="mr-3 text-primary-500">
                                    <div>
                                        <p class="font-medium text-neutral-800">Public</p>
                                        <p class="text-sm text-neutral-500">Anyone can see your profile and content</p>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-4 border-2 border-neutral-300 rounded-duo cursor-pointer hover:border-primary-300">
                                    <input type="radio" name="profile_visibility" value="private" 
                                           {{ old('profile_visibility', $user->profile_visibility) == 'private' ? 'checked' : '' }}
                                           class="mr-3 text-primary-500">
                                    <div>
                                        <p class="font-medium text-neutral-800">Private</p>
                                        <p class="text-sm text-neutral-500">Only approved followers can see your content</p>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-4 border-2 border-neutral-300 rounded-duo cursor-pointer hover:border-primary-300">
                                    <input type="radio" name="profile_visibility" value="friends" 
                                           {{ old('profile_visibility', $user->profile_visibility) == 'friends' ? 'checked' : '' }}
                                           class="mr-3 text-primary-500">
                                    <div>
                                        <p class="font-medium text-neutral-800">Friends Only</p>
                                        <p class="text-sm text-neutral-500">Only people you follow back can see your content</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Personal Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Show Email Address</p>
                                        <p class="text-sm text-neutral-500">Display your email on your public profile</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="show_email" value="1" 
                                               {{ $user->show_email ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3">
                                    <div>
                                        <p class="font-medium text-neutral-800">Show Date of Birth</p>
                                        <p class="text-sm text-neutral-500">Display your birthday on your profile</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="show_date_of_birth" value="1" 
                                               {{ $user->show_date_of_birth ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Data & Privacy -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Data & Privacy</h3>
                            <div class="space-y-3">
                                <a href="#" class="flex items-center justify-between p-4 border-2 border-neutral-300 rounded-duo hover:border-primary-300 hover:bg-primary-50 transition-all duration-200">
                                    <div>
                                        <p class="font-medium text-neutral-800">Download Your Data</p>
                                        <p class="text-sm text-neutral-500">Get a copy of your Tenang data</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-neutral-400"></i>
                                </a>
                                
                                <a href="#" class="flex items-center justify-between p-4 border-2 border-neutral-300 rounded-duo hover:border-primary-300 hover:bg-primary-50 transition-all duration-200">
                                    <div>
                                        <p class="font-medium text-neutral-800">Privacy Policy</p>
                                        <p class="text-sm text-neutral-500">Read our privacy policy</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-neutral-400"></i>
                                </a>
                                
                                <a href="#" class="flex items-center justify-between p-4 border-2 border-neutral-300 rounded-duo hover:border-primary-300 hover:bg-primary-50 transition-all duration-200">
                                    <div>
                                        <p class="font-medium text-neutral-800">Terms of Service</p>
                                        <p class="text-sm text-neutral-500">Read our terms of service</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-neutral-400"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-6 mt-6 border-t border-neutral-200">
                        <button type="submit" class="app-button px-8">
                            <i class="fas fa-lock mr-2"></i> Save Privacy Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Theme Section (Hidden by default) -->
        <div id="theme-section" class="settings-section hidden">
            <div class="card p-6">
                <h2 class="text-2xl font-bold mb-6 text-neutral-800">Theme & Appearance</h2>
                
                <form action="{{ route('settings.theme.update') }}" method="POST" id="theme-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-8">
                        <!-- Theme Selection -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Theme</h3>
                            <p class="text-neutral-600 mb-4">Choose how Tenang looks to you</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @php
                                    $preferences = $user->preferences ?? [];
                                    $currentTheme = $preferences['theme'] ?? 'light';
                                @endphp
                                
                                <label class="theme-preview cursor-pointer {{ $currentTheme == 'light' ? 'active' : '' }}">
                                    <input type="radio" name="theme" value="light" 
                                           class="hidden" 
                                           {{ $currentTheme == 'light' ? 'checked' : '' }}
                                           onchange="updateThemePreview('light')">
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="font-medium">Light</span>
                                            @if($currentTheme == 'light')
                                                <i class="fas fa-check-circle text-primary-500"></i>
                                            @endif
                                        </div>
                                        <div class="preview-card theme-light">
                                            <div class="h-3 w-3/4 bg-primary-500 rounded mb-2"></div>
                                            <div class="h-2 w-1/2 bg-neutral-300 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="theme-preview cursor-pointer {{ $currentTheme == 'dark' ? 'active' : '' }}">
                                    <input type="radio" name="theme" value="dark" 
                                           class="hidden"
                                           {{ $currentTheme == 'dark' ? 'checked' : '' }}
                                           onchange="updateThemePreview('dark')">
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="font-medium">Dark</span>
                                            @if($currentTheme == 'dark')
                                                <i class="fas fa-check-circle text-primary-500"></i>
                                            @endif
                                        </div>
                                        <div class="preview-card theme-dark">
                                            <div class="h-3 w-3/4 bg-primary-500 rounded mb-2"></div>
                                            <div class="h-2 w-1/2 bg-neutral-600 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="theme-preview cursor-pointer {{ $currentTheme == 'system' ? 'active' : '' }}">
                                    <input type="radio" name="theme" value="system" 
                                           class="hidden"
                                           {{ $currentTheme == 'system' ? 'checked' : '' }}
                                           onchange="updateThemePreview('system')">
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="font-medium">System</span>
                                            @if($currentTheme == 'system')
                                                <i class="fas fa-check-circle text-primary-500"></i>
                                            @endif
                                        </div>
                                        <div class="preview-card theme-system">
                                            <div class="h-3 w-3/4 bg-primary-500 rounded mb-2"></div>
                                            <div class="h-2 w-1/2 bg-gradient-to-r from-neutral-300 to-neutral-600 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Color Scheme -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Color Scheme</h3>
                            <p class="text-neutral-600 mb-4">Choose your preferred color palette</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @php
                                    $currentColorScheme = $preferences['color_scheme'] ?? 'default';
                                @endphp
                                
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="color_scheme" value="default" 
                                           class="hidden" 
                                           {{ $currentColorScheme == 'default' ? 'checked' : '' }}>
                                    <div class="border-2 border-neutral-300 rounded-duo p-3 hover:border-primary-300 {{ $currentColorScheme == 'default' ? 'border-primary-500 ring-2 ring-primary-300' : '' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium">Default</span>
                                            @if($currentColorScheme == 'default')
                                                <i class="fas fa-check-circle text-primary-500 text-sm"></i>
                                            @endif
                                        </div>
                                        <div class="flex gap-1">
                                            <div class="h-8 flex-1 bg-primary-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-secondary-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-accent-blue rounded"></div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="color_scheme" value="violet" 
                                           class="hidden"
                                           {{ $currentColorScheme == 'violet' ? 'checked' : '' }}>
                                    <div class="border-2 border-neutral-300 rounded-duo p-3 hover:border-primary-300 {{ $currentColorScheme == 'violet' ? 'border-primary-500 ring-2 ring-primary-300' : '' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium">Violet</span>
                                            @if($currentColorScheme == 'violet')
                                                <i class="fas fa-check-circle text-primary-500 text-sm"></i>
                                            @endif
                                        </div>
                                        <div class="flex gap-1">
                                            <div class="h-8 flex-1 bg-violet-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-fuchsia-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-indigo-500 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="color_scheme" value="forest" 
                                           class="hidden"
                                           {{ $currentColorScheme == 'forest' ? 'checked' : '' }}>
                                    <div class="border-2 border-neutral-300 rounded-duo p-3 hover:border-primary-300 {{ $currentColorScheme == 'forest' ? 'border-primary-500 ring-2 ring-primary-300' : '' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium">Forest</span>
                                            @if($currentColorScheme == 'forest')
                                                <i class="fas fa-check-circle text-primary-500 text-sm"></i>
                                            @endif
                                        </div>
                                        <div class="flex gap-1">
                                            <div class="h-8 flex-1 bg-emerald-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-green-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-lime-500 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="color_scheme" value="sunset" 
                                           class="hidden"
                                           {{ $currentColorScheme == 'sunset' ? 'checked' : '' }}>
                                    <div class="border-2 border-neutral-300 rounded-duo p-3 hover:border-primary-300 {{ $currentColorScheme == 'sunset' ? 'border-primary-500 ring-2 ring-primary-300' : '' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium">Sunset</span>
                                            @if($currentColorScheme == 'sunset')
                                                <i class="fas fa-check-circle text-primary-500 text-sm"></i>
                                            @endif
                                        </div>
                                        <div class="flex gap-1">
                                            <div class="h-8 flex-1 bg-orange-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-rose-500 rounded"></div>
                                            <div class="h-8 flex-1 bg-amber-500 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Accessibility -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Accessibility</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">Reduce Motion</p>
                                        <p class="text-sm text-neutral-500">Minimize animations and transitions</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="reduce_motion" value="1" 
                                               {{ isset($preferences['reduce_motion']) && $preferences['reduce_motion'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3 border-b border-neutral-100">
                                    <div>
                                        <p class="font-medium text-neutral-800">High Contrast</p>
                                        <p class="text-sm text-neutral-500">Increase color contrast for better visibility</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="high_contrast" value="1" 
                                               {{ isset($preferences['high_contrast']) && $preferences['high_contrast'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between py-3">
                                    <div>
                                        <p class="font-medium text-neutral-800">Large Text</p>
                                        <p class="text-sm text-neutral-500">Increase font size across the app</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="large_text" value="1" 
                                               {{ isset($preferences['large_text']) && $preferences['large_text'] ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Font Selection -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-neutral-800">Font</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="border-2 border-neutral-300 rounded-duo p-4 cursor-pointer hover:border-primary-300">
                                    <input type="radio" name="font" value="nunito" checked class="hidden">
                                    <div class="flex items-center justify-between">
                                        <span class="font-nunito font-medium">Nunito</span>
                                        <i class="fas fa-check-circle text-primary-500"></i>
                                    </div>
                                    <p class="font-nunito text-sm text-neutral-500 mt-2">The default Tenang font</p>
                                </label>
                                
                                <label class="border-2 border-neutral-300 rounded-duo p-4 cursor-pointer hover:border-primary-300">
                                    <input type="radio" name="font" value="inter" class="hidden">
                                    <div class="flex items-center justify-between">
                                        <span class="font-inter font-medium">Inter</span>
                                        <i class="fas fa-circle text-neutral-300"></i>
                                    </div>
                                    <p class="font-inter text-sm text-neutral-500 mt-2">A modern, geometric font</p>
                                </label>
                                
                                <label class="border-2 border-neutral-300 rounded-duo p-4 cursor-pointer hover:border-primary-300">
                                    <input type="radio" name="font" value="system" class="hidden">
                                    <div class="flex items-center justify-between">
                                        <span class="font-sans font-medium">System Font</span>
                                        <i class="fas fa-circle text-neutral-300"></i>
                                    </div>
                                    <p class="font-sans text-sm text-neutral-500 mt-2">Use your device's default font</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-6 mt-6 border-t border-neutral-200">
                        <button type="submit" class="app-button px-8">
                            <i class="fas fa-palette mr-2"></i> Save Theme Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone Section (Hidden by default) -->
        <div id="danger-section" class="settings-section hidden">
            <div class="card danger-zone p-6">
                <h2 class="text-2xl font-bold mb-6 text-accent-red">Danger Zone</h2>
                
                <div class="space-y-6">
                    <!-- Export Data -->
                    <div class="p-4 border-2 border-neutral-300 rounded-duo">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-neutral-800">Export Your Data</h3>
                                <p class="text-sm text-neutral-500">Download a copy of all your Tenang data</p>
                            </div>
                            <button type="button" class="app-button-secondary px-6 py-2">
                                <i class="fas fa-download mr-2"></i> Export Data
                            </button>
                        </div>
                    </div>
                    
                    <!-- Deactivate Account -->
                    <div class="p-4 border-2 border-yellow-300 rounded-duo bg-yellow-50">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-neutral-800">Deactivate Account</h3>
                                <p class="text-sm text-neutral-500">Temporarily disable your account. You can reactivate later.</p>
                            </div>
                            <button type="button" 
                                    onclick="openDeactivateModal()" 
                                    class="app-button px-6 py-2" 
                                    style="background: #ffc800; box-shadow: 0 4px 0 #e6b400;">
                                <i class="fas fa-pause mr-2"></i> Deactivate Account
                            </button>
                        </div>
                    </div>
                    
                    <!-- Delete Account -->
                    <div class="p-4 border-2 border-accent-red rounded-duo bg-red-50">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-neutral-800">Delete Account</h3>
                                <p class="text-sm text-neutral-500">Permanently delete your account and all data. This action cannot be undone.</p>
                            </div>
                            <button type="button" 
                                    onclick="openDeleteModal()" 
                                    class="app-button px-6 py-2" 
                                    style="background: #ff6b6b; box-shadow: 0 4px 0 #e05b5b;">
                                <i class="fas fa-trash mr-2"></i> Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-duo-lg max-w-md w-full p-6 modal-enter">
        <h3 class="text-xl font-bold text-accent-red mb-4">Delete Your Account</h3>
        <p class="text-neutral-600 mb-6">
            Are you absolutely sure? This action cannot be undone. This will permanently delete your account and remove all your data from our servers.
        </p>
        
        <form action="{{ route('settings.account.delete') }}" method="POST" id="delete-form">
            @csrf
            @method('DELETE')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        To verify, type <span class="font-bold">delete my account</span> below:
                    </label>
                    <input type="text" 
                           id="delete-confirmation" 
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="delete my account">
                </div>
                
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="delete-password-check" 
                               class="mr-2 text-red-500">
                        <span class="text-sm text-neutral-700">
                            I understand that this action is irreversible
                        </span>
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Enter your password to confirm:
                    </label>
                    <input type="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" 
                        onclick="closeDeleteModal()" 
                        class="px-6 py-3 border-2 border-neutral-300 text-neutral-700 rounded-duo hover:bg-neutral-50">
                    Cancel
                </button>
                <button type="submit" 
                        id="delete-submit"
                        disabled
                        class="px-6 py-3 bg-accent-red text-white rounded-duo hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    Delete Account Permanently
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div id="deactivate-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-duo-lg max-w-md w-full p-6 modal-enter">
        <h3 class="text-xl font-bold text-secondary-600 mb-4">Deactivate Your Account</h3>
        <p class="text-neutral-600 mb-6">
            Your account will be deactivated immediately. You can reactivate it anytime by logging back in.
        </p>
        
        <div class="space-y-4">
            <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-duo">
                <h4 class="font-semibold text-yellow-800 mb-2">What happens when you deactivate:</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Your profile will be hidden</li>
                    <li>• You won't appear in search results</li>
                    <li>• Your posts will be hidden</li>
                    <li>• You can reactivate anytime</li>
                </ul>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="deactivate-terms" class="mr-2 text-secondary-500">
                <label for="deactivate-terms" class="text-sm text-neutral-700">
                    I understand that I can reactivate my account anytime
                </label>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" 
                    onclick="closeDeactivateModal()" 
                    class="px-6 py-3 border-2 border-neutral-300 text-neutral-700 rounded-duo hover:bg-neutral-50">
                Cancel
            </button>
            <button type="button" 
                    class="app-button-secondary px-6 py-3"
                    onclick="deactivateAccount()">
                <i class="fas fa-pause mr-2"></i> Deactivate Account
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab Navigation
    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.settings-section').forEach(section => {
            section.classList.add('hidden');
        });
        
        // Remove active from all tabs
        document.querySelectorAll('.settings-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show selected section
        document.getElementById(sectionId + '-section').classList.remove('hidden');
        
        // Activate selected tab
        document.getElementById('tab-' + sectionId).classList.add('active');
        
        // Scroll to top of section
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Theme Preview Update
    function updateThemePreview(theme) {
        document.querySelectorAll('.theme-preview').forEach(preview => {
            preview.classList.remove('active');
        });
        
        const activePreview = document.querySelector(`input[name="theme"][value="${theme}"]`).parentElement;
        activePreview.classList.add('active');
    }

    // Delete Account Modal
    function openDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        document.body.style.overflow = '';
        // Reset form
        document.getElementById('delete-confirmation').value = '';
        document.getElementById('delete-password-check').checked = false;
        document.getElementById('delete-submit').disabled = true;
    }

    // Deactivate Account Modal
    function openDeactivateModal() {
        document.getElementById('deactivate-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeactivateModal() {
        document.getElementById('deactivate-modal').classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('deactivate-terms').checked = false;
    }

    function deactivateAccount() {
        if (!document.getElementById('deactivate-terms').checked) {
            showNotification('Please confirm that you understand the terms', 'warning');
            return;
        }
        
        if (confirm('Are you sure you want to deactivate your account?')) {
            // AJAX request to deactivate account
            fetch('/api/account/deactivate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Account deactivated successfully. You can reactivate by logging in.', 'success');
                    closeDeactivateModal();
                    setTimeout(() => {
                        window.location.href = '/logout';
                    }, 2000);
                } else {
                    showNotification('Failed to deactivate account: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        }
    }

    // Delete Account Form Validation
    document.addEventListener('DOMContentLoaded', function() {
        const deleteConfirmation = document.getElementById('delete-confirmation');
        const deleteCheckbox = document.getElementById('delete-password-check');
        const deleteSubmit = document.getElementById('delete-submit');
        const deleteForm = document.getElementById('delete-form');
        
        function validateDeleteForm() {
            const isTextMatch = deleteConfirmation.value === 'delete my account';
            const isChecked = deleteCheckbox.checked;
            deleteSubmit.disabled = !(isTextMatch && isChecked);
        }
        
        deleteConfirmation.addEventListener('input', validateDeleteForm);
        deleteCheckbox.addEventListener('change', validateDeleteForm);
        
        // Prevent accidental submission
        deleteForm.addEventListener('submit', function(e) {
            if (deleteConfirmation.value !== 'delete my account' || !deleteCheckbox.checked) {
                e.preventDefault();
                showNotification('Please complete all verification steps', 'warning');
            }
        });
        
        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
                closeDeactivateModal();
            }
        });
        
        // Close modals when clicking outside
        document.getElementById('delete-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
        
        document.getElementById('deactivate-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeactivateModal();
            }
        });
    });

    // Theme Form Auto-Submit on Change
    const themeForm = document.getElementById('theme-form');
    themeForm.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function() {
            // For theme and color scheme changes, submit immediately
            if (this.name === 'theme' || this.name === 'color_scheme') {
                themeForm.submit();
            }
        });
    });

    // Profile Image Upload Preview
    document.querySelectorAll('input[type="file"][name="profile_image"], input[type="file"][name="cover_image"]').forEach(input => {
        input.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You could add a preview here if needed
                    console.log('Image selected for upload');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Initialize with profile section visible
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a hash in URL
        const hash = window.location.hash.substring(1);
        if (hash && document.getElementById(hash + '-section')) {
            showSection(hash);
        } else {
            showSection('profile');
        }
    });

    // Show notification function
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(n => n.remove());

        const colors = {
            success: 'bg-primary-500 text-white shadow-duo',
            error: 'bg-accent-red text-white shadow-duo',
            warning: 'bg-secondary-500 text-neutral-900 shadow-duo',
            info: 'bg-accent-blue text-white shadow-duo'
        };

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        // Create element
        const notification = document.createElement('div');
        notification.className = `
            custom-notification
            fixed top-24 right-8 
            px-5 py-4 rounded-duo-lg z-[9999]
            transform transition-all duration-300
            animate-slide-in
            border-2 border-white
            flex items-center gap-3
            ${colors[type] || colors.info}
        `;

        notification.innerHTML = `
            <i class="fas ${icons[type]} text-xl"></i>
            <span class="font-semibold">${message}</span>
        `;

        document.body.appendChild(notification);

        // Auto remove
        setTimeout(() => {
            notification.style.opacity = "0";
            notification.style.transform = "translateX(100%)";
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
</script>
@endsection