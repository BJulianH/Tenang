{{-- resources/views/journal/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Journal - Tenang')

@section('content')
    <!-- Mood Selection Modal -->
    <div id="moodModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative bg-white rounded-duo-xl p-6 mx-4 max-w-md w-full card">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-smile text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-neutral-800 mb-2">How are you feeling?</h3>
                <p class="text-neutral-600">Please select your current mood before saving</p>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-6">
                @php
                    $moods = [
                        '😊 Happy' => 'bg-green-100 border-green-400 hover:bg-green-200',
                        '😢 Sad' => 'bg-blue-100 border-blue-400 hover:bg-blue-200',
                        '😴 Tired' => 'bg-purple-100 border-purple-400 hover:bg-purple-200',
                        '😌 Calm' => 'bg-teal-100 border-teal-400 hover:bg-teal-200',
                        '😠 Angry' => 'bg-red-100 border-red-400 hover:bg-red-200',
                        '😨 Anxious' => 'bg-yellow-100 border-yellow-400 hover:bg-yellow-200',
                        '😃 Excited' => 'bg-orange-100 border-orange-400 hover:bg-orange-200',
                        '😔 Depressed' => 'bg-gray-100 border-gray-400 hover:bg-gray-200'
                    ];
                @endphp
                
                @foreach($moods as $mood => $classes)
                    <button type="button" 
                            class="mood-option-modal p-3 rounded-duo border-2 border-transparent {{ $classes }} transition-all duration-200 font-medium"
                            data-mood="{{ $mood }}">
                        {{ $mood }}
                    </button>
                @endforeach
            </div>

            <div class="flex space-x-3">
                <button type="button" id="cancelMood" class="flex-1 app-button-secondary py-3 rounded-duo font-bold">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Journal Editor -->
        <div class="lg:col-span-2">
            @include('journal.journal-editor', ['journal' => $journal ?? null])
        </div>

        <!-- Right Column - Journal List & Tips -->
        <div class="space-y-6">
            <!-- Recent Entries -->
            @include('journal.recent-entries', ['journals' => $journals])
            
            <!-- Writing Tips -->
            @include('journal.writing-tips')
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

/* Save Button Styles */
.save-button {
    background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
    color: white;
    box-shadow: 0 4px 0 #3a9549;
    border: none;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.save-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 0 #3a9549;
    background: linear-gradient(135deg, #67d47f 0%, #4fc262 100%);
}

.save-button:active:not(:disabled) {
    transform: translateY(1px);
    box-shadow: 0 2px 0 #3a9549;
}

.save-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
    box-shadow: 0 4px 0 #3a9549;
}

/* Modal Styles */
#moodModal {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.mood-option-modal {
    transition: all 0.2s ease;
}

.mood-option-modal:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
}

.mood-option-modal:active {
    transform: translateY(0);
    box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
}

/* Notification Styles - Top Center Below Navbar */
.notification-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    display: flex;
    justify-content: center;
    padding-top: 6rem; /* Space below navbar */
    pointer-events: none;
}

.notification {
    animation: slideInDown 0.3s ease-out;
    pointer-events: auto;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-radius: 16px;
    transform-origin: top center;
}

.notification.fade-out {
    animation: slideOutUp 0.3s ease-in forwards;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-100%);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideOutUp {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-100%);
    }
}

/* Content Editable Styles */
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

/* Scrollbar Styles */
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

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Animations */
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

/* Toolbar Button Active State */
.toolbar-button.active {
    background: #58cc70;
    color: white;
    box-shadow: 0 2px 0 #45b259;
}

