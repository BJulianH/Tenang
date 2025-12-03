@extends('layouts.admin')

@section('title', 'Post Details - Tenang Admin')
@section('page_title', 'Post Details')

@section('content')
<div class="space-y-6">
    <!-- Post Header -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $post->title ?: 'No Title' }}</h1>
                <div class="flex items-center space-x-4 mt-2">
                    <span class="px-3 py-1 text-sm rounded-full 
                        {{ $post->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $post->is_approved ? 'Approved' : 'Pending Approval' }}
                    </span>
                    @if($post->is_featured)
                    <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                        Featured
                    </span>
                    @endif
                    @if($post->is_support_request)
                    <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                        Support Request
                    </span>
                    @endif
                    @if($post->is_anonymous)
                    <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                        Anonymous
                    </span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.posts.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Post Content -->
                <div class="lg:col-span-2">
                    @if($post->image)
                    <div class="mb-6">
                        <img src="{{ $post->image }}" alt="Post image" class="w-full h-64 object-cover rounded-lg">
                    </div>
                    @endif

                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>

                    @if($post->tags && count($post->tags) > 0)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Tags:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                {{ $tag }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Post Meta -->
                <div class="space-y-6">
                    <!-- Author Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Author Information</h3>
                        <div class="flex items-center space-x-3 mb-3">
                            @if($post->user->profile_image)
                                <img class="h-12 w-12 rounded-full" src="{{ $post->user->profile_image }}" alt="{{ $post->user->name }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                                <p class="text-xs text-gray-500">@{{ $post->user->username }}</p>
                                <p class="text-xs text-gray-500">{{ $post->user->email }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $post->user) }}" 
                           class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            View User Profile →
                        </a>
                    </div>

                    <!-- Post Stats -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Post Statistics</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">{{ $post->upvotes_count ?? 0 }}</p>
                                <p class="text-sm text-gray-600">Upvotes</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-red-600">{{ $post->downvotes_count ?? 0 }}</p>
                                <p class="text-sm text-gray-600">Downvotes</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ $post->comments_count ?? 0 }}</p>
                                <p class="text-sm text-gray-600">Comments</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-purple-600">{{ $post->saves_count ?? 0 }}</p>
                                <p class="text-sm text-gray-600">Saves</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Quick Actions</h3>
                        <div class="space-y-2">
                            @if(!$post->is_approved)
                            <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="contents">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-check mr-2"></i>Approve Post
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.posts.disapprove', $post) }}" method="POST" class="contents">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-yellow-600 text-white py-2 px-4 rounded-lg hover:bg-yellow-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-times mr-2"></i>Disapprove Post
                                </button>
                            </form>
                            @endif

                            @if(!$post->is_featured)
                            <form action="{{ route('admin.posts.feature', $post) }}" method="POST" class="contents">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-star mr-2"></i>Feature Post
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.posts.unfeature', $post) }}" method="POST" class="contents">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-star mr-2"></i>Unfeature Post
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="contents"
                                  onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-trash mr-2"></i>Delete Post
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Post Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Post Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Published:</span>
                                <span class="font-medium">{{ $post->created_at->format('M d, Y g:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="font-medium">{{ $post->updated_at->format('M d, Y g:i A') }}</span>
                            </div>
                            @if($post->community)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Community:</span>
                                <span class="font-medium">{{ $post->community->name }}</span>
                            </div>
                            @endif
                            @if($post->mood)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mood:</span>
                                <span class="font-medium">{{ $post->mood_with_icon ?? $post->mood }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts by Same Author -->
    @if($related_posts->count() > 0)
    <div class="bg-white rounded-lg p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Posts by Same Author</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($related_posts as $related_post)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition-colors">
                <p class="text-sm font-medium text-gray-900 line-clamp-2 mb-2">
                    {{ $related_post->title ?: Str::limit(strip_tags($related_post->content), 60) }}
                </p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>{{ $related_post->created_at->diffForHumans() }}</span>
                    <a href="{{ route('admin.posts.show', $related_post) }}" class="text-primary-600 hover:text-primary-700">
                        View →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection