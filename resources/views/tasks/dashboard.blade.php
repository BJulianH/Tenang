@extends('layouts.app')

@section('title', 'Dashboard Todo - Tenang')

@section('styles')
<style>
    /* Task styles */
    .task-checkbox {
        width: 24px;
        height: 24px;
        border: 3px solid #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .task-checkbox:hover {
        border-color: #58cc70;
        transform: scale(1.1);
    }
    
    .task-checkbox.checked {
        background-color: #58cc70;
        border-color: #45b259;
    }
    
    .task-checkbox.checked i {
        display: block;
    }
    
    .task-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    
    .task-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    
    .task-item.completed {
        opacity: 0.7;
        background: linear-gradient(135deg, #f0f9f0, #e8f5e8);
    }
    
    .task-item.overdue {
        border-left-color: #dc2626;
        animation: pulse 2s infinite;
    }
    
    .task-item.due-today {
        border-left-color: #f59e0b;
    }
    
    .priority-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    
    .priority-urgent { background-color: #dc2626; }
    .priority-high { background-color: #ea580c; }
    .priority-medium { background-color: #2563eb; }
    .priority-low { background-color: #16a34a; }
    
    /* Category badges */
    .category-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(255,255,255,0.9);
    }
    
    /* Mood indicators */
    .mood-indicator {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .mood-1 { background-color: #ef4444; color: white; }
    .mood-2 { background-color: #f97316; color: white; }
    .mood-3 { background-color: #eab308; color: black; }
    .mood-4 { background-color: #22c55e; color: white; }
    .mood-5 { background-color: #3b82f6; color: white; }
    
    /* Matrix quadrants */
    .quadrant-box {
        border-radius: 16px;
        padding: 1.5rem;
        min-height: 180px;
        transition: all 0.3s ease;
        border: 3px solid transparent;
        position: relative;
        overflow: hidden;
    }
    
    .quadrant-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: currentColor;
        opacity: 0.3;
    }
    
    .quadrant-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .quadrant-1 {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.2), rgba(254, 202, 202, 0.1));
        border-color: #f87171;
        color: #dc2626;
    }
    
    .quadrant-2 {
        background: linear-gradient(135deg, rgba(220, 252, 231, 0.2), rgba(187, 247, 208, 0.1));
        border-color: #4ade80;
        color: #16a34a;
    }
    
    .quadrant-3 {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.2), rgba(253, 230, 138, 0.1));
        border-color: #fbbf24;
        color: #ea580c;
    }
    
    .quadrant-4 {
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.2), rgba(199, 210, 254, 0.1));
        border-color: #818cf8;
        color: #2563eb;
    }
    
    /* Progress bars */
    .progress-container {
        width: 100%;
        height: 8px;
        background: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #58cc70, #45b259);
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    /* Stats cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 0 rgba(0,0,0,0.1);
        border: 3px solid #f1f3f4;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 0 rgba(0,0,0,0.1);
    }
    
    /* Streak animation */
    .streak-fire {
        animation: flame 1.5s infinite alternate;
    }
    
    @keyframes flame {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.2); opacity: 1; }
    }
    
    /* Quick add button */
    .quick-add-btn {
        background: linear-gradient(135deg, #58cc70, #45b259);
        color: white;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 0 rgba(69, 178, 89, 0.3);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: bold;
    }
    
    .quick-add-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 0 rgba(69, 178, 89, 0.3);
        background: linear-gradient(135deg, #45b259, #339847);
    }
    
    .quick-add-btn:active {
        transform: translateY(1px);
        box-shadow: 0 2px 0 rgba(69, 178, 89, 0.3);
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    /* Category icons */
    .category-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 0.75rem;
    }
    
    /* Time badges */
    .time-badge {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 12px;
        background: rgba(0,0,0,0.05);
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    /* Subtask indicator */
    .subtask-indicator {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 12px;
        background: rgba(88, 204, 112, 0.1);
        color: #45b259;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    /* Animation for new tasks */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-in {
        animation: slideIn 0.3s ease-out forwards;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .quadrant-box {
            min-height: 150px;
        }
        
        .stat-card {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-2 border-green-400 text-green-700 rounded-duo animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                    @if(session('points'))
                        <p class="text-sm mt-1 opacity-90">+{{ session('points') }} points!</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border-2 border-red-400 text-red-700 rounded-duo animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-800">Todo List</h1>
                <p class="text-neutral-600 mt-2">Kelola tugas harianmu untuk kesehatan mental yang lebih baik</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="showQuickAddModal()" class="quick-add-btn">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Task</span>
                </button>
                <a href="{{ route('templates.index') }}" class="app-button app-button-secondary flex items-center justify-center gap-2">
                    <i class="fas fa-layer-group"></i>
                    <span>Templates</span>
                </a>
            </div>
        </div>
        
        <!-- Date Display -->
        <div class="mt-4 p-3 bg-primary-50 rounded-duo inline-flex items-center gap-3">
            <i class="fas fa-calendar-day text-primary-600"></i>
            <span class="font-medium text-primary-800">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
            @if($overdueCount > 0)
                <span class="bg-red-100 text-red-700 text-sm px-3 py-1 rounded-full font-bold animate-pulse">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    {{ $overdueCount }} tugas tertunda
                </span>
            @endif
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-600 mb-1">Tugas Hari Ini</p>
                    <h3 class="text-2xl font-bold text-neutral-800">{{ $todayTasks->count() }}</h3>
                    <p class="text-xs text-neutral-500 mt-1">{{ $completedToday }} selesai</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-tasks text-primary-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="progress-container">
                    <div class="progress-fill" style="width: {{ $todayTasks->count() > 0 ? round(($completedToday / $todayTasks->count()) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-600 mb-1">Total Tugas</p>
                    <h3 class="text-2xl font-bold text-neutral-800">{{ $statistics['total'] }}</h3>
                    <p class="text-xs text-neutral-500 mt-1">{{ $statistics['completed'] }} selesai</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="progress-container">
                    <div class="progress-fill" style="width: {{ $statistics['completion_rate'] }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-600 mb-1">Streak</p>
                    <h3 class="text-2xl font-bold text-neutral-800">{{ $statistics['streak'] }} hari</h3>
                    <p class="text-xs text-neutral-500 mt-1">Jaga streak-mu!</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-fire streak-fire text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-sm text-neutral-600">
                    @if($statistics['streak'] >= 7)
                        <span class="text-green-600 font-bold">🔥 Streak impresif!</span>
                    @elseif($statistics['streak'] >= 3)
                        <span class="text-yellow-600 font-bold">🔥 Pertahankan!</span>
                    @else
                        <span class="text-neutral-600">Mulai streak baru</span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-600 mb-1">Points Earned</p>
                    <h3 class="text-2xl font-bold text-neutral-800">{{ $statistics['points'] ?? 0 }}</h3>
                    <p class="text-xs text-neutral-500 mt-1">Total points</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-sm text-neutral-600">
                    <i class="fas fa-trophy text-yellow-500 mr-1"></i>
                    Level {{ auth()->user()->level ?? 1 }}
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Today's Tasks -->
        <div class="lg:col-span-2">
            <!-- Today's Tasks Section -->
            <div class="card overflow-hidden">
                <div class="p-4 border-b-2 border-neutral-200 bg-gradient-to-r from-primary-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-duo flex items-center justify-center">
                                <i class="fas fa-sun text-primary-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-neutral-800">Tugas Hari Ini</h2>
                                <p class="text-sm text-neutral-600">Fokus pada tugas yang harus diselesaikan hari ini</p>
                            </div>
                        </div>
                        <span class="bg-primary-100 text-primary-800 text-sm font-bold px-3 py-1 rounded-full">
                            {{ $todayTasks->count() }} tugas
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    @if($todayTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($todayTasks as $task)
                                @php
                                    $isOverdue = $task->due_date && $task->due_date->isPast() && !in_array($task->status, ['completed', 'cancelled']);
                                    $isDueToday = $task->due_date && $task->due_date->isToday();
                                    $taskClasses = ['task-item', 'card', 'p-4'];
                                    if($task->status === 'completed') $taskClasses[] = 'completed';
                                    if($isOverdue) $taskClasses[] = 'overdue';
                                    elseif($isDueToday) $taskClasses[] = 'due-today';
                                @endphp
                                
                                <div class="{{ implode(' ', $taskClasses) }}">
                                    <div class="flex items-start gap-3">
                                        <!-- Checkbox -->
                                        <form action="{{ route('tasks.complete', $task) }}" method="POST" class="flex-shrink-0">
                                            @csrf
                                            <button type="button" onclick="completeTask(this)" 
                                                    class="task-checkbox {{ $task->status === 'completed' ? 'checked' : '' }}"
                                                    data-task-id="{{ $task->id }}"
                                                    data-task-title="{{ $task->title }}">
                                                @if($task->status === 'completed')
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <!-- Task Content -->
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4 class="font-medium text-neutral-800 {{ $task->status === 'completed' ? 'line-through' : '' }}">
                                                        {{ $task->title }}
                                                    </h4>
                                                    
                                                    <div class="flex items-center gap-2 mt-2">
                                                        <!-- Priority -->
                                                        <span class="priority-dot priority-{{ $task->priority }}"></span>
                                                        <span class="text-xs font-medium text-neutral-600">
                                                            {{ ucfirst($task->priority) }}
                                                        </span>
                                                        
                                                        <!-- Category -->
                                                        <span class="category-badge">
                                                            <span class="text-sm">{{ $task->category_icon }}</span>
                                                            <span>{{ $task->category_name }}</span>
                                                        </span>
                                                        
                                                        <!-- Time -->
                                                        @if($task->due_time)
                                                            <span class="time-badge">
                                                                <i class="far fa-clock"></i>
                                                                {{ $task->due_time->format('H:i') }}
                                                            </span>
                                                        @endif
                                                        
                                                        <!-- Subtask indicator -->
                                                        @if($task->subtasks->count() > 0)
                                                            @php
                                                                $completedSubtasks = $task->subtasks->where('status', 'completed')->count();
                                                            @endphp
                                                            <span class="subtask-indicator">
                                                                <i class="fas fa-list-check"></i>
                                                                {{ $completedSubtasks }}/{{ $task->subtasks->count() }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Action buttons -->
                                                <div class="flex items-center gap-1">
                                                    @if($task->is_important)
                                                        <span class="text-yellow-500" title="Penting">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    @endif
                                                    @if($task->is_urgent)
                                                        <span class="text-red-500" title="Mendesak">
                                                            <i class="fas fa-exclamation"></i>
                                                        </span>
                                                    @endif
                                                    <a href="{{ route('tasks.show', $task) }}" 
                                                       class="text-neutral-400 hover:text-primary-600 p-1 rounded-full hover:bg-primary-50">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <!-- Description -->
                                            @if($task->description)
                                                <p class="text-sm text-neutral-600 mt-2 line-clamp-2">
                                                    {{ $task->description }}
                                                </p>
                                            @endif
                                            
                                            <!-- Tags -->
                                            @if($task->tags)
                                                <div class="flex flex-wrap gap-1 mt-2">
                                                    @foreach(json_decode($task->tags, true) as $tag)
                                                        <span class="text-xs bg-neutral-100 text-neutral-600 px-2 py-1 rounded-full">
                                                            {{ $tag }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            <!-- Quick Actions -->
                                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-neutral-100">
                                                <div class="text-xs text-neutral-500">
                                                    @if($task->created_at->isToday())
                                                        Ditambahkan hari ini
                                                    @else
                                                        Ditambahkan {{ $task->created_at->diffForHumans() }}
                                                    @endif
                                                </div>
                                                
                                                <div class="flex gap-1">
                                                    <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium hover:bg-green-200 transition-colors">
                                                            <i class="fas fa-check mr-1"></i>Selesai
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('tasks.edit', $task) }}" 
                                                       class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium hover:bg-blue-200 transition-colors">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state py-8">
                            <div class="empty-state-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h3 class="text-lg font-medium text-neutral-700 mb-2">Tidak ada tugas hari ini</h3>
                            <p class="text-neutral-600 mb-4">Waktunya untuk bersantai atau tambah tugas baru!</p>
                            <button onclick="showQuickAddModal()" class="quick-add-btn">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Task Pertama</span>
                            </button>
                        </div>
                    @endif
                </div>
                
                @if($todayTasks->count() > 0)
                    <div class="p-4 border-t border-neutral-200 bg-neutral-50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-neutral-600">
                                <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                                Tips: Selesaikan 3 tugas hari ini untuk mendapatkan bonus streak!
                            </div>
                            <a href="{{ route('tasks.today') }}" class="text-primary-600 font-medium hover:text-primary-700 text-sm">
                                Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Quick Actions & Insights -->
        <div class="space-y-6">
            <!-- Eisenhower Matrix Preview -->
            <div class="card">
                <div class="p-4 border-b-2 border-neutral-200">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center gap-2">
                        <i class="fas fa-th-large text-purple-600"></i>
                        Eisenhower Matrix
                    </h2>
                    <p class="text-sm text-neutral-600 mt-1">Prioritaskan tugasmu</p>
                </div>
                
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('tasks.matrix') }}" class="quadrant-box quadrant-1">
                            <div class="font-bold text-lg mb-1">Penting & Mendesak</div>
                            <div class="text-2xl font-bold">{{ $matrixCounts['important_urgent'] }}</div>
                            <div class="text-sm opacity-75 mt-1">tugas</div>
                            <div class="absolute bottom-3 right-3 opacity-20">
                                <i class="fas fa-bolt text-2xl"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('tasks.matrix') }}" class="quadrant-box quadrant-2">
                            <div class="font-bold text-lg mb-1">Penting & Tidak Mendesak</div>
                            <div class="text-2xl font-bold">{{ $matrixCounts['important_not_urgent'] }}</div>
                            <div class="text-sm opacity-75 mt-1">tugas</div>
                            <div class="absolute bottom-3 right-3 opacity-20">
                                <i class="fas fa-calendar-alt text-2xl"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('tasks.matrix') }}" class="quadrant-box quadrant-3">
                            <div class="font-bold text-lg mb-1">Tidak Penting & Mendesak</div>
                            <div class="text-2xl font-bold">{{ $matrixCounts['not_important_urgent'] }}</div>
                            <div class="text-sm opacity-75 mt-1">tugas</div>
                            <div class="absolute bottom-3 right-3 opacity-20">
                                <i class="fas fa-share-alt text-2xl"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('tasks.matrix') }}" class="quadrant-box quadrant-4">
                            <div class="font-bold text-lg mb-1">Tidak Penting & Tidak Mendesak</div>
                            <div class="text-2xl font-bold">{{ $matrixCounts['not_important_not_urgent'] }}</div>
                            <div class="text-sm opacity-75 mt-1">tugas</div>
                            <div class="absolute bottom-3 right-3 opacity-20">
                                <i class="fas fa-ban text-2xl"></i>
                            </div>
                        </a>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('tasks.matrix') }}" class="text-primary-600 font-medium hover:text-primary-700 text-sm inline-flex items-center gap-1">
                            Lihat matrix lengkap
                            <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="card">
                <div class="p-4 border-b-2 border-neutral-200">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-orange-600"></i>
                        Distribusi Kategori
                    </h2>
                    <p class="text-sm text-neutral-600 mt-1">Lihat distribusi tugasmu</p>
                </div>
                
                <div class="p-4">
                    @if($categoryStats->count() > 0)
                        <div class="space-y-3">
                            @foreach($categoryStats->take(5) as $category)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-neutral-700">
                                            <span class="mr-2">{{ $category->category_icon ?? '📝' }}</span>
                                            {{ $category->category_name }}
                                        </span>
                                        <span class="text-neutral-600">{{ $category->total }} tugas</span>
                                    </div>
                                    <div class="progress-container">
                                        <div class="progress-fill" style="width: {{ $category->completion_rate }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-neutral-500 mt-1">
                                        <span>{{ $category->completed }} selesai</span>
                                        <span>{{ $category->completion_rate }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($categoryStats->count() > 5)
                            <div class="mt-4 text-center">
                                <button onclick="showAllCategories()" class="text-primary-600 font-medium hover:text-primary-700 text-sm">
                                    Lihat semua kategori
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="empty-state py-6">
                            <i class="fas fa-chart-bar empty-state-icon text-3xl"></i>
                            <p class="text-neutral-600">Belum ada data kategori</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Templates -->
            @if($templates->count() > 0)
                <div class="card">
                    <div class="p-4 border-b-2 border-neutral-200">
                        <h2 class="text-xl font-bold text-neutral-800 flex items-center gap-2">
                            <i class="fas fa-magic text-pink-600"></i>
                            Templates Cepat
                        </h2>
                        <p class="text-sm text-neutral-600 mt-1">Buat tugas dengan cepat</p>
                    </div>
                    
                    <div class="p-4">
                        <div class="space-y-2">
                            @foreach($templates as $template)
                                <button onclick="useTemplate({{ $template->id }})" 
                                        class="w-full text-left p-3 rounded-duo hover:bg-neutral-50 transition-colors border border-transparent hover:border-primary-200 group">
                                    <div class="flex items-center gap-3">
                                        <div class="category-icon" style="background: {{ $template->category_color ?? '#e5e7eb' }}">
                                            <span class="text-lg">{{ $template->category_icon ?? '📝' }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-neutral-800 group-hover:text-primary-700">
                                                {{ $template->name }}
                                            </div>
                                            <div class="text-xs text-neutral-500 mt-1">
                                                {{ $template->category_name }} • {{ $template->duration_hours ?? 'Tanpa durasi' }}
                                            </div>
                                        </div>
                                        <i class="fas fa-plus text-neutral-300 group-hover:text-primary-500"></i>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('templates.index') }}" class="text-primary-600 font-medium hover:text-primary-700 text-sm inline-flex items-center gap-1">
                                Lihat semua template
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('tasks.upcoming') }}" class="card p-4 text-center hover:bg-blue-50 transition-colors group">
                    <div class="text-blue-600 mb-2">
                        <i class="fas fa-calendar-alt text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="font-bold text-neutral-800 group-hover:text-blue-700">Mendatang</h4>
                    <p class="text-sm text-neutral-600">7 hari ke depan</p>
                </a>
                
                <a href="{{ route('tasks.overdue') }}" class="card p-4 text-center hover:bg-red-50 transition-colors group">
                    <div class="text-red-600 mb-2">
                        <i class="fas fa-exclamation-triangle text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="font-bold text-neutral-800 group-hover:text-red-700">Tertunda</h4>
                    <p class="text-sm text-neutral-600">{{ $overdueCount }} tugas</p>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Add Modal -->
