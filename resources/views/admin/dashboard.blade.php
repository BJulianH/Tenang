@extends('layouts.admin')

@section('title', 'Admin Dashboard - Tenang')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-primary-600 mt-2">{{ $stats['total_users'] }}</p>
                    <p class="text-green-600 text-sm mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $stats['new_users_today'] }} new today
                    </p>
                </div>
                <div class="p-3 bg-primary-100 rounded-lg">
                    <i class="fas fa-users text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm font-medium">Total Posts</p>
                    <p class="text-3xl font-bold text-secondary-600 mt-2">{{ $stats['total_posts'] }}</p>
                    <p class="text-green-600 text-sm mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $stats['new_posts_today'] }} new today
                    </p>
                </div>
                <div class="p-3 bg-secondary-100 rounded-lg">
                    <i class="fas fa-file-alt text-secondary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Communities -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm font-medium">Communities</p>
                    <p class="text-3xl font-bold text-accent-gold mt-2">{{ $stats['total_communities'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-users text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Reports -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm font-medium">Pending Reports</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['pending_reports'] }}</p>
                    <p class="text-red-600 text-sm mt-1">Needs attention</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-flag text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl p-6 card-shadow lg:col-span-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-neutral-800">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                @foreach($recent_users as $user)
                <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-neutral-800">{{ $user->name }}</p>
                            <p class="text-xs text-neutral-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                           ($user->role === 'moderator' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white rounded-xl p-6 card-shadow lg:col-span-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-neutral-800">Recent Posts</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                @foreach($recent_posts as $post)
                <div class="p-3 bg-neutral-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-neutral-800">{{ $post->user->name }}</p>
                        <span class="text-xs text-neutral-500">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 line-clamp-2">{{ $post->excerpt }}</p>
                    <div class="flex items-center space-x-4 mt-2 text-xs text-neutral-500">
                        <span><i class="fas fa-heart mr-1"></i>{{ $post->upvotes_count ?? 0 }}</span>
                        <span><i class="fas fa-comment mr-1"></i>{{ $post->comments_count ?? 0 }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-xl p-6 card-shadow lg:col-span-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-neutral-800">Pending Reports</h3>
                <a href="{{ route('admin.reports.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                @foreach($recent_reports as $report)
                <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-red-800">{{ $report->reporter->name }}</p>
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Urgent</span>
                    </div>
                    <p class="text-sm text-red-600 line-clamp-2">{{ $report->reason }}</p>
                    <p class="text-xs text-red-500 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-neutral-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-4 bg-primary-50 border border-primary-200 rounded-lg text-center hover:bg-primary-100 transition-colors">
                <i class="fas fa-users text-primary-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-primary-700">Manage Users</p>
            </a>
            <a href="{{ route('admin.posts.index') }}" class="p-4 bg-secondary-50 border border-secondary-200 rounded-lg text-center hover:bg-secondary-100 transition-colors">
                <i class="fas fa-file-alt text-secondary-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-secondary-700">Manage Posts</p>
            </a>
            <a href="{{ route('admin.communities.index') }}" class="p-4 bg-green-50 border border-green-200 rounded-lg text-center hover:bg-green-100 transition-colors">
                <i class="fas fa-users text-green-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-green-700">Communities</p>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="p-4 bg-red-50 border border-red-200 rounded-lg text-center hover:bg-red-100 transition-colors">
                <i class="fas fa-flag text-red-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-red-700">Reports</p>
            </a>
        </div>
    </div>
</div>
@endsection