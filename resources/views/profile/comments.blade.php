@extends('layouts.app')

@section('title', $user->name . ' - Comments - MindWell Profile')

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

    .profile-avatar {
        border: 4px solid white;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .online-indicator {
        box-shadow: 0 0 0 3px white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

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

    .comment-card {
        transition: all 0.3s ease;
        border: 2px solid #f1f3f4;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .comment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    .post-preview {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-left: 4px solid #58cc70;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .empty-state {
        background: white;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.05);
    }

    .comment-content {
        line-height: 1.6;
        color: #374151;
    }

    .comment-actions {
        opacity: 0;
        transition: all 0.3s ease;
    }

    .comment-card:hover .comment-actions {
        opacity: 1;
    }

    .time-ago {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .like-count {
        transition: all 0.3s ease;
    }

    .like-btn:hover .like-count {
        color: #dc2626;
    }

    .community-badge {
        background: linear-gradient(135deg, #58cc70, #45b259);
        color: white;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-weight: 600;
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

    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
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

    /* Like Animation */
    .like-animation {
        animation: like-pulse 0.6s ease;
    }

    @keyframes like-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
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

    /* Notification Styles */
    .notification-success {
        background: linear-gradient(135deg, #58cc70, #45b259);
        border: 2px solid #45b259;
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 0 rgba(69, 178, 89, 0.3);
    }

    .notification-error {
        background: linear-gradient(135deg, #ff6b6b, #e55c5c);
        border: 2px solid #e55c5c;
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 0 rgba(229, 92, 92, 0.3);
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
                            <div class="text-2xl font-bold text-primary-600">{{ $user->posts_count ?? 0 }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Posts</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary-600">{{ $user->comments_count ?? 0 }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Comments</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-accent-purple">{{ $user->communities()->count() ?? 0 }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Communities</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-neutral-500 font-medium">Joined {{ $user->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Navigation Tabs -->
            <div class="card p-2 mb-8">
                <div class="flex overflow-x-auto custom-scrollbar">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0">
                        <i class="fas fa-newspaper mr-2"></i>
                        <span>Posts</span>
                    </a>
                    <a href="{{ route('profile.comments', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0 active">
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

            <!-- Comments Header -->
            <div class="card p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-neutral-800 flex items-center">
                            <i class="fas fa-comments text-primary-500 mr-2"></i>
                            All Comments
                        </h2>
                        <p class="text-neutral-600 mt-1">
                            {{ $comments->total() }} comments across {{ $comments->unique('post_id')->count() }} posts
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-neutral-500 font-medium">Sorted by:</span>
                        <select class="border-2 border-neutral-300 rounded-duo px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo-pressed">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="popular">Most Liked</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($comments as $comment)
                <div class="comment-card p-6">
                    <!-- Comment Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-semibold text-sm shadow-duo">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-neutral-800">{{ $user->name }}</span>
                                        <span class="time-ago">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-sm text-neutral-500">in</span>
                                        <a href="{{ route('community.show', $comment->post->community->slug) }}" class="community-badge text-xs">
                                            {{ $comment->post->community->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comment Actions -->
                        <div class="comment-actions flex items-center gap-2">
                            @if($isOwnProfile)
                            <button class="text-neutral-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50 interactive-btn"
                                    onclick="deleteComment({{ $comment->id }})">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Comment Content -->
                    <div class="comment-content mb-4">
                        <p class="text-neutral-800">{{ $comment->content }}</p>
                    </div>

                    <!-- Comment Stats -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="flex items-center gap-4 text-sm text-neutral-500">
                            <button class="like-comment-btn flex items-center gap-2 hover:text-red-500 transition-colors {{ $comment->isLikedBy(auth()->user()) ? 'text-red-500' : '' }} interactive-btn"
                                    data-comment-id="{{ $comment->id }}">
                                <i class="fas fa-heart {{ $comment->isLikedBy(auth()->user()) ? 'fas' : 'far' }}"></i>
                                <span class="like-count font-medium">{{ $comment->likes_count }}</span>
                            </button>
                            
                            <span class="flex items-center gap-2">
                                <i class="fas fa-reply"></i>
                                <span class="font-medium">{{ $comment->replies_count }} replies</span>
                            </span>
                        </div>

                        <!-- Post Preview -->
                        <a href="{{ route('posts.show', $comment->post) }}" 
                           class="post-preview hover:bg-primary-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-external-link-alt text-primary-500"></i>
                                <span class="font-bold text-neutral-700">View Post</span>
                            </div>
                            @if($comment->post->title)
                            <div class="text-xs text-neutral-500 mt-1 truncate max-w-xs">
                                "{{ Str::limit($comment->post->title, 60) }}"
                            </div>
                            @endif
                        </a>
                    </div>

                    <!-- Replies Section -->
                    @if($comment->replies_count > 0)
                    <div class="mt-4 pl-4 border-l-2 border-neutral-200">
                        <div class="space-y-3">
                            @foreach($comment->replies->take(2) as $reply)
                            <div class="flex items-start gap-3 py-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-300 to-secondary-300 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0 shadow-duo">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-sm text-neutral-800">{{ $reply->user->name }}</span>
                                        <span class="text-xs text-neutral-500">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-neutral-700">{{ $reply->content }}</p>
                                    <div class="flex items-center gap-3 mt-2">
                                        <button class="like-comment-btn flex items-center gap-1 text-xs text-neutral-500 hover:text-red-500 transition-colors interactive-btn"
                                                data-comment-id="{{ $reply->id }}">
                                            <i class="fas fa-heart {{ $reply->isLikedBy(auth()->user()) ? 'fas text-red-500' : 'far' }}"></i>
                                            <span class="like-count font-medium">{{ $reply->likes_count }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($comment->replies_count > 2)
                            <button class="text-sm text-primary-600 hover:text-primary-700 font-bold flex items-center gap-1 interactive-btn">
                                <i class="fas fa-chevron-down"></i>
                                Show {{ $comment->replies_count - 2 }} more replies
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                <div class="empty-state p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-neutral-200 to-neutral-300 rounded-full flex items-center justify-center mx-auto mb-6 shadow-duo">
                        <i class="fas fa-comments text-3xl text-neutral-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-600 mb-3">No comments yet</h3>
                    <p class="text-neutral-500 text-lg max-w-md mx-auto">
                        @if($isOwnProfile)
                            Start engaging with the community by commenting on posts!
                        @else
                            {{ $user->name }} hasn't commented on any posts yet.
                        @endif
                    </p>
                    @if($isOwnProfile)
                    <div class="mt-6">
                        <a href="{{ route('community.index') }}" class="btn-primary px-6 py-3 rounded-duo font-bold inline-flex items-center">
                            <i class="fas fa-comment mr-2"></i>Explore Posts to Comment
                        </a>
                    </div>
                    @endif
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($comments->hasPages())
            <div class="mt-8">
                {{ $comments->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- Comment Statistics -->
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-primary-500 mr-3"></i>
                    Comment Stats
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Total Comments</span>
                        <span class="text-2xl font-bold text-primary-600">{{ $comments->total() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Posts Commented On</span>
                        <span class="text-2xl font-bold text-primary-600">{{ $comments->unique('post_id')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Average Likes</span>
                        <span class="text-2xl font-bold text-primary-600">
                            {{ number_format($comments->avg('likes_count') ?? 0, 1) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Most Liked Comment</span>
                        <span class="text-2xl font-bold text-primary-600">
                            {{ $comments->max('likes_count') ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-clock text-primary-500 mr-3"></i>
                    Recent Activity
                </h3>
                <div class="space-y-3">
                    @foreach($comments->take(5) as $recentComment)
                    <div class="flex items-start gap-3 p-3 hover:bg-neutral-50 rounded-duo transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0 shadow-duo">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-neutral-700 line-clamp-2">
                                {{ Str::limit($recentComment->content, 80) }}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-neutral-500">{{ $recentComment->created_at->diffForHumans() }}</span>
                                <span class="text-xs text-neutral-400">•</span>
                                <span class="text-xs text-primary-600 font-bold">
                                    {{ $recentComment->post->community->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Communities -->
            <div class="card p-6 bg-gradient-to-br from-primary-50 to-secondary-50 border-2 border-primary-100">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-fire text-primary-500 mr-3"></i>
                    Top Communities
                </h3>
                <div class="space-y-3">
                    @php
                        $topCommunities = $comments->groupBy('post.community_id')
                            ->map(function($comments, $communityId) {
                                return [
                                    'community' => $comments->first()->post->community,
                                    'comment_count' => $comments->count()
                                ];
                            })
                            ->sortByDesc('comment_count')
                            ->take(3);
                    @endphp
                    
                    @foreach($topCommunities as $data)
                    <a href="{{ route('community.show', $data['community']->slug) }}" 
                       class="flex items-center gap-3 p-3 bg-white rounded-duo border-2 border-neutral-200 hover:border-primary-300 transition-all">
                        <div class="w-10 h-10 rounded-duo bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600 shadow-duo-pressed">
                            @if($data['community']->profile_image)
                                <img src="{{ asset('storage/' . $data['community']->profile_image) }}" 
                                     alt="{{ $data['community']->name }}" 
                                     class="w-full h-full rounded-duo object-cover">
                            @else
                                <i class="fas fa-users text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-neutral-800 text-sm truncate">
                                {{ $data['community']->name }}
                            </div>
                            <div class="text-xs text-neutral-500">
                                {{ $data['comment_count'] }} comments
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Like comment functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.like-comment-btn')) {
            const btn = e.target.closest('.like-comment-btn');
            const commentId = btn.dataset.commentId;
            const isLiked = btn.classList.contains('text-red-500');
            const url = isLiked ? `/community/comments/${commentId}/unlike` : `/community/comments/${commentId}/like`;
            
            // Add immediate visual feedback
            const likeIcon = btn.querySelector('i');
            likeIcon.classList.add('like-animation');

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
                    const likeCount = btn.querySelector('.like-count');
                    
                    if (data.action === 'added') {
                        btn.classList.add('text-red-500');
                        likeIcon.classList.replace('far', 'fas');
                    } else {
                        btn.classList.remove('text-red-500');
                        likeIcon.classList.replace('fas', 'far');
                    }
                    
                    likeCount.textContent = data.likes_count;
                    likeCount.classList.add('pulse-gentle');
                    setTimeout(() => likeCount.classList.remove('pulse-gentle'), 600);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
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

    // Delete comment functionality
    async function deleteComment(commentId) {
        if (confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
            try {
                const response = await fetch(`/community/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Comment deleted successfully!', 'success');
                    // Reload page to reflect changes
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error deleting comment', 'error');
            }
        }
    }

    // Sort functionality
    document.querySelector('select')?.addEventListener('change', function(e) {
        const sortBy = e.target.value;
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortBy);
        window.location.href = url.toString();
    });

    // Show more replies functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.show-more-replies')) {
            const btn = e.target.closest('.show-more-replies');
            const repliesSection = btn.closest('.mt-4');
            const hiddenReplies = repliesSection.querySelectorAll('.hidden-reply');
            
            hiddenReplies.forEach(reply => {
                reply.classList.remove('hidden');
            });
            
            btn.style.display = 'none';
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
        document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline, .card, .comment-card').forEach(element => {
            element.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary')) {
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
        });
    });
</script>
@endsection