<div id="quickAddModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-duo-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b-2 border-neutral-200 sticky top-0 bg-white">
            <h3 class="text-xl font-bold text-neutral-800">Tambah Task Baru</h3>
            <p class="text-sm text-neutral-600 mt-1">Isi form cepat untuk menambahkan task</p>
        </div>
        
        <form id="quickAddForm" action="{{ route('tasks.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">
                    <i class="fas fa-heading text-primary-600 mr-2"></i>
                    Judul Task *
                </label>
                <input type="text" name="title" required 
                       class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                       placeholder="Apa yang perlu dilakukan?"
                       autofocus>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-tag text-primary-600 mr-2"></i>
                        Kategori *
                    </label>
                    <select name="category" required 
                            class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        <option value="self_care">🛁 Perawatan Diri</option>
                        <option value="therapy">🧠 Terapi</option>
                        <option value="medication">💊 Obat-obatan</option>
                        <option value="exercise">🏃 Olahraga</option>
                        <option value="social">👥 Sosial</option>
                        <option value="work">💼 Pekerjaan</option>
                        <option value="mindfulness">🧘 Mindfulness</option>
                        <option value="creative">🎨 Kreatif</option>
                        <option value="chores">🧹 Pekerjaan Rumah</option>
                        <option value="other" selected>📝 Lainnya</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-flag text-primary-600 mr-2"></i>
                        Prioritas *
                    </label>
                    <select name="priority" required 
                            class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        <option value="low">Rendah</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">Tinggi</option>
                        <option value="urgent">Mendesak</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-calendar-day text-primary-600 mr-2"></i>
                        Tanggal
                    </label>
                    <input type="date" name="due_date" 
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                           value="{{ date('Y-m-d') }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-clock text-primary-600 mr-2"></i>
                        Waktu (opsional)
                    </label>
                    <input type="time" name="due_time"
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">
                    <i class="fas fa-edit text-primary-600 mr-2"></i>
                    Deskripsi (opsional)
                </label>
                <textarea name="description" rows="2"
                          class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                          placeholder="Deskripsi singkat..."></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_important" id="quickImportant" class="mr-2 h-5 w-5">
                    <label for="quickImportant" class="text-sm text-neutral-700">
                        <i class="fas fa-star text-yellow-500 mr-1"></i> Penting
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_urgent" id="quickUrgent" class="mr-2 h-5 w-5">
                    <label for="quickUrgent" class="text-sm text-neutral-700">
                        <i class="fas fa-exclamation text-red-500 mr-1"></i> Mendesak
                    </label>
                </div>
            </div>
        </form>
        
        <div class="p-6 border-t-2 border-neutral-200 sticky bottom-0 bg-white flex justify-end gap-3">
            <button onclick="closeQuickAddModal()" 
                    class="px-4 py-3 text-neutral-600 font-medium rounded-duo hover:bg-neutral-100 transition-colors flex items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </button>
            <button onclick="submitQuickAdd()" 
                    class="app-button px-4 py-3 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Task</span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Quick Add Modal Functions
    function showQuickAddModal() {
        document.getElementById('quickAddModal').classList.remove('hidden');
        document.getElementById('quickAddModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeQuickAddModal() {
        document.getElementById('quickAddModal').classList.add('hidden');
        document.getElementById('quickAddModal').classList.remove('flex');
        document.body.style.overflow = '';
    }
    
    function submitQuickAdd() {
        document.getElementById('quickAddForm').submit();
    }
    
    // Complete Task Function
    async function completeTask(button) {
        const taskId = button.dataset.taskId;
        const taskTitle = button.dataset.taskTitle;
        
        if (button.classList.contains('checked')) {
            // Task already completed
            return;
        }
        
        // Show completion modal or direct complete
        const response = await fetch(`/tasks/${taskId}/complete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
        
        if (response.ok) {
            // Animate completion
            button.classList.add('checked');
            button.innerHTML = '<i class="fas fa-check text-white text-xs"></i>';
            
            // Show success notification
            showNotification(`Task "${taskTitle}" selesai!`, 'success');
            
            // Reload page after delay to show updated stats
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    }
    
    // Use Template Function
    async function useTemplate(templateId) {
        try {
            const response = await fetch(`/templates/${templateId}/quick-create`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification('Task berhasil dibuat dari template!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } catch (error) {
            console.error('Error using template:', error);
            showNotification('Gagal membuat task dari template', 'error');
        }
    }
    
    // Show Categories Function
    function showAllCategories() {
        // Implement category modal or redirect
        window.location.href = '/tasks/statistics';
    }
    
    // Notification Function
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(n => n.remove());
        
        const colors = {
            success: 'bg-green-100 border-green-400 text-green-700',
            error: 'bg-red-100 border-red-400 text-red-700',
            warning: 'bg-yellow-100 border-yellow-400 text-yellow-700',
            info: 'bg-blue-100 border-blue-400 text-blue-700'
        };
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const notification = document.createElement('div');
        notification.className = `
            custom-notification fixed top-6 right-6 
            px-5 py-4 rounded-duo z-[9999]
            transform transition-all duration-300
            animate-slide-in border-2
            flex items-center gap-3 shadow-lg
            ${colors[type] || colors.info}
        `;
        
        notification.innerHTML = `
            <i class="fas ${icons[type]} text-xl"></i>
            <span class="font-semibold">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            notification.style.opacity = "0";
            notification.style.transform = "translateX(100%)";
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQuickAddModal();
        }
    });
    
    // Close modal on background click
    document.getElementById('quickAddModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeQuickAddModal();
        }
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to task checkboxes
        document.querySelectorAll('.task-checkbox').forEach(checkbox => {
            checkbox.addEventListener('mouseenter', function() {
                if (!this.classList.contains('checked')) {
                    this.style.transform = 'scale(1.1)';
                }
            });
            
            checkbox.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
        
        // Add animation to new elements
        const taskItems = document.querySelectorAll('.task-item');
        taskItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.05}s`;
            item.classList.add('animate-slide-in');
        });
    });
</script>
@endsection