@extends('layouts.app')

@section('title', 'Buat Template Baru - Tenang')

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
    
    .energy-option {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
        font-weight: bold;
    }
    
    .energy-option:hover {
        transform: scale(1.1);
    }
    
    .energy-option.selected {
        color: white;
    }
    
    .energy-1.selected { background: #ef4444; border-color: #ef4444; }
    .energy-2.selected { background: #f97316; border-color: #f97316; }
    .energy-3.selected { background: #eab308; border-color: #eab308; }
    .energy-4.selected { background: #22c55e; border-color: #22c55e; }
    .energy-5.selected { background: #3b82f6; border-color: #3b82f6; }
    
    .difficulty-option {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
        font-weight: bold;
    }
    
    .difficulty-option:hover {
        transform: scale(1.1);
    }
    
    .difficulty-option.selected {
        color: white;
    }
    
    .difficulty-1.selected { background: #22c55e; border-color: #22c55e; }
    .difficulty-2.selected { background: #4ade80; border-color: #4ade80; }
    .difficulty-3.selected { background: #eab308; border-color: #eab308; }
    .difficulty-4.selected { background: #f97316; border-color: #f97316; }
    .difficulty-5.selected { background: #ef4444; border-color: #ef4444; }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">Buat Template Baru</h1>
        <p class="text-neutral-600 mt-1">Buat template untuk tugas yang sering diulang</p>
    </div>

    <!-- Form -->
    <form action="{{ route('task-templates.store') }}" method="POST">
        @csrf
        
        <div class="card p-6 mb-6">
            <h2 class="text-xl font-bold text-neutral-800 mb-4">Informasi Dasar</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Nama Template <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="Contoh: Minum Obat Pagi, Meditasi 10 Menit">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Deskripsi (opsional)
                    </label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Deskripsi template..."></textarea>
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
                    <input type="hidden" name="category" id="category-input" value="other" required>
                </div>
            </div>
        </div>
        
        <div class="card p-6 mb-6">
            <h2 class="text-xl font-bold text-neutral-800 mb-4">Detail Template</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Prioritas <span class="text-red-500">*</span>
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
                    <input type="hidden" name="priority" id="priority-input" value="medium" required>
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
                        Level Energi (1-5)
                    </label>
                    <div class="flex gap-2" id="energy-selector">
                        <div class="energy-option" data-value="1">1</div>
                        <div class="energy-option" data-value="2">2</div>
                        <div class="energy-option" data-value="3">3</div>
                        <div class="energy-option" data-value="4">4</div>
                        <div class="energy-option" data-value="5">5</div>
                    </div>
                    <input type="hidden" name="energy_level_required" id="energy-input">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Level Kesulitan (1-5)
                    </label>
                    <div class="flex gap-2" id="difficulty-selector">
                        <div class="difficulty-option" data-value="1">1</div>
                        <div class="difficulty-option" data-value="2">2</div>
                        <div class="difficulty-option" data-value="3" data-selected="true">3</div>
                        <div class="difficulty-option" data-value="4">4</div>
                        <div class="difficulty-option" data-value="5">5</div>
                    </div>
                    <input type="hidden" name="difficulty_level" id="difficulty-input" value="3">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        Tags (opsional)
                    </label>
                    <input type="text" name="tags"
                           class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="Pisahkan dengan koma, contoh: kesehatan, rutin, pagi">
                    <p class="text-xs text-neutral-500 mt-1">Tags membantu mengelompokkan template serupa</p>
                </div>
            </div>
        </div>
        
        <div class="card p-6 mb-6">
            <h2 class="text-xl font-bold text-neutral-800 mb-4">Pengaturan Tambahan</h2>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_important" id="is_important" class="mr-3 h-5 w-5">
                    <label for="is_important" class="text-sm font-medium text-neutral-700">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Tandai sebagai penting
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_urgent" id="is_urgent" class="mr-3 h-5 w-5">
                    <label for="is_urgent" class="text-sm font-medium text-neutral-700">
                        <i class="fas fa-exclamation text-red-500 mr-2"></i>
                        Tandai sebagai mendesak
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_public" id="is_public" class="mr-3 h-5 w-5">
                    <label for="is_public" class="text-sm font-medium text-neutral-700">
                        <i class="fas fa-globe text-blue-500 mr-2"></i>
                        Buat template publik (dapat digunakan oleh pengguna lain)
                    </label>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-duo p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Tips Template Publik</p>
                            <p class="text-xs text-blue-700 mt-1">
                                Template publik akan terlihat oleh semua pengguna Tenang dan dapat membantu komunitas.
                                Template pribadi hanya dapat diakses oleh Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-between">
            <a href="{{ route('task-templates.index') }}" class="app-button app-button-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Daftar</span>
            </a>
            
            <button type="submit" class="app-button flex items-center gap-2">
                <i class="fas fa-save"></i>
                <span>Simpan Template</span>
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setupCategorySelector();
        setupPrioritySelector();
        setupEnergySelector();
        setupDifficultySelector();
    });
    
    function setupCategorySelector() {
        const options = document.querySelectorAll('.category-option');
        const input = document.getElementById('category-input');
        
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                input.value = this.dataset.value;
            });
        });
        
        // Select 'other' by default
        document.querySelector('.category-option[data-value="other"]').classList.add('selected');
    }
    
    function setupPrioritySelector() {
        const options = document.querySelectorAll('.priority-option');
        const input = document.getElementById('priority-input');
        
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.classList.remove('priority-low', 'priority-medium', 'priority-high', 'priority-urgent');
                });
                this.classList.add('selected');
                this.classList.add(`priority-${this.dataset.value}`);
                input.value = this.dataset.value;
            });
        });
    }
    
    function setupEnergySelector() {
        const options = document.querySelectorAll('.energy-option');
        const input = document.getElementById('energy-input');
        
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.classList.remove('energy-1', 'energy-2', 'energy-3', 'energy-4', 'energy-5');
                });
                this.classList.add('selected');
                this.classList.add(`energy-${this.dataset.value}`);
                input.value = this.dataset.value;
            });
        });
    }
    
    function setupDifficultySelector() {
        const options = document.querySelectorAll('.difficulty-option');
        const input = document.getElementById('difficulty-input');
        
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.classList.remove('difficulty-1', 'difficulty-2', 'difficulty-3', 'difficulty-4', 'difficulty-5');
                });
                this.classList.add('selected');
                this.classList.add(`difficulty-${this.dataset.value}`);
                input.value = this.dataset.value;
            });
        });
        
        // Select difficulty 3 by default
        document.querySelector('.difficulty-option[data-value="3"]').click();
    }
</script>
@endsection