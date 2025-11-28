{{-- resources/views/community/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Community Feed - MindWell')

@section('styles')
<style>
    .mood-happy {
        border-left: 4px solid #58cc70;
        background: linear-gradient(90deg, #f0f9f0 0%, transparent 100%);
    }

    .mood-calm {
        border-left: 4px solid #4a8cff;
        background: linear-gradient(90deg, #f0f8ff 0%, transparent 100%);
    }

    .mood-anxious {
        border-left: 4px solid #ffc800;
        background: linear-gradient(90deg, #fff9e6 0%, transparent 100%);
    }

    .mood-sad {
        border-left: 4px solid #9b59b6;
        background: linear-gradient(90deg, #f8f0ff 0%, transparent 100%);
    }

    .mood-angry {
        border-left: 4px solid #ff6b6b;
        background: linear-gradient(90deg, #fff0f0 0%, transparent 100%);
    }

    .mood-neutral {
        border-left: 4px solid #6c757d;
        background: linear-gradient(90deg, #f8f9fa 0%, transparent 100%);
    }

    .post-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e5e7eb;
        /* abu abu lembut */
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
        /* abu abu sedikit lebih gelap */
    }


    .like-animation {
        animation: like-pulse 0.6s ease;
    }

    @keyframes like-pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.3);
        }

        100% {
            transform: scale(1);
        }
    }

    .comment-section {
        max-height: 400px;
        overflow-y: auto;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
    }

    .reply-form {
        transition: all 0.3s ease;
        background: white;
        border-radius: 12px;
        padding: 1rem;
        border: 2px solid #e9ecef;
    }

    .comment-item {
        border-left: 3px solid transparent;
        transition: border-color 0.3s ease;
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        border: 2px solid #f1f3f4;
    }

    .comment-item:hover {
        border-left-color: #58cc70;
        border-color: #e8f5e8;
    }

    /* Modal Styles */
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        transform: translateY(-50px);
        opacity: 0;
        transition: all 0.3s ease;
        border-radius: 24px;
        border: 3px solid white;
        box-shadow: 0 10px 0 rgba(0, 0, 0, 0.1);
    }

    .modal-open .modal-content {
        transform: translateY(0);
        opacity: 1;
    }

    .mood-option {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 0.75rem;
    }

    .mood-option:hover {
        transform: scale(1.05);
        border-color: #58cc70;
    }

    .mood-option.selected {
        border-color: #58cc70;
        background: linear-gradient(135deg, #e6f7ea, #fff9e6);
        box-shadow: 0 4px 0 rgba(88, 204, 112, 0.2);
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
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

    .btn-secondary {
        background: #ffc800;
        color: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 #e6b400;
        transition: all 0.2s ease;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #e6b400;
    }

    .btn-secondary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #e6b400;
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

    /* Gradient Backgrounds */
    .gradient-primary {
        background: linear-gradient(135deg, #58cc70, #4a8cff);
    }

    .gradient-secondary {
        background: linear-gradient(135deg, #ffc800, #ff9f43);
    }

    /* Notification Styles */
    .notification-success {
        background: linear-gradient(135deg, #58cc70, #45b259);
        border: 2px solid #45b259;
    }

    .notification-error {
        background: linear-gradient(135deg, #ff6b6b, #e55c5c);
        border: 2px solid #e55c5c;
    }

    /* Community Badge */
    .community-badge {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        border: 3px solid #f1f3f4;
    }

    .community-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;

    }

    /* Loading Animation */
    .loading-dots {
        display: inline-flex;
        gap: 4px;
    }

    .loading-dots span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #58cc70;
        animation: loading-bounce 1.4s infinite ease-in-out;
    }

    .loading-dots span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .loading-dots span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes loading-bounce {

        0%,
        80%,
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Pulse Animation */
    @keyframes pulse-gentle {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .pulse-gentle {
        animation: pulse-gentle 2s infinite;
    }

</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Feed -->
        <div class="lg:w-2/3">
            <!-- Header -->
            <div class="mb-6">
                <!-- Profile Header -->
                <div class="bg-white rounded-duo-xl p-6 shadow-duo border-2 border-neutral-200">
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
                                    <div class="text-2xl font-bold text-primary-600">{{ $stats['total_posts'] ??0}}</div>
                                    <div class="text-sm text-neutral-500 font-medium">Posts</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-secondary-600">{{ $stats['total_comments'] ??0}}</div>
                                    <div class="text-sm text-neutral-500 font-medium">Comments</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-accent-purple">{{ $stats['total_communities'] ??0}}</div>
                                    <div class="text-sm text-neutral-500 font-medium">Communities</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm text-neutral-500 font-medium">Joined {{ $stats['member_since'] ??0}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info (Location, Website, etc) -->
                    @if($user->location || $user->website)
                    <div class="mt-6 pt-6 border-t border-neutral-200">
                        <div class="flex flex-wrap gap-4 text-sm text-neutral-600">
                            @if($user->location)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $user->location }}</span>
                            </div>
                            @endif
                            @if($user->website)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-globe"></i>
                                <a href="{{ $user->website }}" target="_blank" class="text-primary-600 hover:text-primary-700">
                                    {{ parse_url($user->website, PHP_URL_HOST) }}
                                </a>
                            </div>
                            @endif
                            @if($user->date_of_birth && $user->show_date_of_birth)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-birthday-cake"></i>
                                <span>{{ $user->date_of_birth->format('F j, Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Social Links -->
                    @if($user->hasSocialLinks())
                    <div class="mt-4 pt-4 border-t border-neutral-200">
                        <div class="flex gap-4">
                            @if($user->facebook_url)
                            <a href="{{ $user->facebook_url }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 hover:bg-blue-200 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if($user->twitter_url)
                            <a href="{{ $user->twitter_url }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-400 hover:bg-blue-200 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                            @if($user->instagram_url)
                            <a href="{{ $user->instagram_url }}" target="_blank" class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 hover:bg-pink-200 transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($user->linkedin_url)
                            <a href="{{ $user->linkedin_url }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 hover:bg-blue-200 transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if($user->github_url)
                            <a href="{{ $user->github_url }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-800 hover:bg-gray-200 transition-colors">
                                <i class="fab fa-github"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Navigation Tabs -->
                <div class="mt-6 bg-white rounded-duo-xl p-1 shadow-duo border-2 border-neutral-200">
                    <div class="flex overflow-x-auto custom-scrollbar">
                        <a href="{{ route('profile.community', $user->username) }}" class="tab-button flex items-center px-6 py-3 font-medium text-neutral-700 rounded-duo {{ request()->routeIs('profile.community') ? 'active' : '' }}">
                            <i class="fas fa-newspaper mr-2"></i>
                            <span>Posts</span>
                        </a>
                        <a href="{{ route('profile.comments', $user->username) }}" class="tab-button flex items-center px-6 py-3 font-medium text-neutral-700 rounded-duo {{ request()->routeIs('profile.comments') ? 'active' : '' }}">
                            <i class="fas fa-comments mr-2"></i>
                            <span>Comments</span>
                        </a>
                        <a href="{{ route('profile.communities', $user->username) }}" class="tab-button flex items-center px-6 py-3 font-medium text-neutral-700 rounded-duo {{ request()->routeIs('profile.communities') ? 'active' : '' }}">
                            <i class="fas fa-users mr-2"></i>
                            <span>Communities</span>
                        </a>
                        @if($isOwnProfile)
                        <a href="{{ route('profile.edit') }}" class="tab-button flex items-center px-6 py-3 font-medium text-neutral-700 rounded-duo {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <i class="fas fa-cog mr-2"></i>
                            <span>Settings</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Create Post Card -->
            <div class="card rounded-duo-xl p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-lg shadow-duo">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <button onclick="openCreatePostModal()" class="flex-1 text-left p-4 bg-neutral-50 rounded-duo border-2 border-neutral-200 hover:border-primary-300 transition-all duration-200 text-neutral-500 hover:text-neutral-700 font-medium">
                        Share your thoughts, {{ auth()->user()->name }}...
                    </button>
                </div>
                <div class="flex justify-between mt-4 px-4">
                    <button onclick="openCreatePostModal()" class="flex items-center space-x-3 text-neutral-600 hover:text-primary-600 transition-all duration-200 interactive-btn">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-image text-green-500"></i>
                        </div>
                        <span class="font-medium">Photo</span>
                    </button>
                    <button onclick="openCreatePostModal()" class="flex items-center space-x-3 text-neutral-600 hover:text-primary-600 transition-all duration-200 interactive-btn">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-video text-blue-500"></i>
                        </div>
                        <span class="font-medium">Video</span>
                    </button>
                    <button onclick="openCreatePostModal()" class="flex items-center space-x-3 text-neutral-600 hover:text-primary-600 transition-all duration-200 interactive-btn">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-feather text-purple-500"></i>
                        </div>
                        <span class="font-medium">Feeling</span>
                    </button>
                </div>
            </div>

            <!-- Posts Feed -->
            <div id="posts-feed" class="space-y-6">
                @foreach($posts as $post)
                @include('community.partials.post-card', ['post' => $post, 'isGlobal' => true])
                @endforeach
            </div>

            <!-- Load More -->
            @if($posts->hasMorePages())
            <div class="text-center mt-8">
                <button id="load-more" data-next-page="{{ $posts->currentPage() + 1 }}" class="btn-primary px-8 py-4 rounded-duo font-bold">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Load More Posts
                </button>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- Trending Communities -->
            <div class="card rounded-duo-xl p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-fire text-secondary-500 mr-3 "></i>
                    Trending Communities
                </h3>
                <div class="space-y-4">
                    @foreach($trendingCommunities as $community)
                    <div class="community-badge p-4 rounded-duo">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600 shadow-duo-pressed">
                                    @if($community->profile_image)
                                    <img src="{{ asset('storage/' . $community->profile_image) }}" alt="{{ $community->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                    <i class="fas fa-users text-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('community.show', $community->slug) }}" class="font-bold text-neutral-800 hover:text-primary-600 transition-colors">
                                        {{ $community->name }}
                                    </a>
                                    <p class="text-sm text-neutral-500">{{ $community->members_count }} members</p>
                                </div>
                            </div>
                            <button class="join-community-btn {{ $community->is_member ? 'joined' : '' }} interactive-btn" data-community-id="{{ $community->id }}" data-join-url="{{ route('communities.join', $community) }}" data-leave-url="{{ route('communities.leave', $community) }}">
                                @if($community->is_member)
                                <span class="text-sm bg-primary-100 text-primary-700 px-3 py-2 rounded-full font-medium">Joined</span>
                                @else
                                <span class="text-sm bg-neutral-100 text-neutral-700 px-3 py-2 rounded-full hover:bg-primary-100 hover:text-primary-700 font-medium transition-colors">Join</span>
                                @endif
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Community Guidelines -->
            <div class="card rounded-duo-xl p-6 bg-gradient-to-br from-primary-50 to-secondary-50 border-2 border-primary-100">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-shield-alt text-primary-600 mr-3"></i>
                    Community Guidelines
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start p-3 bg-white rounded-duo border border-primary-200">
                        <i class="fas fa-heart text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Be kind and supportive to others</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-duo border border-primary-200">
                        <i class="fas fa-hands-helping text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Respect different perspectives</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-duo border border-primary-200">
                        <i class="fas fa-comment-medical text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Share your experiences honestly</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-duo border border-primary-200">
                        <i class="fas fa-lock text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Maintain confidentiality</span>
                    </li>
                </ul>
            </div>

            <!-- Quick Stats -->
            <div class="card rounded-duo-xl p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line text-accent-blue mr-3"></i>
                    Community Stats
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-primary-50 rounded-duo border-2 border-primary-200">
                        <div class="text-2xl font-bold text-primary-600">{{ $posts->total() }}</div>
                        <div class="text-sm text-neutral-600 font-medium">Total Posts</div>
                    </div>
                    <div class="text-center p-4 bg-secondary-50 rounded-duo border-2 border-secondary-200">
                        <div class="text-2xl font-bold text-secondary-600">{{ $trendingCommunities->sum('members_count') }}</div>
                        <div class="text-sm text-neutral-600 font-medium">Active Members</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Post Modal -->
<div id="createPostModal" class="fixed inset-0 z-50 overflow-y-auto modal-overlay hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="modal-content inline-block align-bottom bg-white rounded-duo-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="createPostForm" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-2xl leading-6 font-bold text-neutral-800 mb-6 flex items-center">
                                <i class="fas fa-edit text-primary-500 mr-3"></i>
                                Create New Post
                            </h3>

                            <!-- Community Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-neutral-700 mb-3">Post to Community *</label>
                                <select name="community_id" class="w-full border-2 border-neutral-300 rounded-duo px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo-pressed" required>
                                    <option value="">Select a community...</option>
                                    @foreach(auth()->user()->communities as $community)
                                    <option value="{{ $community->id }}">{{ $community->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Title -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-neutral-700 mb-3">Title *</label>
                                <input type="text" name="title" class="w-full border-2 border-neutral-300 rounded-duo px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo-pressed" placeholder="What's on your mind?" required>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-neutral-700 mb-3">Content *</label>
                                <textarea name="content" rows="4" class="w-full border-2 border-neutral-300 rounded-duo px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo-pressed resize-none" placeholder="Share your thoughts, experiences, or ask for support..." required></textarea>
                            </div>

                            <!-- Mood Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-neutral-700 mb-3">How are you feeling?</label>
                                <div class="grid grid-cols-6 gap-2">
                                    @foreach(['happy' => '😊', 'calm' => '😌', 'anxious' => '😰', 'sad' => '😢', 'angry' => '😠', 'neutral' => '😐'] as $mood => $emoji)
                                    <label class="mood-option text-center cursor-pointer">
                                        <input type="radio" name="mood" value="{{ $mood }}" class="hidden" {{ $mood == 'neutral' ? 'checked' : '' }}>
                                        <div class="text-2xl mb-1">{{ $emoji }}</div>
                                        <div class="text-xs text-neutral-600 capitalize font-medium">{{ $mood }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-neutral-700 mb-3">Add Image (Optional)</label>
                                <div class="border-2 border-dashed border-neutral-300 rounded-duo p-6 text-center bg-neutral-50">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-neutral-400 mb-3"></i>
                                    <p class="text-neutral-500 text-sm mb-3 font-medium">Click to upload an image</p>
                                    <input type="file" name="image" id="image-upload" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('image-upload').click()" class="btn-secondary px-4 py-2 rounded-duo text-sm font-bold">
                                        Choose Image
                                    </button>
                                    <div id="image-preview" class="mt-4 hidden">
                                        <img id="preview-img" class="max-h-48 mx-auto rounded-duo border-2 border-neutral-200">
                                    </div>
                                </div>
                            </div>

                            <!-- Privacy Options -->
                            <div class="flex items-center space-x-6 text-sm font-medium">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="is_anonymous" value="1" class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500 w-5 h-5">
                                    <span class="text-neutral-700">Post anonymously</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="is_support_request" value="1" class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500 w-5 h-5">
                                    <span class="text-neutral-700">This is a support request</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-duo-xl">
                    <button type="submit" class="btn-primary px-6 py-3 rounded-duo font-bold text-lg w-full sm:w-auto sm:ml-3">
                        <i class="fas fa-plus mr-2"></i>
                        Create Post
                    </button>
                    <button type="button" onclick="closeCreatePostModal()" class="mt-3 w-full inline-flex justify-center rounded-duo border border-gray-300 shadow-sm px-4 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm interactive-btn">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal functionality
    function openCreatePostModal() {
        const modal = document.getElementById('createPostModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('modal-open');
        }, 10);
    }

    function closeCreatePostModal() {
        const modal = document.getElementById('createPostModal');
        modal.classList.remove('modal-open');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Close modal when clicking outside
    document.getElementById('createPostModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCreatePostModal();
        }
    });

    // Mood selection with enhanced animation
    document.querySelectorAll('.mood-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.mood-option').forEach(opt => {
                opt.classList.remove('selected', 'border-primary-500', 'bg-primary-50');
            });
            this.classList.add('selected', 'border-primary-500', 'bg-primary-50');
            this.querySelector('input').checked = true;

            // Add bounce animation
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });

    // Image preview with animation
    document.getElementById('image-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-img');
                const previewContainer = document.getElementById('image-preview');

                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
                previewContainer.style.opacity = '0';
                previewContainer.style.transform = 'scale(0.8)';

                setTimeout(() => {
                    previewContainer.style.opacity = '1';
                    previewContainer.style.transform = 'scale(1)';
                    previewContainer.style.transition = 'all 0.3s ease';
                }, 100);
            }
            reader.readAsDataURL(file);
        }
    });

    // Enhanced form submission with better UX
    document.getElementById('createPostForm') ? .addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');

        // Add loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Creating Post...';

        fetch('{{ route("posts.store") }}', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Accept': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({
                status: response.status
                , data
            })))
            .then(({
                status
                , data
            }) => {
                if (status === 422) {
                    let errorMessage = 'Please fix the following errors: ';
                    if (data.errors) {
                        const errorMessages = [];
                        for (const field in data.errors) {
                            errorMessages.push(...data.errors[field]);
                        }
                        errorMessage += errorMessages.join(', ');
                    } else {
                        errorMessage += data.message || 'Validation failed';
                    }
                    showNotification(errorMessage, 'error');
                    return;
                }

                if (data.success) {
                    showNotification('🎉 Post created successfully!', 'success');
                    closeCreatePostModal();
                    this.reset();
                    document.querySelectorAll('.mood-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    document.querySelector('input[value="neutral"]').closest('.mood-option').classList.add('selected');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showNotification(data.message || 'Error creating post', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error: ' + error.message, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Create Post';
            });
    });

    // Enhanced like functionality with better animation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.like-btn')) {
            const btn = e.target.closest('.like-btn');
            const postId = btn.dataset.postId;
            const isLiked = btn.classList.contains('liked');
            const url = isLiked ? `/community/posts/${postId}/unlike` : `/community/posts/${postId}/like`;

            // Add immediate visual feedback
            const likeIcon = btn.querySelector('i');
            likeIcon.classList.add('like-animation');

            fetch(url, {
                    method: 'POST'
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const likeCount = btn.querySelector('.like-count');

                        if (data.action === 'added') {
                            btn.classList.add('liked', 'text-primary-600');
                            likeIcon.classList.replace('far', 'fas');
                        } else {
                            btn.classList.remove('liked', 'text-primary-600');
                            likeIcon.classList.replace('fas', 'far');
                        }

                        likeCount.textContent = data.likes_count;
                        likeCount.classList.add('pulse-gentle');
                        setTimeout(() => likeCount.classList.remove('pulse-gentle'), 600);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error processing like', 'error');
                })
                .finally(() => {
                    setTimeout(() => {
                        likeIcon.classList.remove('like-animation');
                    }, 600);
                });
        }
    });

    // Enhanced notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-duo shadow-lg text-white max-w-sm transform translate-x-full transition-transform duration-300 font-bold ${
            type === 'success' ? 'notification-success' :
            type === 'error' ? 'notification-error' :
            'bg-blue-500'
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

    // Enhanced community join/leave with animation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.join-community-btn')) {
            const btn = e.target.closest('.join-community-btn');
            const communityId = btn.dataset.communityId;
            const isJoined = btn.classList.contains('joined');
            const url = isJoined ? btn.dataset.leaveUrl : btn.dataset.joinUrl;

            // Add loading animation
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div>';

            fetch(url, {
                    method: 'POST'
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (isJoined) {
                            btn.classList.remove('joined');
                            btn.innerHTML = '<span class="text-sm bg-neutral-100 text-neutral-700 px-3 py-2 rounded-full hover:bg-primary-100 hover:text-primary-700 font-medium transition-colors">Join</span>';
                            showNotification('👋 Left community successfully', 'success');
                        } else {
                            btn.classList.add('joined');
                            if (data.status === 'pending') {
                                btn.innerHTML = '<span class="text-sm bg-yellow-100 text-yellow-700 px-3 py-2 rounded-full font-medium">Pending</span>';
                                showNotification('⏳ Join request sent for approval', 'success');
                            } else {
                                btn.innerHTML = '<span class="text-sm bg-primary-100 text-primary-700 px-3 py-2 rounded-full font-medium">Joined</span>';
                                showNotification('🎉 Joined community successfully!', 'success');
                            }
                        }
                    } else {
                        btn.innerHTML = originalHtml;
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.innerHTML = originalHtml;
                    showNotification('Error processing request', 'error');
                });
        }
    });

    // Add hover effects to all interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Add pulse animation to trending communities
        const trendingCards = document.querySelectorAll('.community-badge');
        trendingCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('pulse-gentle');
        });

        // Enhanced scroll behavior
        const loadMoreBtn = document.getElementById('load-more');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                this.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Loading...';
            });
        }
    });

</script>
@endsection
