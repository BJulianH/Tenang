@extends('layouts.admin')

@section('title', 'Post Management - Tenang Admin')
@section('page_title', 'Post Management')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Posts</p>
                    <p class="text-3xl font-bold text-primary-600">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-primary-100 rounded-lg">
                    <i class="fas fa-file-alt text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Today</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['published_today'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Support Requests</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['support_requests'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-hands-helping text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Anonymous</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['anonymous'] }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-user-secret text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_approval'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions & Search -->
    <div class="bg-white rounded-lg p-6 card-shadow">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Bulk Actions -->
            <div class="flex items-center space-x-4">
                <select id="bulk-action" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Bulk Actions</option>
                    <option value="approve">Approve</option>
                    <option value="disapprove">Disapprove</option>
                    <option value="feature">Feature</option>
                    <option value="unfeature">Unfeature</option>
                    <option value="delete">Delete</option>
                </select>
                <button id="apply-bulk-action" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                    Apply
                </button>
            </div>

            <!-- Search -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search posts..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                
                <select id="filter-status" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="featured">Featured</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Post
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Author
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Community
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stats
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="post_ids[]" value="{{ $post->id }}" 
                                   class="post-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-start space-x-3">
                                @if($post->image)
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ $post->image }}" alt="Post image" class="h-12 w-12 object-cover">
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 line-clamp-2">
                                        {{ $post->title ?: Str::limit(strip_tags($post->content), 60) }}
                                    </p>
                                    @if($post->mood)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                        {{ $post->mood_with_icon ?? $post->mood }}
                                    </span>
                                    @endif
                                    @if($post->is_support_request)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1 ml-1">
                                        <i class="fas fa-hands-helping mr-1"></i>Support
                                    </span>
                                    @endif
                                    @if($post->is_anonymous)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1 ml-1">
                                        <i class="fas fa-user-secret mr-1"></i>Anonymous
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($post->user->profile_image)
                                    <img class="h-8 w-8 rounded-full mr-2" src="{{ $post->user->profile_image }}" alt="{{ $post->user->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold text-sm mr-2">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                                    <p class="text-xs text-gray-500">@{{ $post->user->username }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->community)
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                {{ $post->community->name }}
                            </span>
                            @else
                            <span class="text-xs text-gray-500">No Community</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-3">
                                <span class="flex items-center" title="Upvotes">
                                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                                    {{ $post->upvotes_count }}
                                </span>
                                <span class="flex items-center" title="Downvotes">
                                    <i class="fas fa-arrow-down text-red-500 mr-1"></i>
                                    {{ $post->downvotes_count }}
                                </span>
                                <span class="flex items-center" title="Comments">
                                    <i class="fas fa-comment text-blue-500 mr-1"></i>
                                    {{ $post->comments_count }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @if($post->is_approved)
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Approved
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    Pending
                                </span>
                                @endif
                                
                                @if($post->is_featured)
                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                    Featured
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.posts.show', $post) }}" 
                                   class="text-primary-600 hover:text-primary-900 transition-colors"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(!$post->is_approved)
                                <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-900 transition-colors"
                                            title="Approve Post">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.posts.disapprove', $post) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-yellow-600 hover:text-yellow-900 transition-colors"
                                            title="Disapprove Post">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                                
                                @if(!$post->is_featured)
                                <form action="{{ route('admin.posts.feature', $post) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-purple-600 hover:text-purple-900 transition-colors"
                                            title="Feature Post">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.posts.unfeature', $post) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-gray-600 hover:text-gray-900 transition-colors"
                                            title="Unfeature Post">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors"
                                            title="Delete Post">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All Checkbox
    const selectAll = document.getElementById('select-all');
    const postCheckboxes = document.querySelectorAll('.post-checkbox');
    
    selectAll.addEventListener('change', function() {
        postCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk Actions
    const bulkAction = document.getElementById('bulk-action');
    const applyBulkAction = document.getElementById('apply-bulk-action');
    
    applyBulkAction.addEventListener('click', function() {
        const action = bulkAction.value;
        const selectedPosts = Array.from(postCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (!action) {
            alert('Please select an action.');
            return;
        }

        if (selectedPosts.length === 0) {
            alert('Please select at least one post.');
            return;
        }

        if (action === 'delete' && !confirm('Are you sure you want to delete the selected posts? This action cannot be undone.')) {
            return;
        }

        // Submit bulk action form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.posts.bulk-action") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        form.appendChild(actionInput);

        selectedPosts.forEach(postId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'post_ids[]';
            input.value = postId;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    });

    // Search functionality
    const searchInput = document.getElementById('search-input');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = this.value.trim();
            if (query.length >= 2 || query.length === 0) {
                window.location.href = '{{ route("admin.posts.index") }}?q=' + encodeURIComponent(query);
            }
        }, 500);
    });
});
</script>
@endpush