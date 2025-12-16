@extends('layouts.app')

@section('title', 'Task Templates - Tenang')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Task Templates</h1>
            <p class="text-neutral-600 mt-1">Buat dan kelola template untuk tugas berulang</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('task-templates.create') }}" class="app-button flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Buat Template Baru</span>
            </a>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($templates as $template)
            <div class="card p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-lg text-neutral-800">{{ $template->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs px-2 py-1 rounded-full bg-primary-100 text-primary-800">
                                {{ $template->category_name }}
                            </span>
                            @if($template->is_public)
                                <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-globe mr-1"></i> Public
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-neutral-500">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                            {{ $template->usage_count }}
                        </span>
                    </div>
                </div>
                
                @if($template->description)
                    <p class="text-neutral-600 text-sm mb-4">{{ $template->description }}</p>
                @endif
                
                <div class="space-y-2 mb-4">
                    @if($template->estimated_duration)
                        <div class="flex items-center text-sm text-neutral-600">
                            <i class="fas fa-clock mr-2 w-5"></i>
                            <span>{{ $template->duration_hours }}</span>
                        </div>
                    @endif
                    
                    @if($template->energy_level_required)
                        <div class="flex items-center text-sm text-neutral-600">
                            <i class="fas fa-bolt mr-2 w-5"></i>
                            <span>Energy: {{ $template->energy_level_required }}/5</span>
                        </div>
                    @endif
                    
                    @if($template->difficulty_level)
                        <div class="flex items-center text-sm text-neutral-600">
                            <i class="fas fa-chart-line mr-2 w-5"></i>
                            <span>Difficulty: {{ $template->difficulty_level }}/5</span>
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t border-neutral-200">
                    <div class="text-xs text-neutral-500">
                        @if($template->user_id === auth()->id())
                            Template pribadi
                        @else
                            Oleh: {{ $template->user->name ?? 'User' }}
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        <form action="{{ route('task-templates.create-task', $template) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full hover:bg-green-200">
                                <i class="fas fa-plus mr-1"></i> Buat Task
                            </button>
                        </form>
                        
                        @if($template->user_id === auth()->id())
                            <a href="{{ route('task-templates.edit', $template) }}" 
                               class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($templates->hasPages())
        <div class="mt-8">
            {{ $templates->links() }}
        </div>
    @endif
</div>
@endsection