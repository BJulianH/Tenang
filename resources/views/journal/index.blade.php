@extends('layouts.app')

@section('title', 'Journal - Tenang')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">My Journal</h1>
        <p class="text-neutral-600 text-lg">Express your thoughts and feelings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Journal Editor -->
        <div class="lg:col-span-2">
            <div class="card rounded-duo-xl p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-edit text-primary-500 mr-3"></i>
                    {{ isset($journal) ? 'Edit Journal Entry' : 'New Journal Entry' }}
                </h2>
                
                <form action="{{ isset($journal) ? route('journal.update', $journal) : route('journal.store') }}" method="POST">
                    @csrf
                    @if(isset($journal))
                        @method('PUT')
                    @endif

                    <!-- Mood Selection -->
                    <div class="mb-6">
                        <label class="block text-lg font-bold text-neutral-700 mb-3 flex items-center">
                            <i class="fas fa-smile text-secondary-500 mr-2"></i>
                            How are you feeling today?
                        </label>
                        <div class="flex space-x-3 overflow-x-auto pb-4 scrollbar-hide">
                            @php
                                $moods = [
                                    '😊 Happy' => 'hover:bg-green-100 peer-checked:bg-green-100 peer-checked:border-green-400',
                                    '😢 Sad' => 'hover:bg-blue-100 peer-checked:bg-blue-100 peer-checked:border-blue-400',
                                    '😴 Tired' => 'hover:bg-purple-100 peer-checked:bg-purple-100 peer-checked:border-purple-400',
                                    '😌 Calm' => 'hover:bg-teal-100 peer-checked:bg-teal-100 peer-checked:border-teal-400',
                                    '😠 Angry' => 'hover:bg-red-100 peer-checked:bg-red-100 peer-checked:border-red-400',
                                    '😨 Anxious' => 'hover:bg-yellow-100 peer-checked:bg-yellow-100 peer-checked:border-yellow-400',
                                    '😃 Excited' => 'hover:bg-orange-100 peer-checked:bg-orange-100 peer-checked:border-orange-400',
                                    '😔 Depressed' => 'hover:bg-gray-100 peer-checked:bg-gray-100 peer-checked:border-gray-400'
                                ];
                            @endphp
                            
                            @foreach($moods as $mood => $classes)
                                <label class="flex-shrink-0 cursor-pointer transform transition-transform hover:scale-105">
                                    <input type="radio" name="mood" value="{{ $mood }}" 
                                           class="hidden peer" 
                                           {{ (isset($journal) && $journal->mood == $mood) ? 'checked' : '' }}>
                                    <div class="px-4 py-3 rounded-duo border-2 border-neutral-300 {{ $classes }} text-sm font-medium transition-all duration-200 shadow-duo-pressed peer-checked:shadow-duo">
                                        {{ $mood }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" name="title" placeholder="Give your journal a title..." 
                                   value="{{ $journal->title ?? old('title') }}"
                                   class="w-full px-4 py-4 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-lg font-bold bg-white shadow-duo-pressed focus:shadow-duo transition-all duration-200">
                            <i class="fas fa-heading text-neutral-400 absolute right-4 top-4"></i>
                        </div>
                    </div>

                    <!-- Rich Text Editor -->
                    <div class="mb-6">
                        <!-- Toolbar -->
                        <div class="flex flex-wrap gap-2 mb-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200 shadow-duo-pressed">
                            <button type="button" onclick="formatText('bold')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Bold">
                                <i class="fas fa-bold text-neutral-700"></i>
                            </button>
                            <button type="button" onclick="formatText('italic')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Italic">
                                <i class="fas fa-italic text-neutral-700"></i>
                            </button>
                            <button type="button" onclick="formatText('underline')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Underline">
                                <i class="fas fa-underline text-neutral-700"></i>
                            </button>
                            <button type="button" onclick="formatText('strikeThrough')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Strikethrough">
                                <i class="fas fa-strikethrough text-neutral-700"></i>
                            </button>
                            <div class="w-px h-6 bg-neutral-300 mx-1 my-auto"></div>
                            <button type="button" onclick="formatText('justifyLeft')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Align Left">
                                <i class="fas fa-align-left text-neutral-700"></i>
                            </button>
                            <button type="button" onclick="formatText('justifyCenter')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Align Center">
                                <i class="fas fa-align-center text-neutral-700"></i>
                            </button>
                            <button type="button" onclick="formatText('justifyRight')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Align Right">
                                <i class="fas fa-align-right text-neutral-700"></i>
                            </button>
                            <div class="w-px h-6 bg-neutral-300 mx-1 my-auto"></div>
                            <button type="button" onclick="formatText('insertUnorderedList')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Bullet List">
                                <i class="fas fa-list-ul text-neutral-700"></i>
                            </button>
                            <button type="button" onclick="formatText('insertOrderedList')" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200" title="Numbered List">
                                <i class="fas fa-list-ol text-neutral-700"></i>
                            </button>
                            <div class="w-px h-6 bg-neutral-300 mx-1 my-auto"></div>
                            <button type="button" onclick="clearFormatting()" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 text-sm font-medium text-neutral-700" title="Clear Formatting">
                                Clear
                            </button>
                        </div>

                        <!-- Content Editable Area -->
                        <div id="editor" 
                             class="min-h-64 p-4 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo-pressed focus:shadow-duo transition-all duration-200"
                             contenteditable="true"
                             oninput="updateContent()"
                             onfocus="handleEditorFocus()"
                             onblur="handleEditorBlur()">
                            @if(isset($journal) && $journal->content)
                                {!! $journal->content !!}
                            @else
                                <div class="text-neutral-400 italic" id="placeholder">Start writing your thoughts here... ✍️</div>
                            @endif
                        </div>
                        
                        <!-- Hidden input for form submission -->
                        <textarea name="content" id="content" class="hidden" required>
                            @if(isset($journal) && $journal->content)
                                {!! $journal->content !!}
                            @endif
                        </textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3">
                        @if(isset($journal))
                            <a href="{{ route('journal.index') }}" class="app-button-secondary px-6 py-3 rounded-duo font-bold transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        @endif
                        <button type="submit" class="app-button px-6 py-3 rounded-duo font-bold transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>
                            {{ isset($journal) ? 'Update Entry' : 'Save Entry' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Journal List -->
        <div class="space-y-6">
            <!-- Recent Entries -->
            <div class="card rounded-duo-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center">
                        <i class="fas fa-history text-accent-purple mr-3"></i>
                        Recent Entries
                    </h2>
                    <span class="gamification-badge px-3 py-1 text-sm font-bold">
                        {{ $journals->count() }} entries
                    </span>
                </div>
                
                <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($journals as $entry)
                        <div class="p-4 border-2 border-neutral-200 rounded-duo hover:border-primary-300 hover:shadow-duo transition-all duration-200 group cursor-pointer transform hover:scale-[1.02]" 
                             data-journal-id="{{ $entry->id }}"
                             onclick="window.location='{{ route('journal.index', ['edit' => $entry->id]) }}'">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-neutral-800 truncate text-lg">{{ $entry->title }}</h3>
                                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('journal.index', ['edit' => $entry->id]) }}" 
                                       class="p-2 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-duo transition-all duration-200"
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('journal.destroy', $entry) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-neutral-500 hover:text-red-600 hover:bg-red-50 rounded-duo transition-all duration-200"
                                                onclick="return confirm('Are you sure you want to delete this entry?')"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-neutral-600 line-clamp-2 journal-preview mb-2">
                                {!! strip_tags($entry->content) !!}
                            </div>
                            <div class="flex justify-between items-center mt-3 pt-2 border-t border-neutral-100">
                                <span class="text-xs font-medium px-2 py-1 bg-neutral-100 rounded-full text-neutral-600">
                                    {{ $entry->mood }}
                                </span>
                                <span class="text-xs text-neutral-500 font-medium">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $entry->created_at->format('M j, Y') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-neutral-500">
                            <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-book-open text-2xl text-secondary-500"></i>
                            </div>
                            <p class="font-medium text-lg">No journal entries yet</p>
                            <p class="text-sm mt-1">Start writing your first entry!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Writing Tips -->
            <div class="card rounded-duo-xl p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-secondary-500 mr-3"></i>
                    Writing Tips
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start p-3 bg-yellow-50 rounded-duo border border-yellow-200">
                        <i class="fas fa-heart text-yellow-500 mt-1 mr-3 text-lg"></i>
                        <p class="text-neutral-700 font-medium">Be honest and write without judgment</p>
                    </div>
                    <div class="flex items-start p-3 bg-blue-50 rounded-duo border border-blue-200">
                        <i class="fas fa-edit text-blue-500 mt-1 mr-3 text-lg"></i>
                        <p class="text-neutral-700 font-medium">Use formatting to emphasize important thoughts</p>
                    </div>
                    <div class="flex items-start p-3 bg-green-50 rounded-duo border border-green-200">
                        <i class="fas fa-brain text-green-500 mt-1 mr-3 text-lg"></i>
                        <p class="text-neutral-700 font-medium">Reflect on both positive and challenging experiences</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card rounded-duo-xl p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-accent-blue mr-3"></i>
                    Writing Stats
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-primary-50 rounded-duo border border-primary-200">
                        <div class="text-2xl font-bold text-primary-600">{{ $journals->count() }}</div>
                        <div class="text-sm text-neutral-600 font-medium">Total Entries</div>
                    </div>
                    <div class="text-center p-3 bg-secondary-50 rounded-duo border border-secondary-200">
                        <div class="text-2xl font-bold text-secondary-600">
                            {{ $journals->count() > 0 ? $journals->sortByDesc('created_at')->first()->created_at->diffForHumans() : 'N/A' }}
                        </div>
                        <div class="text-sm text-neutral-600 font-medium">Last Entry</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
.journal-preview {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
}

/* Style untuk content editable */
#editor:focus {
    outline: none;
}

