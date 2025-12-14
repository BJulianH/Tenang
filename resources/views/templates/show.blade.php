    @extends('layouts.app')

@section('title', $template->name . ' - Tenang')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">{{ $template->name }}</h1>
            <div class="flex items-center gap-3 mt-2">
                <span class="text-sm px-3 py-1 rounded-full bg-primary-100 text-primary-800 font-medium">
                    {{ $template->category_name }}
                </span>
                @if($template->is_public)
                    <span class="text-sm px-3 py-1 rounded-full bg-green-100 text-green-800 font-medium">
                        <i class="fas fa-globe mr-1"></i> Public Template
                    </span>
                @endif
                <span class="text-sm text-neutral-500">
                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                    {{ $template->usage_count }} kali digunakan
                </span>
            </div>
        </div>
        
        <div class="mt-4 md:mt-0 flex gap-3">
            @if($template->user_id === auth()->id())
                <a href="{{ route('task-templates.edit', $template) }}" class="app-button app-button-secondary flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
            @endif
            
            <form action="{{ route('task-templates.create-task', $template) }}" method="POST">
                @csrf
                <button type="submit" class="app-button flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Buat Task</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Template Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2">
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Deskripsi Template</h2>
                
                @if($template->description)
                    <p class="text-neutral-600 mb-6">{{ $template->description }}</p>
                @else
                    <p class="text-neutral-400 italic mb-6">Tidak ada deskripsi</p>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Details -->
                    <div>
                        <h3 class="font-bold text-neutral-700 mb-3">Detail</h3>
                        <div class="space-y-3">
                            @if($template->estimated_duration)
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-primary-600 w-5 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-neutral-600">Estimasi Durasi</p>
                                        <p class="font-medium">{{ $template->duration_hours }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($template->energy_level_required)
                                <div class="flex items-center">
                                    <i class="fas fa-bolt text-yellow-600 w-5 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-neutral-600">Level Energi</p>
                                        <p class="font-medium">{{ $template->energy_level_required }}/5</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($template->difficulty_level)
                                <div class="flex items-center">
                                    <i class="fas fa-chart-line text-purple-600 w-5 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-neutral-600">Level Kesulitan</p>
                                        <p class="font-medium">{{ $template->difficulty_level }}/5</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Priority & Importance -->
                    <div>
                        <h3 class="font-bold text-neutral-700 mb-3">Prioritas & Penting</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-flag text-blue-600 w-5 mr-3"></i>
                                <div>
                                    <p class="text-sm text-neutral-600">Prioritas</p>
                                    <p class="font-medium">{{ ucfirst($template->priority) }}</p>
                                </div>
                            </div>
                            
                            @if($template->is_important)
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-600 w-5 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-neutral-600">Status</p>
                                        <p class="font-medium">Penting</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($template->is_urgent)
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation text-red-600 w-5 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-neutral-600">Status</p>
                                        <p class="font-medium">Mendesak</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Tags -->
                @if($template->tags && count(json_decode($template->tags, true)) > 0)
                    <div class="mt-6 pt-6 border-t border-neutral-200">
                        <h3 class="font-bold text-neutral-700 mb-3">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(json_decode($template->tags, true) as $tag)
                                <span class="px-3 py-1 bg-neutral-100 text-neutral-600 rounded-full text-sm">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Quick Create Form -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Buat Task dari Template</h2>
                <form action="{{ route('task-templates.create-task', $template) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Tanggal Deadline
                            </label>
                            <input type="date" name="due_date" 
                                   class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   value="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Waktu (opsional)
                            </label>
                            <input type="time" name="due_time"
                                   class="w-full px-4 py-2 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-neutral-600">
                            Task akan dibuat dengan pengaturan template
                        </div>
                        
                        <button type="submit" class="app-button flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Buat Task Sekarang</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Right Column: Stats & Actions -->
        <div>
            <!-- Template Stats -->
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Statistik</h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-neutral-600 mb-1">Penggunaan</p>
                        <h3 class="text-2xl font-bold text-neutral-800">{{ $template->usage_count }}</h3>
                        <p class="text-xs text-neutral-500">kali digunakan</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-neutral-600 mb-1">Dibuat</p>
                        <p class="font-medium">{{ $template->created_at->translatedFormat('d F Y') }}</p>
                        <p class="text-xs text-neutral-500">{{ $template->created_at->diffForHumans() }}</p>
                    </div>
                    
                    @if($template->updated_at != $template->created_at)
                        <div>
                            <p class="text-sm text-neutral-600 mb-1">Terakhir diupdate</p>
                            <p class="font-medium">{{ $template->updated_at->translatedFormat('d F Y') }}</p>
                            <p class="text-xs text-neutral-500">{{ $template->updated_at->diffForHumans() }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Owner Info -->
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Pemilik Template</h2>
                
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="font-bold text-primary-800">
                            {{ substr($template->user->name ?? 'U', 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-neutral-800">{{ $template->user->name ?? 'User' }}</p>
                        <p class="text-sm text-neutral-600">
                            @if($template->user_id === auth()->id())
                                Template pribadi Anda
                            @else
                                Template publik dari komunitas
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($template->user_id !== auth()->id())
                    <div class="mt-4 pt-4 border-t border-neutral-200">
                        <a href="{{ route('task-templates.duplicate', $template) }}" 
                           class="w-full app-button app-button-secondary flex items-center justify-center gap-2">
                            <i class="fas fa-copy"></i>
                            <span>Simpan sebagai Template Pribadi</span>
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Quick Actions -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4">Aksi Cepat</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('task-templates.index') }}" 
                       class="flex items-center gap-3 p-3 rounded-duo hover:bg-neutral-50 transition-colors text-neutral-700">
                        <i class="fas fa-list text-primary-600"></i>
                        <span>Lihat Semua Template</span>
                    </a>
                    
                    <a href="{{ route('tasks.create') }}" 
                       class="flex items-center gap-3 p-3 rounded-duo hover:bg-neutral-50 transition-colors text-neutral-700">
                        <i class="fas fa-plus-circle text-green-600"></i>
                        <span>Buat Task Baru</span>
                    </a>
                    
                    @if($template->user_id === auth()->id())
                        <a href="{{ route('task-templates.edit', $template) }}" 
                           class="flex items-center gap-3 p-3 rounded-duo hover:bg-neutral-50 transition-colors text-neutral-700">
                            <i class="fas fa-edit text-blue-600"></i>
                            <span>Edit Template</span>
                        </a>
                        
                        <form action="{{ route('task-templates.destroy', $template) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus template ini?')"
                                    class="w-full flex items-center gap-3 p-3 rounded-duo hover:bg-red-50 transition-colors text-red-600">
                                <i class="fas fa-trash"></i>
                                <span>Hapus Template</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection