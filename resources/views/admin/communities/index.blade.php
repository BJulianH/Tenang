@extends('layouts.admin')

@section('title', 'Community Management - MindWell Admin')
@section('page_title', 'Community Management')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Communities</p>
                    <p class="text-3xl font-bold text-primary-600">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-primary-100 rounded-lg">
                    <i class="fas fa-users text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Main Communities</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['main_communities'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-home text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Sub-Communities</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['sub_communities'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-folder text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Active Today</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['active_today'] }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-bolt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Members</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['total_members'] }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-user-friends text-orange-600 text-xl"></i>
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
                    <option value="make_main">Make Main</option>
                    <option value="make_sub">Make Sub</option>
                    <option value="change_type">Change Type</option>
                    <option value="delete">Delete</option>
                </select>
                <select id="type-select" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 hidden">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                    <option value="restricted">Restricted</option>
                </select>
                <button id="apply-bulk-action" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                    Apply
                </button>
            </div>

            <!-- Create Button & Search -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.communities.create') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create Community
                </a>
                
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search communities..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Communities Table -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Community
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stats
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($communities as $community)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="community_ids[]" value="{{ $community->id }}" 
                                   class="community-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if($community->profile_image)
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $community->profile_image }}" alt="{{ $community->name }}">
                                </div>
                                @else
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-primary-400 to-secondary-400 flex items-center justify-center text-white font-bold">
                                    {{ substr($community->name, 0, 1) }}
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $community->name }}
                                        @if($community->parent)
                                        <span class="text-xs text-gray-500 ml-1">({{ $community->parent->name }})</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 line-clamp-1">
                                        {{ $community->description ?: 'No description' }}
                                    </div>
                                    <div class="flex items-center space-x-2 mt-1">
                                        @if($community->is_main)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Main
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Sub-Community
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($community->creator->profile_image)
                                    <img class="h-8 w-8 rounded-full mr-2" src="{{ $community->creator->profile_image }}" alt="{{ $community->creator->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold text-sm mr-2">
                                        {{ substr($community->creator->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $community->creator->name }}</p>
                                    <p class="text-xs text-gray-500">@{{ $community->creator->username }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.communities.update', $community) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="type" onchange="this.form.submit()" 
                                        class="text-xs font-medium rounded-full px-3 py-1 border-0 focus:ring-2 focus:ring-primary-500 
                                        {{ $community->type === 'public' ? 'bg-green-100 text-green-800' : 
                                           ($community->type === 'private' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    <option value="public" {{ $community->type === 'public' ? 'selected' : '' }}>Public</option>
                                    <option value="private" {{ $community->type === 'private' ? 'selected' : '' }}>Private</option>
                                    <option value="restricted" {{ $community->type === 'restricted' ? 'selected' : '' }}>Restricted</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-4">
                                <span class="flex items-center" title="Members">
                                    <i class="fas fa-users text-gray-400 mr-1"></i>
                                    {{ $community->members_count }}
                                </span>
                                <span class="flex items-center" title="Posts">
                                    <i class="fas fa-file-alt text-gray-400 mr-1"></i>
                                    {{ $community->posts_count }}
                                </span>
                                <span class="flex items-center" title="Sub-communities">
                                    <i class="fas fa-folder text-gray-400 mr-1"></i>
                                    {{ $community->children_count }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.communities.update', $community) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="{{ $community->is_active ? 0 : 1 }}">
                                <button type="submit" class="text-xs font-medium rounded-full px-3 py-1 
                                    {{ $community->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $community->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $community->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">
                                {{ $community->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.communities.show', $community) }}" 
                                   class="text-primary-600 hover:text-primary-900 transition-colors"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('admin.communities.members', $community) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors"
                                   title="Manage Members">
                                    <i class="fas fa-user-friends"></i>
                                </a>

                                <form action="{{ route('admin.communities.destroy', $community) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this community? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors"
                                            title="Delete Community">
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
            {{ $communities->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All Checkbox
    const selectAll = document.getElementById('select-all');
    const communityCheckboxes = document.querySelectorAll('.community-checkbox');
    
    selectAll.addEventListener('change', function() {
        communityCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk Actions
    const bulkAction = document.getElementById('bulk-action');
    const typeSelect = document.getElementById('type-select');
    const applyBulkAction = document.getElementById('apply-bulk-action');
    
    bulkAction.addEventListener('change', function() {
        if (this.value === 'change_type') {
            typeSelect.classList.remove('hidden');
        } else {
            typeSelect.classList.add('hidden');
        }
    });
    
    applyBulkAction.addEventListener('click', function() {
        const action = bulkAction.value;
        const selectedCommunities = Array.from(communityCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (!action) {
            alert('Please select an action.');
            return;
        }

        if (selectedCommunities.length === 0) {
            alert('Please select at least one community.');
            return;
        }

        if (action === 'delete' && !confirm('Are you sure you want to delete the selected communities? This action cannot be undone.')) {
            return;
        }

        // Submit bulk action form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.communities.bulk-action") }}';
        
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

        if (action === 'change_type') {
            const typeInput = document.createElement('input');
            typeInput.type = 'hidden';
            typeInput.name = 'type';
            typeInput.value = typeSelect.value;
            form.appendChild(typeInput);
        }

        selectedCommunities.forEach(communityId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'community_ids[]';
            input.value = communityId;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    });
});
</script>
@endpush