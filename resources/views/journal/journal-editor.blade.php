{{-- resources/views/journal/journal-editor.blade.php --}}
<div class="card rounded-duo-xl p-6">
    <form action="{{ isset($journal) ? route('journal.update', $journal) : route('journal.store') }}" method="POST" id="journalForm">
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
                    <label class="flex-shrink-0 cursor-pointer transform transition-transform hover:scale-105 mood-option">
                        <input type="radio" name="mood" value="{{ $mood }}" 
                                class="hidden peer" 
                                {{ (isset($journal) && $journal->mood == $mood) ? 'checked' : '' }}
                                {{ old('mood') == $mood ? 'checked' : '' }}>
                        <div class="px-4 py-3 rounded-duo border-2 border-neutral-300 {{ $classes }} text-sm font-medium transition-all duration-200 shadow-duo-pressed peer-checked:shadow-duo">
                            {{ $mood }}
                        </div>
                    </label>
                @endforeach
            </div>
            <div class="flex items-center mt-2 text-sm text-neutral-500">
                <i class="fas fa-info-circle mr-2"></i>
                Select a mood to track your emotional state
            </div>
        </div>

        <!-- Title -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-neutral-700 mb-2">
                Journal Title
            </label>

            <div class="relative">
                <input type="text" name="title" placeholder="Give your journal a title (optional)..." 
                        value="{{ $journal->title ?? old('title') }}"
                        class="w-full px-4 py-4 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-lg font-bold bg-white shadow-duo-pressed focus:shadow-duo transition-all duration-200"
                        maxlength="255">
                <i class="fas fa-heading text-neutral-400 absolute right-4 top-4"></i>
                <div class="absolute bottom-2 right-4 text-xs text-neutral-500" id="titleCounter">
                    {{ strlen($journal->title ?? old('title') ?? '') }}/255
                </div>
            </div>
        </div>

        <!-- Rich Text Editor -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-neutral-700 mb-2">
                Journal Content
            </label>

            <!-- Toolbar -->
            <div class="flex flex-wrap gap-2 mb-3 p-3 bg-neutral-50 rounded-duo border-2 border-neutral-200 shadow-duo-pressed" id="editorToolbar">
                <button type="button" onclick="formatText('bold', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="bold" title="Bold">
                    <i class="fas fa-bold text-neutral-700"></i>
                </button>
                <button type="button" onclick="formatText('italic', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="italic" title="Italic">
                    <i class="fas fa-italic text-neutral-700"></i>
                </button>
                <button type="button" onclick="formatText('underline', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="underline" title="Underline">
                    <i class="fas fa-underline text-neutral-700"></i>
                </button>
                <button type="button" onclick="formatText('strikeThrough', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="strikeThrough" title="Strikethrough">
                    <i class="fas fa-strikethrough text-neutral-700"></i>
                </button>
                <div class="w-px h-6 bg-neutral-300 mx-1 my-auto"></div>
                <button type="button" onclick="formatText('justifyLeft', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="justifyLeft" title="Align Left">
                    <i class="fas fa-align-left text-neutral-700"></i>
                </button>
                <button type="button" onclick="formatText('justifyCenter', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="justifyCenter" title="Align Center">
                    <i class="fas fa-align-center text-neutral-700"></i>
                </button>
                <button type="button" onclick="formatText('justifyRight', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="justifyRight" title="Align Right">
                    <i class="fas fa-align-right text-neutral-700"></i>
                </button>
                <div class="w-px h-6 bg-neutral-300 mx-1 my-auto"></div>
                <button type="button" onclick="formatText('insertUnorderedList', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="insertUnorderedList" title="Bullet List">
                    <i class="fas fa-list-ul text-neutral-700"></i>
                </button>
                <button type="button" onclick="formatText('insertOrderedList', this)" class="p-2 rounded-duo hover:bg-white hover:shadow-duo transition-all duration-200 toolbar-button format-button" data-command="insertOrderedList" title="Numbered List">
                    <i class="fas fa-list-ol text-neutral-700"></i>
                </button>
                <div class="w-px h-6 bg-neutral-300 mx-1 my-auto"></div>
            </div>

            <!-- Content Editable Area -->
            <div id="editor" 
                    class="min-h-64 p-4 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-duo-pressed focus:shadow-duo transition-all duration-200"
                    contenteditable="true"
                    oninput="updateContent(); updateToolbarState();"
                    onfocus="handleEditorFocus()"
                    onblur="handleEditorBlur()"
                    onmouseup="updateToolbarState()"
                    onkeyup="updateToolbarState()">
                @if(isset($journal) && $journal->content)
                    {!! $journal->content !!}
                @elseif(old('content'))
                    {!! old('content') !!}
                @else
                    <div class="text-neutral-400 italic" id="placeholder">Write your thoughts freely... ✍️</div>
                @endif
            </div>
            
            <!-- Hidden input for form submission -->
            <textarea name="content" id="content" class="hidden">
                @if(isset($journal) && $journal->content)
                    {!! $journal->content !!}
                @elseif(old('content'))
                    {!! old('content') !!}
                @endif
            </textarea>

            <!-- Character counter for content -->
            <div class="flex justify-between items-center mt-2">
                <div class="text-xs text-neutral-500" id="contentCounter">
                    <span id="contentLength">0</span> characters written
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center pt-4 border-t border-neutral-200">
            <div class="text-sm text-neutral-500">
                <i class="fas fa-pencil-alt mr-1"></i>
                Write as much or as little as you want
            </div>
            <div class="flex space-x-3">
                @if(isset($journal))
                    <a href="{{ route('journal.index') }}" class="app-button-secondary px-6 py-3 rounded-duo font-bold transition-all duration-200 flex items-center group">
                        <i class="fas fa-times mr-2 group-hover:scale-110 transition-transform"></i>
                        Cancel
                    </a>
                @else
                    <button type="button" onclick="clearForm()" class="app-button-secondary px-6 py-3 rounded-duo font-bold transition-all duration-200 flex items-center group">
                        <i class="fas fa-eraser mr-2 group-hover:scale-110 transition-transform"></i>
                        Clear
                    </button>
                @endif
                
                <!-- Save Button -->
                <button type="button" 
                        class="save-button px-8 py-3 rounded-duo font-bold transition-all duration-300 flex items-center group relative overflow-hidden"
                        id="submitButton">
                    <span class="flex items-center">
                        <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                        <span id="buttonText">{{ isset($journal) ? 'Update Entry' : 'Save Entry' }}</span>
                    </span>
                    
                    <!-- Loading Spinner -->
                    <div id="buttonLoading" class="hidden absolute inset-0 bg-primary-600 rounded-duo flex items-center justify-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-white font-medium">Saving...</span>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Fungsi untuk memperbarui state toolbar
