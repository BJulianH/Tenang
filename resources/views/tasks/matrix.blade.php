@extends('layouts.app')

@section('title', 'Eisenhower Matrix - Tenang')

@section('styles')
<style>
    .quadrant {
        border-radius: 16px;
        padding: 1.5rem;
        min-height: 300px;
        transition: all 0.3s ease;
        border: 3px solid transparent;
    }
    
    .quadrant:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .quadrant-important-urgent {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-color: #f87171;
    }
    
    .quadrant-important-not-urgent {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        border-color: #4ade80;
    }
    
    .quadrant-not-important-urgent {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-color: #fbbf24;
    }
    
    .quadrant-not-important-not-urgent {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        border-color: #818cf8;
    }
    
    .quadrant-header {
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }
    
    .matrix-task {
        background: rgba(255,255,255,0.8);
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-left: 4px solid;
        transition: all 0.2s ease;
    }
    
    .matrix-task:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .matrix-task.important-urgent { border-left-color: #dc2626; }
    .matrix-task.important-not-urgent { border-left-color: #16a34a; }
    .matrix-task.not-important-urgent { border-left-color: #ea580c; }
    .matrix-task.not-important-not-urgent { border-left-color: #2563eb; }
    
    .empty-quadrant {
        text-align: center;
        padding: 2rem 1rem;
        color: rgba(0,0,0,0.5);
        font-style: italic;
    }
    
    .matrix-stats {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 0 rgba(0,0,0,0.1);
        border: 3px solid #f1f3f4;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">Eisenhower Matrix</h1>
        <p class="text-neutral-600 mt-1">Prioritaskan tugas berdasarkan kepentingan dan urgensi</p>
    </div>

    <!-- Matrix Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="matrix-stats">
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600 mb-1">
                    {{ $quadrants['important_urgent']['tasks']->count() }}
                </div>
                <div class="text-sm text-neutral-600">Penting & Mendesak</div>
                <div class="text-xs text-neutral-500 mt-1">Lakukan segera</div>
            </div>
        </div>
        
        <div class="matrix-stats">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 mb-1">
                    {{ $quadrants['important_not_urgent']['tasks']->count() }}
                </div>
                <div class="text-sm text-neutral-600">Penting & Tidak Mendesak</div>
                <div class="text-xs text-neutral-500 mt-1">Jadwalkan</div>
            </div>
        </div>
        
        <div class="matrix-stats">
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600 mb-1">
                    {{ $quadrants['not_important_urgent']['tasks']->count() }}
                </div>
                <div class="text-sm text-neutral-600">Tidak Penting & Mendesak</div>
                <div class="text-xs text-neutral-500 mt-1">Delegasikan</div>
            </div>
        </div>
        
        <div class="matrix-stats">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 mb-1">
                    {{ $quadrants['not_important_not_urgent']['tasks']->count() }}
                </div>
                <div class="text-sm text-neutral-600">Tidak Penting & Tidak Mendesak</div>
                <div class="text-xs text-neutral-500 mt-1">Eliminasi</div>
            </div>
        </div>
    </div>

    <!-- Matrix Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Quadrant 1: Important & Urgent -->
        <div class="quadrant quadrant-important-urgent">
            <div class="quadrant-header">
                <h3 class="font-bold text-xl text-red-700">Penting & Mendesak</h3>
                <p class="text-sm text-red-600">Lakukan sekarang!</p>
            </div>
            
            @if($quadrants['important_urgent']['tasks']->count() > 0)
                <div class="space-y-2">
                    @foreach($quadrants['important_urgent']['tasks'] as $task)
                        <div class="matrix-task important-urgent">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-neutral-800">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-neutral-600">{{ $task->category_name }}</span>
                                        @if($task->due_date)
                                            <span class="text-xs text-neutral-600">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $task->human_due_date }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full hover:bg-green-200">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full hover:bg-blue-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-quadrant">
                    <i class="fas fa-check-circle text-3xl mb-2 opacity-50"></i>
                    <p>Tidak ada tugas</p>
                    <p class="text-sm mt-1">Kerja bagus! Semua tugas penting dan mendesak sudah ditangani.</p>
                </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('tasks.create') }}?is_important=1&is_urgent=1" 
                   class="text-sm text-red-700 font-medium hover:text-red-800">
                    <i class="fas fa-plus mr-1"></i> Tambah task
                </a>
            </div>
        </div>

        <!-- Quadrant 2: Important & Not Urgent -->
        <div class="quadrant quadrant-important-not-urgent">
            <div class="quadrant-header">
                <h3 class="font-bold text-xl text-green-700">Penting & Tidak Mendesak</h3>
                <p class="text-sm text-green-600">Jadwalkan untuk nanti</p>
            </div>
            
            @if($quadrants['important_not_urgent']['tasks']->count() > 0)
                <div class="space-y-2">
                    @foreach($quadrants['important_not_urgent']['tasks'] as $task)
                        <div class="matrix-task important-not-urgent">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-neutral-800">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-neutral-600">{{ $task->category_name }}</span>
                                        @if($task->due_date)
                                            <span class="text-xs text-neutral-600">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $task->human_due_date }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick="scheduleTask({{ $task->id }})" 
                                            class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full hover:bg-yellow-200">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full hover:bg-blue-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-quadrant">
                    <i class="fas fa-clock text-3xl mb-2 opacity-50"></i>
                    <p>Tidak ada tugas</p>
                    <p class="text-sm mt-1">Waktunya untuk berpikir jangka panjang.</p>
                </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('tasks.create') }}?is_important=1&is_urgent=0" 
                   class="text-sm text-green-700 font-medium hover:text-green-800">
                    <i class="fas fa-plus mr-1"></i> Tambah task
                </a>
            </div>
        </div>

        <!-- Quadrant 3: Not Important & Urgent -->
        <div class="quadrant quadrant-not-important-urgent">
            <div class="quadrant-header">
                <h3 class="font-bold text-xl text-orange-700">Tidak Penting & Mendesak</h3>
                <p class="text-sm text-orange-600">Delegasikan atau minimalkan</p>
            </div>
            
            @if($quadrants['not_important_urgent']['tasks']->count() > 0)
                <div class="space-y-2">
                    @foreach($quadrants['not_important_urgent']['tasks'] as $task)
                        <div class="matrix-task not-important-urgent">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-neutral-800">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-neutral-600">{{ $task->category_name }}</span>
                                        @if($task->due_date)
                                            <span class="text-xs text-neutral-600">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $task->human_due_date }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick="delegateTask({{ $task->id }})" 
                                            class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full hover:bg-purple-200">
                                        <i class="fas fa-user-friends"></i>
                                    </button>
                                    <form action="{{ route('tasks.cancel', $task) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full hover:bg-red-200">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-quadrant">
                    <i class="fas fa-exclamation text-3xl mb-2 opacity-50"></i>
                    <p>Tidak ada tugas</p>
                    <p class="text-sm mt-1">Tidak terburu-buru dengan hal yang kurang penting.</p>
                </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('tasks.create') }}?is_important=0&is_urgent=1" 
                   class="text-sm text-orange-700 font-medium hover:text-orange-800">
                    <i class="fas fa-plus mr-1"></i> Tambah task
                </a>
            </div>
        </div>

        <!-- Quadrant 4: Not Important & Not Urgent -->
        <div class="quadrant quadrant-not-important-not-urgent">
            <div class="quadrant-header">
                <h3 class="font-bold text-xl text-blue-700">Tidak Penting & Tidak Mendesak</h3>
                <p class="text-sm text-blue-600">Eliminasi atau tunda</p>
            </div>
            
            @if($quadrants['not_important_not_urgent']['tasks']->count() > 0)
                <div class="space-y-2">
                    @foreach($quadrants['not_important_not_urgent']['tasks'] as $task)
                        <div class="matrix-task not-important-not-urgent">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-neutral-800">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-neutral-600">{{ $task->category_name }}</span>
                                        @if($task->due_date)
                                            <span class="text-xs text-neutral-600">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $task->human_due_date }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick="eliminateTask({{ $task->id }})" 
                                            class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full hover:bg-red-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button onclick="postponeTask({{ $task->id }})" 
                                            class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full hover:bg-gray-200">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-quadrant">
                    <i class="fas fa-ban text-3xl mb-2 opacity-50"></i>
                    <p>Tidak ada tugas</p>
                    <p class="text-sm mt-1">Fokus pada hal yang benar-benar penting.</p>
                </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('tasks.create') }}?is_important=0&is_urgent=0" 
                   class="text-sm text-blue-700 font-medium hover:text-blue-800">
                    <i class="fas fa-plus mr-1"></i> Tambah task
                </a>
            </div>
        </div>
    </div>

    <!-- Explanation Section -->
    <div class="mt-8 card p-6">
        <h3 class="text-xl font-bold text-neutral-800 mb-4">Cara Menggunakan Eisenhower Matrix</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <h4 class="font-bold text-red-600 mb-2">1. Penting & Mendesak</h4>
                <ul class="text-sm text-neutral-600 space-y-1">
                    <li>• Krisis dan deadline</li>
                    <li>• Masalah mendesak</li>
                    <li>• Tugas dengan konsekuensi besar</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-green-600 mb-2">2. Penting & Tidak Mendesak</h4>
                <ul class="text-sm text-neutral-600 space-y-1">
                    <li>• Perencanaan jangka panjang</li>
                    <li>• Pengembangan diri</li>
                    <li>• Hubungan yang bermakna</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-orange-600 mb-2">3. Tidak Penting & Mendesak</h4>
                <ul class="text-sm text-neutral-600 space-y-1">
                    <li>• Interupsi tak terduga</li>
                    <li>• Beberapa meeting</li>
                    <li>• Aktivitas yang bisa didelegasikan</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-blue-600 mb-2">4. Tidak Penting & Tidak Mendesak</h4>
                <ul class="text-sm text-neutral-600 space-y-1">
                    <li>• Aktivitas membuang waktu</li>
                    <li>• Media sosial berlebihan</li>
                    <li>• Hal yang bisa dieliminasi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-duo-xl w-full max-w-md">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-xl font-bold text-neutral-800">Jadwalkan Task</h3>
        </div>
        <form id="scheduleForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="task_id" id="scheduleTaskId">
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Pilih Prioritas</label>
                <div class="flex gap-2">
                    <button type="button" onclick="setPriority('high')" class="priority-option priority-high">
                        <div class="text-center">Tinggi</div>
                    </button>
                    <button type="button" onclick="setPriority('urgent')" class="priority-option priority-urgent">
                        <div class="text-center">Mendesak</div>
                    </button>
                </div>
                <input type="hidden" name="priority" id="schedulePriority" value="high">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Deadline Baru</label>
                <input type="date" name="due_date" 
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       value="{{ date('Y-m-d', strtotime('+3 days')) }}">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Waktu Spesifik (opsional)</label>
                <input type="time" name="due_time"
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
        </form>
        <div class="p-6 border-t border-neutral-200 flex justify-end gap-3">
            <button onclick="closeScheduleModal()" class="px-4 py-2 text-neutral-600 font-medium rounded-duo hover:bg-neutral-100">
                Batal
            </button>
            <button onclick="submitScheduleForm()" class="app-button px-4 py-2">
                <i class="fas fa-calendar-check mr-2"></i> Jadwalkan
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function scheduleTask(taskId) {
        document.getElementById('scheduleTaskId').value = taskId;
        document.getElementById('scheduleForm').action = `/tasks/${taskId}`;
        showScheduleModal();
    }
    
    function showScheduleModal() {
        document.getElementById('scheduleModal').classList.remove('hidden');
        document.getElementById('scheduleModal').classList.add('flex');
    }
    
    function closeScheduleModal() {
        document.getElementById('scheduleModal').classList.add('hidden');
        document.getElementById('scheduleModal').classList.remove('flex');
    }
    
    function setPriority(priority) {
        document.getElementById('schedulePriority').value = priority;
        
        // Reset semua button
        document.querySelectorAll('.priority-option').forEach(btn => {
            btn.classList.remove('selected');
            btn.style.color = '';
            btn.style.backgroundColor = '';
        });
        
        // Select button yang diklik
        const clickedBtn = event.target.closest('.priority-option');
        clickedBtn.classList.add('selected');
    }
    
    function submitScheduleForm() {
        document.getElementById('scheduleForm').submit();
    }
    
    function delegateTask(taskId) {
        if (confirm('Tandai task ini sebagai delegasi? Task akan dipindah ke kategori "Menunggu Delegasi".')) {
            fetch(`/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    category: 'other',
                    notes: 'Didelegasikan - ' + new Date().toLocaleDateString()
                })
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
    
    function eliminateTask(taskId) {
        if (confirm('Hapus task ini? Task tidak penting dan tidak mendesak, lebih baik dieliminasi.')) {
            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
    
    function postponeTask(taskId) {
        const newDate = prompt('Tunda sampai tanggal berapa? (YYYY-MM-DD)', 
            new Date(new Date().setDate(new Date().getDate() + 14)).toISOString().split('T')[0]);
        
        if (newDate) {
            fetch(`/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    due_date: newDate,
                    is_urgent: false
                })
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeScheduleModal();
        }
    });
    
    // Close modal on background click
    document.getElementById('scheduleModal').addEventListener('click', function(e) {
        if (e.target === this) closeScheduleModal();
    });
</script>
@endsection