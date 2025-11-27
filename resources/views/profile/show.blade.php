@extends('layouts.app')

@section('title', $user->name . ' - MindWell Profile')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .profile-stats {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .social-icon {
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Profile Header -->
    <div class="rounded-xl card-shadow mb-6 overflow-hidden profile-header">
        <!-- Cover Image -->
        <div class="h-64 relative">
            @if($user->cover_image)
            <img src="{{ asset('storage/' . $user->cover_image) }}" alt="Cover image" class="w-full h-full object-cover">
            @endif
            
            <!-- Profile Stats Overlay -->
            <div class="absolute bottom-4 left-4 right-4">
                <div class="profile-stats rounded-lg p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <!-- Profile Image -->
                            <div class="relative">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        {{ substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                                @if($user->is_online)
                                <div class="absolute bottom-2 right-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                @endif
                            </div>
                            
                            <!-- User Info -->
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-neutral-800">{{ $user->name }}</h1>
                                <p class="text-neutral-600">@{{ $user->username }}</p>
                                @if($user->bio)
                                <p class="text-neutral-600 mt-2">{{ $user->bio }}</p>
                                @endif
                                
                                <!-- Social Links -->
                                @if($user->website || $user->facebook_url || $user->twitter_url || $user->instagram_url)
                                <div class="flex items-center space-x-3 mt-3">
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
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            @if($isOwnProfile)
                            <a href="{{ route('profile.edit') }}" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                            @else
                            <button class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Follow
                            </button>
                            <button class="border border-neutral-300 text-neutral-700 px-4 py-2 rounded-lg hover:bg-neutral-50 transition-colors">
                                <i class="fas fa-envelope mr-2"></i>Message
                            </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-4 gap-4 mt-6 text-center">
                        <div>
                            <div class="text-2xl font-bold text-primary-600">{{ $stats['total_posts'] }}</div>
                            <div class="text-sm text-neutral-500">Posts</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-primary-600">{{ $stats['total_comments'] }}</div>
                            <div class="text-sm text-neutral-500">Comments</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-primary-600">{{ $stats['total_communities'] }}</div>
                            <div class="text-sm text-neutral-500">Communities</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-primary-600">{{ $stats['member_since'] }}</div>
                            <div class="text-sm text-neutral-500">Member Since</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Navigation Tabs -->
            <div class="bg-white rounded-xl card-shadow p-4 mb-6">
                <div class="flex space-x-8 border-b border-neutral-200">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="pb-4 px-2 border-b-2 border-primary-500 text-primary-600 font-medium">
                        Posts
                    </a>
                    <a href="{{ route('profile.comments', $user->username) }}" 
                       class="pb-4 px-2 text-neutral-500 hover:text-neutral-700 font-medium">
                        Comments
                    </a>
                    <a href="{{ route('profile.communities', $user->username) }}" 
                       class="pb-4 px-2 text-neutral-500 hover:text-neutral-700 font-medium">
                        Communities
                    </a>
                </div>
            </div>

            <!-- Posts Feed -->
            <div id="posts-feed">
                @forelse($posts as $post)
                    @include('community.partials.post-card', ['post' => $post])
                @empty
                    <div class="bg-white rounded-xl card-shadow p-8 text-center">
                        <i class="fas fa-file-alt text-4xl text-neutral-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-neutral-600 mb-2">No posts yet</h3>
                        <p class="text-neutral-500">
                            @if($isOwnProfile)
                                Start sharing your thoughts and experiences with the community!
                            @else
                                {{ $user->name }} hasn't posted anything yet.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Load More -->
            @if($posts->hasMorePages())
            <div class="text-center mt-6">
                <a href="{{ $posts->nextPageUrl() }}" class="bg-white border border-primary-200 text-primary-600 px-6 py-3 rounded-lg hover:bg-primary-50 transition-colors font-medium">
                    Load More Posts
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- About User -->
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">About</h3>
                <div class="space-y-3 text-sm text-neutral-600">
                    @if($user->location)
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt text-neutral-400"></i>
                        <span>{{ $user->location }}</span>
                    </div>
                    @endif
                    
                    @if($user->show_date_of_birth && $user->date_of_birth)
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-birthday-cake text-neutral-400"></i>
                        <span>{{ $user->date_of_birth->format('F j, Y') }} ({{ $user->age }} years old)</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-calendar text-neutral-400"></i>
                        <span>Joined {{ $user->created_at->format('F Y') }}</span>
                    </div>
                    
                    @if($user->show_email && $user->email)
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-neutral-400"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Communities -->
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">Recent Communities</h3>
                <div class="space-y-3">
                    @forelse($communities as $community)
                    <a href="{{ route('community.show', $community->slug) }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-neutral-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600">
                            @if($community->profile_image)
                                <img src="{{ asset('storage/' . $community->profile_image) }}" alt="{{ $community->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class="fas fa-users text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-neutral-800">{{ $community->name }}</div>
                            <div class="text-xs text-neutral-500">{{ $community->members_count }} members</div>
                        </div>
                    </a>
                    @empty
                    <p class="text-neutral-500 text-sm text-center py-4">No communities joined yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Badges/Achievements -->
            <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-xl card-shadow p-6 border border-primary-100">
                <h3 class="font-bold text-lg text-neutral-800 mb-3">Achievements</h3>
                <div class="grid grid-cols-3 gap-3">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-star text-yellow-500"></i>
                        </div>
                        <div class="text-xs text-neutral-600">Active Member</div>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-comments text-blue-500"></i>
                        </div>
                        <div class="text-xs text-neutral-600">Contributor</div>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-heart text-green-500"></i>
                        </div>
                        <div class="text-xs text-neutral-600">Supporter</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal functionality untuk community show
    function openCreatePostModal(communityId) {
        const modal = document.getElementById('createPostModal');
        // Untuk community show, community_id sudah di-set via hidden input
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

    // Mood selection
    document.querySelectorAll('.mood-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.mood-option').forEach(opt => {
                opt.classList.remove('selected', 'border-primary-500', 'bg-primary-50');
            });
            this.classList.add('selected', 'border-primary-500', 'bg-primary-50');
            this.querySelector('input').checked = true;
        });
    });

    // Image preview
    document.getElementById('image-upload')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Create post form submission untuk community show
    document.getElementById('createPostForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        
        // Debug: lihat data form
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Disable button dan show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
        
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
                showNotification(data.message, 'success');
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
            submitBtn.innerHTML = 'Create Post';
        });
    });

    // Like/Unlike functionality for posts
    document.addEventListener('click', function(e) {
        if (e.target.closest('.like-btn')) {
            const btn = e.target.closest('.like-btn');
            const postId = btn.dataset.postId;
            const isLiked = btn.classList.contains('liked');
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
                        btn.classList.add('liked', 'text-primary-600');
                        likeIcon.classList.replace('far', 'fas');
                        likeIcon.classList.add('like-animation');
                    } else {
                        btn.classList.remove('liked', 'text-primary-600');
                        likeIcon.classList.replace('fas', 'far');
                    }
                    
                    likeCount.textContent = data.likes_count;
                    
                    // Remove animation class after animation completes
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

    // Save/Unsave functionality for posts
    document.addEventListener('click', function(e) {
        if (e.target.closest('.save-btn')) {
            const btn = e.target.closest('.save-btn');
            const postId = btn.dataset.postId;
            const isSaved = btn.classList.contains('saved');
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
                        btn.classList.add('saved', 'text-secondary-600');
                        saveIcon.classList.replace('far', 'fas');
                    } else {
                        btn.classList.remove('saved', 'text-secondary-600');
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

    // Toggle comments section
    function toggleComments(postId) {
        const commentsSection = document.querySelector(`#post-${postId} .comments-section`);
        const commentBtn = document.querySelector(`#post-${postId} .comment-btn`);
        
        if (commentsSection) {
            // Toggle visibility
            commentsSection.classList.toggle('hidden');
            
            // Update button text and icon
            const commentIcon = commentBtn.querySelector('i');
            const commentText = commentBtn.querySelector('span:last-child');
            
            if (commentsSection.classList.contains('hidden')) {
                commentIcon.classList.replace('fas', 'far');
                commentText.textContent = 'Comment';
                commentBtn.classList.remove('text-primary-600', 'bg-primary-50');
            } else {
                commentIcon.classList.replace('far', 'fas');
                commentText.textContent = 'Comments';
                commentBtn.classList.add('text-primary-600', 'bg-primary-50');
                
                // Auto-focus comment textarea when opening
                const textarea = commentsSection.querySelector('textarea');
                if (textarea) {
                    setTimeout(() => {
                        textarea.focus();
                    }, 100);
                }
            }
        }
    }

    // Comment button functionality
    document.addEventListener('click', function(e) {
        // Handle comment button click
        if (e.target.closest('.comment-btn')) {
            const btn = e.target.closest('.comment-btn');
            let postId = btn.dataset.postId;
            
            if (!postId) {
                // Fallback: try to get post ID from parent element
                const postCard = btn.closest('.post-card');
                if (postCard) {
                    postId = postCard.id.replace('post-', '');
                }
            }
            
            if (postId) {
                toggleComments(postId);
            } else {
                console.error('Could not find post ID for comment button');
            }
        }
        
        // Handle cancel comment button
        if (e.target.closest('.cancel-comment-btn')) {
            const btn = e.target.closest('.cancel-comment-btn');
            const form = btn.closest('.comment-form');
            if (form) {
                form.reset();
            }
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
                    
                    // Update comments count
                    const postCard = document.querySelector(`#post-${postId}`);
                    const commentsCount = postCard.querySelector('.comments-count');
                    const commentsCountDisplay = postCard.querySelector('.comments-count-display');
                    
                    if (commentsCount) {
                        commentsCount.textContent = data.comments_count;
                    }
                    if (commentsCountDisplay) {
                        commentsCountDisplay.textContent = data.comments_count + ' comments';
                    }
                    
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

    // Community join/leave functionality
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

    // Like comment functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.like-comment-btn')) {
            const btn = e.target.closest('.like-comment-btn');
            const commentId = btn.dataset.commentId;
            const isLiked = btn.classList.contains('text-primary-600');
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
                        btn.classList.add('text-primary-600');
                        likeIcon.classList.replace('far', 'fas');
                        likeIcon.classList.add('like-animation');
                    } else {
                        btn.classList.remove('text-primary-600');
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

    // Reply functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.reply-btn')) {
            const btn = e.target.closest('.reply-btn');
            const commentId = btn.dataset.commentId;
            const replyForm = btn.closest('.comment-item').querySelector('.reply-form');
            
            // Hide all other reply forms
            document.querySelectorAll('.reply-form').forEach(form => {
                if (form !== replyForm) form.classList.add('hidden');
            });
            
            replyForm.classList.toggle('hidden');
            
            // Focus on textarea when opening
            if (!replyForm.classList.contains('hidden')) {
                const textarea = replyForm.querySelector('textarea');
                setTimeout(() => textarea.focus(), 100);
            }
        }
    });

    // Cancel reply
    document.addEventListener('click', function(e) {
        if (e.target.closest('.cancel-reply-btn')) {
            const btn = e.target.closest('.cancel-reply-btn');
            const replyForm = btn.closest('.reply-form');
            replyForm.classList.add('hidden');
            replyForm.querySelector('textarea').value = '';
        }
    });

    // Submit reply
    document.addEventListener('submit', function(e) {
        if (e.target.closest('.reply-form form')) {
            e.preventDefault();
            const form = e.target.closest('.reply-form form');
            const parentId = form.dataset.parentId;
            const formData = new FormData(form);
            formData.append('parent_id', parentId);
            
            // Get post_id from the closest post card
            const postCard = form.closest('.post-card');
            const postId = postCard ? postCard.id.replace('post-', '') : null;
            
            if (!postId) {
                showNotification('Error: Could not find post', 'error');
                return;
            }
            
            formData.append('post_id', postId);
            
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
                    showNotification('Reply posted successfully!', 'success');
                    
                    // Hide reply form
                    form.closest('.reply-form').classList.add('hidden');
                    
                    // Reload to show new reply
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error posting reply', 'error');
            });
        }
    });

    // Comment menu functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.comment-menu-btn')) {
            const btn = e.target.closest('.comment-menu-btn');
            const menu = btn.nextElementSibling;
            
            // Hide all other menus
            document.querySelectorAll('.comment-menu').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            
            menu.classList.toggle('hidden');
        }
    });

    // Delete comment
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-comment-btn')) {
            const btn = e.target.closest('.delete-comment-btn');
            const commentId = btn.dataset.commentId;
            
            if (confirm('Are you sure you want to delete this comment?')) {
                fetch(`/community/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        
                        // Remove comment from DOM
                        const commentElement = document.getElementById(`comment-${commentId}`);
                        if (commentElement) {
                            commentElement.remove();
                        }
                        
                        // Update comments count in post
                        const postCard = document.querySelector('.post-card');
                        const commentsCount = postCard.querySelector('.comments-count');
                        const commentsCountDisplay = postCard.querySelector('.comments-count-display');
                        
                        if (commentsCount) {
                            commentsCount.textContent = data.comments_count;
                        }
                        if (commentsCountDisplay) {
                            commentsCountDisplay.textContent = data.comments_count + ' comments';
                        }
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error deleting comment', 'error');
                });
            }
        }
    });

    // Close comment menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.comment-menu') && !e.target.closest('.comment-menu-btn')) {
            document.querySelectorAll('.comment-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    function showNotification(message, type = 'info') {
        // Notification implementation
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
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
</script>
@endsection