@extends('layouts.admin')

@section('title', $user->name . ' - User Details - MindWell Admin')
@section('page_title', 'User Details: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- User Profile Header -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-primary-500 to-secondary-500"></div>
        <div class="px-6 py-4 -mt-16">
            <div class="flex items-end justify-between">
                <div class="flex items-end space-x-6">
                    <div class="relative">
                        @if($user->profile_image)
                            <img class="h-32 w-32 rounded-full border-4 border-white bg-white" 
                                 src="{{ $user->profile_image }}" alt="{{ $user->name }}">
                        @else
                            <div class="h-32 w-32 rounded-full border-4 border-white bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-4xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <!-- Online Status -->
                        @if($user->is_online)
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-2 border-white rounded-full" 
                             title="Online"></div>
                        @endif
                    </div>
                    
                    <div class="pb-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        @if($user->username)
                        <p class="text-gray-500">@{{ $user->username }}</p>
                        @endif
                        
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="px-3 py-1 text-sm rounded-full 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role === 'moderator' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            
                            <span class="px-3 py-1 text-sm rounded-full 
                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            
                            @if($user->is_verified)
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-badge-check mr-1"></i>Verified
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                        <button type="submit" 
                                class="p-4 bg-purple-50 border border-purple-200 rounded-lg text-center hover:bg-purple-100 transition-colors">
                            <i class="fas fa-crown text-purple-600 text-xl mb-2"></i>
                            <p class="text-sm font-medium text-purple-700">
                                {{ $user->role === 'admin' ? 'Remove Admin' : 'Make Admin' }}
                            </p>
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                        <button type="submit" 
                                class="p-4 {{ $user->is_active ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200' }} border rounded-lg text-center hover:bg-opacity-75 transition-colors">
                            <i class="fas {{ $user->is_active ? 'fa-user-slash text-red-600' : 'fa-user-check text-green-600' }} text-xl mb-2"></i>
                            <p class="text-sm font-medium {{ $user->is_active ? 'text-red-700' : 'text-green-700' }}">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </p>
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_verified" value="{{ $user->is_verified ? 0 : 1 }}">
                        <button type="submit" 
                                class="p-4 {{ $user->is_verified ? 'bg-yellow-50 border-yellow-200' : 'bg-blue-50 border-blue-200' }} border rounded-lg text-center hover:bg-opacity-75 transition-colors">
                            <i class="fas fa-badge-check {{ $user->is_verified ? 'text-yellow-600' : 'text-blue-600' }} text-xl mb-2"></i>
                            <p class="text-sm font-medium {{ $user->is_verified ? 'text-yellow-700' : 'text-blue-700' }}">
                                {{ $user->is_verified ? 'Unverify' : 'Verify' }}
                            </p>
                        </button>
                    </form>
                    
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="contents"
                          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="p-4 bg-red-50 border border-red-200 rounded-lg text-center hover:bg-red-100 transition-colors">
                            <i class="fas fa-trash text-red-600 text-xl mb-2"></i>
                            <p class="text-sm font-medium text-red-700">Delete User</p>
                        </button>
                    </form>
                    @else
                    <button disabled
                            class="p-4 bg-gray-100 border border-gray-200 rounded-lg text-center cursor-not-allowed">
                        <i class="fas fa-trash text-gray-400 text-xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-500">Cannot Delete</p>
                    </button>
                    @endif
                </div>
            </div>

            <!-- User Statistics -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">User Statistics</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-2xl font-bold text-blue-600">{{ $user->posts_count }}</p>
                        <p class="text-sm text-blue-700">Posts</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-2xl font-bold text-green-600">{{ $user->comments_count }}</p>
                        <p class="text-sm text-green-700">Comments</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-2xl font-bold text-purple-600">{{ $user->owned_communities_count }}</p>
                        <p class="text-sm text-purple-700">Communities</p>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <p class="text-2xl font-bold text-orange-600">{{ $user->reputation_score ?? 0 }}</p>
                        <p class="text-sm text-orange-700">Reputation</p>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Posts</h3>
                    <a href="#" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse($recent_posts as $post)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900">{{ Str::limit($post->title, 50) }}</p>
                            <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $post->excerpt }}</p>
                        <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                            <span><i class="fas fa-heart mr-1"></i>{{ $post->upvotes_count ?? 0 }}</span>
                            <span><i class="fas fa-comment mr-1"></i>{{ $post->comments_count ?? 0 }}</span>
                            @if($post->community)
                            <span class="px-2 py-1 bg-gray-100 rounded-full">{{ $post->community->name }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">No posts yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Account Details -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Member Since</p>
                        <p class="text-sm font-medium">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Last Login</p>
                        <p class="text-sm font-medium">
                            @if($user->last_login_at)
                                {{ $user->last_login_at->diffForHumans() }}
                            @else
                                Never
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email Visibility</p>
                        <p class="text-sm font-medium">{{ $user->show_email ? 'Public' : 'Private' }}</p>
                    </div>
                    @if($user->date_of_birth)
                    <div>
                        <p class="text-sm text-gray-600">Date of Birth</p>
                        <p class="text-sm font-medium">{{ $user->date_of_birth->format('M d, Y') }}</p>
                    </div>
                    @endif
                    @if($user->location)
                    <div>
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="text-sm font-medium">{{ $user->location }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Role Management -->
            <div class="bg-white rounded-lg p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Role Management</h3>
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User Role</label>
                        <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    
                    <div class="flex space-x-2">
                        <div class="flex-1">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ $user->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Active Account</span>
                            </label>
                        </div>
                        
                        <div class="flex-1">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_verified" value="1" 
                                       {{ $user->is_verified ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Verified</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors">
                        Update Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection