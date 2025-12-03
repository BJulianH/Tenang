@extends('layouts.app')

@section('title', $user->name . ' - Tenang Profile')

@section('styles')
<style>
    .profile-header {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .profile-header:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    .profile-stats {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
    }

    .social-icon {
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        transform: translateY(-2px);
    }

    /* Button Styles */
    .btn-primary {
        background: #58cc70;
        color: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 #45b259;
        transition: all 0.2s ease;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #45b259;
    }

    .btn-primary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #45b259;
    }

    .btn-outline {
        background: white;
        color: #495057;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        font-weight: 600;
        padding: 12px 24px;
    }

    .btn-outline:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #58cc70;
        color: #58cc70;
    }

    /* Card Styles */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* Navigation Tabs */
    .nav-tab {
        position: relative;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        border-radius: 12px 12px 0 0;
        padding: 12px 20px;
        font-weight: 600;
    }

    .nav-tab:hover {
        color: #58cc70;
        border-bottom-color: #c2ebd0;
        background-color: #f8fdf8;
        transform: translateY(-2px);
    }

    .nav-tab.active {
        color: #58cc70;
        border-bottom-color: #58cc70;
        background: linear-gradient(135deg, #f0f9f0, #ffffff);
        box-shadow: 0 2px 0 rgba(88, 204, 112, 0.2);
    }

    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
        padding: 20px;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* Community Cards */
    .community-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
        padding: 16px;
    }

    .community-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    /* Achievement Cards */
    .achievement-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
        padding: 16px;
        text-align: center;
    }

    .achievement-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* Empty State */
    .empty-state {
        background: white;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.05);
        padding: 48px 24px;
        text-align: center;
    }

    /* Interactive Elements */
    .interactive-btn {
        transition: all 0.2s ease;
        border-radius: 12px;
        padding: 8px 16px;
    }

    .interactive-btn:hover {
        transform: translateY(-2px);
        background: #f8f9fa;
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #58cc70;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #45b259;
    }

    /* Rounded corners */
    .rounded-duo {
        border-radius: 16px;
    }

    .rounded-duo-xl {
        border-radius: 24px;
    }

    /* Shadows */
    .shadow-duo {
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .shadow-duo-lg {
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Profile Header -->
    <div class="profile-header mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-2xl shadow-duo">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-neutral-800">{{ $user->name }}</h1>
                            <p class="text-neutral-600 text-lg">@<span>{{ $user->username }}</span></p>
                            @if($user->bio)
                                <p class="text-neutral-500 mt-2 max-w-2xl">{{ $user->bio }}</p>
                            @else
                                <p class="text-neutral-400 mt-2 italic">No bio yet</p>
                            @endif
                        </div>

                        @if($isOwnProfile)
                            <a href="{{ route('profile.edit') }}" class="btn-outline px-6 py-2 rounded-duo font-bold whitespace-nowrap">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                        @else
                            <button class="btn-primary px-6 py-2 rounded-duo font-bold whitespace-nowrap">
                                <i class="fas fa-user-plus mr-2"></i>Follow
                            </button>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap gap-6 mt-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary-600">{{ $stats['total_posts'] ?? 0 }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Posts</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary-600">{{ $stats['total_comments'] ?? 0 }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Comments</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-accent-purple">{{ $stats['total_communities'] ?? 0 }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Communities</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-neutral-500 font-medium">Joined {{ $stats['member_since'] ?? '' }}</div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    @if($user->website || $user->facebook_url || $user->twitter_url || $user->instagram_url)
                    <div class="flex items-center space-x-3 mt-4">
                        @if($user->website)
                        <a href="{{ $user->website }}" target="_blank" class="social-icon text-neutral-500 hover:text-primary-600">
                            <i class="fas fa-globe text-lg"></i>
                        </a>
                        @endif
                        @if($user->facebook_url)
                        <a href="{{ $user->facebook_url }}" target="_blank" class="social-icon text-neutral-500 hover:text-blue-600">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                        @endif
                        @if($user->twitter_url)
                        <a href="{{ $user->twitter_url }}" target="_blank" class="social-icon text-neutral-500 hover:text-blue-400">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        @endif
                        @if($user->instagram_url)
                        <a href="{{ $user->instagram_url }}" target="_blank" class="social-icon text-neutral-500 hover:text-pink-600">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Navigation Tabs -->
            <div class="card p-2 mb-6">
                <div class="flex overflow-x-auto custom-scrollbar">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0 active">
                        <i class="fas fa-newspaper mr-2"></i>
                        <span>Posts</span>
                    </a>
                    <a href="{{ route('profile.comments', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0">
                        <i class="fas fa-comments mr-2"></i>
                        <span>Comments</span>
                    </a>
                    <a href="{{ route('profile.communities', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0">
                        <i class="fas fa-users mr-2"></i>
                        <span>Communities</span>
                    </a>
                </div>
            </div>

            <!-- Posts Feed -->
            <div id="posts-feed" class="space-y-6">
                @forelse($posts as $post)
                    @include('community.partials.post-card', ['post' => $post])
                @empty
                    <div class="empty-state">
                        <i class="fas fa-file-alt text-6xl text-neutral-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-neutral-600 mb-2">No posts yet</h3>
                        <p class="text-neutral-500 text-lg">
                            @if($isOwnProfile)
                                Start sharing your thoughts and experiences with the community!
                            @else
                                {{ $user->name }} hasn't posted anything yet.
                            @endif
                        </p>
                        @if($isOwnProfile)
                        <div class="mt-6">
                            <a href="{{ route('community.index') }}" class="btn-primary px-6 py-3 rounded-duo font-bold inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Create Your First Post
                            </a>
                        </div>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Load More -->
            @if($posts->hasMorePages())
            <div class="text-center mt-8">
                <a href="{{ $posts->nextPageUrl() }}" class="btn-outline px-8 py-4 rounded-duo font-bold inline-flex items-center">
                    <i class="fas fa-arrow-down mr-2"></i>Load More Posts
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- About User -->
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                    About
                </h3>
                <div class="space-y-4 text-sm text-neutral-600">
                    @if($user->location)
                    <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <i class="fas fa-map-marker-alt text-neutral-400"></i>
                        <span class="font-medium">{{ $user->location }}</span>
                    </div>
                    @endif
                    
                    @if($user->show_date_of_birth && $user->date_of_birth)
                    <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <i class="fas fa-birthday-cake text-neutral-400"></i>
                        <span class="font-medium">{{ $user->date_of_birth->format('F j, Y') }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <i class="fas fa-calendar text-neutral-400"></i>
                        <span class="font-medium">Joined {{ $user->created_at->format('F Y') }}</span>
                    </div>
                    
                    @if($user->show_email && $user->email)
                    <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <i class="fas fa-envelope text-neutral-400"></i>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Communities -->
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-users text-primary-500 mr-2"></i>
                    Recent Communities
                </h3>
                <div class="space-y-3">
                    @forelse($communities as $community)
                    <a href="{{ route('community.show', $community->slug) }}" class="community-card flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-duo bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600 shadow-duo-pressed">
                            @if($community->profile_image)
                                <img src="{{ asset('storage/' . $community->profile_image) }}" alt="{{ $community->name }}" class="w-full h-full rounded-duo object-cover">
                            @else
                                <i class="fas fa-users text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-neutral-800">{{ $community->name }}</div>
                            <div class="text-xs text-neutral-500">{{ $community->members_count }} members</div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-6">
                        <i class="fas fa-users text-3xl text-neutral-300 mb-2"></i>
                        <p class="text-neutral-500 text-sm">No communities joined yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Badges/Achievements -->
            <div class="card p-6 bg-gradient-to-br from-primary-50 to-secondary-50 border-2 border-primary-100">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-trophy text-primary-500 mr-2"></i>
                    Achievements
                </h3>
                <div class="grid grid-cols-3 gap-3">
                    <div class="achievement-card text-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2 shadow-duo">
                            <i class="fas fa-star text-yellow-500"></i>
                        </div>
                        <div class="text-xs font-bold text-neutral-600">Active Member</div>
                    </div>
                    <div class="achievement-card text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2 shadow-duo">
                            <i class="fas fa-comments text-blue-500"></i>
                        </div>
                        <div class="text-xs font-bold text-neutral-600">Contributor</div>
                    </div>
                    <div class="achievement-card text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2 shadow-duo">
                            <i class="fas fa-heart text-green-500"></i>
                        </div>
                        <div class="text-xs font-bold text-neutral-600">Supporter</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add active class to current nav tab
    document.addEventListener('DOMContentLoaded', function() {
        const navTabs = document.querySelectorAll('.nav-tab');
        
        navTabs.forEach(tab => {
            if (tab.href === window.location.href) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });

        // Add Duolingo-style interactions
        document.querySelectorAll('.btn-primary, .btn-outline, .card, .community-card, .achievement-card').forEach(element => {
            element.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-outline')) {
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-outline')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-outline')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
        });
    });

    // Enhanced notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-duo shadow-lg text-white max-w-sm transform translate-x-full transition-transform duration-300 font-bold ${
            type === 'success' ? 'bg-green-500 border-2 border-green-600' :
            type === 'error' ? 'bg-red-500 border-2 border-red-600' :
            'bg-blue-500 border-2 border-blue-600'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} mr-3 text-lg"></i>
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
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
</script>
@endsection