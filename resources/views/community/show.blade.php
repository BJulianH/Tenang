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
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Community Header -->
    <div class="rounded-xl card-shadow mb-6 overflow-hidden community-header">
        <!-- Cover Area -->
        <div class="h-64 relative">
            @if($community->banner_image)
            <img src="{{ asset('storage/' . $community->banner_image) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
            @endif
            
            <!-- Community Stats Overlay -->
            <div class="absolute bottom-4 left-4 right-4">
                <div class="community-stats rounded-lg p-4 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Community Image -->
                            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg">
                                @if($community->profile_image)
                                    <img src="{{ asset('storage/' . $community->profile_image) }}" alt="{{ $community->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fas fa-users"></i>
                                @endif
                            </div>
                            
                            <!-- Community Info -->
                            <div>
                                <h1 class="text-2xl font-bold text-neutral-800">{{ $community->name }}</h1>
                                <p class="text-neutral-600">{{ $community->description }}</p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-neutral-500">
                                    <span class="flex items-center space-x-1">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $community->members_count }} members</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <i class="fas fa-file-alt"></i>
                                        <span>{{ $community->posts_count }} posts</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <i class="fas fa-globe"></i>
                                        <span class="capitalize">{{ $community->type }} community</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            @if($isMember)
                                @if($isAdmin)
                                <span class="bg-primary-500 text-white px-4 py-2 rounded-lg font-medium">
                                    <i class="fas fa-crown mr-2"></i>Admin
                                </span>
                                @else
                                <span class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium">
                                    <i class="fas fa-check mr-2"></i>Member
                                </span>
                                @endif
                                <button class="leave-community-btn border border-red-300 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 transition-colors"
                                        data-community-id="{{ $community->id }}"
                                        data-leave-url="{{ route('communities.leave', $community) }}">
                                    Leave
                                </button>
                            @else
                                <button class="join-community-btn bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors join-btn"
                                        data-community-id="{{ $community->id }}"
                                        data-join-url="{{ route('communities.join', $community) }}">
                                    Join Community
                                </button>
                            @endif
                            
                            @if($isAdmin)
                            <a href="{{ route('community.manage', $community->slug) }}" class="border border-neutral-300 text-neutral-700 px-4 py-2 rounded-lg hover:bg-neutral-50 transition-colors">
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
            <div class="bg-white rounded-xl card-shadow p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <button onclick="openCreatePostModal('{{ $community->id }}')" class="flex-1 text-left p-3 bg-neutral-50 rounded-lg border border-neutral-200 hover:border-primary-300 transition-colors text-neutral-500 hover:text-neutral-700">
                        Share something in {{ $community->name }}...
                    </button>
                </div>
            </div>
            @endif

            <!-- Posts Feed -->
            <div id="posts-feed">
                @forelse($posts as $post)
                    @include('community.partials.post-card', ['post' => $post])
                @empty
                    <div class="bg-white rounded-xl card-shadow p-8 text-center">
                        <i class="fas fa-comments text-4xl text-neutral-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-neutral-600 mb-2">No posts yet</h3>
                        <p class="text-neutral-500 mb-4">
                            @if($isMember)
                                Be the first to start a discussion in this community!
                            @else
                                Join this community to start posting and see existing discussions.
                            @endif
                        </p>
                        @if($isMember)
                        <button onclick="openCreatePostModal('{{ $community->id }}')" class="bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                            Create First Post
                        </button>
                        @else
                        <button class="join-community-btn bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors"
                                data-community-id="{{ $community->id }}"
                                data-join-url="{{ route('communities.join', $community) }}">
                            Join to Participate
                        </button>
                        @endif
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
            <!-- About Community -->
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">About This Community</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-neutral-700 mb-2">Description</h4>
                        <p class="text-neutral-600 text-sm">{{ $community->description }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-neutral-700 mb-2">Community Type</h4>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 rounded-full text-xs 
                                @if($community->type === 'public') bg-green-100 text-green-800
                                @elseif($community->type === 'private') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                <i class="fas 
                                    @if($community->type === 'public') fa-globe
                                    @elseif($community->type === 'private') fa-lock
                                    @else fa-shield-alt @endif mr-1"></i>
                                {{ ucfirst($community->type) }}
                            </span>
                            <span class="text-xs text-neutral-500">
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
                        <p class="text-neutral-600 text-sm">{{ $community->created_at->format('F j, Y') }} by 
                            <a href="{{ route('profile.community', $community->creator->username) }}" class="text-primary-600 hover:text-primary-700">
                                {{ $community->creator->name }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Members -->
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">Recent Members</h3>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($recentMembers as $member)
                    <a href="{{ route('profile.community', $member->username) }}" class="text-center group">
                        <div class="member-avatar w-12 h-12 rounded-full bg-gradient-to-r from-primary-300 to-secondary-300 flex items-center justify-center text-white font-bold mx-auto group-hover:shadow-lg transition-all">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                        <p class="text-xs text-neutral-600 mt-1 truncate group-hover:text-primary-600">
                            {{ $member->name }}
                        </p>
                    </a>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="#" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        View All {{ $community->members_count }} Members
                    </a>
                </div>
            </div>

            <!-- Related Communities -->
            @if($relatedCommunities->count() > 0)
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="font-bold text-lg text-neutral-800 mb-4">Related Communities</h3>
                <div class="space-y-3">
                    @foreach($relatedCommunities as $relatedCommunity)
                    <a href="{{ route('community.show', $relatedCommunity->slug) }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-neutral-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600">
                            <i class="fas fa-users text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-neutral-800">{{ $relatedCommunity->name }}</div>
                            <div class="text-xs text-neutral-500">{{ $relatedCommunity->members_count }} members</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Community Guidelines -->
            <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-xl card-shadow p-6 border border-primary-100">
                <h3 class="font-bold text-lg text-neutral-800 mb-3">Community Guidelines</h3>
                <ul class="text-sm text-neutral-600 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2 text-xs"></i>
                        <span>Be respectful to all members</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2 text-xs"></i>
                        <span>Keep discussions relevant</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2 text-xs"></i>
                        <span>No spam or self-promotion</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2 text-xs"></i>
                        <span>Follow community-specific rules</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="createPostModal" class="fixed inset-0 z-50 overflow-y-auto modal-overlay hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="modal-content inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Di create post modal - PASTIKAN struktur ini -->
            <form id="createPostForm" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Create New Post
                            </h3>

                           
                            <input type="hidden" name="community_id" value="{{ $community->id }}"></input>

                            <!-- Title -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Title *</label>
                                <input type="text" name="title" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="What's on your mind?" required>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Content *</label>
                                <textarea name="content" rows="4" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none" placeholder="Share your thoughts, experiences, or ask for support..." required></textarea>
                            </div>

                            <!-- Mood Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">How are you feeling?</label>
                                <div class="grid grid-cols-6 gap-2">
                                    @foreach(['happy' => '😊', 'calm' => '😌', 'anxious' => '😰', 'sad' => '😢', 'angry' => '😠', 'neutral' => '😐'] as $mood => $emoji)
                                    <label class="mood-option border-2 border-neutral-200 rounded-lg p-2 text-center cursor-pointer">
                                        <input type="radio" name="mood" value="{{ $mood }}" class="hidden" {{ $mood == 'neutral' ? 'checked' : '' }}>
                                        <div class="text-lg">{{ $emoji }}</div>
                                        <div class="text-xs text-neutral-600 capitalize mt-1">{{ $mood }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Add Image (Optional)</label>
                                <div class="border-2 border-dashed border-neutral-300 rounded-lg p-4 text-center">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-neutral-400 mb-2"></i>
                                    <p class="text-neutral-500 text-sm mb-2">Click to upload an image</p>
                                    <input type="file" name="image" id="image-upload" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('image-upload').click()" class="bg-primary-500 text-white px-3 py-1 rounded-lg hover:bg-primary-600 transition-colors text-sm">
                                        Choose Image
                                    </button>
                                    <div id="image-preview" class="mt-3 hidden">
                                        <img id="preview-img" class="max-h-48 mx-auto rounded-lg">
                                    </div>
                                </div>
                            </div>

                            <!-- Privacy Options -->
                            <div class="flex items-center space-x-4 text-sm">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="is_anonymous" value="1" class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                                    <span>Post anonymously</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="is_support_request" value="1" class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                                    <span>This is a support request</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-500 text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Create Post
                    </button>
                    <button type="button" onclick="closeCreatePostModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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