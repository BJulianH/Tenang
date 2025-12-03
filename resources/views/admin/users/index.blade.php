@extends('layouts.admin')

@section('title', 'User Management - Tenang Admin')
@section('page_title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Users</p>
                    <p class="text-3xl font-bold text-primary-600">{{ $users->total() }}</p>
                </div>
                <div class="p-3 bg-primary-100 rounded-lg">
                    <i class="fas fa-users text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Admins</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-crown text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Moderators</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $users->where('role', 'moderator')->count() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Verified</p>
                    <p class="text-3xl font-bold text-green-600">{{ $users->where('is_verified', true)->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-badge-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
            
            <!-- Search and Filters -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search users..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Roles</option>
                    <option value="user">User</option>
                    <option value="moderator">Moderator</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stats
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($user->profile_image)
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_image }}" alt="{{ $user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                        @if($user->is_verified)
                                            <i class="fas fa-badge-check text-blue-500 ml-1" title="Verified"></i>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    @if($user->username)
                                    <div class="text-xs text-gray-400">@{{ $user->username }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="role" onchange="this.form.submit()" 
                                    class="text-xs font-medium rounded-full px-3 py-1 border-0 focus:ring-2 focus:ring-primary-500 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                       ($user->role === 'moderator' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-4">
                                <span class="flex items-center" title="Posts">
                                    <i class="fas fa-file-alt text-gray-400 mr-1"></i>
                                    {{ $user->posts_count }}
                                </span>
                                <span class="flex items-center" title="Comments">
                                    <i class="fas fa-comment text-gray-400 mr-1"></i>
                                    {{ $user->comments_count }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                                    <button type="submit" class="text-xs font-medium rounded-full px-3 py-1 
                                        {{ $user->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_verified" value="{{ $user->is_verified ? 0 : 1 }}">
                                    <button type="submit" class="text-xs rounded-full p-1 
                                        {{ $user->is_verified ? 'text-blue-500 hover:text-blue-700' : 'text-gray-400 hover:text-gray-600' }}"
                                        title="{{ $user->is_verified ? 'Unverify' : 'Verify' }}">
                                        <i class="fas fa-badge-check"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="text-primary-600 hover:text-primary-900 mr-3 transition-colors"
                               title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-gray-400 cursor-not-allowed" title="Cannot delete your own account">
                                <i class="fas fa-trash"></i>
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit forms on select change
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelects = document.querySelectorAll('select[name="role"]');
        roleSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Show loading state
                const originalText = this.options[this.selectedIndex].text;
                this.disabled = true;
                this.nextElementSibling?.remove();
                
                const spinner = document.createElement('span');
                spinner.className = 'ml-2 fas fa-spinner fa-spin';
                this.parentNode.appendChild(spinner);
                
                this.form.submit();
            });
        });
    });
</script>
@endpush