function updateToolbarState() {
    const editor = document.getElementById('editor');
    const formatButtons = document.querySelectorAll('.format-button');
    
    // Reset semua tombol
    formatButtons.forEach(button => {
        button.classList.remove('active');
        button.style.backgroundColor = '';
        button.style.color = '';
        button.style.boxShadow = '';
    });
    
    // Periksa state format untuk selection saat ini
    formatButtons.forEach(button => {
        const command = button.getAttribute('data-command');
        
        try {
            const isActive = document.queryCommandState(command);
            if (isActive) {
                button.classList.add('active');
                button.style.backgroundColor = '#58cc70';
                button.style.color = 'white';
                button.style.boxShadow = '0 2px 0 #45b259';
            }
        } catch (e) {
            console.error(`Error checking command state for ${command}:`, e);
        }
    });
}

// Update fungsi formatText untuk menerima parameter button
function formatText(command, buttonElement = null) {
    const editor = document.getElementById('editor');
    editor.focus();
    
    try {
        // Eksekusi command
        document.execCommand(command, false, null);
        
        // Update konten
        updateContent();
        
        // Update state toolbar
        updateToolbarState();
        
        // Jika ada buttonElement, toggle active state
        if (buttonElement) {
            const isNowActive = document.queryCommandState(command);
            
            if (isNowActive) {
                buttonElement.classList.add('active');
                buttonElement.style.backgroundColor = '#58cc70';
                buttonElement.style.color = 'white';
                buttonElement.style.boxShadow = '0 2px 0 #45b259';
            } else {
                buttonElement.classList.remove('active');
                buttonElement.style.backgroundColor = '';
                buttonElement.style.color = '';
                buttonElement.style.boxShadow = '';
            }
        }
        
    } catch (e) {
        console.error(`Error executing command ${command}:`, e);
    }
}

