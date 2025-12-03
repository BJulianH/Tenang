@extends('layouts.app')

@section('title', 'Edit Profile - Tenang')

@section('styles')
<style>
    .image-upload-container {
        transition: all 0.3s ease;
    }
    
    .image-upload-container:hover {
        transform: translateY(-2px);
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">Edit Profile</h1>
        <p class="text-neutral-600 mt-2">Manage your profile information and preferences</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-xl card-shadow p-6 sticky top-8">
                <nav class="space-y-2">
                    <button type="button" data-tab="basic" class="tab-nav w-full text-left px-4 py-3 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-primary-600 bg-primary-50">
                        <i class="fas fa-user mr-3"></i>
                        Basic Information
                    </button>
                    <button type="button" data-tab="images" class="tab-nav w-full text-left px-4 py-3 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-neutral-600">
                        <i class="fas fa-images mr-3"></i>
                        Profile Images
                    </button>
                    <button type="button" data-tab="social" class="tab-nav w-full text-left px-4 py-3 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-neutral-600">
                        <i class="fas fa-share-alt mr-3"></i>
                        Social Links
                    </button>
                    <button type="button" data-tab="privacy" class="tab-nav w-full text-left px-4 py-3 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-neutral-600">
                        <i class="fas fa-shield-alt mr-3"></i>
                        Privacy & Visibility
                    </button>
                    <button type="button" data-tab="preferences" class="tab-nav w-full text-left px-4 py-3 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-neutral-600">
                        <i class="fas fa-cog mr-3"></i>
                        Preferences
                    </button>
                    <button type="button" data-tab="password" class="tab-nav w-full text-left px-4 py-3 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-neutral-600">
                        <i class="fas fa-lock mr-3"></i>
                        Change Password
                    </button>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4">
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information Tab -->
                <div id="basic" class="tab-content active">
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Basic Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-neutral-700 mb-2">Username *</label>
                                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                @error('username')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-neutral-700 mb-2">Location</label>
                                <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="City, Country">
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-neutral-700 mb-2">Date of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                @error('date_of_birth')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-neutral-700 mb-2">Gender</label>
                                <select id="gender" name="gender" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    <option value="prefer_not_to_say" {{ old('gender', $user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mt-6">
                            <label for="bio" class="block text-sm font-medium text-neutral-700 mb-2">Bio</label>
                            <textarea id="bio" name="bio" rows="4" 
                                      class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
                                      placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            <p class="text-neutral-500 text-sm mt-1">Maximum 500 characters</p>
                            @error('bio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div class="mt-6">
                            <label for="website" class="block text-sm font-medium text-neutral-700 mb-2">Website</label>
                            <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" 
                                   class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                   placeholder="https://example.com">
                            @error('website')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Profile Images Tab -->
                <div id="images" class="tab-content">
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Profile Images</h2>
                        
                        <!-- Profile Image -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-neutral-700 mb-4">Profile Picture</label>
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div class="flex-shrink-0">
                                    <div class="w-32 h-32 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-lg overflow-hidden">
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="w-full h-full object-cover" id="profile-preview">
                                        @else
                                            <span id="profile-initial">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(this, 'profile-preview', 'profile-initial')">
                                    <button type="button" onclick="document.getElementById('profile_image').click()" 
                                            class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors mb-2">
                                        <i class="fas fa-upload mr-2"></i>Upload New Photo
                                    </button>
                                    @if($user->profile_image)
                                    <button type="button" onclick="deleteProfileImage()" 
                                            class="border border-red-300 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 transition-colors">
                                        <i class="fas fa-trash mr-2"></i>Remove Photo
                                    </button>
                                    @endif
                                    <p class="text-neutral-500 text-sm mt-2">Recommended: Square image, at least 200x200 pixels</p>
                                    @error('profile_image')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-4">Cover Photo</label>
                            <div class="space-y-4">
                                <div class="w-full h-48 rounded-lg bg-gradient-to-r from-primary-100 to-secondary-100 border-2 border-dashed border-neutral-300 flex items-center justify-center overflow-hidden">
                                    @if($user->cover_image)
                                        <img src="{{ asset('storage/' . $user->cover_image) }}" alt="Cover" class="w-full h-full object-cover" id="cover-preview">
                                    @else
                                        <div class="text-center" id="cover-placeholder">
                                            <i class="fas fa-image text-4xl text-neutral-400 mb-2"></i>
                                            <p class="text-neutral-500">No cover photo</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-3">
                                    <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden" onchange="previewCoverImage(this)">
                                    <button type="button" onclick="document.getElementById('cover_image').click()" 
                                            class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                        <i class="fas fa-upload mr-2"></i>Upload Cover Photo
                                    </button>
                                    @if($user->cover_image)
                                    <button type="button" onclick="deleteCoverImage()" 
                                            class="border border-red-300 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 transition-colors">
                                        <i class="fas fa-trash mr-2"></i>Remove Cover
                                    </button>
                                    @endif
                                </div>
                                <p class="text-neutral-500 text-sm">Recommended: 1500x500 pixels for best display</p>
                                @error('cover_image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links Tab -->
                <div id="social" class="tab-content">
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Social Links</h2>
                        
                        <div class="space-y-6">
                            <!-- Facebook -->
                            <div>
                                <label for="facebook_url" class="block text-sm font-medium text-neutral-700 mb-2">
                                    <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook
                                </label>
                                <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $user->facebook_url) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="https://facebook.com/yourprofile">
                                @error('facebook_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Twitter -->
                            <div>
                                <label for="twitter_url" class="block text-sm font-medium text-neutral-700 mb-2">
                                    <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter
                                </label>
                                <input type="url" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $user->twitter_url) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="https://twitter.com/yourprofile">
                                @error('twitter_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram_url" class="block text-sm font-medium text-neutral-700 mb-2">
                                    <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram
                                </label>
                                <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="https://instagram.com/yourprofile">
                                @error('instagram_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- LinkedIn -->
                            <div>
                                <label for="linkedin_url" class="block text-sm font-medium text-neutral-700 mb-2">
                                    <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn
                                </label>
                                <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="https://linkedin.com/in/yourprofile">
                                @error('linkedin_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- GitHub -->
                            <div>
                                <label for="github_url" class="block text-sm font-medium text-neutral-700 mb-2">
                                    <i class="fab fa-github text-gray-800 mr-2"></i>GitHub
                                </label>
                                <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $user->github_url) }}" 
                                       class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="https://github.com/yourprofile">
                                @error('github_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy & Visibility Tab -->
                <div id="privacy" class="tab-content">
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Privacy & Visibility</h2>
                        
                        <div class="space-y-6">
                            <!-- Profile Visibility -->
                            <div>
                                <label for="profile_visibility" class="block text-sm font-medium text-neutral-700 mb-3">Profile Visibility</label>
                                <select id="profile_visibility" name="profile_visibility" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="public" {{ old('profile_visibility', $user->profile_visibility) == 'public' ? 'selected' : '' }}>Public - Anyone can view my profile</option>
                                    <option value="followers_only" {{ old('profile_visibility', $user->profile_visibility) == 'followers_only' ? 'selected' : '' }}>Followers Only - Only my followers can view</option>
                                    <option value="private" {{ old('profile_visibility', $user->profile_visibility) == 'private' ? 'selected' : '' }}>Private - Only I can view my profile</option>
                                </select>
                            </div>

                            <!-- Privacy Settings -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-neutral-700 mb-3">Privacy Settings</label>
                                
                                <div class="flex items-center justify-between p-4 border border-neutral-200 rounded-lg">
                                    <div>
                                        <div class="font-medium text-neutral-800">Show Email Address</div>
                                        <div class="text-sm text-neutral-600">Allow others to see your email address</div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="show_email" value="1" class="sr-only peer" {{ old('show_email', $user->show_email) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-4 border border-neutral-200 rounded-lg">
                                    <div>
                                        <div class="font-medium text-neutral-800">Show Date of Birth</div>
                                        <div class="text-sm text-neutral-600">Allow others to see your age and birthday</div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="show_date_of_birth" value="1" class="sr-only peer" {{ old('show_date_of_birth', $user->show_date_of_birth) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferences Tab -->
                <div id="preferences" class="tab-content">
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Preferences</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-neutral-700 mb-2">Timezone</label>
                                <select id="timezone" name="timezone" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Timezone</option>
                                    @foreach(timezone_identifiers_list() as $tz)
                                        <option value="{{ $tz }}" {{ old('timezone', $user->timezone) == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Language/Locale -->
                            <div>
                                <label for="locale" class="block text-sm font-medium text-neutral-700 mb-2">Language</label>
                                <select id="locale" name="locale" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="en" {{ old('locale', $user->locale) == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="id" {{ old('locale', $user->locale) == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <!-- Add more languages as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Tab -->
                <div id="password" class="tab-content">
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Change Password</h2>
                        
                        <div class="space-y-4 max-w-md">
                            <p class="text-neutral-600">To change your password, please use the dedicated password change form.</p>
                            <a href="{{ route('profile.password') }}" class="inline-flex items-center bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                <i class="fas fa-lock mr-2"></i>
                                Change Password
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end gap-4">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="px-6 py-2 border border-neutral-300 text-neutral-700 rounded-lg hover:bg-neutral-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors font-medium">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab Navigation
    document.querySelectorAll('.tab-nav').forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Update active tab button
            document.querySelectorAll('.tab-nav').forEach(btn => {
                btn.classList.remove('text-primary-600', 'bg-primary-50');
                btn.classList.add('text-neutral-600');
            });
            this.classList.add('text-primary-600', 'bg-primary-50');
            this.classList.remove('text-neutral-600');
            
            // Show active tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Image Preview Functions
    function previewImage(input, previewId, initialId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const initial = document.getElementById(initialId);
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                if (initial) {
                    initial.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewCoverImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const placeholder = document.getElementById('cover-placeholder');
                let preview = document.getElementById('cover-preview');
                
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'cover-preview';
                    preview.className = 'w-full h-full object-cover';
                    document.querySelector('#images .h-48').prepend(preview);
                }
                
                preview.src = e.target.result;
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Delete Image Functions
    async function deleteProfileImage() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            try {
                const response = await fetch('{{ route("profile.delete-image") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('profile-preview').style.display = 'none';
                    document.getElementById('profile-initial').style.display = 'block';
                    document.getElementById('profile_image').value = '';
                    showNotification('Profile image removed successfully!', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error removing profile image', 'error');
            }
        }
    }

    async function deleteCoverImage() {
        if (confirm('Are you sure you want to remove your cover photo?')) {
            try {
                const response = await fetch('{{ route("profile.delete-cover") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('cover-preview').remove();
                    document.getElementById('cover-placeholder').style.display = 'block';
                    document.getElementById('cover_image').value = '';
                    showNotification('Cover image removed successfully!', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error removing cover image', 'error');
            }
        }
    }

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white max-w-sm transform translate-x-full transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            'bg-blue-500'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
</script>
@endsection