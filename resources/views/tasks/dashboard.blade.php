@extends('layouts.app')

@section('title', 'Todo List - Tenang')

@section('styles')
<style>
    .task-category-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
    }
    
    .task-priority-dot {
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
    
    .task-checkbox {
        width: 24px;
        height: 24px;
        border: 3px solid #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .task-checkbox:hover {
        border-color: #58cc70;
    }
    
    .task-checkbox.checked {
        background-color: #58cc70;
        border-color: #45b259;
    }
    
    .task-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    
    .task-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .task-item.completed {
        opacity: 0.7;
        background: #f8f9fa;
    }
    
    .task-item.overdue {
        border-left-color: #dc2626;
        animation: pulse 2s infinite;
    }
    
    .task-item.due-today {
        border-left-color: #f59e0b;
    }
    
    .category-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
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
    
    .energy-level {
        width: 60px;
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .energy-fill {
        height: 100%;
        background-color: #22c55e;
        border-radius: 4px;
    }
    
    .matrix-quadrant {
        min-height: 200px;
        border-radius: 16px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .matrix-quadrant:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .quadrant-1 { background: linear-gradient(135deg, #fee2e2, #fecaca); }
    .quadrant-2 { background: linear-gradient(135deg, #dcfce7, #bbf7d0); }
    .quadrant-3 { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .quadrant-4 { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 0 rgba(0,0,0,0.1);
        border: 3px solid #f1f3f4;
    }
    
    .streak-fire {
        animation: flame 1.5s infinite alternate;
    }
    
    @keyframes flame {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    
    .quick-add-task {
        background: linear-gradient(135deg, #58cc70, #45b259);
        color: white;
        border-radius: 16px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 0 rgba(69, 178, 89, 0.3);
    }
    
    .quick-add-task:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 0 rgba(69, 178, 89, 0.3);
    }
    
    .quick-add-task:active {
        transform: translateY(1px);
        box-shadow: 0 2px 0 rgba(69, 178, 89, 0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Todo List</h1>
            <p class="text-neutral-600 mt-1">Kelola tugas harianmu untuk kesehatan mental yang lebih baik</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-3">
            <a href="{{ route('tasks.create') }}" class="app-button flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Task</span>
            </a>
            <a href="{{ route('task-templates.index') }}" class="app-button app-button-secondary flex items-center gap-2">
                <i class="fas fa-layer-group"></i>
                <span>Templates</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm">Tugas Hari Ini</p>
                    <h3 class="text-2xl font-bold text-neutral-800" id="today-count">0</h3>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-calendar-day text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm">Tugas Selesai</p>
                    <h3 class="text-2xl font-bold text-neutral-800" id="completed-count">0</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm">Streak</p>
                    <h3 class="text-2xl font-bold text-neutral-800" id="streak-count">0 hari</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-fire streak-fire text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-600 text-sm">Points Earned</p>
                    <h3 class="text-2xl font-bold text-neutral-800" id="points-earned">0</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-duo flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <a href="{{ route('tasks.today') }}" class="card p-4 text-center hover:bg-primary-50 transition-colors">
            <div class="text-primary-600 mb-2">
                <i class="fas fa-sun text-2xl"></i>
            </div>
            <h4 class="font-bold text-neutral-800">Hari Ini</h4>
            <p class="text-sm text-neutral-600">Lihat tugas hari ini</p>
        </a>
        
        <a href="{{ route('tasks.upcoming') }}" class="card p-4 text-center hover:bg-blue-50 transition-colors">
            <div class="text-blue-600 mb-2">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
            <h4 class="font-bold text-neutral-800">Mendatang</h4>
            <p class="text-sm text-neutral-600">7 hari ke depan</p>
        </a>
        
        <a href="{{ route('tasks.overdue') }}" class="card p-4 text-center hover:bg-red-50 transition-colors">
            <div class="text-red-600 mb-2">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <h4 class="font-bold text-neutral-800">Overdue</h4>
            <p class="text-sm text-neutral-600">Tugas tertunda</p>
        </a>
        
        <a href="{{ route('tasks.matrix') }}" class="card p-4 text-center hover:bg-purple-50 transition-colors">
            <div class="text-purple-600 mb-2">
                <i class="fas fa-th text-2xl"></i>
            </div>
            <h4 class="font-bold text-neutral-800">Matrix</h4>
            <p class="text-sm text-neutral-600">Eisenhower Matrix</p>
        </a>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Tasks -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="p-4 border-b border-neutral-200 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center gap-2">
                        <i class="fas fa-tasks text-primary-600"></i>
                        Tugas Hari Ini
                    </h2>
                    <span class="bg-primary-100 text-primary-800 text-sm font-semibold px-3 py-1 rounded-full" id="today-counter">0</span>
                </div>
                <div class="p-4" id="today-tasks-container">
                    <!-- Tasks will be loaded here -->
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <p class="text-neutral-600">Tidak ada tugas untuk hari ini</p>
                        <button onclick="loadTodayTasks()" class="app-button mt-4">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Add & Eisenhower Matrix -->
        <div class="space-y-6">
            <!-- Quick Add Task -->
            <div class="quick-add-task" onclick="showQuickAddModal()">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg">Tambah Task Cepat</h3>
                        <p class="text-white/90 text-sm">Klik untuk tambah tugas baru</p>
                    </div>
                    <i class="fas fa-plus-circle text-2xl"></i>
                </div>
            </div>

            <!-- Eisenhower Matrix Preview -->
            <div class="card">
                <div class="p-4 border-b border-neutral-200">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center gap-2">
                        <i class="fas fa-th text-purple-600"></i>
                        Eisenhower Matrix
                    </h2>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="matrix-quadrant quadrant-1">
                            <h4 class="font-bold text-neutral-800 mb-2">Penting & Mendesak</h4>
                            <p class="text-sm text-neutral-600" id="quadrant-1-count">0 tugas</p>
                        </div>
                        <div class="matrix-quadrant quadrant-2">
                            <h4 class="font-bold text-neutral-800 mb-2">Penting & Tidak Mendesak</h4>
                            <p class="text-sm text-neutral-600" id="quadrant-2-count">0 tugas</p>
                        </div>
                        <div class="matrix-quadrant quadrant-3">
                            <h4 class="font-bold text-neutral-800 mb-2">Tidak Penting & Mendesak</h4>
                            <p class="text-sm text-neutral-600" id="quadrant-3-count">0 tugas</p>
                        </div>
                        <div class="matrix-quadrant quadrant-4">
                            <h4 class="font-bold text-neutral-800 mb-2">Tidak Penting & Tidak Mendesak</h4>
                            <p class="text-sm text-neutral-600" id="quadrant-4-count">0 tugas</p>
                        </div>
                    </div>
                    <a href="{{ route('tasks.matrix') }}" class="block text-center mt-4 text-primary-600 font-semibold hover:text-primary-700">
                        Lihat semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="card">
                <div class="p-4 border-b border-neutral-200">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-accent-orange"></i>
                        Distribusi Kategori
                    </h2>
                </div>
                <div class="p-4" id="category-chart">
                    <!-- Chart will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Add Task Modal -->
<div id="quick-add-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-duo-xl w-full max-w-md modal-enter">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-xl font-bold text-neutral-800">Tambah Task Baru</h3>
        </div>
        <form id="quick-add-form" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Judul Task</label>
                <input type="text" name="title" required 
                       class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Apa yang perlu dilakukan?">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="self_care">🛁 Perawatan Diri</option>
                    <option value="therapy">🧠 Terapi</option>
                    <option value="medication">💊 Obat-obatan</option>
                    <option value="exercise">🏃 Olahraga</option>
                    <option value="social">👥 Sosial</option>
                    <option value="work">💼 Pekerjaan</option>
                    <option value="mindfulness">🧘 Mindfulness</option>
                    <option value="creative">🎨 Kreatif</option>
                    <option value="chores">🧹 Pekerjaan Rumah</option>
                    <option value="other">📝 Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Prioritas</label>
                <select name="priority" class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="low">Rendah</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">Tinggi</option>
                    <option value="urgent">Mendesak</option>
                </select>
            </div>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Tanggal</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Waktu (opsional)</label>
                    <input type="time" name="due_time"
                           class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
            <div class="flex gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_important" id="important" class="mr-2">
                    <label for="important" class="text-sm text-neutral-700">Penting</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_urgent" id="urgent" class="mr-2">
                    <label for="urgent" class="text-sm text-neutral-700">Mendesak</label>
                </div>
            </div>
        </form>
        <div class="p-6 border-t border-neutral-200 flex justify-end gap-3">
            <button onclick="closeQuickAddModal()" class="px-4 py-2 text-neutral-600 font-medium rounded-duo hover:bg-neutral-100">
                Batal
            </button>
            <button onclick="submitQuickAdd()" class="app-button px-4 py-2">
                <i class="fas fa-plus mr-2"></i> Tambah Task
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();
        loadTodayTasks();
        loadMatrixCounts();
        loadCategoryChart();
    });

    async function loadDashboardData() {
        try {
            const response = await fetch('/api/tasks/statistics');
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('today-count').textContent = data.data.overall?.pending || 0;
                document.getElementById('completed-count').textContent = data.data.overall?.completed || 0;
                document.getElementById('streak-count').textContent = data.data.streak + ' hari';
                document.getElementById('points-earned').textContent = data.data.overall?.points || 0;
            }
        } catch (error) {
            console.error('Error loading dashboard data:', error);
        }
    }

    async function loadTodayTasks() {
        try {
            const response = await fetch('/api/tasks/today');
            const data = await response.json();
            
            const container = document.getElementById('today-tasks-container');
            const counter = document.getElementById('today-counter');
            
            if (data.success && data.data.tasks.length > 0) {
                counter.textContent = data.data.tasks.length;
                
                let html = '<div class="space-y-3">';
                data.data.tasks.forEach(task => {
                    html += `
                    <div class="task-item card p-4 ${task.status === 'completed' ? 'completed' : ''} ${task.is_overdue ? 'overdue' : task.is_due_today ? 'due-today' : ''}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="task-checkbox ${task.status === 'completed' ? 'checked' : ''}" 
                                     onclick="toggleTaskCompletion(${task.id})">
                                    ${task.status === 'completed' ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                                </div>
                                <div>
                                    <h4 class="font-medium text-neutral-800 ${task.status === 'completed' ? 'line-through' : ''}">
                                        ${task.title}
                                    </h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="task-priority-dot priority-${task.priority}"></span>
                                        <span class="text-sm text-neutral-600">${task.category_name}</span>
                                        ${task.due_time ? `<span class="text-sm text-neutral-600"><i class="far fa-clock mr-1"></i>${task.due_time}</span>` : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                ${task.is_important ? '<span class="text-yellow-500"><i class="fas fa-star"></i></span>' : ''}
                                <a href="/tasks/${task.id}" class="text-primary-600 hover:text-primary-700">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <p class="text-neutral-600">Tidak ada tugas untuk hari ini</p>
                    <button onclick="showQuickAddModal()" class="app-button mt-4">
                        <i class="fas fa-plus"></i> Tambah Task
                    </button>
                </div>
                `;
                counter.textContent = '0';
            }
        } catch (error) {
            console.error('Error loading today tasks:', error);
        }
    }

    async function loadMatrixCounts() {
        try {
            const quadrants = ['important_urgent', 'important_not_urgent', 'not_important_urgent', 'not_important_not_urgent'];
            
            for (let i = 0; i < quadrants.length; i++) {
                const response = await fetch(`/api/tasks/matrix?quadrant=${quadrants[i]}`);
                const data = await response.json();
                
                if (data.success) {
                    const count = data.data.tasks?.meta?.total || 0;
                    document.getElementById(`quadrant-${i+1}-count`).textContent = `${count} tugas`;
                }
            }
        } catch (error) {
            console.error('Error loading matrix counts:', error);
        }
    }

    async function loadCategoryChart() {
        try {
            const response = await fetch('/api/tasks/statistics');
            const data = await response.json();
            
            const container = document.getElementById('category-chart');
            if (data.success && data.data.categories) {
                let html = '<div class="space-y-2">';
                data.data.categories.forEach(cat => {
                    const width = cat.completion_rate || 0;
                    html += `
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium">${cat.category}</span>
                            <span class="text-neutral-600">${cat.total} tugas</span>
                        </div>
                        <div class="energy-level">
                            <div class="energy-fill" style="width: ${width}%"></div>
                        </div>
                    </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p class="text-neutral-600 text-center py-4">Belum ada data kategori</p>';
            }
        } catch (error) {
            console.error('Error loading category chart:', error);
        }
    }

    function showQuickAddModal() {
        document.getElementById('quick-add-modal').classList.remove('hidden');
        document.getElementById('quick-add-modal').classList.add('flex');
    }

    function closeQuickAddModal() {
        document.getElementById('quick-add-modal').classList.add('hidden');
        document.getElementById('quick-add-modal').classList.remove('flex');
    }

    async function submitQuickAdd() {
        const form = document.getElementById('quick-add-form');
        const formData = new FormData(form);
        
        try {
            const response = await fetch('/api/tasks', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification('Task berhasil ditambahkan!', 'success');
                closeQuickAddModal();
                form.reset();
                loadDashboardData();
                loadTodayTasks();
            } else {
                showNotification(data.message || 'Gagal menambahkan task', 'error');
            }
        } catch (error) {
            console.error('Error adding task:', error);
            showNotification('Terjadi kesalahan', 'error');
        }
    }

    async function toggleTaskCompletion(taskId) {
        try {
            const response = await fetch(`/api/tasks/${taskId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification('Task selesai! +' + data.data.points_earned + ' points', 'success');
                loadDashboardData();
                loadTodayTasks();
                loadMatrixCounts();
            } else {
                showNotification(data.message || 'Gagal menyelesaikan task', 'error');
            }
        } catch (error) {
            console.error('Error completing task:', error);
            showNotification('Terjadi kesalahan', 'error');
        }
    }
</script>
@endsection