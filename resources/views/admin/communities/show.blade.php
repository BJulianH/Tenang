@extends('layouts.admin')

@section('title', $community->name . ' - Community Details - Tenang Admin')
@section('page_title', 'Community Details: ' . $community->name)

@section('content')
<div class="space-y-6">
    <!-- Community Header -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        @if($community->banner_image)
        <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $community->banner_image }}')"></div>
        @else
        <div class="h-32 bg-gradient-to-r from-primary-500 to-secondary-500"></div>
        @endif
        
        <div class="px-6 py-4 {{ $community->banner_image ? '-mt-20' : '-mt-16' }}">
            <div class="flex items-end justify-between">
                <div class="flex items-end space-x-6">
                    <div class="relative">
                        @if($community->profile_image)
                            <img class="h-32 w-32 rounded-full border-4 border-white bg-white" 
                                 src="{{ $community->profile_image }}" alt="{{ $community->name }}">
                        @else
                            <div class="h-32 w-32 rounded-full border-4 border-white bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-4xl font-bold">
                                {{ substr($community->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="pb-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $community->name }}</h1>
                        <p class="text-gray-600">{{ $community->description ?: 'No description available' }}</p>
                        
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="px-3 py-1 text-sm rounded-full 
                                {{ $community->type === 'public' ? 'bg-green-100 text-green-800' : 
                                   ($community->type === 'private' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($community->type) }}
                            </span>
                            
                            @if($community->is_main)
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                Main Community
                            </span>
                            @else
                            <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                                Sub-Community
                            </span>
                            @endif
                            
                            @if($community->parent)
                            <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                                Parent: {{ $community->parent->name }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('admin.communities.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                    <a href="{{ route('admin.communities.members', $community) }}" 
                       class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <i class="fas fa-user-friends mr-2"></i>Manage Members
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <form action="{{ route('admin.communities.update', $community) }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_main" value="{{ $community->is_main ? 0 : 1 }}">
                        <button type="submit" 
                                class="p-4 {{ $community->is_main ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }} border rounded-lg text-center hover:bg-opacity-75 transition-colors">
                            <i class="fas {{ $community->is_main ? 'fa-home text-blue-600' : 'fa-folder text-gray-600' }} text-xl mb-2"></i>
                            <p class="text-sm font-medium {{ $community->is_main ? 'text-blue-700' : 'text-gray-700' }}">
                                {{ $community->is_main ? 'Make Sub' : 'Make Main' }}
                            </p>
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.communities.update', $community) }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" value="{{ $community->type === 'public' ? 'private' : 'public' }}">
                        <button type="submit" 
                                class="p-4 {{ $community->type === 'public' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} border rounded-lg text-center hover:bg-opacity-75 transition-colors">
                            <i class="fas {{ $community->type === 'public' ? 'fa-lock-open text-green-600' : 'fa-lock text-red-600' }} text-xl mb-2"></i>
                            <p class="text-sm font-medium {{ $community->type === 'public' ? 'text-green-700' : 'text-red-700' }}">
                                Make {{ $community->type === 'public' ? 'Private' : 'Public' }}
                            </p>
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.communities.update', $community) }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_active" value="{{ $community->is_active ? 0 : 1 }}">
                        <button type="submit" 
                                class="p-4 {{ $community->is_active ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} border rounded-lg text-center hover:bg-opacity-75 transition-colors">
                            <i class="fas {{ $community->is_active ? 'fa-toggle-on text-green-600' : 'fa-toggle-off text-red-600' }} text-xl mb-2"></i>
                            <p class="text-sm font-medium {{ $community->is_active ? 'text-green-700' : 'text-red-700' }}">
                                {{ $community->is_active ? 'Deactivate' : 'Activate' }}
                            </p>
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.communities.destroy', $community) }}" method="POST" class="contents"
                          onsubmit="return confirm('Are you sure you want to delete this community? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="p-4 bg-red-50 border border-red-200 rounded-lg text-center hover:bg-red-100 transition-colors">
                            <i class="fas fa-trash text-red-600 text-xl mb-2"></i>
                            <p class="text-sm font-medium text-red-700">Delete Community</p>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Posts</h3>
                    <span class="text-sm text-gray-500">{{ $community->posts_count }} total posts</span>
                </div>
                <div class="space-y-4">
                    @forelse($recent_posts as $post)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                @if($post->user->profile_image)
                                    <img class="h-8 w-8 rounded-full" src="{{ $post->user->profile_image }}" alt="{{ $post->user->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm font-medium text-gray-800 mb-2">
                            {{ $post->title ?: Str::limit(strip_tags($post->content), 80) }}
                        </p>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $post->excerpt }}</p>
                        <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                            <span><i class="fas fa-heart mr-1"></i>{{ $post->upvotes_count }}</span>
                            <span><i class="fas fa-comment mr-1"></i>{{ $post->comments_count }}</span>
                            @if($post->mood)
                            <span class="px-2 py-1 bg-gray-100 rounded-full">{{ $post->mood }}</span>
                            @endif
                            @if($post->is_support_request)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Support</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-file-alt text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No posts yet in this community</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Sub-Communities -->
            @if($community->children->count() > 0)
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Sub-Communities</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($community->children as $child)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition-colors">
                        <div class="flex items-center space-x-3 mb-2">
                            @if($child->profile_image)
                                <img class="h-10 w-10 rounded-full" src="{{ $child->profile_image }}" alt="{{ $child->name }}">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                                    {{ substr($child->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $child->name }}</p>
                                <p class="text-xs text-gray-500">{{ $child->members_count }} members</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $child->description ?: 'No description' }}</p>
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $child->type === 'public' ? 'bg-green-100 text-green-800' : 
                                   ($child->type === 'private' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($child->type) }}
                            </span>
                            <a href="{{ route('admin.communities.show', $child) }}" class="text-primary-600 hover:text-primary-700 text-sm">
                                View →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Community Statistics -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Community Statistics</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Members</span>
                        <span class="text-lg font-bold text-primary-600">{{ $community->members_count }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Posts</span>
                        <span class="text-lg font-bold text-green-600">{{ $community->posts_count }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Sub-Communities</span>
                        <span class="text-lg font-bold text-blue-600">{{ $community->children_count }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Active Today</span>
                        <span class="text-lg font-bold text-purple-600">
                            {{ $community->posts()->whereDate('created_at', today())->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Top Members -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Contributors</h3>
                <div class="space-y-3">
                    @forelse($top_members as $member)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            @if($member->profile_image)
                                <img class="h-8 w-8 rounded-full" src="{{ $member->profile_image }}" alt="{{ $member->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500">{{ $member->posts_count }} posts</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $member->pivot->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                               ($member->pivot->role === 'moderator' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($member->pivot->role) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">No members yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Community Settings -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Community Settings</h3>
                <form action="{{ route('admin.communities.update', $community) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Community Name</label>
                        <input type="text" name="name" value="{{ $community->name }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ $community->description }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Community Type</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="public" {{ $community->type === 'public' ? 'selected' : '' }}>Public - Anyone can join and post</option>
                            <option value="private" {{ $community->type === 'private' ? 'selected' : '' }}>Private - Approval required to join</option>
                            <option value="restricted" {{ $community->type === 'restricted' ? 'selected' : '' }}>Restricted - Anyone can view, but only approved members can post</option>
                        </select>
                    </div>
                    
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_main" value="1" 
                                       {{ $community->is_main ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Main Community</span>
                            </label>
                        </div>
                        
                        <div class="flex-1">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ $community->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors">
                        Update Settings
                    </button>
                </form>
            </div>

            <!-- Creator Information -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Creator Information</h3>
                <div class="flex items-center space-x-3">
                    @if($community->creator->profile_image)
                        <img class="h-12 w-12 rounded-full" src="{{ $community->creator->profile_image }}" alt="{{ $community->creator->name }}">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                            {{ substr($community->creator->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $community->creator->name }}</p>
                        <p class="text-xs text-gray-500">@{{ $community->creator->username }}</p>
                        <p class="text-xs text-gray-500">{{ $community->creator->email }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.users.show', $community->creator) }}" 
                       class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        View Creator Profile →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection