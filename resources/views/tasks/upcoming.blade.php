@extends('layouts.app')

@section('title', 'Tugas Mendatang - Tenang')

@section('styles')
<style>
    .day-header {
        background: linear-gradient(135deg, #58cc70, #45b259);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
    }
    
    .day-tasks {
        margin-left: 1rem;
        padding-left: 1rem;
        border-left: 2px dashed #d1d5db;
    }
    
    .empty-day {
        padding: 2rem;
        text-align: center;
        color: #6b7280;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Tugas Mendatang</h1>
            <p class="text-neutral-600 mt-1">7 hari ke depan</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-3">
            <a href="{{ route('tasks.create') }}" class="app-button flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Task</span>
            </a>
        </div>
    </div>

    <!-- Upcoming Days -->
    <div class="space-y-6">
        @php
            $today = now();
            $next7Days = collect();
            for ($i = 0; $i < 7; $i++) {
                $date = $today->copy()->addDays($i);
                $next7Days->push([
                    'date' => $date,
                    'tasks' => $tasks->filter(function($task) use ($date) {
                        return $task->due_date && $task->due_date->format('Y-m-d') === $date->format('Y-m-d');
                    })
                ]);
            }
        @endphp

        @foreach($next7Days as $day)
            <div>
                <div class="day-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg">
                                {{ $day['date']->translatedFormat('l') }}
                            </h3>
                            <p class="text-sm opacity-90">
                                {{ $day['date']->translatedFormat('d F Y') }}
                                @if($day['date']->isToday())
                                    <span class="ml-2 bg-white text-green-700 text-xs px-2 py-1 rounded-full font-bold">HARI INI</span>
                                @endif
                                @if($day['date']->isTomorrow())
                                    <span class="ml-2 bg-white text-blue-700 text-xs px-2 py-1 rounded-full font-bold">BESOK</span>
                                @endif
                            </p>
                        </div>
                        <span class="bg-white text-green-700 px-3 py-1 rounded-full font-bold">
                            {{ $day['tasks']->count() }} tugas
                        </span>
                    </div>
                </div>
                
                @if($day['tasks']->count() > 0)
                    <div class="day-tasks">
                        @foreach($day['tasks'] as $task)
                            <div class="task-item card p-4 mb-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="task-checkbox {{ $task->status === 'completed' ? 'checked' : '' }}" 
                                             onclick="toggleTaskCompletion({{ $task->id }})">
                                            @if($task->status === 'completed')
                                                <i class="fas fa-check text-white text-xs"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-neutral-800 {{ $task->status === 'completed' ? 'line-through' : '' }}">
                                                {{ $task->title }}
                                            </h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="task-priority-dot priority-{{ $task->priority }}"></span>
                                                <span class="text-sm text-neutral-600">{{ $task->category_name }}</span>
                                                @if($task->due_time)
                                                    <span class="text-sm text-neutral-600">
                                                        <i class="far fa-clock mr-1"></i>{{ $task->due_time->format('H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
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
                                        <a href="{{ route('tasks.show', $task) }}" class="text-primary-600 hover:text-primary-700">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                @if($task->description)
                                    <p class="text-neutral-600 text-sm mt-3">{{ $task->description }}</p>
                                @endif
                                
                                @if($task->estimated_duration)
                                    <div class="flex items-center gap-2 mt-3 text-sm text-neutral-600">
                                        <i class="fas fa-hourglass-half"></i>
                                        <span>{{ $task->duration_hours }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-neutral-200">
                                    <div class="flex items-center gap-3">
                                        @if($task->tags)
                                            @foreach(json_decode($task->tags, true) as $tag)
                                                <span class="text-xs bg-neutral-100 text-neutral-600 px-2 py-1 rounded-full">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium hover:bg-green-200">
                                                Selesai
                                            </button>
                                        </form>
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium hover:bg-blue-200">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-day">
                        <i class="fas fa-calendar-plus text-3xl text-neutral-400 mb-3"></i>
                        <p class="text-neutral-600">Tidak ada tugas untuk hari ini</p>
                        <a href="{{ route('tasks.create') }}?due_date={{ $day['date']->format('Y-m-d') }}" 
                           class="app-button mt-3 inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Tambah Task
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Quick Complete Modal -->
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-duo-xl w-full max-w-md">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-xl font-bold text-neutral-800">Selesaikan Task</h3>
        </div>
        <form id="completeForm" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="task_id" id="completeTaskId">
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Mood Sebelum</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setMood('before', {{ $i }})" 
                                class="mood-option flex-1 p-3 text-center">
                            <div class="text-2xl">
                                @switch($i)
                                    @case(1) 😢 @break
                                    @case(2) 😔 @break
                                    @case(3) 😐 @break
                                    @case(4) 😊 @break
                                    @case(5) 😁 @break
                                @endswitch
                            </div>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="mood_before" id="moodBefore">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Mood Sesudah</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setMood('after', {{ $i }})" 
                                class="mood-option flex-1 p-3 text-center">
                            <div class="text-2xl">
                                @switch($i)
                                    @case(1) 😢 @break
                                    @case(2) 😔 @break
                                    @case(3) 😐 @break
                                    @case(4) 😊 @break
                                    @case(5) 😁 @break
                                @endswitch
                            </div>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="mood_after" id="moodAfter">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Catatan (opsional)</label>
                <textarea name="notes" rows="3" 
                          class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                          placeholder="Bagaimana perasaanmu setelah menyelesaikan task ini?"></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Durasi Aktual (menit, opsional)</label>
                <input type="number" name="actual_duration" min="1"
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Berapa lama waktu yang sebenarnya dibutuhkan?">
            </div>
        </form>
        <div class="p-6 border-t border-neutral-200 flex justify-end gap-3">
            <button onclick="closeCompleteModal()" class="px-4 py-2 text-neutral-600 font-medium rounded-duo hover:bg-neutral-100">
                Batal
            </button>
            <button onclick="submitCompleteForm()" class="app-button px-4 py-2">
                <i class="fas fa-check mr-2"></i> Selesai
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleTaskCompletion(taskId) {
        document.getElementById('completeTaskId').value = taskId;
        document.getElementById('completeForm').action = `/tasks/${taskId}/complete`;
        showCompleteModal();
    }
    
    function showCompleteModal() {
        document.getElementById('completeModal').classList.remove('hidden');
        document.getElementById('completeModal').classList.add('flex');
        resetMoodButtons();
    }
    
    function closeCompleteModal() {
        document.getElementById('completeModal').classList.add('hidden');
        document.getElementById('completeModal').classList.remove('flex');
    }
    
    function resetMoodButtons() {
        document.getElementById('moodBefore').value = '';
        document.getElementById('moodAfter').value = '';
        
        document.querySelectorAll('.mood-option').forEach(btn => {
            btn.classList.remove('selected');
            btn.style.borderColor = '#e5e7eb';
            btn.style.backgroundColor = 'white';
        });
    }
    
    function setMood(type, score) {
        const inputId = type === 'before' ? 'moodBefore' : 'moodAfter';
        const buttons = document.querySelectorAll(`.mood-option[onclick*="${type}"]`);
        
        // Reset semua button untuk type ini
        buttons.forEach(btn => {
            btn.classList.remove('selected');
            btn.style.borderColor = '#e5e7eb';
            btn.style.backgroundColor = 'white';
        });
        
        // Select button yang diklik
        const clickedBtn = event.target.closest('.mood-option');
        clickedBtn.classList.add('selected');
        clickedBtn.style.borderColor = '#58cc70';
        clickedBtn.style.backgroundColor = '#f0f9f0';
        
        document.getElementById(inputId).value = score;
    }
    
    function submitCompleteForm() {
        document.getElementById('completeForm').submit();
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCompleteModal();
        }
    });
    
    // Close modal on background click
    document.getElementById('completeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCompleteModal();
        }
    });
</script>
@endsection