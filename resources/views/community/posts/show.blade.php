@extends('layouts.app')

@section('title', $post->title . ' - ' . $post->community->name . ' - MindWell')

@section('styles')
<style>
    .post-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .post-content {
        line-height: 1.7;
        font-size: 1.125rem;
    }
    
    .comment-card {
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    
    .comment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .reply-form {
        transition: all 0.3s ease;
        max-height: 0;
        overflow: hidden;
    }
    
    .reply-form.open {
        max-height: 500px;
    }
    
    .like-animation {
        animation: like-pulse 0.6s ease;
    }
    
    @keyframes like-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .mood-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .mood-happy { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .mood-calm { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
    .mood-anxious { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .mood-sad { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
    .mood-angry { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .mood-neutral { background: linear-gradient(135deg, #6b7280, #4b5563); color: white; }
    
    .support-badge {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
    }
    
    .anonymous-badge {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('community.index') }}" class="hover:text-indigo-600">Community</a>
        <span>/</span>
        <a href="{{ route('community.show', $post->community->slug) }}" class="hover:text-indigo-600">{{ $post->community->name }}</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Post</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Post Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Post Header -->
                <div class="border-b border-gray-100 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @if($post->is_anonymous)
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                <i class="fas fa-user-secret text-gray-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900">Anonymous</span>
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <a href="{{ route('community.show', $post->community->slug) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                        {{ $post->community->name }}
                                    </a>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('profile.community', $post->user->username) }}" class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900">{{ $post->user->name }}</span>
                                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        <span>•</span>
                                        <a href="{{ route('community.show', $post->community->slug) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                            {{ $post->community->name }}
                                        </a>
                                    </div>
                                </div>
                            </a>
                            @endif
                        </div>
                        
                        <!-- Post Actions Menu -->
                        @if(Auth::check() && (Auth::id() === $post->user_id || Auth::user()->isAdmin()))
                        <div class="relative">
                            <button class="post-menu-btn p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-ellipsis-h text-gray-400"></i>
                            </button>
                            <div class="post-menu absolute right-0 top-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-10 hidden min-w-32">
                                @if(Auth::id() === $post->user_id)
                                <button class="w-full text-left px-4 py-2 hover:bg-gray-50 text-gray-700 flex items-center space-x-2 text-sm">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit Post</span>
                                </button>
                                @endif
                                <button class="w-full text-left px-4 py-2 hover:bg-gray-50 text-red-600 flex items-center space-x-2 text-sm delete-post-btn" data-post-id="{{ $post->id }}">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete Post</span>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Post Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                    <!-- Post Badges -->
                    <div class="flex items-center space-x-2">
                        <span class="mood-badge mood-{{ $post->mood }} capitalize">
                            <i class="fas 
                                @if($post->mood === 'happy') fa-smile
                                @elseif($post->mood === 'calm') fa-peace
                                @elseif($post->mood === 'anxious') fa-flushed
                                @elseif($post->mood === 'sad') fa-sad-tear
                                @elseif($post->mood === 'angry') fa-angry
                                @else fa-meh @endif mr-1">
                            </i>
                            {{ $post->mood }}
                        </span>
                        
                        @if($post->is_support_request)
                        <span class="support-badge px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-hands-helping mr-1"></i>Support Request
                        </span>
                        @endif
                        
                        @if($post->is_anonymous)
                        <span class="anonymous-badge px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-user-secret mr-1"></i>Anonymous
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Post Content -->
                <div class="p-6">
                    @if($post->image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="Post image" 
                             class="rounded-2xl max-w-full h-auto max-h-96 object-cover mx-auto shadow-sm">
                    </div>
                    @endif

                    <div class="post-content text-gray-800 whitespace-pre-line">
                        {{ $post->content }}
                    </div>
                </div>

                <!-- Post Stats & Actions -->
                <div class="border-t border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-eye"></i>
                                <span>{{ $post->views_count }} views</span>
                            </span>
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-comment"></i>
                                <span>{{ $post->comments_count }} comments</span>
                            </span>
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-clock"></i>
                                <span>{{ $post->created_at->format('M j, Y g:i A') }}</span>
                            </span>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Like Button -->
                            <button class="like-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors {{ $post->isLikedBy(Auth::user()) ? 'text-red-600' : 'text-gray-600' }}" 
                                    data-post-id="{{ $post->id }}">
                                <i class="{{ $post->isLikedBy(Auth::user()) ? 'fas' : 'far' }} fa-heart"></i>
                                <span class="like-count font-medium">{{ $post->upvotes_count }}</span>
                            </button>

                            <!-- Save Button -->
                            <button class="save-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors {{ $post->isSavedBy(Auth::user()) ? 'text-indigo-600' : 'text-gray-600' }}" 
                                    data-post-id="{{ $post->id }}">
                                <i class="{{ $post->isSavedBy(Auth::user()) ? 'fas' : 'far' }} fa-bookmark"></i>
                                <span class="font-medium">Save</span>
                            </button>

                            <!-- Share Button -->
                            <button class="share-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors text-gray-600">
                                <i class="fas fa-share"></i>
                                <span class="font-medium">Share</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Comments ({{ $post->comments_count }})</h2>

                    <!-- Comment Form -->
                    @if($isMember)
                    <form class="comment-form mb-8" data-post-id="{{ $post->id }}">
                        @csrf
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="content" rows="3" 
                                          class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none" 
                                          placeholder="Share your thoughts..." 
                                          required></textarea>
                                <div class="flex justify-end space-x-3 mt-3">
                                    <button type="button" class="cancel-comment-btn px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors font-medium">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded-xl hover:bg-indigo-600 transition-colors font-medium">
                                        Comment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="bg-gray-50 rounded-xl p-6 text-center mb-6">
                        <i class="fas fa-comments text-3xl text-gray-400 mb-3"></i>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Join the Conversation</h3>
                        <p class="text-gray-600 mb-4">Become a member of this community to comment on posts.</p>
                        <button class="join-community-btn bg-indigo-500 text-white px-6 py-2 rounded-xl hover:bg-indigo-600 transition-colors font-medium"
                                data-community-id="{{ $post->community->id }}"
                                data-join-url="{{ route('communities.join', $post->community) }}">
                            Join {{ $post->community->name }}
                        </button>
                    </div>
                    @endif

                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse($post->comments as $comment)
                            @include('community.partials.comment', ['comment' => $comment, 'depth' => 0])
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">No comments yet</h3>
                                <p class="text-gray-500">Be the first to share your thoughts!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- Community Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4">About Community</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600">
                            @if($post->community->profile_image)
                                <img src="{{ asset('storage/' . $post->community->profile_image) }}" 
                                     alt="{{ $post->community->name }}" 
                                     class="w-full h-full rounded-xl object-cover">
                            @else
                                <i class="fas fa-users"></i>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $post->community->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $post->community->members_count }} members</p>
                        </div>
                    </div>
                    
                    @if($post->community->description)
                    <p class="text-gray-600 text-sm">{{ Str::limit($post->community->description, 120) }}</p>
                    @endif
                    
                    <div class="flex space-x-3">
                        @if($isMember)
                        <button class="leave-community-btn flex-1 border border-red-300 text-red-600 px-4 py-2 rounded-xl hover:bg-red-50 transition-colors text-sm font-medium"
                                data-community-id="{{ $post->community->id }}"
                                data-leave-url="{{ route('communities.leave', $post->community) }}">
                            Leave
                        </button>
                        @else
                        <button class="join-community-btn flex-1 bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition-colors text-sm font-medium"
                                data-community-id="{{ $post->community->id }}"
                                data-join-url="{{ route('communities.join', $post->community) }}">
                            Join
                        </button>
                        @endif
                        <a href="{{ route('community.show', $post->community->slug) }}" 
                           class="flex-1 border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors text-sm font-medium text-center">
                            Visit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4">Related Posts</h3>
                <div class="space-y-4">
                    @foreach($relatedPosts as $relatedPost)
                    <a href="{{ route('posts.show', $relatedPost) }}" 
                       class="block p-4 rounded-xl border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
                        <h4 class="font-semibold text-gray-900 text-sm mb-2 line-clamp-2">
                            {{ $relatedPost->title }}
                        </h4>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $relatedPost->created_at->diffForHumans() }}</span>
                            <span class="flex items-center space-x-1">
                                <i class="fas fa-heart"></i>
                                <span>{{ $relatedPost->upvotes_count }}</span>
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Post Stats -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm border border-indigo-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4">Post Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-700 font-medium">Views</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $post->views_count }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-700 font-medium">Likes</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $post->upvotes_count }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-700 font-medium">Comments</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $post->comments_count }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-700 font-medium">Posted</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Like functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.like-btn')) {
            const btn = e.target.closest('.like-btn');
            const postId = btn.dataset.postId;
            const isLiked = btn.classList.contains('text-red-600');
            const url = isLiked ? `/community/posts/${postId}/unlike` : `/community/posts/${postId}/like`;
            
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
                        btn.classList.add('text-red-600');
                        likeIcon.classList.replace('far', 'fas');
                        likeIcon.classList.add('like-animation');
                    } else {
                        btn.classList.remove('text-red-600');
                        likeIcon.classList.replace('fas', 'far');
                    }
                    
                    likeCount.textContent = data.likes_count;
                    
                    setTimeout(() => {
                        likeIcon.classList.remove('like-animation');
                    }, 600);
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

    // Save functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.save-btn')) {
            const btn = e.target.closest('.save-btn');
            const postId = btn.dataset.postId;
            const isSaved = btn.classList.contains('text-indigo-600');
            const url = isSaved ? `/community/posts/${postId}/unsave` : `/community/posts/${postId}/save`;
            
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
                    const saveIcon = btn.querySelector('i');
                    
                    if (data.action === 'saved') {
                        btn.classList.add('text-indigo-600');
                        saveIcon.classList.replace('far', 'fas');
                    } else {
                        btn.classList.remove('text-indigo-600');
                        saveIcon.classList.replace('fas', 'far');
                    }
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error processing save', 'error');
            });
        }
    });

    // Comment functionality
    document.addEventListener('submit', function(e) {
        if (e.target.closest('.comment-form')) {
            e.preventDefault();
            const form = e.target.closest('.comment-form');
            const postId = form.dataset.postId;
            const formData = new FormData(form);
            
            fetch('/community/comments', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.reset();
                    showNotification('Comment posted successfully!', 'success');
                    // Reload to show new comment
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Error posting comment: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error posting comment: ' + error.message, 'error');
            });
        }
    });

    // Join/Leave community functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.join-community-btn') || e.target.closest('.leave-community-btn')) {
            const btn = e.target.closest('.join-community-btn') || e.target.closest('.leave-community-btn');
            const isJoin = btn.classList.contains('join-community-btn');
            const url = isJoin ? btn.dataset.joinUrl : btn.dataset.leaveUrl;
            
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
                    showNotification(data.message, 'success');
                    // Reload page to update UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error processing request', 'error');
            });
        }
    });

    // Post menu functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.post-menu-btn')) {
            const btn = e.target.closest('.post-menu-btn');
            const menu = btn.nextElementSibling;
            menu.classList.toggle('hidden');
        }
    });

    // Close menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.post-menu') && !e.target.closest('.post-menu-btn')) {
            document.querySelectorAll('.post-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

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
</script>
@endsection