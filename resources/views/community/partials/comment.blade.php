{{-- resources/views/community/partials/comment.blade.php --}}
<div class="comment-item bg-neutral-50 rounded-lg p-4 {{ $comment->parent_id ? 'ml-8 border-l-2 border-neutral-200' : '' }}" id="comment-{{ $comment->id }}">
    <div class="flex items-start justify-between mb-2">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-300 to-secondary-300 flex items-center justify-center text-white font-bold text-sm">
                {{ substr($comment->user->name, 0, 1) }}
            </div>
            <div>
                <span class="font-medium text-neutral-700">
                    {{ $comment->user->name }}
                </span>
                <p class="text-xs text-neutral-500">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>
        
        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
        <div class="relative">
            <button class="comment-menu-btn p-1 text-neutral-400 hover:text-neutral-600 rounded transition-colors">
                <i class="fas fa-ellipsis-h text-sm"></i>
            </button>
            <div class="comment-menu hidden absolute right-0 top-full mt-1 bg-white rounded-lg shadow-lg border border-neutral-200 py-1 z-10 min-w-[120px]">
                <button class="edit-comment-btn w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors" data-comment-id="{{ $comment->id }}">
                    <i class="fas fa-edit mr-2"></i>Edit
                </button>
                <button class="delete-comment-btn w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors" data-comment-id="{{ $comment->id }}">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </div>
        </div>
        @endif
    </div>

    <div class="comment-content mb-3">
        <p class="text-neutral-700 whitespace-pre-line">{{ $comment->content }}</p>
    </div>

    <div class="comment-actions flex items-center space-x-4 text-sm text-neutral-500">
        <!-- Like Button -->
        <button class="like-comment-btn flex items-center space-x-1 hover:text-primary-600 transition-colors {{ auth()->check() && $comment->isLikedBy(auth()->user()) ? 'text-primary-600' : '' }}" 
                data-comment-id="{{ $comment->id }}"
                {{ !auth()->check() ? 'disabled' : '' }}>
            <i class="{{ auth()->check() && $comment->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-up"></i>
            <span class="like-count">{{ $comment->upvotes_count ?? 0 }}</span>
        </button>
        
        <!-- Reply Button (hanya untuk comment utama) -->
        @if(!$comment->parent_id && auth()->check())
        <button class="reply-btn flex items-center space-x-1 hover:text-secondary-600 transition-colors" 
                data-comment-id="{{ $comment->id }}">
            <i class="far fa-comment-dots"></i>
            <span>Reply</span>
        </button>
        @endif
    </div>

    <!-- Reply Form (Hidden by default) -->
    @if(auth()->check() && !$comment->parent_id)
    <div class="reply-form hidden mt-3">
        <form class="flex items-start space-x-3" data-parent-id="{{ $comment->id }}">
            @csrf
            <div class="w-6 h-6 rounded-full bg-gradient-to-r from-primary-200 to-secondary-200 flex items-center justify-center text-white font-bold text-xs">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <textarea name="content" placeholder="Write a reply..." 
                         class="w-full p-2 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 resize-none text-sm" 
                         rows="2" 
                         required></textarea>
                <div class="flex justify-end mt-2 space-x-2">
                    <button type="button" class="cancel-reply-btn px-3 py-1 text-xs text-neutral-600 hover:text-neutral-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-3 py-1 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors text-xs">
                        Reply
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Replies Section -->
    @if($comment->replies_count > 0)
    <div class="replies mt-3 space-y-3">
        @foreach($comment->replies as $reply)
            @include('community.partials.comment', ['comment' => $reply])
        @endforeach
    </div>
    @endif
</div>