@extends('layouts.app')

@section('title', $user->name . ' - Communities - Tenang Profile')

@section('styles')
<style>
    .profile-header {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .profile-header:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    /* Button Styles */
    .btn-primary {
        background: #58cc70;
        color: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 #45b259;
        transition: all 0.2s ease;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #45b259;
    }

    .btn-primary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #45b259;
    }

    .btn-secondary {
        background: #ffc800;
        color: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 #e6b400;
        transition: all 0.2s ease;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #e6b400;
    }

    .btn-secondary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #e6b400;
    }

    .btn-outline {
        background: white;
        color: #495057;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        font-weight: 600;
        padding: 12px 24px;
    }

    .btn-outline:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #58cc70;
        color: #58cc70;
    }

    /* Card Styles */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* Navigation Tabs */
    .nav-tab {
        position: relative;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        border-radius: 12px 12px 0 0;
        padding: 12px 20px;
        font-weight: 600;
    }

    .nav-tab:hover {
        color: #58cc70;
        border-bottom-color: #c2ebd0;
        background-color: #f8fdf8;
        transform: translateY(-2px);
    }

    .nav-tab.active {
        color: #58cc70;
        border-bottom-color: #58cc70;
        background: linear-gradient(135deg, #f0f9f0, #ffffff);
        box-shadow: 0 2px 0 rgba(88, 204, 112, 0.2);
    }

    /* Community Cards */
    .community-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 2px solid #f1f3f4;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .community-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    .community-avatar {
        border: 3px solid white;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    /* Type Badges */
    .type-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-weight: 600;
    }

    .type-public {
        background: linear-gradient(135deg, #58cc70, #45b259);
        color: white;
    }

    .type-private {
        background: linear-gradient(135deg, #ffc800, #e6b400);
        color: white;
    }

    .type-restricted {
        background: linear-gradient(135deg, #ff6b6b, #e55c5c);
        color: white;
    }

    /* Role Badges */
    .role-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.6rem;
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .role-admin {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        color: white;
    }

    .role-moderator {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .role-member {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }

    /* Empty State */
    .empty-state {
        background: white;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.05);
        padding: 48px 24px;
        text-align: center;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 12px;
    }

    .stat-item {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid #f1f3f4;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    /* Filter Buttons */
    .filter-btn {
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 600;
        background: white;
    }

    .filter-btn.active {
        background: #58cc70;
        color: white;
        border-color: #45b259;
        box-shadow: 0 2px 0 #45b259;
    }

    .filter-btn:hover:not(.active) {
        border-color: #58cc70;
        color: #58cc70;
        transform: translateY(-2px);
    }

    /* Community Description */
    .community-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    /* Interactive Elements */
    .interactive-btn {
        transition: all 0.2s ease;
        border-radius: 12px;
        padding: 8px 16px;
    }

    .interactive-btn:hover {
        transform: translateY(-2px);
        background: #f8f9fa;
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #58cc70;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #45b259;
    }

    /* Rounded corners */
    .rounded-duo {
        border-radius: 16px;
    }

    .rounded-duo-xl {
        border-radius: 24px;
    }

    /* Shadows */
    .shadow-duo {
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .shadow-duo-pressed {
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Notification Styles */
    .notification-success {
        background: linear-gradient(135deg, #58cc70, #45b259);
        border: 2px solid #45b259;
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 0 rgba(69, 178, 89, 0.3);
    }

    .notification-error {
        background: linear-gradient(135deg, #ff6b6b, #e55c5c);
        border: 2px solid #e55c5c;
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 0 rgba(229, 92, 92, 0.3);
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Profile Header -->
    <div class="profile-header mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-2xl shadow-duo">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-neutral-800">{{ $user->name }}</h1>
                            <p class="text-neutral-600 text-lg">@<span>{{ $user->username }}</span></p>
                            @if($user->bio)
                                <p class="text-neutral-500 mt-2 max-w-2xl">{{ $user->bio }}</p>
                            @else
                                <p class="text-neutral-400 mt-2 italic">No bio yet</p>
                            @endif
                        </div>

                        @if($isOwnProfile)
                            <div class="flex gap-3">
                                <a href="{{ route('profile.edit') }}" class="btn-outline px-6 py-2 rounded-duo font-bold whitespace-nowrap">
                                    <i class="fas fa-edit mr-2"></i>Edit Profile
                                </a>
                                <a href="{{ route('community.create') }}" class="btn-secondary px-6 py-2 rounded-duo font-bold whitespace-nowrap">
                                    <i class="fas fa-plus mr-2"></i>Create Community
                                </a>
                            </div>
                        @else
                            <button class="btn-primary px-6 py-2 rounded-duo font-bold whitespace-nowrap">
                                <i class="fas fa-user-plus mr-2"></i>Follow
                            </button>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap gap-6 mt-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary-600">{{ $communities->total() }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Communities</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary-600">{{ $totalMembers }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Total Members</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-accent-purple">{{ $ownedCommunitiesCount }}</div>
                            <div class="text-sm text-neutral-500 font-medium">Created</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-neutral-500 font-medium">Joined {{ $user->created_at->diffForHumans() }}</div>
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
            <div class="card p-2 mb-6">
                <div class="flex overflow-x-auto custom-scrollbar">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0">
                        <i class="fas fa-newspaper mr-2"></i>
                        <span>Posts</span>
                    </a>
                    <a href="{{ route('profile.comments', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0">
                        <i class="fas fa-comments mr-2"></i>
                        <span>Comments</span>
                    </a>
                    <a href="{{ route('profile.communities', $user->username) }}" 
                       class="nav-tab flex items-center font-medium text-neutral-700 flex-shrink-0 active">
                        <i class="fas fa-users mr-2"></i>
                        <span>Communities</span>
                    </a>
                </div>
            </div>

            <!-- Communities Header -->
            <div class="card p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-neutral-800 flex items-center">
                            <i class="fas fa-users text-primary-500 mr-2"></i>
                            Communities
                        </h2>
                        <p class="text-neutral-600 mt-1">
                            {{ $communities->total() }} communities • 
                            {{ $ownedCommunitiesCount }} created • 
                            {{ $communities->total() - $ownedCommunitiesCount }} joined
                        </p>
                    </div>
                    
                    <!-- Filters and Search -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex rounded-duo border-2 border-neutral-300 overflow-hidden bg-white shadow-duo-pressed">
                            <button class="filter-btn px-4 py-2 text-sm font-bold {{ $filter === 'all' ? 'active' : '' }}"
                                    onclick="setFilter('all')">
                                All
                            </button>
                            <button class="filter-btn px-4 py-2 text-sm font-bold {{ $filter === 'owned' ? 'active' : '' }}"
                                    onclick="setFilter('owned')">
                                Created
                            </button>
                            <button class="filter-btn px-4 py-2 text-sm font-bold {{ $filter === 'joined' ? 'active' : '' }}"
                                    onclick="setFilter('joined')">
                                Joined
                            </button>
                        </div>
                        
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Search communities..." 
                                   class="pl-10 pr-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-full sm:w-64 bg-white shadow-duo-pressed"
                                   onkeyup="searchCommunities(this.value)">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Communities Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($communities as $community)
                @php
                    $userRole = $community->pivot->role ?? null;
                    $isOwner = $community->creator_id === $user->id;
                @endphp
                
                <div class="community-card">
                    <!-- Community Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-duo community-avatar bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white text-xl font-bold shadow-duo">
                                    @if($community->profile_image)
                                        <img src="{{ asset('storage/' . $community->profile_image) }}" 
                                             alt="{{ $community->name }}" 
                                             class="w-full h-full rounded-duo object-cover">
                                    @else
                                        <i class="fas fa-users"></i>
                                    @endif
                                </div>
                                
                                <!-- Role Badge -->
                                @if($isOwner || $userRole)
                                <div class="absolute -top-2 -right-2">
                                    <span class="role-badge {{ $isOwner ? 'role-admin' : ($userRole === 'moderator' ? 'role-moderator' : 'role-member') }}">
                                        {{ $isOwner ? 'Owner' : ucfirst($userRole) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-neutral-800 truncate">
                                    <a href="{{ route('community.show', $community->slug) }}" 
                                       class="hover:text-primary-600 transition-colors">
                                        {{ $community->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="type-badge type-{{ $community->type }}">
                                        <i class="fas {{ $community->type === 'public' ? 'fa-globe' : ($community->type === 'private' ? 'fa-lock' : 'fa-shield-alt') }} mr-1"></i>
                                        {{ ucfirst($community->type) }}
                                    </span>
                                    <span class="text-sm text-neutral-500 font-medium">
                                        {{ $community->members_count }} members
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Community Description -->
                    @if($community->description)
                    <p class="community-description text-neutral-600 mb-4 text-sm">
                        {{ $community->description }}
                    </p>
                    @endif

                    <!-- Community Stats -->
                    <div class="stats-grid mb-4">
                        <div class="stat-item">
                            <div class="text-xl font-bold text-primary-600">{{ $community->members_count }}</div>
                            <div class="text-xs text-neutral-500 font-medium">Members</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-xl font-bold text-primary-600">{{ $community->posts_count ?? 0 }}</div>
                            <div class="text-xs text-neutral-500 font-medium">Posts</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-xs font-bold text-primary-600">
                                {{ $community->created_at->format('M Y') }}
                            </div>
                            <div class="text-xs text-neutral-500 font-medium">Created</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('community.show', $community->slug) }}" 
                           class="text-primary-600 hover:text-primary-700 font-bold text-sm flex items-center gap-2 interactive-btn">
                            <i class="fas fa-eye"></i>
                            View Community
                        </a>
                        
                        @if($isOwnProfile && !$isOwner && $userRole === 'member')
                        <button class="leave-community-btn text-red-600 hover:text-red-700 text-sm font-bold flex items-center gap-2 interactive-btn"
                                data-community-id="{{ $community->id }}"
                                data-leave-url="{{ route('communities.leave', $community) }}">
                            <i class="fas fa-sign-out-alt"></i>
                            Leave
                        </button>
                        @endif
                        
                        @if($isOwner)
                        <a href="{{ route('community.manage', $community->slug) }}" 
                           class="btn-primary px-4 py-2 rounded-duo text-sm font-bold">
                            <i class="fas fa-cog mr-1"></i>
                            Manage
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-2">
                    <div class="empty-state">
                        <div class="w-24 h-24 bg-gradient-to-r from-neutral-200 to-neutral-300 rounded-full flex items-center justify-center mx-auto mb-6 shadow-duo">
                            <i class="fas fa-users text-3xl text-neutral-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-600 mb-3">No communities yet</h3>
                        <p class="text-neutral-500 text-lg max-w-md mx-auto">
                            @if($isOwnProfile)
                                Start by joining communities or create your own to connect with others!
                            @else
                                {{ $user->name }} hasn't joined any communities yet.
                            @endif
                        </p>
                        @if($isOwnProfile)
                        <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('community.index') }}" class="btn-primary px-6 py-3 rounded-duo font-bold inline-flex items-center">
                                <i class="fas fa-compass mr-2"></i>Explore Communities
                            </a>
                            <a href="{{ route('community.create') }}" class="btn-secondary px-6 py-3 rounded-duo font-bold inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Create Community
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($communities->hasPages())
            <div class="mt-8">
                {{ $communities->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3 space-y-6">
            <!-- Community Statistics -->
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-chart-pie text-primary-500 mr-2"></i>
                    Community Stats
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Total Communities</span>
                        <span class="text-2xl font-bold text-primary-600">{{ $communities->total() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Communities Created</span>
                        <span class="text-2xl font-bold text-primary-600">{{ $ownedCommunitiesCount }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Communities Joined</span>
                        <span class="text-2xl font-bold text-primary-600">{{ $communities->total() - $ownedCommunitiesCount }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200">
                        <span class="text-neutral-700 font-bold">Total Members</span>
                        <span class="text-2xl font-bold text-primary-600">{{ $totalMembers }}</span>
                    </div>
                </div>
            </div>

            <!-- Community Types Distribution -->
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-layer-group text-primary-500 mr-2"></i>
                    Community Types
                </h3>
                <div class="space-y-3">
                    @php
                        $typeCounts = [
                            'public' => 0,
                            'private' => 0,
                            'restricted' => 0
                        ];
                        
                        foreach($communities as $community) {
                            $typeCounts[$community->type]++;
                        }
                    @endphp
                    
                    @foreach($typeCounts as $type => $count)
                    @if($count > 0)
                    <div class="flex items-center justify-between p-3 rounded-duo border-2 border-neutral-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full 
                                @if($type === 'public') bg-green-500
                                @elseif($type === 'private') bg-yellow-500
                                @else bg-red-500 @endif shadow-duo">
                            </div>
                            <span class="font-bold text-neutral-700 capitalize">{{ $type }}</span>
                        </div>
                        <span class="text-lg font-bold text-neutral-800">{{ $count }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card p-6 bg-gradient-to-br from-primary-50 to-secondary-50 border-2 border-primary-100">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-clock text-primary-500 mr-2"></i>
                    Recent Activity
                </h3>
                <div class="space-y-3">
                    @foreach($communities->take(5) as $recentCommunity)
                    <a href="{{ route('community.show', $recentCommunity->slug) }}" 
                       class="flex items-center gap-3 p-3 bg-white rounded-duo border-2 border-neutral-200 hover:border-primary-300 transition-all">
                        <div class="w-10 h-10 rounded-duo bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600 shadow-duo-pressed">
                            @if($recentCommunity->profile_image)
                                <img src="{{ asset('storage/' . $recentCommunity->profile_image) }}" 
                                     alt="{{ $recentCommunity->name }}" 
                                     class="w-full h-full rounded-duo object-cover">
                            @else
                                <i class="fas fa-users text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-neutral-800 text-sm truncate">
                                {{ $recentCommunity->name }}
                            </div>
                            <div class="text-xs text-neutral-500">
                                {{ $recentCommunity->members_count }} members
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            @if($isOwnProfile)
            <div class="card p-6">
                <h3 class="font-bold text-xl text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-primary-500 mr-2"></i>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('community.create') }}" 
                       class="w-full btn-primary py-3 px-4 rounded-duo font-bold flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        Create New Community
                    </a>
                    <a href="{{ route('community.index') }}" 
                       class="w-full btn-outline py-3 px-4 rounded-duo font-bold flex items-center justify-center gap-2">
                        <i class="fas fa-compass"></i>
                        Explore Communities
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filter functionality
    function setFilter(filter) {
        const url = new URL(window.location.href);
        url.searchParams.set('filter', filter);
        window.location.href = url.toString();
    }

    // Search functionality
    function searchCommunities(query) {
        const communityCards = document.querySelectorAll('.community-card');
        communityCards.forEach(card => {
            const communityName = card.querySelector('h3').textContent.toLowerCase();
            if (communityName.includes(query.toLowerCase())) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Leave community functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.leave-community-btn')) {
            const btn = e.target.closest('.leave-community-btn');
            const communityId = btn.dataset.communityId;
            const leaveUrl = btn.dataset.leaveUrl;
            
            if (confirm('Are you sure you want to leave this community? You will need to request to join again if it\'s a private community.')) {
                fetch(leaveUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Successfully left the community!', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error leaving community', 'error');
                });
            }
        }
    });

    // Add active class to current nav tab
    document.addEventListener('DOMContentLoaded', function() {
        const navTabs = document.querySelectorAll('.nav-tab');
        
        navTabs.forEach(tab => {
            if (tab.href === window.location.href) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });

        // Set active filter button
        const currentFilter = '{{ $filter }}';
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.textContent.trim().toLowerCase() === currentFilter) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Add Duolingo-style interactions
        document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline, .card, .community-card, .stat-item').forEach(element => {
            element.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary') || this.classList.contains('btn-outline')) {
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary') || this.classList.contains('btn-outline')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-secondary') || this.classList.contains('btn-outline')) {
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
        });
    });

    // Enhanced notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-duo shadow-lg text-white max-w-sm transform translate-x-full transition-transform duration-300 font-bold ${
            type === 'success' ? 'notification-success' :
            type === 'error' ? 'notification-error' :
            'bg-blue-500'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} mr-3 text-lg"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
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