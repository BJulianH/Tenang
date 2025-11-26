{{-- resources/views/community/partials/post-card.blade.php --}}
<div class="bg-white rounded-xl card-shadow mb-6 post-card mood-{{ $post->mood ?? 'neutral' }}" id="post-{{ $post->id }}">
    <!-- Post Header -->
    <div class="p-6 pb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                @if($post->is_anonymous)
                <div class="w-10 h-10 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-500">
                    <i class="fas fa-user-secret"></i>
                </div>
                <div>
                    <span class="font-medium text-neutral-700">Anonymous</span>
                    <p class="text-xs text-neutral-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
                @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <div>
                    <a href="{{ route('profile.community', $post->user->username) }}" class="font-medium text-neutral-700 hover:text-primary-600">
                        {{ $post->user->name }}
                    </a>
                    <p class="text-xs text-neutral-500">
                        {{ $post->created_at->diffForHumans() }} 
                        @if($post->community && !$post->community->is_main)
                        • in <a href="{{ route('community.show', $post->community->slug) }}" class="text-primary-600 hover:text-primary-700">{{ $post->community->name }}</a>
                        @endif
                    </p>
                </div>
                @endif
            </div>
            <div class="flex items-center space-x-2">
                @if($post->mood)
                <span class="px-2 py-1 rounded-full text-xs bg-primary-50 text-primary-600 border border-primary-100">
                    <i class="fas fa-smile mr-1"></i>{{ ucfirst($post->mood) }}
                </span>
                @endif
                <button class="p-2 text-neutral-400 hover:text-neutral-600 rounded-lg transition-colors">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Post Content -->
    <div class="px-6 pb-4">
        <h3 class="font-semibold text-neutral-800 text-lg mb-2">{{ $post->title }}</h3>
        <p class="text-neutral-600 leading-relaxed whitespace-pre-line">{{ $post->content }}</p>
        
        @if($post->image)
        <div class="mt-4 rounded-lg overflow-hidden">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full h-auto max-h-96 object-cover">
        </div>
        @endif
    </div>

    <!-- Post Stats -->
    <div class="px-6 py-3 border-t border-b border-neutral-100 text-sm text-neutral-500">
        <div class="flex items-center space-x-4">
            <span class="flex items-center space-x-1">
                <i class="fas fa-thumbs-up text-primary-500"></i>
                <span class="like-count-display">{{ $post->upvotes_count }} likes</span>
            </span>
            <span class="flex items-center space-x-1">
                <i class="fas fa-comment text-secondary-500"></i>
                <span class="comments-count-display">{{ $post->comments_count }} comments</span>
            </span>
            <span class="flex items-center space-x-1">
                <i class="fas fa-share text-green-500"></i>
                <span>12 shares</span>
            </span>
        </div>
    </div>

    <!-- Post Actions -->
    <div class="p-4">
        <div class="flex justify-between text-neutral-500">
            <!-- Like Button -->
            <button class="like-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-primary-50 transition-colors {{ $post->isLikedBy(auth()->user()) ? 'liked text-primary-600' : '' }}"
                    data-post-id="{{ $post->id }}"
                    {{ !auth()->check() ? 'disabled' : '' }}>
                <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                <span class="like-count">{{ $post->upvotes_count }}</span>
            </button>

            <!-- Comment Button -->
            <button class="comment-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-secondary-50 transition-colors"
                    onclick="toggleComments({{ $post->id }})"
                    {{ !auth()->check() ? 'disabled' : '' }}>
                <i class="far fa-comment"></i>
                <span class="comments-count">{{ $post->comments_count }}</span>
                <span>Comment</span>
            </button>

            <!-- Save Button -->
            <button class="save-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-accent-gold/10 transition-colors {{ $post->isSavedBy(auth()->user()) ? 'saved text-secondary-600' : '' }}"
                    data-post-id="{{ $post->id }}"
                    {{ !auth()->check() ? 'disabled' : '' }}>
                <i class="{{ $post->isSavedBy(auth()->user()) ? 'fas' : 'far' }} fa-bookmark"></i>
                <span>Save</span>
            </button>

            <!-- Share Button -->
            <button class="share-btn flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-green-50 transition-colors"
                    {{ !auth()->check() ? 'disabled' : '' }}>
                <i class="far fa-share-square"></i>
                <span>Share</span>
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section hidden border-t border-neutral-100">
        <div class="p-4">
            @if(auth()->check())
            <!-- Add Comment Form -->
            <div class="flex items-start space-x-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-300 to-secondary-300 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <form class="flex-1 comment-form" data-post-id="{{ $post->id }}">
                    @csrf
                    <textarea name="content" placeholder="Write a comment..." 
                             class="w-full p-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 resize-none"
                             rows="2" required></textarea>
                    <div class="flex justify-end mt-2 space-x-2">
                        <button type="button" class="cancel-comment-btn px-4 py-2 text-neutral-600 hover:text-neutral-800 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors">
                            Comment
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="text-center py-4">
                <p class="text-neutral-500">Please <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700">login</a> to comment</p>
            </div>
            @endif

            <!-- Comments List -->
            <div class="comments-list space-y-3">
                @foreach($post->comments->take(5) as $comment)
                    @include('community.partials.comment', ['comment' => $comment])
                @endforeach
            </div>

            @if($post->comments_count > 5)
            <button class="w-full text-center py-3 text-secondary-600 hover:text-secondary-700 font-medium view-all-comments"
                    data-post-id="{{ $post->id }}">
                View all {{ $post->comments_count }} comments
            </button>
            @endif
        </div>
    </div>
</div>