// Update fungsi clearFormatting
function clearFormatting() {
    const editor = document.getElementById('editor');
    editor.focus();
    
    try {
        // Clear semua format
        document.execCommand('removeFormat', false, null);
        document.execCommand('unlink', false, null);
        
        // Update konten
        updateContent();
        
        // Update toolbar state
        updateToolbarState();
        
        // Reset semua tombol format
        const formatButtons = document.querySelectorAll('.format-button');
        formatButtons.forEach(button => {
            button.classList.remove('active');
            button.style.backgroundColor = '';
            button.style.color = '';
            button.style.boxShadow = '';
        });
        
    } catch (e) {
        console.error('Error clearing formatting:', e);
    }
}

// Update fungsi handleEditorFocus untuk inisialisasi toolbar
function handleEditorFocus() {
    const editor = document.getElementById('editor');
    const placeholder = document.getElementById('placeholder');
    
    if (placeholder && editor.textContent.trim() === 'Write your thoughts freely... ✍️') {
        editor.innerHTML = '';
        editor.classList.remove('text-neutral-400', 'italic');
    }
    
    // Update toolbar state saat editor mendapat fokus
    setTimeout(() => {
        updateToolbarState();
    }, 100);
}

// Update fungsi handleEditorBlur untuk reset toolbar jika perlu
function handleEditorBlur() {
    const editor = document.getElementById('editor');
    
    if (!editor.textContent.trim()) {
        editor.innerHTML = '<div class="text-neutral-400 italic" id="placeholder">Write your thoughts freely... ✍️</div>';
    }
    
    // Tidak reset toolbar saat blur karena kita ingin state tetap terlihat
}

// Update fungsi updateContent untuk juga update toolbar
function updateContent() {
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    const contentLength = document.getElementById('contentLength');
    
    const placeholder = document.getElementById('placeholder');
    if (placeholder && editor.textContent.trim() !== 'Write your thoughts freely... ✍️') {
        placeholder.remove();
    }
    
    content.value = editor.innerHTML;
    
    const textContent = editor.textContent || editor.innerText;
    const charCount = textContent.replace(/\s+/g, ' ').trim().length;
    contentLength.textContent = charCount;
    
    // Update toolbar state saat konten berubah
    updateToolbarState();
}

// Inisialisasi saat DOM siap
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    
    // Inisialisasi toolbar state
    setTimeout(() => {
        updateToolbarState();
    }, 500);
    
    // Event listener untuk paste
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
        updateContent();
        updateToolbarState();
    });
    
    // Event listener untuk selection change
    document.addEventListener('selectionchange', function() {
        if (editor === document.activeElement) {
            updateToolbarState();
        }
    });
});
</script>

<style>
.toolbar-button.active {
    background: #58cc70 !important;
    color: white !important;
    box-shadow: 0 2px 0 #45b259 !important;
}

.toolbar-button.active i {
    color: white !important;
}

.toolbar-button:hover {
    background: #f3f4f6 !important;
}

.toolbar-button.active:hover {
    background: #4fc262 !important;
}
</style>