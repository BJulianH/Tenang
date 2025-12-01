@extends('layouts.admin')

@section('title', 'Create Community - Tenang Admin')
@section('page_title', 'Create New Community')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Create New Community</h3>
        </div>

        <form action="{{ route('admin.communities.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Basic Information -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Community Name *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                                   placeholder="Enter community name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="creator_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Creator *
                            </label>
                            <select id="creator_id" name="creator_id" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('creator_id') border-red-500 @enderror">
                                <option value="">Select Creator</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('creator_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} (@{{ $user->username }})
                                </option>
                                @endforeach
                            </select>
                            @error('creator_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                  placeholder="Describe the purpose of this community">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Community Settings -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Community Settings</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Community Type *
                            </label>
                            <select id="type" name="type" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror">
                                <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Private</option>
                                <option value="restricted" {{ old('type') == 'restricted' ? 'selected' : '' }}>Restricted</option>
                            </select>
                            <div class="mt-2 text-sm text-gray-500">
                                <p><strong>Public:</strong> Anyone can join and post</p>
                                <p><strong>Private:</strong> Approval required to join</p>
                                <p><strong>Restricted:</strong> Anyone can view, but only approved members can post</p>
                            </div>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Parent Community (Optional)
                            </label>
                            <select id="parent_id" name="parent_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_id') border-red-500 @enderror">
                                <option value="">No Parent (Main Community)</option>
                                @foreach($mainCommunities as $mainCommunity)
                                <option value="{{ $mainCommunity->id }}" {{ old('parent_id') == $mainCommunity->id ? 'selected' : '' }}>
                                    {{ $mainCommunity->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_main" value="1" 
                                   {{ old('is_main', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                   id="is_main_checkbox">
                            <span class="ml-2 text-sm text-gray-700">This is a main community</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">
                            Main communities can have sub-communities. If you select a parent community, this will automatically become a sub-community.
                        </p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.communities.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Create Community
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const parentSelect = document.getElementById('parent_id');
    const isMainCheckbox = document.getElementById('is_main_checkbox');
    
    parentSelect.addEventListener('change', function() {
        if (this.value) {
            isMainCheckbox.checked = false;
            isMainCheckbox.disabled = true;
        } else {
            isMainCheckbox.disabled = false;
        }
    });
    
    // Initialize state on page load
    if (parentSelect.value) {
        isMainCheckbox.checked = false;
        isMainCheckbox.disabled = true;
    }
});
</script>
@endpush