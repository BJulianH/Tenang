@extends('layouts.app')

@section('title', 'Journal - MindWell')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-neutral-800">My Journal</h1>
        <p class="text-neutral-600">Express your thoughts and feelings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Journal Editor -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <h2 class="text-lg font-bold text-neutral-800 mb-4">
                    {{ isset($journal) ? 'Edit Journal Entry' : 'New Journal Entry' }}
                </h2>
                
                <form action="{{ isset($journal) ? route('journal.update', $journal) : route('journal.store') }}" method="POST">
                    @csrf
                    @if(isset($journal))
                        @method('PUT')
                    @endif

                    <!-- Mood Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">How are you feeling?</label>
                        <div class="flex space-x-2 overflow-x-auto pb-2">
                            @foreach(['😊 Happy', '😢 Sad', '😴 Tired', '😌 Calm', '😠 Angry', '😨 Anxious', '😃 Excited', '😔 Depressed'] as $mood)
                                <label class="flex-shrink-0 cursor-pointer">
                                    <input type="radio" name="mood" value="{{ $mood }}" 
                                           class="hidden peer" 
                                           {{ (isset($journal) && $journal->mood == $mood) ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-full border border-neutral-300 peer-checked:border-primary-500 peer-checked:bg-primary-50 text-sm hover:bg-neutral-50 transition-colors">
                                        {{ $mood }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <input type="text" name="title" placeholder="Journal Title" 
                               value="{{ $journal->title ?? old('title') }}"
                               class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-lg font-medium">
                    </div>

                    <!-- Rich Text Editor -->
                    <div class="mb-4">
                        <!-- Toolbar -->
                        <div class="flex flex-wrap gap-1 mb-2 p-2 bg-neutral-50 rounded-lg border border-neutral-200">
                            <button type="button" onclick="formatText('bold')" class="p-2 rounded hover:bg-neutral-200" title="Bold">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" onclick="formatText('italic')" class="p-2 rounded hover:bg-neutral-200" title="Italic">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" onclick="formatText('underline')" class="p-2 rounded hover:bg-neutral-200" title="Underline">
                                <i class="fas fa-underline"></i>
                            </button>
                            <button type="button" onclick="formatText('strikeThrough')" class="p-2 rounded hover:bg-neutral-200" title="Strikethrough">
                                <i class="fas fa-strikethrough"></i>
                            </button>
                            <div class="w-px h-6 bg-neutral-300 mx-1"></div>
                            <button type="button" onclick="formatText('justifyLeft')" class="p-2 rounded hover:bg-neutral-200" title="Align Left">
                                <i class="fas fa-align-left"></i>
                            </button>
                            <button type="button" onclick="formatText('justifyCenter')" class="p-2 rounded hover:bg-neutral-200" title="Align Center">
                                <i class="fas fa-align-center"></i>
                            </button>
                            <button type="button" onclick="formatText('justifyRight')" class="p-2 rounded hover:bg-neutral-200" title="Align Right">
                                <i class="fas fa-align-right"></i>
                            </button>
                            <div class="w-px h-6 bg-neutral-300 mx-1"></div>
                            <button type="button" onclick="formatText('insertUnorderedList')" class="p-2 rounded hover:bg-neutral-200" title="Bullet List">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button type="button" onclick="formatText('insertOrderedList')" class="p-2 rounded hover:bg-neutral-200" title="Numbered List">
                                <i class="fas fa-list-ol"></i>
                            </button>
                            <div class="w-px h-6 bg-neutral-300 mx-1"></div>
                            <button type="button" onclick="clearFormatting()" class="p-2 rounded hover:bg-neutral-200 text-sm font-medium" title="Clear Formatting">
                                Clear
                            </button>
                        </div>

                        <!-- Content Editable Area -->
                        <div id="editor" 
                             class="min-h-64 p-4 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                             contenteditable="true"
                             oninput="updateContent()"
                             onfocus="handleEditorFocus()"
                             onblur="handleEditorBlur()">
                            @if(isset($journal) && $journal->content)
                                {!! $journal->content !!}
                            @else
                                <div class="text-neutral-400" id="placeholder">Start writing your thoughts here...</div>
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
                            <a href="{{ route('journal.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 hover:bg-neutral-50 transition-colors">
                                Cancel
                            </a>
                        @endif
                        <button type="submit" class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                            {{ isset($journal) ? 'Update Entry' : 'Save Entry' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Journal List -->
        <div class="space-y-6">
            <!-- Recent Entries -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-neutral-800">Recent Entries</h2>
                    <span class="text-sm text-neutral-500">{{ $journals->count() }} entries</span>
                </div>
                
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($journals as $entry)
                        <div class="p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors group" data-journal-id="{{ $entry->id }}">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-neutral-800 truncate">{{ $entry->title }}</h3>
                                <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('journal.index', ['edit' => $entry->id]) }}" 
                                       class="p-1 text-neutral-500 hover:text-primary-600 transition-colors"
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('journal.destroy', $entry) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1 text-neutral-500 hover:text-red-600 transition-colors"
                                                onclick="return confirm('Are you sure you want to delete this entry?')"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-sm text-neutral-600 line-clamp-2 journal-preview">
                                {!! strip_tags($entry->content) !!}
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xs text-neutral-500">{{ $entry->mood }}</span>
                                <span class="text-xs text-neutral-500">{{ $entry->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-neutral-500">
                            <i class="fas fa-book-open text-3xl mb-2"></i>
                            <p>No journal entries yet</p>
                            <p class="text-sm">Start writing your first entry!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Writing Tips -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <h2 class="text-lg font-bold text-neutral-800 mb-4">Writing Tips</h2>
                <div class="space-y-3 text-sm text-neutral-600">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mt-1 mr-3"></i>
                        <p>Be honest and write without judgment</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mt-1 mr-3"></i>
                        <p>Use formatting to emphasize important thoughts</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mt-1 mr-3"></i>
                        <p>Reflect on both positive and challenging experiences</p>
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
}

/* Style untuk content editable */
#editor:focus {
    outline: none;
}

#editor b, #editor strong {
    font-weight: bold;
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
}

#editor ul {
    list-style-type: disc;
}

#editor ol {
    list-style-type: decimal;
}

