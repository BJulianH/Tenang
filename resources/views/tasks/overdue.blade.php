@extends('layouts.app')

@section('title', 'Tugas Tertunda - Tenang')

@section('styles')
<style>
    .overdue-badge {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .days-late {
        font-size: 0.75rem;
        color: #dc2626;
        font-weight: bold;
    }
    
    .overdue-task {
        border-left: 4px solid #dc2626;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
    
    .reschedule-option {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }
    
    .reschedule-option:hover {
        border-color: #58cc70;
        background: #f0f9f0;
    }
    
    .reschedule-option.selected {
        border-color: #58cc70;
        background: #f0f9f0;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Tugas Tertunda</h1>
            <p class="text-neutral-600 mt-1">Tugas yang sudah melewati deadline</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-3">
            <button onclick="bulkReschedule()" class="app-button app-button-secondary flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i>
                <span>Reschedule Semua</span>
            </button>
            <a href="{{ route('tasks.create') }}" class="app-button flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Task Baru</span>
            </a>
        </div>
    </div>

    @if($tasks->count() > 0)
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-duo flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-600">Total Tertunda</p>
                        <h3 class="text-xl font-bold text-neutral-800">{{ $tasks->total() }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-duo flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-600">Rata-rata Keterlambatan</p>
                        <h3 class="text-xl font-bold text-neutral-800">
                            {{ number_format($tasks->avg('days_late'), 1) }} hari
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-duo flex items-center justify-center mr-3">
                        <i class="fas fa-fire text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-600">Poin Hilang</p>
                        <h3 class="text-xl font-bold text-neutral-800">
                            {{ $tasks->sum('points_lost') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Tasks -->
        <div class="space-y-4">
            @foreach($tasks as $task)
                @php
                    $daysLate = $task->due_date ? now()->diffInDays($task->due_date, false) * -1 : 0;
                    $pointsLost = $task->calculatePoints() * 0.5; // 50% points lost for being late
                @endphp
                
                <div class="overdue-task card p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="task-checkbox {{ $task->status === 'completed' ? 'checked' : '' }}" 
                                 onclick="completeTask({{ $task->id }})">
                                @if($task->status === 'completed')
                                    <i class="fas fa-check text-white text-xs"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold text-neutral-800 {{ $task->status === 'completed' ? 'line-through' : '' }}">
                                        {{ $task->title }}
                                    </h4>
                                    <span class="overdue-badge">
                                        <i class="fas fa-clock"></i>
                                        {{ $daysLate }} hari terlambat
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="task-priority-dot priority-{{ $task->priority }}"></span>
                                    <span class="text-sm text-neutral-600">{{ $task->category_name }}</span>
                                    @if($task->due_date)
                                        <span class="text-sm text-neutral-600">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ $task->due_date->translatedFormat('d M Y') }}
                                        </span>
                                    @endif
                                    @if($task->due_time)
                                        <span class="text-sm text-neutral-600">
                                            <i class="far fa-clock mr-1"></i>{{ $task->due_time->format('H:i') }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($task->description)
                                    <p class="text-neutral-600 text-sm mb-3">{{ $task->description }}</p>
                                @endif
                                
                                <div class="flex items-center gap-4 text-sm">
                                    @if($task->is_important)
                                        <span class="text-yellow-500">
                                            <i class="fas fa-star mr-1"></i> Penting
                                        </span>
                                    @endif
                                    @if($task->is_urgent)
                                        <span class="text-red-500">
                                            <i class="fas fa-exclamation mr-1"></i> Mendesak
                                        </span>
                                    @endif
                                    <span class="text-red-500">
                                        <i class="fas fa-coins mr-1"></i> -{{ $pointsLost }} points
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-neutral-200">
                        <div class="flex items-center gap-2">
                            @if($task->tags)
                                @foreach(json_decode($task->tags, true) as $tag)
                                    <span class="text-xs bg-neutral-100 text-neutral-600 px-2 py-1 rounded-full">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                        
                        <div class="flex gap-2">
                            <button onclick="rescheduleTask({{ $task->id }})" 
                                    class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium hover:bg-blue-200">
                                Reschedule
                            </button>
                            
                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium hover:bg-green-200">
                                    Selesai Sekarang
                                </button>
                            </form>
                            
                            <a href="{{ route('tasks.edit', $task) }}" class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-medium hover:bg-yellow-200">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Pagination -->
            @if($tasks->hasPages())
                <div class="mt-6">
                    {{ $tasks->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State -->
        <div class="card p-8 text-center">
            <div class="empty-state-icon mb-4">
                <i class="fas fa-check-double text-5xl text-green-500"></i>
            </div>
            <h3 class="text-xl font-bold text-neutral-800 mb-2">Tidak ada tugas tertunda!</h3>
            <p class="text-neutral-600 mb-6">Semua tugas sudah selesai atau masih dalam batas waktu.</p>
            <div class="flex justify-center gap-3">
                <a href="{{ route('tasks.create') }}" class="app-button">
                    <i class="fas fa-plus mr-2"></i> Buat Task Baru
                </a>
                <a href="{{ route('tasks.dashboard') }}" class="app-button app-button-secondary">
                    <i class="fas fa-home mr-2"></i> Ke Dashboard
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Reschedule Modal -->
<div id="rescheduleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-duo-xl w-full max-w-md">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-xl font-bold text-neutral-800" id="rescheduleTitle">Reschedule Task</h3>
        </div>
        <form id="rescheduleForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="task_id" id="rescheduleTaskId">
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Baru</label>
                <input type="date" name="due_date" id="newDueDate" 
                       value="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Waktu Baru (opsional)</label>
                <input type="time" name="due_time" id="newDueTime"
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Quick Reschedule</label>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="setRescheduleDate('today')" class="reschedule-option">
                        <div class="font-medium">Hari Ini</div>
                        <div class="text-xs text-neutral-600">{{ date('d M') }}</div>
                    </button>
                    <button type="button" onclick="setRescheduleDate('tomorrow')" class="reschedule-option">
                        <div class="font-medium">Besok</div>
                        <div class="text-xs text-neutral-600">{{ date('d M', strtotime('+1 day')) }}</div>
                    </button>
                    <button type="button" onclick="setRescheduleDate('next_week')" class="reschedule-option">
                        <div class="font-medium">Minggu Depan</div>
                        <div class="text-xs text-neutral-600">{{ date('d M', strtotime('+7 days')) }}</div>
                    </button>
                    <button type="button" onclick="setRescheduleDate('next_month')" class="reschedule-option">
                        <div class="font-medium">Bulan Depan</div>
                        <div class="text-xs text-neutral-600">{{ date('d M', strtotime('+30 days')) }}</div>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" name="keep_reminder" id="keepReminder" class="mr-2" checked>
                <label for="keepReminder" class="text-sm text-neutral-700">Pertahankan pengaturan reminder</label>
            </div>
        </form>
        <div class="p-6 border-t border-neutral-200 flex justify-end gap-3">
            <button onclick="closeRescheduleModal()" class="px-4 py-2 text-neutral-600 font-medium rounded-duo hover:bg-neutral-100">
                Batal
            </button>
            <button onclick="submitRescheduleForm()" class="app-button px-4 py-2">
                <i class="fas fa-calendar-check mr-2"></i> Reschedule
            </button>
        </div>
    </div>
</div>

<!-- Bulk Reschedule Modal -->
<div id="bulkRescheduleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-duo-xl w-full max-w-md">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-xl font-bold text-neutral-800">Reschedule Semua Tugas Tertunda</h3>
        </div>
        <div class="p-6 space-y-4">
            <p class="text-neutral-600">Pilih tanggal baru untuk semua {{ $tasks->count() }} tugas tertunda:</p>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Baru</label>
                <input type="date" id="bulkNewDate" 
                       value="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="setBulkDate('today')" class="reschedule-option">
                    <div class="font-medium">Hari Ini</div>
                    <div class="text-xs text-neutral-600">{{ date('d M') }}</div>
                </button>
                <button type="button" onclick="setBulkDate('tomorrow')" class="reschedule-option">
                    <div class="font-medium">Besok</div>
                    <div class="text-xs text-neutral-600">{{ date('d M', strtotime('+1 day')) }}</div>
                </button>
                <button type="button" onclick="setBulkDate('next_week')" class="reschedule-option">
                    <div class="font-medium">Minggu Depan</div>
                    <div class="text-xs text-neutral-600">{{ date('d M', strtotime('+7 days')) }}</div>
                </button>
                <button type="button" onclick="setBulkDate('next_month')" class="reschedule-option">
                    <div class="font-medium">Bulan Depan</div>
                    <div class="text-xs text-neutral-600">{{ date('d M', strtotime('+30 days')) }}</div>
                </button>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-duo p-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                    <div>
                        <p class="text-sm text-yellow-800 font-medium">Perhatian</p>
                        <p class="text-xs text-yellow-700 mt-1">
                            Aksi ini akan mengubah tanggal semua tugas tertunda. Pastikan ini adalah yang Anda inginkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 border-t border-neutral-200 flex justify-end gap-3">
            <button onclick="closeBulkRescheduleModal()" class="px-4 py-2 text-neutral-600 font-medium rounded-duo hover:bg-neutral-100">
                Batal
            </button>
            <button onclick="submitBulkReschedule()" class="app-button px-4 py-2">
                <i class="fas fa-calendar-alt mr-2"></i> Reschedule Semua
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedTaskId = null;
    
    function completeTask(taskId) {
        window.location.href = `/tasks/${taskId}/complete`;
    }
    
    function rescheduleTask(taskId) {
        selectedTaskId = taskId;
        const taskElement = document.querySelector(`[onclick="rescheduleTask(${taskId})"]`);
        const taskTitle = taskElement.closest('.overdue-task').querySelector('h4').textContent;
        
        document.getElementById('rescheduleTitle').textContent = `Reschedule: ${taskTitle}`;
        document.getElementById('rescheduleTaskId').value = taskId;
        document.getElementById('rescheduleForm').action = `/tasks/${taskId}`;
        
        showRescheduleModal();
    }
    
    function showRescheduleModal() {
        document.getElementById('rescheduleModal').classList.remove('hidden');
        document.getElementById('rescheduleModal').classList.add('flex');
    }
    
    function closeRescheduleModal() {
        document.getElementById('rescheduleModal').classList.add('hidden');
        document.getElementById('rescheduleModal').classList.remove('flex');
    }
    
    function setRescheduleDate(option) {
        const dateInput = document.getElementById('newDueDate');
        const today = new Date();
        
        switch(option) {
            case 'today':
                dateInput.value = today.toISOString().split('T')[0];
                break;
            case 'tomorrow':
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                dateInput.value = tomorrow.toISOString().split('T')[0];
                break;
            case 'next_week':
                const nextWeek = new Date(today);
                nextWeek.setDate(nextWeek.getDate() + 7);
                dateInput.value = nextWeek.toISOString().split('T')[0];
                break;
            case 'next_month':
                const nextMonth = new Date(today);
                nextMonth.setMonth(nextMonth.getMonth() + 1);
                dateInput.value = nextMonth.toISOString().split('T')[0];
                break;
        }
        
        // Reset semua button
        document.querySelectorAll('.reschedule-option').forEach(btn => {
            btn.classList.remove('selected');
            btn.style.borderColor = '#e5e7eb';
            btn.style.backgroundColor = 'white';
        });
        
        // Select button yang diklik
        event.target.closest('.reschedule-option').classList.add('selected');
        event.target.closest('.reschedule-option').style.borderColor = '#58cc70';
        event.target.closest('.reschedule-option').style.backgroundColor = '#f0f9f0';
    }
    
    function submitRescheduleForm() {
        document.getElementById('rescheduleForm').submit();
    }
    
    function bulkReschedule() {
        showBulkRescheduleModal();
    }
    
    function showBulkRescheduleModal() {
        document.getElementById('bulkRescheduleModal').classList.remove('hidden');
        document.getElementById('bulkRescheduleModal').classList.add('flex');
    }
    
    function closeBulkRescheduleModal() {
        document.getElementById('bulkRescheduleModal').classList.add('hidden');
        document.getElementById('bulkRescheduleModal').classList.remove('flex');
    }
    
    function setBulkDate(option) {
        const dateInput = document.getElementById('bulkNewDate');
        const today = new Date();
        
        switch(option) {
            case 'today':
                dateInput.value = today.toISOString().split('T')[0];
                break;
            case 'tomorrow':
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                dateInput.value = tomorrow.toISOString().split('T')[0];
                break;
            case 'next_week':
                const nextWeek = new Date(today);
                nextWeek.setDate(nextWeek.getDate() + 7);
                dateInput.value = nextWeek.toISOString().split('T')[0];
                break;
            case 'next_month':
                const nextMonth = new Date(today);
                nextMonth.setMonth(nextMonth.getMonth() + 1);
                dateInput.value = nextMonth.toISOString().split('T')[0];
                break;
        }
        
        // Reset semua button
        document.querySelectorAll('#bulkRescheduleModal .reschedule-option').forEach(btn => {
            btn.classList.remove('selected');
            btn.style.borderColor = '#e5e7eb';
            btn.style.backgroundColor = 'white';
        });
        
        // Select button yang diklik
        event.target.closest('.reschedule-option').classList.add('selected');
        event.target.closest('.reschedule-option').style.borderColor = '#58cc70';
        event.target.closest('.reschedule-option').style.backgroundColor = '#f0f9f0';
    }
    
    async function submitBulkReschedule() {
        const newDate = document.getElementById('bulkNewDate').value;
        
        if (!newDate) {
            alert('Pilih tanggal terlebih dahulu');
            return;
        }
        
        // Get all overdue task IDs
        const taskIds = Array.from(document.querySelectorAll('.overdue-task'))
            .map(task => task.querySelector('[onclick^="rescheduleTask"]'))
            .filter(btn => btn)
            .map(btn => parseInt(btn.getAttribute('onclick').match(/\d+/)[0]));
        
        if (taskIds.length === 0) {
            alert('Tidak ada tugas untuk di-reschedule');
            return;
        }
        
        // Confirm action
        if (!confirm(`Anda yakin ingin mereschedule ${taskIds.length} tugas ke tanggal ${newDate}?`)) {
            return;
        }
        
        try {
            // Send bulk update request
            const response = await fetch('/api/tasks/bulk', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    task_ids: taskIds,
                    action: 'update_due_date',
                    data: {
                        due_date: newDate
                    }
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert(`Berhasil mereschedule ${data.data.total_updated} tugas!`);
                window.location.reload();
            } else {
                alert('Gagal mereschedule tugas: ' + (data.message || 'Terjadi kesalahan'));
            }
        } catch (error) {
            console.error('Error bulk rescheduling:', error);
            alert('Terjadi kesalahan saat mereschedule tugas');
        }
    }
    
    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRescheduleModal();
            closeBulkRescheduleModal();
        }
    });
    
    // Close modals on background click
    document.getElementById('rescheduleModal').addEventListener('click', function(e) {
        if (e.target === this) closeRescheduleModal();
    });
    
    document.getElementById('bulkRescheduleModal').addEventListener('click', function(e) {
        if (e.target === this) closeBulkRescheduleModal();
    });
</script>
@endsection