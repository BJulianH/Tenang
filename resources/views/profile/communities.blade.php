@extends('layouts.app')

@section('title', $user->name . ' - Communities - MindWell Profile')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
    }
    
    .profile-stats {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .profile-avatar {
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .online-indicator {
        box-shadow: 0 0 0 3px white;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    
    .nav-tab {
        position: relative;
        transition: all 0.3s ease;
        border-bottom: 2px solid transparent;
    }
    
    .nav-tab:hover {
        color: #4f46e5;
    }
    
    .nav-tab.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }
    
    .community-card {
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
        background: white;
    }
    
    .community-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: #e2e8f0;
    }
    
    .community-avatar {
        border: 3px solid white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .type-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-weight: 600;
    }
    
    .type-public {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .type-private {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    
    .type-restricted {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    .role-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.6rem;
        border-radius: 0.75rem;
        font-weight: 600;
    }
    
    .role-admin {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
    }
    
    .role-moderator {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
    }
    
    .role-member {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    
    .empty-state {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 2px dashed #e2e8f0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }
    
    .stat-item {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .join-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .join-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .filter-btn {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    
    .filter-btn.active {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }
    
    .community-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Profile Header -->
    <div class="rounded-2xl overflow-hidden profile-header mb-8">
        <!-- Cover Image -->
        <div class="h-64 relative">
            @if($user->cover_image)
            <img src="{{ asset('storage/' . $user->cover_image) }}" alt="Cover image" class="w-full h-full object-cover">
            @endif
            
            <!-- Profile Stats Overlay -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="profile-stats rounded-2xl p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-6 flex-1">
                            <!-- Profile Image -->
                            <div class="relative">
                                <div class="w-20 h-20 rounded-full profile-avatar bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        {{ substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                                @if($user->is_online)
                                <div class="absolute bottom-2 right-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white online-indicator"></div>
                                @endif
                            </div>
                            
                            <!-- User Info -->
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-600">@{{ $user->username }}</p>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                    <span>{{ $communities->total() }} communities</span>
                                    <span>•</span>
                                    <span>{{ $totalMembers }} total members</span>
                                    <span>•</span>
                                    <span>{{ $ownedCommunitiesCount }} communities created</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            @if($isOwnProfile)
                            <a href="{{ route('profile.edit') }}" class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition-all font-semibold">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                            <a href="{{ route('community.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 transition-all font-semibold">
                                <i class="fas fa-plus mr-2"></i>Create Community
                            </a>
                            @else
                            <button class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition-all font-semibold">
                                <i class="fas fa-user-plus mr-2"></i>Follow
                            </button>
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 transition-all font-semibold">
                                <i class="fas fa-envelope mr-2"></i>Message
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Navigation Tabs -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8">
                <div class="flex space-x-1">
                    <a href="{{ route('profile.community', $user->username) }}" 
                       class="nav-tab flex-1 text-center py-4 px-2 font-semibold text-gray-700">
                        <i class="fas fa-file-alt mr-2"></i>Posts
                    </a>
                    <a href="{{ route('profile.comments', $user->username) }}" 
                       class="nav-tab flex-1 text-center py-4 px-2 font-semibold text-gray-700">
                        <i class="fas fa-comments mr-2"></i>Comments
                    </a>
                    <a href="{{ route('profile.communities', $user->username) }}" 
                       class="nav-tab flex-1 text-center py-4 px-2 font-semibold text-indigo-600 active">
                        <i class="fas fa-users mr-2"></i>Communities
                    </a>
                </div>
            </div>

            <!-- Communities Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Communities</h2>
                        <p class="text-gray-600 mt-1">
                            {{ $communities->total() }} communities • 
                            {{ $ownedCommunitiesCount }} created • 
                            {{ $communities->total() - $ownedCommunitiesCount }} joined
                        </p>
                    </div>
                    
                    <!-- Filters and Search -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <button class="filter-btn px-4 py-2 text-sm font-medium {{ $filter === 'all' ? 'active' : '' }}"
                                    onclick="setFilter('all')">
                                All
                            </button>
                            <button class="filter-btn px-4 py-2 text-sm font-medium {{ $filter === 'owned' ? 'active' : '' }}"
                                    onclick="setFilter('owned')">
                                Created
                            </button>
                            <button class="filter-btn px-4 py-2 text-sm font-medium {{ $filter === 'joined' ? 'active' : '' }}"
                                    onclick="setFilter('joined')">
                                Joined
                            </button>
                        </div>
                        
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Search communities..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64"
                                   onkeyup="searchCommunities(this.value)">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
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
                
                <div class="community-card rounded-2xl p-6">
                    <!-- Community Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl community-avatar bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold">
                                    @if($community->profile_image)
                                        <img src="{{ asset('storage/' . $community->profile_image) }}" 
                                             alt="{{ $community->name }}" 
                                             class="w-full h-full rounded-2xl object-cover">
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
                                <h3 class="font-bold text-lg text-gray-900 truncate">
                                    <a href="{{ route('community.show', $community->slug) }}" 
                                       class="hover:text-indigo-600 transition-colors">
                                        {{ $community->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="type-badge type-{{ $community->type }}">
                                        <i class="fas {{ $community->type === 'public' ? 'fa-globe' : ($community->type === 'private' ? 'fa-lock' : 'fa-shield-alt') }} mr-1"></i>
                                        {{ ucfirst($community->type) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $community->members_count }} members
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Community Description -->
                    @if($community->description)
                    <p class="community-description text-gray-600 mb-4 text-sm">
                        {{ $community->description }}
                    </p>
                    @endif

                    <!-- Community Stats -->
                    <div class="stats-grid mb-4">
                        <div class="stat-item">
                            <div class="text-2xl font-bold text-indigo-600">{{ $community->members_count }}</div>
                            <div class="text-xs text-gray-500">Members</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-2xl font-bold text-indigo-600">{{ $community->posts_count ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Posts</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-2xl font-bold text-indigo-600">
                                {{ $community->created_at->format('M Y') }}
                            </div>
                            <div class="text-xs text-gray-500">Created</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('community.show', $community->slug) }}" 
                           class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-2">
                            <i class="fas fa-eye"></i>
                            View Community
                        </a>
                        
                        @if($isOwnProfile && !$isOwner && $userRole === 'member')
                        <button class="leave-community-btn text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-2"
                                data-community-id="{{ $community->id }}"
                                data-leave-url="{{ route('communities.leave', $community) }}">
                            <i class="fas fa-sign-out-alt"></i>
                            Leave
                        </button>
                        @endif
                        
                        @if($isOwner)
                        <a href="{{ route('community.manage', $community->slug) }}" 
                           class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition-all text-sm font-medium">
                            <i class="fas fa-cog mr-1"></i>
                            Manage
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-2">
                    <div class="empty-state rounded-2xl p-12 text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-600 mb-3">No communities yet</h3>
                        <p class="text-gray-500 text-lg max-w-md mx-auto">
                            @if($isOwnProfile)
                                Start by joining communities or create your own to connect with others!
                            @else
                                {{ $user->name }} hasn't joined any communities yet.
                            @endif
                        </p>
                        @if($isOwnProfile)
                        <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('community.explore') }}" class="inline-flex items-center bg-indigo-500 text-white px-6 py-3 rounded-xl hover:bg-indigo-600 transition-all font-semibold">
                                <i class="fas fa-compass mr-2"></i>Explore Communities
                            </a>
                            <a href="{{ route('community.create') }}" class="inline-flex items-center bg-green-500 text-white px-6 py-3 rounded-xl hover:bg-green-600 transition-all font-semibold">
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-pie text-indigo-500 mr-3"></i>
                    Community Stats
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Total Communities</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ $communities->total() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Communities Created</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ $ownedCommunitiesCount }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Communities Joined</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ $communities->total() - $ownedCommunitiesCount }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Total Members</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ $totalMembers }}</span>
                    </div>
                </div>
            </div>

            <!-- Community Types Distribution -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-layer-group text-indigo-500 mr-3"></i>
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
                    <div class="flex items-center justify-between p-3 rounded-lg border">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full 
                                @if($type === 'public') bg-green-500
                                @elseif($type === 'private') bg-yellow-500
                                @else bg-red-500 @endif">
                            </div>
                            <span class="font-medium text-gray-700 capitalize">{{ $type }}</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ $count }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm border border-indigo-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock text-indigo-500 mr-3"></i>
                    Recent Activity
                </h3>
                <div class="space-y-3">
                    @foreach($communities->take(5) as $recentCommunity)
                    <a href="{{ route('community.show', $recentCommunity->slug) }}" 
                       class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600">
                            @if($recentCommunity->profile_image)
                                <img src="{{ asset('storage/' . $recentCommunity->profile_image) }}" 
                                     alt="{{ $recentCommunity->name }}" 
                                     class="w-full h-full rounded-xl object-cover">
                            @else
                                <i class="fas fa-users text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-900 text-sm truncate">
                                {{ $recentCommunity->name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $recentCommunity->members_count }} members
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            @if($isOwnProfile)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-indigo-500 mr-3"></i>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('community.create') }}" 
                       class="w-full bg-indigo-500 text-white py-3 px-4 rounded-xl hover:bg-indigo-600 transition-all font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        Create New Community
                    </a>
                    <a href="{{ route('community.explore') }}" 
                       class="w-full border border-indigo-500 text-indigo-600 py-3 px-4 rounded-xl hover:bg-indigo-50 transition-all font-semibold flex items-center justify-center gap-2">
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
        // This would typically make an API call or filter client-side
        // For now, we'll just log the query
        console.log('Searching for:', query);
        
        // You can implement client-side filtering or make an API call here
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
                        // Reload page to reflect changes
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
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl shadow-lg text-white max-w-sm transform translate-x-full transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 shadow-green-200' :
            type === 'error' ? 'bg-red-500 shadow-red-200' :
            'bg-blue-500 shadow-blue-200'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} text-lg"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-0');
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