.placeholder {
    color: #9CA3AF;
}
</style>
@endsection

@section('scripts')
<script>
function formatText(command, value = null) {
    document.getElementById('editor').focus();
    document.execCommand(command, false, value);
    updateContent();
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
    if (placeholder && editor.textContent.trim() !== 'Start writing your thoughts here...') {
        placeholder.remove();
    }
    
    content.value = editor.innerHTML;
}

function handleEditorFocus() {
    const editor = document.getElementById('editor');
    const placeholder = document.getElementById('placeholder');
    
    // Jika konten hanya berisi placeholder, kosongkan editor
    if (placeholder && editor.textContent.trim() === 'Start writing your thoughts here...') {
        editor.innerHTML = '';
        editor.classList.remove('text-neutral-400');
    }
}

function handleEditorBlur() {
    const editor = document.getElementById('editor');
    
    // Jika editor kosong, tambahkan placeholder kembali
    if (!editor.textContent.trim()) {
        editor.innerHTML = '<div class="text-neutral-400" id="placeholder">Start writing your thoughts here...</div>';
    }
}

// Initialize editor content
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    
    // Pastikan content hidden field terisi dengan benar
    if (!editor.textContent.trim() || editor.textContent.trim() === 'Start writing your thoughts here...') {
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
        if (placeholder && editor.textContent.trim() === 'Start writing your thoughts here...' && e.key.length === 1) {
            editor.innerHTML = '';
            editor.classList.remove('text-neutral-400');
        }
    });
});

// Handle edit parameter
@if(request()->has('edit'))
    document.addEventListener('DOMContentLoaded', function() {
        const journalEntry = document.querySelector('[data-journal-id="{{ request('edit') }}"]');
        if (journalEntry) {
            journalEntry.scrollIntoView({ behavior: 'smooth', block: 'center' });
            journalEntry.classList.add('ring-2', 'ring-primary-500');
        }
    });
@endif
</script>
@endsection