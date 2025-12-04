@extends('layouts.app')

@section('title', 'Tambah Task Baru - Tenang')

@section('styles')
<style>
    .category-option {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }
    
    .category-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .category-option.selected {
        border-color: #58cc70;
        background: #f0f9f0;
    }
    
    .category-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .priority-option {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid #e5e7eb;
    }
    
    .priority-option:hover {
        transform: scale(1.05);
    }
    
    .priority-option.selected {
        color: white;
    }
    
    .priority-low.selected { background: #16a34a; border-color: #16a34a; }
    .priority-medium.selected { background: #2563eb; border-color: #2563eb; }
    .priority-high.selected { background: #ea580c; border-color: #ea580c; }
    .priority-urgent.selected { background: #dc2626; border-color: #dc2626; }
    
    .matrix-cell {
        padding: 1rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        border: 2px solid #e5e7eb;
    }
    
    .matrix-cell:hover {
        transform: translateY(-2px);
    }
    
    .matrix-cell.selected {
        border-width: 3px;
    }
    
    .quadrant-important-urgent { border-color: #dc2626; }
    .quadrant-important-not-urgent { border-color: #16a34a; }
    .quadrant-not-important-urgent { border-color: #ea580c; }
    .quadrant-not-important-not-urgent { border-color: #2563eb; }
    
    .recurring-option {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .recurring-option:hover {
        background: #f8f9fa;
    }
    
    .recurring-option.selected {
        border-color: #58cc70;
        background: #f0f9f0;
    }
    
    .day-selector {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .day-option {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    
    .day-option:hover {
        transform: scale(1.1);
    }
    
    .day-option.selected {
        background: #58cc70;
        color: white;
        border-color: #45b259;
    }
    
    .energy-level-selector {
        display: flex;
        gap: 0.5rem;
    }
    
    .energy-option {
        flex: 1;
        padding: 0.75rem;
        text-align: center;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    
    .energy-option:hover {
        transform: translateY(-2px);
    }
    
    .energy-option.selected {
        color: white;
    }
    
    .energy-1.selected { background: #ef4444; border-color: #ef4444; }
    .energy-2.selected { background: #f97316; border-color: #f97316; }
    .energy-3.selected { background: #eab308; border-color: #eab308; }
    .energy-4.selected { background: #22c55e; border-color: #22c55e; }
    .energy-5.selected { background: #3b82f6; border-color: #3b82f6; }
    
    .form-step {
        display: none;
        animation: slideIn 0.3s ease-out;
    }
    
    .form-step.active {
        display: block;
    }
    
    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .step-indicator::before {
        content: '';
        position: absolute;
        top: 16px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e5e7eb;
        z-index: 1;
    }
    
    .step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: white;
        border: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .step.active .step-circle {
        background: #58cc70;
        color: white;
        border-color: #45b259;
    }
    
    .step.completed .step-circle {
        background: #58cc70;
        color: white;
        border-color: #45b259;
    }
    
    .step-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b7280;
    }
    
    .step.active .step-label {
        color: #58cc70;
        font-weight: 600;
    }
    
    .template-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .template-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .template-card.selected {
        border-color: #58cc70;
        background: #f0f9f0;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">Tambah Task Baru</h1>
        <p class="text-neutral-600 mt-1">Buat tugas untuk mendukung kesehatan mentalmu</p>
    </div>

    <!-- Step Indicator -->
    <div class="step-indicator">
        <div class="step active" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-label">Dasar</div>
        </div>
        <div class="step" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-label">Detail</div>
        </div>
        <div class="step" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-label">Pengaturan</div>
        </div>
        <div class="step" data-step="4">
            <div class="step-circle">4</div>
            <div class="step-label">Review</div>
        </div>
    </div>

    <!-- Form -->
    <form id="task-form" action="{{ route('tasks.store') }}" method="POST">
        @csrf
        
        <!-- Step 1: Basic Info -->
        <div class="form-step active" id="step-1">
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Judul Task <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Contoh: Minum obat pagi, Meditasi 10 menit">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Deskripsi (opsional)
                        </label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Deskripsi detail tentang task ini..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3" id="category-selector">
                            <div class="category-option" data-value="self_care">
                                <div class="category-icon">🛁</div>
                                <div class="text-sm font-medium">Self Care</div>
                            </div>
                            <div class="category-option" data-value="therapy">
                                <div class="category-icon">🧠</div>
                                <div class="text-sm font-medium">Terapi</div>
                            </div>
                            <div class="category-option" data-value="medication">
                                <div class="category-icon">💊</div>
                                <div class="text-sm font-medium">Obat</div>
                            </div>
                            <div class="category-option" data-value="exercise">
                                <div class="category-icon">🏃</div>
                                <div class="text-sm font-medium">Olahraga</div>
                            </div>
                            <div class="category-option" data-value="social">
                                <div class="category-icon">👥</div>
                                <div class="text-sm font-medium">Sosial</div>
                            </div>
                            <div class="category-option" data-value="work">
                                <div class="category-icon">💼</div>
                                <div class="text-sm font-medium">Pekerjaan</div>
                            </div>
                            <div class="category-option" data-value="mindfulness">
                                <div class="category-icon">🧘</div>
                                <div class="text-sm font-medium">Mindfulness</div>
                            </div>
                            <div class="category-option" data-value="creative">
                                <div class="category-icon">🎨</div>
                                <div class="text-sm font-medium">Kreatif</div>
                            </div>
                            <div class="category-option" data-value="chores">
                                <div class="category-icon">🧹</div>
                                <div class="text-sm font-medium">Pekerjaan Rumah</div>
                            </div>
                            <div class="category-option" data-value="other">
                                <div class="category-icon">📝</div>
                                <div class="text-sm font-medium">Lainnya</div>
                            </div>
                        </div>
                        <input type="hidden" name="category" id="category-input" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Eisenhower Matrix
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="matrix-cell quadrant-important-urgent" data-important="1" data-urgent="1">
                                <div class="font-bold text-red-600">Penting & Mendesak</div>
                                <div class="text-xs text-neutral-600 mt-1">Lakukan segera</div>
                            </div>
                            <div class="matrix-cell quadrant-important-not-urgent" data-important="1" data-urgent="0">
                                <div class="font-bold text-green-600">Penting & Tidak Mendesak</div>
                                <div class="text-xs text-neutral-600 mt-1">Jadwalkan</div>
                            </div>
                            <div class="matrix-cell quadrant-not-important-urgent" data-important="0" data-urgent="1">
                                <div class="font-bold text-orange-600">Tidak Penting & Mendesak</div>
                                <div class="text-xs text-neutral-600 mt-1">Delegasikan</div>
                            </div>
                            <div class="matrix-cell quadrant-not-important-not-urgent" data-important="0" data-urgent="0">
                                <div class="font-bold text-blue-600">Tidak Penting & Tidak Mendesak</div>
                                <div class="text-xs text-neutral-600 mt-1">Eliminasi</div>
                            </div>
                        </div>
                        <input type="hidden" name="is_important" id="important-input" value="0">
                        <input type="hidden" name="is_urgent" id="urgent-input" value="0">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <div></div>
                <button type="button" onclick="nextStep()" class="app-button">
                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 2: Details -->
        <div class="form-step" id="step-2">
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Detail Task</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Tanggal Deadline
                        </label>
                        <input type="date" name="due_date" 
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               value="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Waktu (opsional)
                        </label>
                        <input type="time" name="due_time"
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Prioritas
                        </label>
                        <div class="grid grid-cols-4 gap-2" id="priority-selector">
                            <div class="priority-option priority-low" data-value="low">
                                <div class="text-center font-medium">Rendah</div>
                            </div>
                            <div class="priority-option priority-medium selected" data-value="medium">
                                <div class="text-center font-medium">Medium</div>
                            </div>
                            <div class="priority-option priority-high" data-value="high">
                                <div class="text-center font-medium">Tinggi</div>
                            </div>
                            <div class="priority-option priority-urgent" data-value="urgent">
                                <div class="text-center font-medium">Mendesak</div>
                            </div>
                        </div>
                        <input type="hidden" name="priority" id="priority-input" value="medium">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Estimasi Durasi (menit)
                        </label>
                        <input type="number" name="estimated_duration" min="1"
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Contoh: 30">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Level Kesulitan (1-5)
                        </label>
                        <select name="difficulty_level"
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Pilih level kesulitan</option>
                            <option value="1">1 - Sangat Mudah</option>
                            <option value="2">2 - Mudah</option>
                            <option value="3" selected>3 - Sedang</option>
                            <option value="4">4 - Sulit</option>
                            <option value="5">5 - Sangat Sulit</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Energi yang Dibutuhkan (1-5)
                        </label>
                        <div class="energy-level-selector">
                            <div class="energy-option energy-1" data-value="1">
                                <div class="text-sm">Sangat Rendah</div>
                            </div>
                            <div class="energy-option energy-2" data-value="2">
                                <div class="text-sm">Rendah</div>
                            </div>
                            <div class="energy-option energy-3 selected" data-value="3">
                                <div class="text-sm">Sedang</div>
                            </div>
                            <div class="energy-option energy-4" data-value="4">
                                <div class="text-sm">Tinggi</div>
                            </div>
                            <div class="energy-option energy-5" data-value="5">
                                <div class="text-sm">Sangat Tinggi</div>
                            </div>
                        </div>
                        <input type="hidden" name="energy_level_required" id="energy-input" value="3">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Tags (opsional)
                    </label>
                    <input type="text" name="tags"
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="Pisahkan dengan koma, contoh: kesehatan, rutin, penting">
                    <p class="text-xs text-neutral-500 mt-1">Gunakan tags untuk mengelompokkan task yang serupa</p>
                </div>
            </div>
            
            <div class="flex justify-between">
                <button type="button" onclick="prevStep()" class="app-button app-button-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
                <button type="button" onclick="nextStep()" class="app-button">
                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 3: Settings -->
        <div class="form-step" id="step-3">
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Pengaturan Lanjutan</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Task Berulang?
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3" id="recurring-selector">
                            <div class="recurring-option" data-value="none">
                                <div class="text-center font-medium">Tidak Berulang</div>
                            </div>
                            <div class="recurring-option" data-value="daily">
                                <div class="text-center font-medium">Harian</div>
                            </div>
                            <div class="recurring-option" data-value="weekly">
                                <div class="text-center font-medium">Mingguan</div>
                            </div>
                            <div class="recurring-option" data-value="monthly">
                                <div class="text-center font-medium">Bulanan</div>
                            </div>
                            <div class="recurring-option" data-value="weekdays">
                                <div class="text-center font-medium">Weekdays</div>
                            </div>
                            <div class="recurring-option" data-value="weekends">
                                <div class="text-center font-medium">Weekends</div>
                            </div>
                        </div>
                        <input type="hidden" name="is_recurring" id="is-recurring-input" value="0">
                        <input type="hidden" name="recurring_pattern" id="recurring-pattern-input" value="">
                    </div>
                    
                    <div id="recurring-details" style="display: none;">
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Hari (untuk mingguan)
                            </label>
                            <div class="day-selector">
                                <div class="day-option" data-day="0">M</div>
                                <div class="day-option" data-day="1">S</div>
                                <div class="day-option" data-day="2">S</div>
                                <div class="day-option" data-day="3">R</div>
                                <div class="day-option" data-day="4">K</div>
                                <div class="day-option" data-day="5">J</div>
                                <div class="day-option" data-day="6">S</div>
                            </div>
                            <input type="hidden" name="recurring_days" id="recurring-days-input">
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Tanggal Berakhir (opsional)
                            </label>
                            <input type="date" name="recurring_end_date"
                                   class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Reminder (menit sebelum)
                        </label>
                        <select name="reminder_before"
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Tidak ada reminder</option>
                            <option value="5">5 menit sebelum</option>
                            <option value="15">15 menit sebelum</option>
                            <option value="30" selected>30 menit sebelum</option>
                            <option value="60">1 jam sebelum</option>
                            <option value="120">2 jam sebelum</option>
                            <option value="1440">1 hari sebelum</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Subtasks (opsional)
                        </label>
                        <div id="subtasks-container">
                            <div class="flex gap-2 mb-2">
                                <input type="text" placeholder="Nama subtask"
                                       class="flex-1 px-3 py-2 border border-neutral-300 rounded-duo">
                                <button type="button" onclick="addSubtask(this)"
                                        class="app-button px-3 py-2">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-neutral-500 mt-1">Tambahkan subtask untuk memecah task besar menjadi bagian kecil</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <button type="button" onclick="prevStep()" class="app-button app-button-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
                <button type="button" onclick="nextStep()" class="app-button">
                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 4: Review -->
        <div class="form-step" id="step-4">
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Review Task</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-neutral-700 mb-2">Informasi Dasar</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-neutral-600">Judul:</span>
                                    <div class="font-medium" id="review-title"></div>
                                </div>
                                <div>
                                    <span class="text-sm text-neutral-600">Kategori:</span>
                                    <div class="font-medium" id="review-category"></div>
                                </div>
                                <div>
                                    <span class="text-sm text-neutral-600">Matrix:</span>
                                    <div class="font-medium" id="review-matrix"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-neutral-700 mb-2">Detail</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-neutral-600">Deadline:</span>
                                    <div class="font-medium" id="review-due-date"></div>
                                </div>
                                <div>
                                    <span class="text-sm text-neutral-600">Prioritas:</span>
                                    <div class="font-medium" id="review-priority"></div>
                                </div>
                                <div>
                                    <span class="text-sm text-neutral-600">Estimasi Durasi:</span>
                                    <div class="font-medium" id="review-duration"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-neutral-700 mb-2">Pengaturan Lanjutan</h4>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm text-neutral-600">Task Berulang:</span>
                                <div class="font-medium" id="review-recurring"></div>
                            </div>
                            <div>
                                <span class="text-sm text-neutral-600">Reminder:</span>
                                <div class="font-medium" id="review-reminder"></div>
                            </div>
                            <div>
                                <span class="text-sm text-neutral-600">Subtasks:</span>
                                <div class="font-medium" id="review-subtasks"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-primary-50 rounded-duo">
                        <h4 class="font-bold text-primary-800 mb-2">🎯 Poin yang akan didapat:</h4>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span class="font-bold" id="review-points">0</span>
                            <span class="text-neutral-600">points</span>
                        </div>
                        <p class="text-sm text-neutral-600 mt-1">Poin akan diberikan saat task diselesaikan</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <button type="button" onclick="prevStep()" class="app-button app-button-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
                <button type="submit" class="app-button">
                    <i class="fas fa-check mr-2"></i> Buat Task
                </button>
            </div>
        </div>
    </form>

    <!-- Templates Section -->
    <div class="card p-6 mt-8">
        <h2 class="text-xl font-bold text-neutral-800 mb-4">Gunakan Template</h2>
        <p class="text-neutral-600 mb-4">Pilih template untuk membuat task lebih cepat</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="templates-container">
            <!-- Templates will be loaded here -->
        </div>
        
        <div class="text-center mt-6">
            <a href="{{ route('task-templates.index') }}" class="text-primary-600 font-medium hover:text-primary-700">
                Lihat semua template <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 4;
    let selectedTemplate = null;
    
    document.addEventListener('DOMContentLoaded', function() {
        setupCategorySelector();
        setupMatrixSelector();
        setupPrioritySelector();
        setupEnergySelector();
        setupRecurringSelector();
        setupDaySelector();
        loadTemplates();
        
        // Set default values
        document.getElementById('category-input').value = 'self_care';
        document.getElementById('priority-input').value = 'medium';
        document.getElementById('energy-input').value = '3';
        document.getElementById('is-recurring-input').value = '0';
        
        // Select first category by default
        document.querySelector('.category-option').classList.add('selected');
        
        // Select no recurring by default
        document.querySelector('.recurring-option[data-value="none"]').classList.add('selected');
    });
    
    function setupCategorySelector() {
        const options = document.querySelectorAll('.category-option');
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('category-input').value = this.dataset.value;
            });
        });
    }
    
    function setupMatrixSelector() {
        const cells = document.querySelectorAll('.matrix-cell');
        cells.forEach(cell => {
            cell.addEventListener('click', function() {
                cells.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('important-input').value = this.dataset.important;
                document.getElementById('urgent-input').value = this.dataset.urgent;
            });
        });
    }
    
    function setupPrioritySelector() {
        const options = document.querySelectorAll('.priority-option');
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.classList.remove('priority-low', 'priority-medium', 'priority-high', 'priority-urgent');
                });
                this.classList.add('selected');
                this.classList.add(`priority-${this.dataset.value}`);
                document.getElementById('priority-input').value = this.dataset.value;
            });
        });
    }
    
    function setupEnergySelector() {
        const options = document.querySelectorAll('.energy-option');
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.classList.remove('energy-1', 'energy-2', 'energy-3', 'energy-4', 'energy-5');
                });
                this.classList.add('selected');
                this.classList.add(`energy-${this.dataset.value}`);
                document.getElementById('energy-input').value = this.dataset.value;
            });
        });
    }
    
    function setupRecurringSelector() {
        const options = document.querySelectorAll('.recurring-option');
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                const value = this.dataset.value;
                const detailsDiv = document.getElementById('recurring-details');
                
                if (value === 'none') {
                    document.getElementById('is-recurring-input').value = '0';
                    document.getElementById('recurring-pattern-input').value = '';
                    detailsDiv.style.display = 'none';
                } else {
                    document.getElementById('is-recurring-input').value = '1';
                    document.getElementById('recurring-pattern-input').value = value;
                    if (value === 'weekly') {
                        detailsDiv.style.display = 'block';
                    } else {
                        detailsDiv.style.display = 'none';
                    }
                }
            });
        });
    }
    
    function setupDaySelector() {
        const options = document.querySelectorAll('.day-option');
        const daysInput = document.getElementById('recurring-days-input');
        const selectedDays = [];
        
        options.forEach(option => {
            option.addEventListener('click', function() {
                this.classList.toggle('selected');
                const day = this.dataset.day;
                
                if (this.classList.contains('selected')) {
                    selectedDays.push(day);
                } else {
                    const index = selectedDays.indexOf(day);
                    if (index > -1) selectedDays.splice(index, 1);
                }
                
                daysInput.value = JSON.stringify(selectedDays);
            });
        });
    }
    
    function addSubtask(button) {
        const container = document.getElementById('subtasks-container');
        const input = button.previousElementSibling;
        const value = input.value.trim();
        
        if (value) {
            const subtaskDiv = document.createElement('div');
            subtaskDiv.className = 'flex items-center justify-between bg-neutral-50 p-2 rounded-duo mb-2';
            subtaskDiv.innerHTML = `
                <span class="flex-1">${value}</span>
                <button type="button" onclick="removeSubtask(this)" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
                <input type="hidden" name="subtasks[]" value="${value}">
            `;
            container.appendChild(subtaskDiv);
            input.value = '';
        }
    }
    
    function removeSubtask(button) {
        button.parentElement.remove();
    }
    
    async function loadTemplates() {
        try {
            const response = await fetch('/api/task-templates');
            const data = await response.json();
            
            const container = document.getElementById('templates-container');
            if (data.success && data.data.data.length > 0) {
                let html = '';
                data.data.data.slice(0, 3).forEach(template => {
                    html += `
                    <div class="template-card" onclick="useTemplate(${template.id})">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-duo bg-primary-100 flex items-center justify-center">
                                <span class="text-xl">${getCategoryIcon(template.category)}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-neutral-800">${template.name}</h4>
                                <p class="text-sm text-neutral-600">${template.category_name}</p>
                            </div>
                        </div>
                        ${template.description ? `<p class="text-sm text-neutral-600 mb-2">${template.description}</p>` : ''}
                        <div class="flex items-center justify-between text-sm text-neutral-500">
                            <span>${template.duration_hours || 'Tidak ada durasi'}</span>
                            <span>${template.usage_count} kali digunakan</span>
                        </div>
                    </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p class="text-neutral-600 text-center col-span-3">Belum ada template tersedia</p>';
            }
        } catch (error) {
            console.error('Error loading templates:', error);
        }
    }
    
    function getCategoryIcon(category) {
        const icons = {
            'self_care': '🛁',
            'therapy': '🧠',
            'medication': '💊',
            'exercise': '🏃',
            'social': '👥',
            'work': '💼',
            'mindfulness': '🧘',
            'creative': '🎨',
            'chores': '🧹',
            'other': '📝'
        };
        return icons[category] || '📝';
    }
    
    function useTemplate(templateId) {
        if (selectedTemplate === templateId) {
            // Deselect
            document.querySelectorAll('.template-card').forEach(card => card.classList.remove('selected'));
            selectedTemplate = null;
            resetForm();
        } else {
            // Select new template
            document.querySelectorAll('.template-card').forEach(card => card.classList.remove('selected'));
            event.target.closest('.template-card').classList.add('selected');
            selectedTemplate = templateId;
            loadTemplateData(templateId);
        }
    }
    
    async function loadTemplateData(templateId) {
        try {
            const response = await fetch(`/api/task-templates/${templateId}`);
            const data = await response.json();
            
            if (data.success) {
                const template = data.data;
                
                // Fill form with template data
                document.querySelector('input[name="title"]').value = template.name;
                document.querySelector('textarea[name="description"]').value = template.description || '';
                document.getElementById('category-input').value = template.category;
                document.getElementById('priority-input').value = template.priority || 'medium';
                document.getElementById('energy-input').value = template.energy_level_required || '3';
                document.querySelector('input[name="estimated_duration"]').value = template.estimated_duration || '';
                document.querySelector('select[name="difficulty_level"]').value = template.difficulty_level || '3';
                document.querySelector('input[name="tags"]').value = template.tags ? template.tags.join(', ') : '';
                
                // Update UI
                document.querySelectorAll('.category-option').forEach(opt => {
                    opt.classList.toggle('selected', opt.dataset.value === template.category);
                });
                
                document.querySelectorAll('.priority-option').forEach(opt => {
                    opt.classList.toggle('selected', opt.dataset.value === (template.priority || 'medium'));
                });
                
                showNotification(`Template "${template.name}" diterapkan!`, 'success');
            }
        } catch (error) {
            console.error('Error loading template data:', error);
        }
    }
    
    function resetForm() {
        document.getElementById('task-form').reset();
        document.getElementById('category-input').value = 'self_care';
        document.getElementById('priority-input').value = 'medium';
        document.getElementById('energy-input').value = '3';
        document.getElementById('is-recurring-input').value = '0';
        document.getElementById('recurring-pattern-input').value = '';
        
        // Reset UI selections
        document.querySelectorAll('.category-option').forEach((opt, index) => {
            opt.classList.toggle('selected', index === 0);
        });
        
        document.querySelectorAll('.priority-option').forEach(opt => {
            opt.classList.toggle('selected', opt.dataset.value === 'medium');
        });
        
        document.querySelector('.recurring-option[data-value="none"]').classList.add('selected');
        document.getElementById('recurring-details').style.display = 'none';
    }
    
    function nextStep() {
        if (currentStep < totalSteps) {
            // Validate current step
            if (!validateStep(currentStep)) {
                return;
            }
            
            // Update step indicator
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('completed');
            currentStep++;
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
            
            // Show next step
            document.querySelectorAll('.form-step').forEach(step => step.classList.remove('active'));
            document.getElementById(`step-${currentStep}`).classList.add('active');
            
            // If last step, update review
            if (currentStep === totalSteps) {
                updateReview();
            }
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            // Update step indicator
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
            currentStep--;
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
            document.querySelector(`.step[data-step="${currentStep + 1}"]`).classList.remove('completed');
            
            // Show previous step
            document.querySelectorAll('.form-step').forEach(step => step.classList.remove('active'));
            document.getElementById(`step-${currentStep}`).classList.add('active');
        }
    }
    
    function validateStep(step) {
        if (step === 1) {
            const title = document.querySelector('input[name="title"]').value.trim();
            const category = document.getElementById('category-input').value;
            
            if (!title) {
                showNotification('Judul task harus diisi', 'error');
                return false;
            }
            
            if (!category) {
                showNotification('Pilih kategori task', 'error');
                return false;
            }
            
            return true;
        }
        
        return true;
    }
    
    function updateReview() {
        // Basic info
        document.getElementById('review-title').textContent = document.querySelector('input[name="title"]').value;
        document.getElementById('review-category').textContent = document.querySelector('.category-option.selected .text-sm').textContent;
        
        // Matrix
        const important = document.getElementById('important-input').value;
        const urgent = document.getElementById('urgent-input').value;
        let matrixText = '';
        if (important === '1' && urgent === '1') matrixText = 'Penting & Mendesak';
        else if (important === '1' && urgent === '0') matrixText = 'Penting & Tidak Mendesak';
        else if (important === '0' && urgent === '1') matrixText = 'Tidak Penting & Mendesak';
        else matrixText = 'Tidak Penting & Tidak Mendesak';
        document.getElementById('review-matrix').textContent = matrixText;
        
        // Details
        const dueDate = document.querySelector('input[name="due_date"]').value;
        const dueTime = document.querySelector('input[name="due_time"]').value;
        document.getElementById('review-due-date').textContent = dueDate ? (dueTime ? `${dueDate} ${dueTime}` : dueDate) : 'Tidak ada';
        
        const priority = document.getElementById('priority-input').value;
        const priorityText = {
            'low': 'Rendah', 'medium': 'Medium', 'high': 'Tinggi', 'urgent': 'Mendesak'
        }[priority];
        document.getElementById('review-priority').textContent = priorityText;
        
        const duration = document.querySelector('input[name="estimated_duration"]').value;
        document.getElementById('review-duration').textContent = duration ? `${duration} menit` : 'Tidak ada';
        
        // Settings
        const isRecurring = document.getElementById('is-recurring-input').value;
        const pattern = document.getElementById('recurring-pattern-input').value;
        let recurringText = 'Tidak berulang';
        if (isRecurring === '1') {
            const patternText = {
                'daily': 'Harian', 'weekly': 'Mingguan', 'monthly': 'Bulanan',
                'weekdays': 'Weekdays', 'weekends': 'Weekends'
            }[pattern];
            recurringText = patternText || 'Berulang';
        }
        document.getElementById('review-recurring').textContent = recurringText;
        
        const reminder = document.querySelector('select[name="reminder_before"]').value;
        document.getElementById('review-reminder').textContent = reminder ? `${reminder} menit sebelum` : 'Tidak ada';
        
        const subtasks = document.querySelectorAll('input[name="subtasks[]"]');
        document.getElementById('review-subtasks').textContent = subtasks.length > 0 ? `${subtasks.length} subtasks` : 'Tidak ada';
        
        // Calculate points
        calculatePoints();
    }
    
    function calculatePoints() {
        let points = 10; // Base
        
        // Priority bonus
        const priority = document.getElementById('priority-input').value;
        points += {
            'low': 5, 'medium': 10, 'high': 15, 'urgent': 20
        }[priority] || 0;
        
        // Difficulty bonus
        const difficulty = document.querySelector('select[name="difficulty_level"]').value;
        if (difficulty) points += parseInt(difficulty) * 5;
        
        // Important/Urgent bonus
        const important = document.getElementById('important-input').value;
        const urgent = document.getElementById('urgent-input').value;
        if (important === '1') points += 10;
        if (urgent === '1') points += 5;
        
        // Energy required bonus
        const energy = document.getElementById('energy-input').value;
        if (energy) points += parseInt(energy) * 2;
        
        document.getElementById('review-points').textContent = points;
    }
    
    // Handle form submission
    document.getElementById('task-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification('Task berhasil dibuat!', 'success');
                setTimeout(() => {
                    window.location.href = '/tasks';
                }, 1500);
            } else {
                let errorMessage = data.message || 'Gagal membuat task';
                if (data.errors) {
                    errorMessage = Object.values(data.errors).flat().join(', ');
                }
                showNotification(errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error creating task:', error);
            showNotification('Terjadi kesalahan', 'error');
        }
    });
</script>
@endsection