#editor b, #editor strong {
    font-weight: bold;
    color: #1f2937;
}

#editor i, #editor em {
    font-style: italic;
}

#editor u {
    text-decoration: underline;
}

#editor s, #editor strike {
    text-decoration: line-through;
}

#editor ul, #editor ol {
    padding-left: 2rem;
    margin: 0.5rem 0;
}

#editor ul {
    list-style-type: disc;
}

#editor ol {
    list-style-type: decimal;
}

#editor li {
    margin: 0.25rem 0;
}

.placeholder {
    color: #9CA3AF;
}

/* Custom scrollbar untuk journal list */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #58cc70;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #45b259;
}

/* Hide scrollbar for mood selector */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Animation untuk journal entries */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.5s ease-out;
}

/* Hover effects untuk mood buttons */
.mood-option {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.mood-option:hover {
    transform: translateY(-2px);
}

/* Style untuk toolbar buttons aktif */
.toolbar-button.active {
    background: #58cc70;
    color: white;
}

/* Gradient border untuk card yang aktif */
.card-active {
    background: linear-gradient(135deg, #58cc70, #ffc800) padding-box,
                linear-gradient(135deg, #58cc70, #ffc800) border-box;
    border: 2px solid transparent;
}
</style>
@endsection

@section('scripts')
<script>
function formatText(command, value = null) {
    document.getElementById('editor').focus();
    document.execCommand(command, false, value);
    updateContent();
    
    // Add active state to toolbar button
    const buttons = document.querySelectorAll('.toolbar-button');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    setTimeout(() => {
        event.target.classList.remove('active');
    }, 300);
}

function clearFormatting() {
    document.getElementById('editor').focus();
    document.execCommand('removeFormat', false, null);
    document.execCommand('unlink', false, null);
    updateContent();
}

function updateContent() {
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    
    // Hapus placeholder jika ada
    const placeholder = document.getElementById('placeholder');
    if (placeholder && editor.textContent.trim() !== 'Start writing your thoughts here... ✍️') {
        placeholder.remove();
    }
    
    content.value = editor.innerHTML;
}

function handleEditorFocus() {
    const editor = document.getElementById('editor');
    const placeholder = document.getElementById('placeholder');
    
    // Jika konten hanya berisi placeholder, kosongkan editor
    if (placeholder && editor.textContent.trim() === 'Start writing your thoughts here... ✍️') {
        editor.innerHTML = '';
        editor.classList.remove('text-neutral-400', 'italic');
    }
}

function handleEditorBlur() {
    const editor = document.getElementById('editor');
    
    // Jika editor kosong, tambahkan placeholder kembali
    if (!editor.textContent.trim()) {
        editor.innerHTML = '<div class="text-neutral-400 italic" id="placeholder">Start writing your thoughts here... ✍️</div>';
    }
}

// Initialize editor content
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    
    // Pastikan content hidden field terisi dengan benar
    if (!editor.textContent.trim() || editor.textContent.trim() === 'Start writing your thoughts here... ✍️') {
        content.value = '';
    } else {
        content.value = editor.innerHTML;
    }
    
    // Update content on paste
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
        updateContent();
    });
    
    // Handle keyboard events untuk mencegah penghapusan placeholder yang tidak diinginkan
    editor.addEventListener('keydown', function(e) {
        const placeholder = document.getElementById('placeholder');
        if (placeholder && editor.textContent.trim() === 'Start writing your thoughts here... ✍️' && e.key.length === 1) {
            editor.innerHTML = '';
            editor.classList.remove('text-neutral-400', 'italic');
        }
    });

    // Add animation to mood selection
    const moodOptions = document.querySelectorAll('input[name="mood"]');
    moodOptions.forEach(option => {
        option.addEventListener('change', function() {
            const allLabels = document.querySelectorAll('input[name="mood"] + div');
            allLabels.forEach(label => {
                label.style.transform = 'scale(1)';
            });
            
            if (this.checked) {
                this.nextElementSibling.style.transform = 'scale(1.05)';
            }
        });
    });
});

// Handle edit parameter
@if(request()->has('edit'))
    document.addEventListener('DOMContentLoaded', function() {
        const journalEntry = document.querySelector('[data-journal-id="{{ request('edit') }}"]');
        if (journalEntry) {
            journalEntry.scrollIntoView({ behavior: 'smooth', block: 'center' });
            journalEntry.classList.add('ring-4', 'ring-primary-500', 'ring-opacity-50');
            
            // Remove highlight after 3 seconds
            setTimeout(() => {
                journalEntry.classList.remove('ring-4', 'ring-primary-500', 'ring-opacity-50');
            }, 3000);
        }
    });
@endif

// Add click animation to cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card, .gamification-badge, .sidebar-item');
    
    cards.forEach(card => {
        card.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.98)';
        });
        
        card.addEventListener('mouseup', function() {
            this.style.transform = 'scale(1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection