@extends('layouts.app')

@section('title', 'Tugas Hari Ini - Tenang')

@section('styles')
<style>
    .time-slot {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 1rem;
    }
    
    .time-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 2.5rem;
        height: 2.5rem;
        background: #58cc70;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 2px 0 #45b259;
    }
    
    .time-slot-content {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #58cc70;
    }
    
    .no-time-slot .time-slot-content {
        border-left-color: #6b7280;
    }
    
    .progress-time {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .time-progress {
        width: 100%;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        margin-top: 0.5rem;
        overflow: hidden;
    }
    
    .time-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #58cc70, #45b259);
        border-radius: 2px;
        transition: width 0.3s ease;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Tugas Hari Ini</h1>
            <p class="text-neutral-600 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-3">
            <button onclick="refreshToday()" class="app-button app-button-secondary">
                <i class="fas fa-sync-alt mr-2"></i> Refresh
            </button>
            <a href="{{ route('tasks.create') }}" class="app-button">
                <i class="fas fa-plus mr-2"></i> Tambah Task
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-primary-100 rounded-duo flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-primary-600"></i>
                </div>
                <div>
                    <p class="text-sm text-neutral-600">Tersisa</p>
                    <h3 class="text-xl font-bold text-neutral-800" id="remaining-count">0</h3>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-duo flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-neutral-600">Selesai</p>
                    <h3 class="text-xl font-bold text-neutral-800" id="completed-count">0</h3>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-yellow-100 rounded-duo flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm text-neutral-600">Produktivitas</p>
                    <h3 class="text-xl font-bold text-neutral-800" id="productivity-score">0%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks by Time -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-neutral-800 mb-4">Jadwal Harian</h2>
        <div id="time-slots-container">
            <!-- Time slots will be loaded here -->
        </div>
    </div>

    <!-- All Today's Tasks -->
    <div class="card">
        <div class="p-4 border-b border-neutral-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-neutral-800">Semua Tugas Hari Ini</h2>
            <div class="flex gap-2">
                <button onclick="filterTasks('all')" class="px-3 py-1 rounded-duo bg-primary-100 text-primary-700 font-medium">
                    Semua
                </button>
                <button onclick="filterTasks('pending')" class="px-3 py-1 rounded-duo bg-neutral-100 text-neutral-700 font-medium">
                    Belum Selesai
                </button>
                <button onclick="filterTasks('completed')" class="px-3 py-1 rounded-duo bg-green-100 text-green-700 font-medium">
                    Selesai
                </button>
            </div>
        </div>
        <div class="p-4" id="all-tasks-container">
            <!-- All tasks will be loaded here -->
        </div>
    </div>

    <!-- Mood Tracking -->
    <div class="card mt-6">
        <div class="p-4 border-b border-neutral-200">
            <h2 class="text-xl font-bold text-neutral-800">Tracking Mood Hari Ini</h2>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-5 gap-2 mb-4" id="mood-selector">
                <button onclick="rateMood(1)" class="mood-option p-4 rounded-duo text-center">
                    <div class="text-2xl">😢</div>
                    <div class="text-sm mt-1">Sangat Buruk</div>
                </button>
                <button onclick="rateMood(2)" class="mood-option p-4 rounded-duo text-center">
                    <div class="text-2xl">😔</div>
                    <div class="text-sm mt-1">Buruk</div>
                </button>
                <button onclick="rateMood(3)" class="mood-option p-4 rounded-duo text-center">
                    <div class="text-2xl">😐</div>
                    <div class="text-sm mt-1">Biasa</div>
                </button>
                <button onclick="rateMood(4)" class="mood-option p-4 rounded-duo text-center">
                    <div class="text-2xl">😊</div>
                    <div class="text-sm mt-1">Baik</div>
                </button>
                <button onclick="rateMood(5)" class="mood-option p-4 rounded-duo text-center">
                    <div class="text-2xl">😁</div>
                    <div class="text-sm mt-1">Sangat Baik</div>
                </button>
            </div>
            <div id="mood-tracking-result"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadTodayTasks();
        setupTimeSlots();
    });

    async function loadTodayTasks() {
        try {
            const response = await fetch('/api/tasks/today');
            const data = await response.json();
            
            if (data.success) {
                updateStats(data.data);
                renderAllTasks(data.data.tasks);
                renderTimeSlots(data.data.tasks);
            }
        } catch (error) {
            console.error('Error loading today tasks:', error);
        }
    }

    function updateStats(data) {
        document.getElementById('remaining-count').textContent = data.total_today - data.completed_today;
        document.getElementById('completed-count').textContent = data.completed_today;
        
        const productivity = data.total_today > 0 
            ? Math.round((data.completed_today / data.total_today) * 100)
            : 100;
        document.getElementById('productivity-score').textContent = productivity + '%';
    }

    function renderAllTasks(tasks) {
        const container = document.getElementById('all-tasks-container');
        
        if (tasks.length === 0) {
            container.innerHTML = `
            <div class="empty-state py-8">
                <div class="empty-state-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <p class="text-neutral-600">Tidak ada tugas untuk hari ini</p>
                <a href="{{ route('tasks.create') }}" class="app-button mt-4 inline-block">
                    <i class="fas fa-plus"></i> Tambah Task Pertama
                </a>
            </div>
            `;
            return;
        }

        let html = '<div class="space-y-3">';
        tasks.forEach(task => {
            const timeDisplay = task.due_time ? 
                `<span class="text-sm text-neutral-600"><i class="far fa-clock mr-1"></i>${task.due_time}</span>` : '';
            
            html += `
            <div class="task-item card p-4 ${task.status === 'completed' ? 'completed' : ''}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="task-checkbox ${task.status === 'completed' ? 'checked' : ''}" 
                             onclick="toggleTaskCompletion(${task.id})">
                            ${task.status === 'completed' ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-neutral-800 ${task.status === 'completed' ? 'line-through' : ''}">
                                    ${task.title}
                                </h4>
                                <div class="flex items-center gap-2">
                                    ${task.is_important ? '<span class="text-yellow-500"><i class="fas fa-star"></i></span>' : ''}
                                    ${task.is_urgent ? '<span class="text-red-500"><i class="fas fa-exclamation"></i></span>' : ''}
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="category-badge bg-${getCategoryColor(task.category)}-100 text-${getCategoryColor(task.category)}-800">
                                    ${task.category_icon} ${task.category_name}
                                </span>
                                ${timeDisplay}
                                ${task.estimated_duration ? 
                                    `<span class="text-sm text-neutral-600"><i class="fas fa-hourglass-half mr-1"></i>${task.duration_hours}</span>` : 
                                    ''}
                            </div>
                            ${task.description ? `<p class="text-neutral-600 text-sm mt-2">${task.description}</p>` : ''}
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
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
    }

    function setupTimeSlots() {
        // Create time slots from 6 AM to 10 PM
        const timeSlots = [];
        for (let hour = 6; hour <= 22; hour++) {
            timeSlots.push({
                hour: hour,
                display: `${hour.toString().padStart(2, '0')}:00`,
                tasks: []
            });
        }
        
        renderTimeSlots([]); // Will be populated by data
    }

    function renderTimeSlots(tasks) {
        const container = document.getElementById('time-slots-container');
        
        const timeSlots = {};
        for (let hour = 6; hour <= 22; hour++) {
            timeSlots[hour] = {
                hour: hour,
                display: `${hour.toString().padStart(2, '0')}:00`,
                tasks: []
            };
        }
        
        // Group tasks by hour
        tasks.forEach(task => {
            if (task.due_time) {
                const hour = parseInt(task.due_time.split(':')[0]);
                if (hour >= 6 && hour <= 22) {
                    timeSlots[hour].tasks.push(task);
                }
            }
        });
        
        let html = '';
        Object.values(timeSlots).forEach(slot => {
            if (slot.tasks.length > 0) {
                html += `
                <div class="time-slot">
                    <div class="time-marker">${slot.display}</div>
                    <div class="time-slot-content">
                        <div class="space-y-2">
                            ${slot.tasks.map(task => `
                            <div class="flex items-center justify-between p-2 bg-neutral-50 rounded-duo">
                                <div class="flex items-center gap-2">
                                    <div class="task-checkbox ${task.status === 'completed' ? 'checked' : ''}" 
                                         onclick="toggleTaskCompletion(${task.id})">
                                        ${task.status === 'completed' ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                                    </div>
                                    <span class="${task.status === 'completed' ? 'line-through' : ''}">${task.title}</span>
                                </div>
                                <span class="text-sm text-neutral-600">${task.category_icon}</span>
                            </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
                `;
            }
        });
        
        // Add no-time tasks
        const noTimeTasks = tasks.filter(task => !task.due_time);
        if (noTimeTasks.length > 0) {
            html += `
            <div class="time-slot no-time-slot">
                <div class="time-marker" style="background: #6b7280;"><i class="fas fa-infinity"></i></div>
                <div class="time-slot-content">
                    <h4 class="font-bold text-neutral-800 mb-2">Tanpa Waktu Spesifik</h4>
                    <div class="space-y-2">
                        ${noTimeTasks.map(task => `
                        <div class="flex items-center justify-between p-2 bg-neutral-50 rounded-duo">
                            <div class="flex items-center gap-2">
                                <div class="task-checkbox ${task.status === 'completed' ? 'checked' : ''}" 
                                     onclick="toggleTaskCompletion(${task.id})">
                                    ${task.status === 'completed' ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                                </div>
                                <span class="${task.status === 'completed' ? 'line-through' : ''}">${task.title}</span>
                            </div>
                            <span class="text-sm text-neutral-600">${task.category_icon}</span>
                        </div>
                        `).join('')}
                    </div>
                </div>
            </div>
            `;
        }
        
        if (html === '') {
            html = `
            <div class="empty-state py-8">
                <div class="empty-state-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <p class="text-neutral-600">Tidak ada tugas terjadwal hari ini</p>
                <button onclick="showQuickSchedule()" class="app-button mt-4">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </button>
            </div>
            `;
        }
        
        container.innerHTML = html;
    }

    function getCategoryColor(category) {
        const colors = {
            'self_care': 'purple',
            'therapy': 'indigo',
            'medication': 'red',
            'exercise': 'green',
            'social': 'blue',
            'work': 'yellow',
            'mindfulness': 'pink',
            'creative': 'orange',
            'chores': 'gray',
            'other': 'neutral'
        };
        return colors[category] || 'neutral';
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
                loadTodayTasks();
            } else {
                showNotification(data.message || 'Gagal menyelesaikan task', 'error');
            }
        } catch (error) {
            console.error('Error completing task:', error);
            showNotification('Terjadi kesalahan', 'error');
        }
    }

    function filterTasks(status) {
        const tasks = document.querySelectorAll('.task-item');
        tasks.forEach(task => {
            const isCompleted = task.classList.contains('completed');
            
            if (status === 'all') {
                task.style.display = 'block';
            } else if (status === 'pending') {
                task.style.display = isCompleted ? 'none' : 'block';
            } else if (status === 'completed') {
                task.style.display = isCompleted ? 'block' : 'none';
            }
        });
    }

    async function rateMood(score) {
        try {
            const response = await fetch('/api/mood/track', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    mood_score: score,
                    notes: 'Setelah menyelesaikan tasks hari ini'
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification('Mood berhasil direkam!', 'success');
                document.getElementById('mood-tracking-result').innerHTML = `
                <div class="p-4 bg-green-50 rounded-duo text-green-800">
                    <p class="font-medium">Terima kasih telah merekam mood kamu!</p>
                    <p class="text-sm mt-1">Mood: ${getMoodText(score)}</p>
                </div>
                `;
            }
        } catch (error) {
            console.error('Error rating mood:', error);
            showNotification('Gagal merekam mood', 'error');
        }
    }

    function getMoodText(score) {
        const texts = [
            '', 'Sangat Buruk', 'Buruk', 'Biasa', 'Baik', 'Sangat Baik'
        ];
        return texts[score];
    }

    function refreshToday() {
        loadTodayTasks();
        showNotification('Data diperbarui', 'info');
    }

    function showQuickSchedule() {
        // Implementation for quick schedule modal
        showNotification('Fitur jadwal cepat akan datang!', 'info');
    }
</script>
@endsection