/* Mood Option Hover Effects */
.mood-option {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.mood-option:hover {
    transform: translateY(-2px);
}
</style>
@endsection

@section('scripts')
<script>
// Global variables
let isSubmitting = false;
let pendingFormSubmission = false;

// Notification system - Top Center Below Navbar
function showNotification(message, type = 'info') {
    // Create notification overlay if it doesn't exist
    let notificationOverlay = document.getElementById('notificationOverlay');
    if (!notificationOverlay) {
        notificationOverlay = document.createElement('div');
        notificationOverlay.id = 'notificationOverlay';
        notificationOverlay.className = 'notification-overlay';
        document.body.appendChild(notificationOverlay);
    }
    
    const styles = {
        success: 'bg-green-50 border-green-300 text-green-700 border-2',
        error: 'bg-red-50 border-red-300 text-red-700 border-2',
        info: 'bg-blue-50 border-blue-300 text-blue-700 border-2'
    };
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const titles = {
        success: 'Success!',
        error: 'Error!',
        info: 'Notice'
    };
    
    const notification = document.createElement('div');
    notification.className = `notification p-4 ${styles[type]}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 ${
                type === 'success' ? 'bg-green-100' : 
                type === 'error' ? 'bg-red-100' : 'bg-blue-100'
            }">
                <i class="fas ${icons[type]} text-xl ${
                    type === 'success' ? 'text-green-600' : 
                    type === 'error' ? 'text-red-600' : 'text-blue-600'
                }"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-lg">${titles[type]}</h3>
                <p class="font-medium">${message}</p>
            </div>
            <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    notificationOverlay.appendChild(notification);
    
    // Auto remove after 2 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.add('fade-out');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
                // Remove overlay if no more notifications
                if (notificationOverlay.children.length === 0) {
                    notificationOverlay.remove();
                }
            }, 300);
        }
    }, 2000);
}

// Mood Modal Functions
function showMoodModal() {
    const modal = document.getElementById('moodModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideMoodModal() {
    const modal = document.getElementById('moodModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

function selectMoodFromModal(mood) {
    // Find and check the corresponding radio button
    const radioInput = document.querySelector(`input[name="mood"][value="${mood}"]`);
    if (radioInput) {
        radioInput.checked = true;
        
        // Trigger change event to update UI
        radioInput.dispatchEvent(new Event('change'));
        
        showNotification(`Mood set to: ${mood}`, 'success');
    }
    
    hideMoodModal();
    
    // If there was a pending form submission, submit it now
    if (pendingFormSubmission) {
        submitForm();
        pendingFormSubmission = false;
    }
}

// Form submission handling
function submitForm() {
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('journalForm');
    
    if (isSubmitting) {
        return;
    }
    
    // Show loading state
    isSubmitting = true;
    setButtonState(submitButton, 'loading');
    
    // Submit the form
    form.submit();
}

function handleSaveClick() {
    const moodSelected = document.querySelector('input[name="mood"]:checked');
    
    if (!moodSelected) {
        // Show mood selection modal
        pendingFormSubmission = true;
        showMoodModal();
    } else {
        // Submit form directly
        submitForm();
    }
}

function formatText(command, value = null) {
    document.getElementById('editor').focus();
    document.execCommand(command, false, value);
    updateContent();
    
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
    const contentLength = document.getElementById('contentLength');
    
    const placeholder = document.getElementById('placeholder');
    if (placeholder && editor.textContent.trim() !== 'Write your thoughts freely... ✍️') {
        placeholder.remove();
    }
    
    content.value = editor.innerHTML;
    
    const textContent = editor.textContent || editor.innerText;
    const charCount = textContent.replace(/\s+/g, ' ').trim().length;
    contentLength.textContent = charCount;
}

function handleEditorFocus() {
    const editor = document.getElementById('editor');
    const placeholder = document.getElementById('placeholder');
    
    if (placeholder && editor.textContent.trim() === 'Write your thoughts freely... ✍️') {
        editor.innerHTML = '';
        editor.classList.remove('text-neutral-400', 'italic');
    }
}

function handleEditorBlur() {
    const editor = document.getElementById('editor');
    
    if (!editor.textContent.trim()) {
        editor.innerHTML = '<div class="text-neutral-400 italic" id="placeholder">Write your thoughts freely... ✍️</div>';
    }
}

function clearForm() {
    if (confirm('Are you sure you want to clear all fields?')) {
        document.getElementById('journalForm').reset();
        document.getElementById('editor').innerHTML = '<div class="text-neutral-400 italic" id="placeholder">Write your thoughts freely... ✍️</div>';
        document.getElementById('content').value = '';
        document.getElementById('titleCounter').textContent = '0/255';
        document.getElementById('contentLength').textContent = '0';
        
        document.querySelectorAll('input[name="mood"]').forEach(radio => {
            radio.checked = false;
        });
        
        showNotification('Form cleared successfully!', 'success');
    }
}

function confirmDelete() {
    return confirm('Are you sure you want to delete this journal entry?');
}

function setButtonState(button, state) {
    const buttonText = document.getElementById('buttonText');
    const buttonLoading = document.getElementById('buttonLoading');
    
    button.disabled = state === 'loading';
    
    if (state === 'loading') {
        buttonText.classList.add('hidden');
        buttonLoading.classList.remove('hidden');
    } else {
        buttonText.classList.remove('hidden');
        buttonLoading.classList.add('hidden');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    const titleInput = document.querySelector('input[name="title"]');
    const titleCounter = document.getElementById('titleCounter');
    const saveButton = document.getElementById('submitButton');
    
    // Show any session messages as temporary notifications
    @if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showNotification('{{ $error }}', 'error');
        @endforeach
    @endif
    
    // Initialize title counter
    if (titleInput) {
        titleCounter.textContent = `${titleInput.value.length}/255`;
        titleInput.addEventListener('input', function() {
            titleCounter.textContent = `${this.value.length}/255`;
        });
    }
    
    // Initialize content
    if (!editor.textContent.trim() || editor.textContent.trim() === 'Write your thoughts freely... ✍️') {
        content.value = '';
    } else {
        content.value = editor.innerHTML;
        updateContent();
    }
    
    // Mood modal event listeners
    document.querySelectorAll('.mood-option-modal').forEach(button => {
        button.addEventListener('click', function() {
            const mood = this.getAttribute('data-mood');
            selectMoodFromModal(mood);
        });
    });

    document.getElementById('cancelMood').addEventListener('click', function() {
        hideMoodModal();
        pendingFormSubmission = false;
    });

    // Close modal when clicking outside
    document.getElementById('moodModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideMoodModal();
            pendingFormSubmission = false;
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('moodModal');
            if (!modal.classList.contains('hidden')) {
                hideMoodModal();
                pendingFormSubmission = false;
            }
        }
    });

    // Save button click handler
    saveButton.addEventListener('click', handleSaveClick);
    
    // Editor event listeners
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
        updateContent();
    });
    
    editor.addEventListener('keydown', function(e) {
        const placeholder = document.getElementById('placeholder');
        if (placeholder && editor.textContent.trim() === 'Write your thoughts freely... ✍️' && e.key.length === 1) {
            editor.innerHTML = '';
            editor.classList.remove('text-neutral-400', 'italic');
        }
    });

    // Mood selection animation
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
            
            setTimeout(() => {
                journalEntry.classList.remove('ring-4', 'ring-primary-500', 'ring-opacity-50');
            }, 3000);
        }
    });
@endif
</script>
@endsection
