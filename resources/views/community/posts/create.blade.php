{{-- resources/views/community/posts/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Post - MindWell')

@section('styles')
<style>
    .mood-option {
        transition: all 0.3s ease;
    }
    .mood-option:hover {
        transform: scale(1.05);
    }
    .mood-option.selected {
        border-color: #4caf50;
        background-color: #f0f9f0;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl card-shadow p-6">
        <h1 class="text-2xl font-bold text-neutral-800 mb-6">Create New Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="create-post-form">
            @csrf
            
            <!-- Community Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-neutral-700 mb-2">Post to Community</label>
                <select name="community_id" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Select a community...</option>
                    @foreach(auth()->user()->communities as $community)
                        <option value="{{ $community->id }}">{{ $community->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-neutral-700 mb-2">Title</label>
                <input type="text" name="title" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="What's on your mind?" required>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-neutral-700 mb-2">Content</label>
                <textarea name="content" rows="6" class="w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Share your thoughts, experiences, or ask for support..." required></textarea>
            </div>

            <!-- Mood Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-neutral-700 mb-3">How are you feeling?</label>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                    @foreach(['happy' => '😊', 'calm' => '😌', 'anxious' => '😰', 'sad' => '😢', 'angry' => '😠', 'neutral' => '😐'] as $mood => $emoji)
                    <label class="mood-option border-2 border-neutral-200 rounded-lg p-3 text-center cursor-pointer transition-all">
                        <input type="radio" name="mood" value="{{ $mood }}" class="hidden">
                        <div class="text-2xl mb-1">{{ $emoji }}</div>
                        <div class="text-sm text-neutral-600 capitalize">{{ $mood }}</div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-neutral-700 mb-2">Add Image (Optional)</label>
                <div class="border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center">
                    <i class="fas fa-cloud-upload-alt text-3xl text-neutral-400 mb-2"></i>
                    <p class="text-neutral-500 mb-2">Drag & drop an image or click to browse</p>
                    <input type="file" name="image" id="image-upload" class="hidden" accept="image/*">
                    <button type="button" onclick="document.getElementById('image-upload').click()" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                        Choose Image
                    </button>
                    <div id="image-preview" class="mt-3 hidden">
                        <img id="preview-img" class="max-h-48 mx-auto rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Privacy Options -->
            <div class="mb-6">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_anonymous" id="anonymous" class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                    <label for="anonymous" class="text-sm text-neutral-700">Post anonymously</label>
                </div>
                <div class="flex items-center space-x-3 mt-2">
                    <input type="checkbox" name="is_support_request" id="support-request" class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                    <label for="support-request" class="text-sm text-neutral-700">This is a support request</label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('community.index') }}" class="px-6 py-2 border border-neutral-300 text-neutral-700 rounded-lg hover:bg-neutral-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Mood selection
    document.querySelectorAll('.mood-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.mood-option').forEach(opt => {
                opt.classList.remove('selected', 'border-primary-500');
            });
            this.classList.add('selected', 'border-primary-500');
            this.querySelector('input').checked = true;
        });
    });

    // Image preview
    document.getElementById('image-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection