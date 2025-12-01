{{-- resources/views/community/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', $user->name . ' - Tenang Community')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #f0f9f0 0%, #dcf2dc 100%);
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .tab-active {
        border-bottom: 3px solid #4caf50;
        color: #4caf50;
    }
    
    .activity-item {
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        border-left-color: #4caf50;
        background-color: #f8fdf8;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl card-shadow mb-6 overflow-hidden">
        <!-- Cover Photo -->
        <div class="h-48 profile-header relative">
            @if($user->cover_image)
            <img src="{{ asset('storage/' . $user->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
            @endif
            <div class="absolute bottom-4 right-4">
                @if(auth()->id() === $user->id)
                <button class="bg-white bg-opacity-90 text-neutral-700 px-4 py-2 rounded-lg hover:bg-opacity-100 transition-all flex items-center space-x-2">
                    <i class="fas fa-camera"></i>
                    <span>Edit Cover</span>
                </button>
                @endif
            </div>
        </div>
        
        <!-- Profile Info -->
        <div class="px-6 pb-6">
            <div class="flex flex-col md:flex-row items-start md:items-end -mt-16">
                <!-- Profile Image -->
                <div class="mb-4 md:mb-0 md:mr-6 relative">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-lg">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>
                    @if(auth()->id() === $user->id)
                    <button class="absolute bottom-2 right-2 bg-primary-500 text-white p-2 rounded-full hover:bg-primary-600 transition-colors">
                        <i class="fas fa-camera text-sm"></i>
                    </button>
                    @endif
                </div>
                
                <!-- User Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-neutral-800">{{ $user->name }}</h1>
                            <p class="text-neutral-600">@{{ $user->username }}</p>
                            @if($user->bio)
                            <p class="text-neutral-600 mt-2 max-w-2xl">{{ $user->bio }}</p>
                            @endif
                            
                            <!-- User Badges -->
                            <div class="flex items-center space-x-2 mt-2">
                                @if($user->is_verified)
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Verified</span>
                                </span>
                                @endif
                                <span class="bg-primary-100 text-primary-600 px-2 py-1 rounded-full text-xs font-medium">
                                    Member since {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            @if(auth()->id() !== $user->id)
                            <button class="bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors flex items-center space-x-2">
                                <i class="fas fa-user-plus"></i>
                                <span>Follow</span>
                            </button>
                            <button class="border border-neutral-300 text-neutral-700 px-6 py-2 rounded-lg hover:bg-neutral-50 transition-colors flex items-center space-x-2">
                                <i class="fas fa-envelope"></i>
                                <span>Message</span>
                            </button>
                            @else
                            <a href="{{ route('profile.edit') }}" class="border border-neutral-300 text-neutral-700 px-6 py-2 rounded-lg hover:bg-neutral-50 transition-colors flex items-center space-x-2">
                                <i class="fas fa-edit"></i>
                                <span>Edit Profile</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex items-center space-x-8 text-sm text-neutral-600">
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold text-neutral-800 text-lg">{{ $user->posts_count }}</span>
                            <span>Posts</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold text-neutral-800 text-lg">{{ $user->comments_count }}</span>
                            <span>Comments</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold text-neutral-800 text-lg">{{ $user->follower_count }}</span>
                            <span>Followers</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold text-neutral-800 text-lg">{{ $user->following_count }}</span>
                            <span>Following</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Tabs -->
            <div class="bg-white rounded-xl card-shadow mb-6">
                <div class="border-b border-neutral-200">
                    <nav class="flex space-x-8 px-6">
                        <button class="tab-button py-4 px-2 font-medium text-neutral-600 hover:text-primary-600 transition-colors tab-active" data-tab="posts">
                            Posts
                        </button>
                        <button class="tab-button py-4 px-2 font-medium text-neutral-600 hover:text-primary-600 transition-colors" data-tab="about">
                            About
                        </button>
                        <button class="tab-button py-4 px-2 font-medium text-neutral-600 hover:text-primary-600 transition-colors" data-tab="communities">
                            Communities
                        </button>
                    </nav>
                </div>
                
                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Posts Tab -->
                    <div id="posts-tab" class="tab-content">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Recent Posts</h2>
                        
                        @forelse($posts as $post)
                            @include('community.partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-edit text-5xl text-neutral-300 mb-4"></i>
                                <h3 class="text-lg font-semibold text-neutral-600 mb-2">No posts yet</h3>
                                <p class="text-neutral-500">When {{ $user->name }} creates posts, they'll appear here.</p>
                                @if(auth()->id() === $user->id)
                                <a href="{{ route('posts.create') }}" class="inline-block mt-4 bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                    Create Your First Post
                                </a>
                                @endif
                            </div>
                        @endforelse
                        
                        @if($posts->hasMorePages())
                        <div class="text-center mt-6">
                            <a href="{{ $posts->nextPageUrl() }}" class="bg-white border border-primary-200 text-primary-600 px-6 py-2 rounded-lg hover:bg-primary-50 transition-colors">
                                Load More Posts
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <!-- About Tab -->
                    <div id="about-tab" class="tab-content hidden">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">About {{ $user->name }}</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Info -->
                            <div class="space-y-4">
                                <h3 class="font-semibold text-neutral-800">Personal Information</h3>
                                
                                @if($user->bio)
                                <div>
                                    <label class="text-sm text-neutral-600">Bio</label>
                                    <p class="text-neutral-800">{{ $user->bio }}</p>
                                </div>
                                @endif
                                
                                @if($user->location)
                                <div>
                                    <label class="text-sm text-neutral-600">Location</label>
                                    <p class="text-neutral-800 flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-primary-500"></i>
                                        <span>{{ $user->location }}</span>
                                    </p>
                                </div>
                                @endif
                                
                                @if($user->website)
                                <div>
                                    <label class="text-sm text-neutral-600">Website</label>
                                    <a href="{{ $user->website }}" target="_blank" class="text-primary-600 hover:text-primary-700 flex items-center space-x-2">
                                        <i class="fas fa-link text-primary-500"></i>
                                        <span>{{ $user->website }}</span>
                                    </a>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="text-sm text-neutral-600">Member Since</label>
                                    <p class="text-neutral-800 flex items-center space-x-2">
                                        <i class="fas fa-calendar text-primary-500"></i>
                                        <span>{{ $user->created_at->format('F j, Y') }}</span>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Community Stats -->
                            <div class="space-y-4">
                                <h3 class="font-semibold text-neutral-800">Community Stats</h3>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="stat-card bg-primary-50 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-primary-600">{{ $user->reputation_score }}</div>
                                        <div class="text-sm text-neutral-600">Reputation</div>
                                    </div>
                                    
                                    <div class="stat-card bg-secondary-50 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-secondary-600">{{ $totalLikes }}</div>
                                        <div class="text-sm text-neutral-600">Likes Received</div>
                                    </div>
                                    
                                    <div class="stat-card bg-green-50 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $user->posts_count }}</div>
                                        <div class="text-sm text-neutral-600">Posts Created</div>
                                    </div>
                                    
                                    <div class="stat-card bg-purple-50 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $user->comments_count }}</div>
                                        <div class="text-sm text-neutral-600">Comments</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Links -->
                        @if($user->facebook_url || $user->twitter_url || $user->instagram_url || $user->linkedin_url || $user->github_url)
                        <div class="mt-8">
                            <h3 class="font-semibold text-neutral-800 mb-4">Social Links</h3>
                            <div class="flex space-x-4">
                                @if($user->facebook_url)
                                <a href="{{ $user->facebook_url }}" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @endif
                                
                                @if($user->twitter_url)
                                <a href="{{ $user->twitter_url }}" target="_blank" class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                
                                @if($user->instagram_url)
                                <a href="{{ $user->instagram_url }}" target="_blank" class="w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                                
                                @if($user->linkedin_url)
                                <a href="{{ $user->linkedin_url }}" target="_blank" class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                @endif
                                
                                @if($user->github_url)
                                <a href="{{ $user->github_url }}" target="_blank" class="w-10 h-10 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-gray-900 transition-colors">
                                    <i class="fab fa-github"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Communities Tab -->
                    <div id="communities-tab" class="tab-content hidden">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6">Communities</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($communities as $community)
                            <a href="{{ route('community.show', $community->slug) }}" class="block p-4 rounded-lg border border-neutral-200 hover:border-primary-300 hover:bg-primary-50 transition-all duration-300">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-neutral-800">{{ $community->name }}</h3>
                                        <p class="text-sm text-neutral-500">{{ $community->members_count }} members</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-full">
                                            Member
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="col-span-2 text-center py-8">
                                <i class="fas fa-users text-4xl text-neutral-300 mb-4"></i>
                                <h3 class="text-lg font-semibold text-neutral-600 mb-2">No communities yet</h3>
                                <p class="text-neutral-500">When {{ $user->name }} joins communities, they'll appear here.</p>
                                @if(auth()->id() === $user->id)
                                <a href="{{ route('community.explore') }}" class="inline-block mt-4 bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                    Explore Communities
                                </a>
                                @endif
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">Community Impact</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-800">{{ $totalLikes }}</div>
                                <div class="text-sm text-neutral-500">Total Likes</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-800">{{ $user->comments_count }}</div>
                                <div class="text-sm text-neutral-500">Comments Made</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <i class="fas fa-share"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-800">{{ $communities->count() }}</div>
                                <div class="text-sm text-neutral-500">Communities</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">Recent Activity</h3>
                <div class="space-y-3">
                    @php
                        $recentPosts = $posts->take(3);
                    @endphp
                    
                    @forelse($recentPosts as $activity)
                    <div class="activity-item p-3 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-200 to-secondary-200 flex items-center justify-center text-primary-600 text-sm">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-neutral-700 line-clamp-2">
                                    Posted "{{ Str::limit($activity->title, 50) }}"
                                </p>
                                <p class="text-xs text-neutral-500 mt-1">
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-neutral-500 text-sm">No recent activity</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Support Badge -->
            @if($user->reputation_score > 100)
            <div class="bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl card-shadow p-6 text-white">
                <div class="text-center">
                    <i class="fas fa-hands-helping text-3xl mb-3"></i>
                    <h3 class="font-bold text-lg mb-2">Community Supporter</h3>
                    <p class="text-primary-100 text-sm">
                        Thank you for being an active and supportive member of our community!
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab functionality
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Update active tab
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('tab-active', 'text-primary-600');
                btn.classList.add('text-neutral-600');
            });
            this.classList.add('tab-active', 'text-primary-600');
            this.classList.remove('text-neutral-600');
            
            // Show active tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        });
    });

    // Follow functionality
    document.querySelectorAll('[class*="bg-primary-500"]').forEach(button => {
        if (button.textContent.includes('Follow')) {
            button.addEventListener('click', function() {
                const isFollowing = this.textContent.includes('Following');
                
                if (isFollowing) {
                    this.innerHTML = '<i class="fas fa-user-plus"></i><span>Follow</span>';
                    this.classList.remove('bg-green-500');
                    this.classList.add('bg-primary-500');
                    showNotification('Unfollowed ' + '{{ $user->name }}', 'info');
                } else {
                    this.innerHTML = '<i class="fas fa-check"></i><span>Following</span>';
                    this.classList.remove('bg-primary-500');
                    this.classList.add('bg-green-500');
                    showNotification('Following ' + '{{ $user->name }}', 'success');
                }
            });
        }
    });

    function showNotification(message, type = 'info') {
        // Simple notification implementation
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white max-w-sm ${
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
            document.body.removeChild(notification);
        }, 3000);
    }
</script>
@endsection