{{-- resources/views/community/show.blade.php --}}
@extends('layouts.app')

@section('title', $community->name . ' - MindWell Community')

@section('styles')
<style>
    .community-header {
        background: linear-gradient(135deg, #f0f9f0 0%, #dcf2dc 100%);
    }
    
    .member-avatar {
        transition: transform 0.3s ease;
    }
    
    .member-avatar:hover {
        transform: scale(1.1);
    }
    
    .join-btn {
        transition: all 0.3s ease;
    }
    
    .community-stats {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }

    /* Mood Styles dari index */
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
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
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

    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

    @keyframes loading-bounce {
        0%, 80%, 100% {
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
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .pulse-gentle {
        animation: pulse-gentle 2s infinite;
    }

    /* Card Styles */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
    }

    .rounded-duo {
        border-radius: 16px;
    }

    .rounded-duo-xl {
        border-radius: 24px;
    }

    .shadow-duo {
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .shadow-duo-pressed {
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Community Header -->
    <div class="rounded-duo-xl mb-6 overflow-hidden community-header">
        <!-- Cover Area -->
        <div class="h-64 relative">
            @if($community->banner_image)
            <img src="{{ asset('storage/' . $community->banner_image) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
            @endif
            
            <!-- Community Stats Overlay -->
            <div class="absolute bottom-4 left-4 right-4">
                <div class="community-stats rounded-duo p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <!-- Community Image -->
                            <div class="w-24 h-24 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-3xl font-bold border-4 border-white shadow-duo">
                                @if($community->profile_image)
                                    <img src="{{ asset('storage/' . $community->profile_image) }}" alt="{{ $community->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fas fa-users"></i>
                                @endif
                            </div>
                            
                            <!-- Community Info -->
                            <div>
                                <h1 class="text-3xl font-bold text-neutral-800">{{ $community->name }}</h1>
                                <p class="text-neutral-600 text-lg mt-1">{{ $community->description }}</p>
                                <div class="flex items-center space-x-6 mt-3 text-base text-neutral-500">
                                    <span class="flex items-center space-x-2">
                                        <i class="fas fa-users text-primary-500"></i>
                                        <span class="font-medium">{{ $community->members_count }} members</span>
                                    </span>
                                    <span class="flex items-center space-x-2">
                                        <i class="fas fa-file-alt text-secondary-500"></i>
                                        <span class="font-medium">{{ $community->posts_count }} posts</span>
                                    </span>
                                    <span class="flex items-center space-x-2">
                                        <i class="fas fa-globe text-accent-blue"></i>
                                        <span class="font-medium capitalize">{{ $community->type }} community</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-4">
                            @if($isMember)
                                @if($isAdmin)
                                <span class="bg-primary-500 text-white px-6 py-3 rounded-duo font-bold shadow-duo">
                                    <i class="fas fa-crown mr-2"></i>Admin
                                </span>
                                @else
                                <span class="bg-green-500 text-white px-6 py-3 rounded-duo font-bold shadow-duo">
                                    <i class="fas fa-check mr-2"></i>Member
                                </span>
                                @endif
                                <button class="leave-community-btn border-2 border-red-300 text-red-600 px-6 py-3 rounded-duo hover:bg-red-50 transition-all font-bold interactive-btn"
                                        data-community-id="{{ $community->id }}"
                                        data-leave-url="{{ route('communities.leave', $community) }}">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Leave
                                </button>
                            @else
                                <button class="join-community-btn btn-primary px-8 py-3 rounded-duo font-bold join-btn"
                                        data-community-id="{{ $community->id }}"
                                        data-join-url="{{ route('communities.join', $community) }}">
                                    <i class="fas fa-plus mr-2"></i>Join Community
                                </button>
                            @endif
                            
                            @if($isAdmin)
                            <a href="{{ route('community.manage', $community->slug) }}" class="border-2 border-neutral-300 text-neutral-700 px-6 py-3 rounded-duo hover:bg-neutral-50 transition-all font-bold interactive-btn">
                                <i class="fas fa-cog mr-2"></i>Manage
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Create Post Card (for members) -->
            @if($isMember)
            <div class="card rounded-duo-xl p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-lg shadow-duo">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <button onclick="openCreatePostModal('{{ $community->id }}')" class="flex-1 text-left p-4 bg-neutral-50 rounded-duo border-2 border-neutral-200 hover:border-primary-300 transition-all duration-200 text-neutral-500 hover:text-neutral-700 font-medium">
                        Share something in {{ $community->name }}...
                    </button>
                </div>
                <div class="flex justify-between mt-4 px-4">
                    <button onclick="openCreatePostModal('{{ $community->id }}')" class="flex items-center space-x-3 text-neutral-600 hover:text-primary-600 transition-all duration-200 interactive-btn">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-image text-green-500"></i>
                        </div>
                        <span class="font-medium">Photo</span>
                    </button>
                    <button onclick="openCreatePostModal('{{ $community->id }}')" class="flex items-center space-x-3 text-neutral-600 hover:text-primary-600 transition-all duration-200 interactive-btn">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-video text-blue-500"></i>
                        </div>
                        <span class="font-medium">Video</span>
                    </button>
                    <button onclick="openCreatePostModal('{{ $community->id }}')" class="flex items-center space-x-3 text-neutral-600 hover:text-primary-600 transition-all duration-200 interactive-btn">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-feather text-purple-500"></i>
                        </div>
                        <span class="font-medium">Feeling</span>
                    </button>
                </div>
            </div>
            @endif

            <!-- Posts Feed -->
            <div id="posts-feed" class="space-y-6">
                @forelse($posts as $post)
                    @include('community.partials.post-card', ['post' => $post])
                @empty
                    <div class="card rounded-duo-xl p-8 text-center">
                        <i class="fas fa-comments text-6xl text-neutral-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-neutral-600 mb-3">No posts yet</h3>
                        <p class="text-neutral-500 text-lg mb-6">
                            @if($isMember)
                                Be the first to start a discussion in this community!
                            @else
                                Join this community to start posting and see existing discussions.
                            @endif
                        </p>
                        @if($isMember)
                        <button onclick="openCreatePostModal('{{ $community->id }}')" class="btn-primary px-8 py-4 rounded-duo font-bold text-lg">
                            <i class="fas fa-plus mr-2"></i>Create First Post
                        </button>
                        @else
                        <button class="join-community-btn btn-primary px-8 py-4 rounded-duo font-bold text-lg"
                                data-community-id="{{ $community->id }}"
                                data-join-url="{{ route('communities.join', $community) }}">
                            <i class="fas fa-users mr-2"></i>Join to Participate
                        </button>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Load More -->
            @if($posts->hasMorePages())
            <div class="text-center mt-8">
                <a href="{{ $posts->nextPageUrl() }}" class="btn-primary px-8 py-4 rounded-duo font-bold">
                    <i class="fas fa-arrow-down mr-2"></i>Load More Posts
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- About Community -->
            <div class="card rounded-duo-xl p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-primary-500 mr-3"></i>
                    About This Community
                </h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-neutral-700 mb-2">Description</h4>
                        <p class="text-neutral-600">{{ $community->description }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-neutral-700 mb-2">Community Type</h4>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-2 rounded-duo text-sm font-bold
                                @if($community->type === 'public') bg-green-100 text-green-800 border-2 border-green-200
                                @elseif($community->type === 'private') bg-blue-100 text-blue-800 border-2 border-blue-200
                                @else bg-yellow-100 text-yellow-800 border-2 border-yellow-200 @endif">
                                <i class="fas 
                                    @if($community->type === 'public') fa-globe
                                    @elseif($community->type === 'private') fa-lock
                                    @else fa-shield-alt @endif mr-2"></i>
                                {{ ucfirst($community->type) }}
                            </span>
                            <span class="text-sm text-neutral-500 font-medium">
                                @if($community->type === 'public')
                                    Anyone can view and join
                                @elseif($community->type === 'private')
                                    Approval required to join
                                @else
                                    Restricted access
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-neutral-700 mb-2">Created</h4>
                        <p class="text-neutral-600">{{ $community->created_at->format('F j, Y') }} by 
                            <a href="{{ route('profile.community', $community->creator->username) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                {{ $community->creator->name }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Members -->
            <div class="card rounded-duo-xl p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-users text-secondary-500 mr-3"></i>
                    Recent Members
                </h3>
                <div class="grid grid-cols-4 gap-4">
                    @foreach($recentMembers as $member)
                    <a href="{{ route('profile.community', $member->username) }}" class="text-center group">
                        <div class="member-avatar w-14 h-14 rounded-full bg-gradient-to-r from-primary-300 to-secondary-300 flex items-center justify-center text-white font-bold mx-auto shadow-duo group-hover:shadow-lg transition-all">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                        <p class="text-sm text-neutral-600 mt-2 truncate font-medium group-hover:text-primary-600 transition-colors">
                            {{ $member->name }}
                        </p>
                    </a>
                    @endforeach
                </div>
                <div class="text-center mt-4 pt-4 border-t border-neutral-200">
                    <a href="#" class="text-primary-600 hover:text-primary-700 font-bold text-sm">
                        View All {{ $community->members_count }} Members
                    </a>
                </div>
            </div>

            <!-- Related Communities -->
            @if($relatedCommunities->count() > 0)
            <div class="card rounded-duo-xl p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-compass text-accent-blue mr-3"></i>
                    Related Communities
                </h3>
                <div class="space-y-4">
                    @foreach($relatedCommunities as $relatedCommunity)
                    <a href="{{ route('community.show', $relatedCommunity->slug) }}" class="community-badge p-4 rounded-duo block hover:no-underline">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600 shadow-duo-pressed">
                                @if($relatedCommunity->profile_image)
                                <img src="{{ asset('storage/' . $relatedCommunity->profile_image) }}" alt="{{ $relatedCommunity->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                <i class="fas fa-users"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-neutral-800">{{ $relatedCommunity->name }}</div>
                                <div class="text-sm text-neutral-500">{{ $relatedCommunity->members_count }} members</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Community Guidelines -->
            <div class="card rounded-duo-xl p-6 bg-gradient-to-br from-primary-50 to-secondary-50 border-2 border-primary-100">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-shield-alt text-primary-600 mr-3"></i>
                    Community Guidelines
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start p-3 bg-white rounded-duo border-2 border-primary-200">
                        <i class="fas fa-heart text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Be respectful to all members</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-duo border-2 border-primary-200">
                        <i class="fas fa-hands-helping text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Keep discussions relevant</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-duo border-2 border-primary-200">
                        <i class="fas fa-comment-medical text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">No spam or self-promotion</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-duo border-2 border-primary-200">
                        <i class="fas fa-lock text-primary-500 mt-1 mr-3"></i>
                        <span class="text-neutral-700 font-medium">Follow community rules</span>
                    </li>
                </ul>
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

                            <!-- Community Selection (hidden) -->
                            <input type="hidden" name="community_id" value="{{ $community->id }}">

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
    // Modal functionality untuk community show
    function openCreatePostModal(communityId) {
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
            // Reset form ketika modal ditutup
            const form = document.getElementById('createPostForm');
            if (form) {
                form.reset();
                // Reset mood selection
                document.querySelectorAll('.mood-option').forEach(opt => {
                    opt.classList.remove('selected', 'border-primary-500', 'bg-primary-50');
                });
                // Set default mood
                const defaultMood = document.querySelector('input[name="mood"][value="neutral"]');
                if (defaultMood) {
                    defaultMood.checked = true;
                    defaultMood.closest('.mood-option').classList.add('selected', 'border-primary-500', 'bg-primary-50');
                }
                // Reset image preview
                document.getElementById('image-preview').classList.add('hidden');
            }
        }, 300);
    }

    // Close modal when clicking outside
    document.getElementById('createPostModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCreatePostModal();
        }
    });

    // Mood selection dengan animasi enhanced
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

    // Image preview dengan animasi
    document.getElementById('image-upload')?.addEventListener('change', function(e) {
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

    // Enhanced form submission dengan UX yang lebih baik
    document.getElementById('createPostForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        
        // Debug: lihat data form
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Disable button dan show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Creating Post...';
        
        fetch('{{ route("posts.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json().then(data => {
                return {
                    status: response.status,
                    data: data
                };
            });
        })
        .then(({status, data}) => {
            console.log('Response data:', data);
            
            if (status === 422) {
                // Validation errors
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
                // Reset form
                this.reset();
                // Reload page to show new post
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
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Create Post';
        });
    });

    // Enhanced community join/leave dengan animasi
    document.addEventListener('click', function(e) {
        if (e.target.closest('.join-community-btn') || e.target.closest('.leave-community-btn')) {
            const btn = e.target.closest('.join-community-btn') || e.target.closest('.leave-community-btn');
            const isJoin = btn.classList.contains('join-community-btn');
            const url = isJoin ? btn.dataset.joinUrl : btn.dataset.leaveUrl;
            
            // Add loading animation
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div>';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (isJoin) {
                        if (data.status === 'pending') {
                            showNotification('⏳ Join request sent for approval', 'success');
                            btn.innerHTML = '<span class="text-sm bg-yellow-100 text-yellow-700 px-3 py-2 rounded-full font-medium">Pending</span>';
                        } else {
                            showNotification('🎉 Joined community successfully!', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        showNotification('👋 Left community successfully', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
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

    // Add hover effects dan animations
    document.addEventListener('DOMContentLoaded', function() {
        // Add pulse animation ke community badges
        const communityBadges = document.querySelectorAll('.community-badge');
        communityBadges.forEach((badge, index) => {
            badge.style.animationDelay = `${index * 0.1}s`;
            badge.classList.add('pulse-gentle');
        });

        // Enhanced member avatars
        const memberAvatars = document.querySelectorAll('.member-avatar');
        memberAvatars.forEach(avatar => {
            avatar.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(5deg)';
            });
            avatar.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        });
    });

    // Fungsi lainnya (like, comment, dll) dari index
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
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
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
</script>
@endsection