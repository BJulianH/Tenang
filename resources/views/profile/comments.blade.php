@extends('layouts.app')

@section('title', $user->name . ' - Comments - MindWell Profile')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
    }
    
    .profile-stats {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .profile-avatar {
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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
        border-bottom: 2px solid transparent;
    }
    
    .nav-tab:hover {
        color: #4f46e5;
    }
    
    .nav-tab.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }
    
    .comment-card {
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
        background: white;
    }
    
    .comment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #e2e8f0;
    }
    
    .post-preview {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-left: 4px solid #4f46e5;
    }
    
    .empty-state {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 2px dashed #e2e8f0;
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
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Profile Header -->
    <div class="rounded-2xl overflow-hidden profile-header mb-8">
        <!-- Cover Image -->
        <div class="h-64 relative">
            @if($user->cover_image)
            <img src="{{ asset('storage/' . $user->cover_image) }}" alt="Cover image" class="w-full h-full object-cover">
            @endif
            
            <!-- Profile Stats Overlay -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="profile-stats rounded-2xl p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-6 flex-1">
                            <!-- Profile Image -->
                            <div class="relative">
                                <div class="w-20 h-20 rounded-full profile-avatar bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        {{ substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                                @if($user->is_online)
                                <div class="absolute bottom-2 right-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white online-indicator"></div>
                                @endif
                            </div>
                            
                            <!-- User Info -->
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-600">@{{ $user->username }}</p>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                    <span>{{ $comments->total() }} comments</span>
                                    <span>•</span>
                                    <span>Joined {{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            @if($isOwnProfile)
                            <a href="{{ route('profile.edit') }}" class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition-all font-semibold">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                            @else
                            <button class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition-all font-semibold">
                                <i class="fas fa-user-plus mr-2"></i>Follow
                            </button>
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 transition-all font-semibold">
                                <i class="fas fa-envelope mr-2"></i>Message
                            </button>
                            @endif
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8">
                <div class="flex space-x-1">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="nav-tab flex-1 text-center py-4 px-2 font-semibold text-gray-700">
                        <i class="fas fa-file-alt mr-2"></i>Posts
                    </a>
                    <a href="{{ route('profile.comments', $user->username) }}" 
                       class="nav-tab flex-1 text-center py-4 px-2 font-semibold text-indigo-600 active">
                        <i class="fas fa-comments mr-2"></i>Comments
                    </a>
                    <a href="{{ route('profile.communities', $user->username) }}" 
                       class="nav-tab flex-1 text-center py-4 px-2 font-semibold text-gray-700">
                        <i class="fas fa-users mr-2"></i>Communities
                    </a>
                </div>
            </div>

            <!-- Comments Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">All Comments</h2>
                        <p class="text-gray-600 mt-1">
                            {{ $comments->total() }} comments across {{ $comments->unique('post_id')->count() }} posts
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Sorted by:</span>
                        <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                <div class="comment-card rounded-2xl p-6">
                    <!-- Comment Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                                        <span class="time-ago">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-sm text-gray-500">in</span>
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
                            <button class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50"
                                    onclick="deleteComment({{ $comment->id }})">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Comment Content -->
                    <div class="comment-content mb-4">
                        <p class="text-gray-800">{{ $comment->content }}</p>
                    </div>

                    <!-- Comment Stats -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <button class="like-comment-btn flex items-center gap-2 hover:text-red-500 transition-colors {{ $comment->isLikedBy(auth()->user()) ? 'text-red-500' : '' }}"
                                    data-comment-id="{{ $comment->id }}">
                                <i class="fas fa-heart {{ $comment->isLikedBy(auth()->user()) ? 'fas' : 'far' }}"></i>
                                <span class="like-count">{{ $comment->likes_count }}</span>
                            </button>
                            
                            <span class="flex items-center gap-2">
                                <i class="fas fa-reply"></i>
                                <span>{{ $comment->replies_count }} replies</span>
                            </span>
                        </div>

                        <!-- Post Preview -->
                        <a href="{{ route('posts.show', $comment->post) }}" 
                           class="post-preview px-4 py-2 rounded-lg text-sm hover:bg-indigo-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-external-link-alt text-indigo-500"></i>
                                <span class="font-medium text-gray-700">View Post</span>
                            </div>
                            @if($comment->post->title)
                            <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">
                                "{{ Str::limit($comment->post->title, 60) }}"
                            </div>
                            @endif
                        </a>
                    </div>

                    <!-- Replies Section -->
                    @if($comment->replies_count > 0)
                    <div class="mt-4 pl-4 border-l-2 border-gray-200">
                        <div class="space-y-3">
                            @foreach($comment->replies->take(2) as $reply)
                            <div class="flex items-start gap-3 py-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-gray-400 to-gray-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-sm text-gray-900">{{ $reply->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $reply->content }}</p>
                                    <div class="flex items-center gap-3 mt-2">
                                        <button class="like-comment-btn flex items-center gap-1 text-xs text-gray-500 hover:text-red-500 transition-colors"
                                                data-comment-id="{{ $reply->id }}">
                                            <i class="fas fa-heart {{ $reply->isLikedBy(auth()->user()) ? 'fas text-red-500' : 'far' }}"></i>
                                            <span class="like-count">{{ $reply->likes_count }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($comment->replies_count > 2)
                            <button class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                                <i class="fas fa-chevron-down"></i>
                                Show {{ $comment->replies_count - 2 }} more replies
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                <div class="empty-state rounded-2xl p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-3">No comments yet</h3>
                    <p class="text-gray-500 text-lg max-w-md mx-auto">
                        @if($isOwnProfile)
                            Start engaging with the community by commenting on posts!
                        @else
                            {{ $user->name }} hasn't commented on any posts yet.
                        @endif
                    </p>
                    @if($isOwnProfile)
                    <div class="mt-6">
                        <a href="{{ route('community.index') }}" class="inline-flex items-center bg-indigo-500 text-white px-6 py-3 rounded-xl hover:bg-indigo-600 transition-all font-semibold">
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-indigo-500 mr-3"></i>
                    Comment Stats
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Total Comments</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ $comments->total() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Posts Commented On</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ $comments->unique('post_id')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Average Likes</span>
                        <span class="text-2xl font-bold text-indigo-600">
                            {{ number_format($comments->avg('likes_count') ?? 0, 1) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Most Liked Comment</span>
                        <span class="text-2xl font-bold text-indigo-600">
                            {{ $comments->max('likes_count') ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock text-indigo-500 mr-3"></i>
                    Recent Activity
                </h3>
                <div class="space-y-3">
                    @foreach($comments->take(5) as $recentComment)
                    <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700 line-clamp-2">
                                {{ Str::limit($recentComment->content, 80) }}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-gray-500">{{ $recentComment->created_at->diffForHumans() }}</span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-indigo-600 font-medium">
                                    {{ $recentComment->post->community->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Communities -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm border border-indigo-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-fire text-indigo-500 mr-3"></i>
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
                       class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600">
                            @if($data['community']->profile_image)
                                <img src="{{ asset('storage/' . $data['community']->profile_image) }}" 
                                     alt="{{ $data['community']->name }}" 
                                     class="w-full h-full rounded-xl object-cover">
                            @else
                                <i class="fas fa-users text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-900 text-sm truncate">
                                {{ $data['community']->name }}
                            </div>
                            <div class="text-xs text-gray-500">
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
                    const likeIcon = btn.querySelector('i');
                    const likeCount = btn.querySelector('.like-count');
                    
                    if (data.action === 'added') {
                        btn.classList.add('text-red-500');
                        likeIcon.classList.replace('far', 'fas');
                        likeIcon.classList.add('like-animation');
                    } else {
                        btn.classList.remove('text-red-500');
                        likeIcon.classList.replace('fas', 'far');
                    }
                    
                    likeCount.textContent = data.likes_count;
                    
                    // Remove animation
                    setTimeout(() => {
                        likeIcon.classList.remove('like-animation');
                    }, 600);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error processing like', 'error');
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
    document.querySelector('select').addEventListener('change', function(e) {
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

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl shadow-lg text-white max-w-sm transform translate-x-full transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 shadow-green-200' :
            type === 'error' ? 'bg-red-500 shadow-red-200' :
            'bg-blue-500 shadow-blue-200'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} text-lg"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-0');
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
    });
</script>
@endsection