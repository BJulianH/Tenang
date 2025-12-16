@extends('layouts.app')

@section('title', 'Profil - MindWell')

@section('styles')
<style>
    .mental-health-card {
        background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
        border: 1px solid #ccfbef;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .mental-health-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(20, 184, 166, 0.1);
    }
    
    .progress-bar {
        height: 8px;
        background-color: #e8f0e5;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    .wellness-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    
    .wellness-excellent { background-color: #4caf50; }
    .wellness-good { background-color: #8fd18f; }
    .wellness-fair { background-color: #ffb74d; }
    .wellness-poor { background-color: #ff9800; }
    .wellness-critical { background-color: #f44336; }

    /* Mood Option Styles */
    .mood-option input:checked + label {
        border-color: #4caf50;
        background-color: #f0f9f0;
        transform: scale(1.02);
        box-shadow: 0 4px 6px -1px rgba(76, 175, 80, 0.1), 0 2px 4px -1px rgba(76, 175, 80, 0.06);
    }

    .mood-option input:checked + label .mood-icon-container {
        transform: scale(1.1);
    }

    .mood-option label {
        transition: all 0.3s ease;
    }

    .mood-option:hover label {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Scrollbar untuk mood entries */
    #mood-entries::-webkit-scrollbar {
        width: 6px;
    }

    #mood-entries::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #mood-entries::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    #mood-entries::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Modal Styles */
    #deleteMoodModal {
        transition: opacity 0.3s ease;
    }
    
    #deleteMoodModal .modal-content {
        transform: scale(0.7);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    #deleteMoodModal.show {
        display: flex !important;
    }
    
    #deleteMoodModal.show .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    /* Tab Styles */
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .tab-button {
        transition: all 0.3s ease;
    }
    
    .tab-button.active {
        background-color: #4caf50;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">Profil Saya</h1>
        <p class="text-neutral-600 mt-2">Kelola informasi profil dan kesehatan mental Anda</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg border border-neutral-200 p-2 mb-6">
        <div class="flex space-x-2">
            <button class="tab-button px-4 py-2 rounded-lg font-medium transition-colors active" data-tab="mental-health">
                <i class="fas fa-heart mr-2"></i>Kesehatan Mental
            </button>
            <button class="tab-button px-4 py-2 rounded-lg font-medium transition-colors" data-tab="edit-profile">
                <i class="fas fa-user-edit mr-2"></i>Edit Profil
            </button>
            <button class="tab-button px-4 py-2 rounded-lg font-medium transition-colors" data-tab="change-password">
                <i class="fas fa-lock mr-2"></i>Ubah Sandi
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            @include('profile.partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Mental Health Tab -->
            <div class="tab-content active" id="mental-health-tab">
                @include('profile.partials.mental-health')
            </div>

            <!-- Edit Profile Tab -->
            <div class="tab-content" id="edit-profile-tab">
                @include('profile.partials.edit-profile')
            </div>

            <!-- Change Password Tab -->
            <div class="tab-content" id="change-password-tab">
                @include('profile.partials.change-password')
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Mood -->
@include('profile.partials.modals.delete-mood')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Update active tab button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Show active tab content
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === `${tabId}-tab`) {
                        content.classList.add('active');
                    }
                });
            });
        });

        // Initialize mood tracking
        initializeMoodTracking();
        
        // Initialize password toggles
        initializePasswordToggles();
        
        // Avatar upload click
        const avatarPreview = document.querySelector('.avatar-preview');
        if (avatarPreview) {
            avatarPreview.addEventListener('click', function() {
                document.getElementById('avatar').click();
            });
        }
    });

    // Mood Tracking Functionality
    function initializeMoodTracking() {
        // Mood selection with visual feedback
        const moodOptions = document.querySelectorAll('.mood-option');
        
        moodOptions.forEach(option => {
            const input = option.querySelector('input[type="radio"]');
            const label = option.querySelector('label');
            
            // Add visual feedback on click
            label.addEventListener('click', (e) => {
                // Remove active class from all options
                moodOptions.forEach(opt => {
                    const optLabel = opt.querySelector('label');
                    optLabel.classList.remove('border-primary-500', 'bg-primary-50', 'ring-2', 'ring-primary-200');
                });
                
                // Add active class to clicked option
                label.classList.add('border-primary-500', 'bg-primary-50', 'ring-2', 'ring-primary-200');
            });
            
            // Check if this option is pre-selected (from old data)
            if (input && input.checked) {
                label.classList.add('border-primary-500', 'bg-primary-50', 'ring-2', 'ring-primary-200');
            }
        });
        
        // Enter key submission for mood form
        const moodForm = document.getElementById('mood-form');
        const moodDescription = document.getElementById('mood_description');
        
        if (moodForm && moodDescription) {
            moodDescription.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                    // Ctrl+Enter or Cmd+Enter to submit
                    e.preventDefault();
                    moodForm.submit();
                }
            });
            
            // Also allow Enter key when a mood is selected and textarea is focused
            moodForm.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    const selectedMood = moodForm.querySelector('input[name="mood"]:checked');
                    if (selectedMood && document.activeElement === moodDescription) {
                        e.preventDefault();
                        moodForm.submit();
                    }
                }
            });
        }
        
        // Initialize delete functionality
        initializeDeleteFunctionality();
    }

    // Delete Functionality (Single and Multiple)
    function initializeDeleteFunctionality() {
        // Single delete modal
        const deleteModal = document.getElementById('deleteMoodModal');
        const cancelDeleteBtn = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteMoodForm');
        
        // Multiple delete modal
        const multipleDeleteModal = document.getElementById('deleteMultipleMoodsModal');
        const cancelMultipleDeleteBtn = document.getElementById('cancelMultipleDelete');
        const confirmMultipleDeleteBtn = document.getElementById('confirmMultipleDelete');
        
        // Delete selected moods button
        const deleteSelectedBtn = document.getElementById('delete-selected-moods');
        const selectAllBtn = document.getElementById('select-all-moods');
        const selectedCountSpan = document.getElementById('selected-count');
        const countSpan = document.getElementById('count');
        const deleteCountSpan = document.getElementById('delete-count');
        
        // Checkbox elements
        const checkboxes = document.querySelectorAll('.mood-checkbox');
        
        // Variables
        let selectedMoodIds = new Set();
        let isSelectAll = false;
        
        // Update selected count display
        function updateSelectedCount() {
            const count = selectedMoodIds.size;
            countSpan.textContent = count;
            deleteCountSpan.textContent = count;
            
            if (count > 0) {
                selectedCountSpan.classList.remove('hidden');
                deleteSelectedBtn.classList.remove('hidden');
                selectAllBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Batal Pilih';
            } else {
                selectedCountSpan.classList.add('hidden');
                deleteSelectedBtn.classList.add('hidden');
                selectAllBtn.innerHTML = '<i class="fas fa-check-square mr-2"></i>Pilih Semua';
            }
        }
        
        // Handle checkbox change
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    selectedMoodIds.add(this.value);
                } else {
                    selectedMoodIds.delete(this.value);
                }
                updateSelectedCount();
            });
        });
        
        // Select all / deselect all
        selectAllBtn.addEventListener('click', function() {
            isSelectAll = !isSelectAll;
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = isSelectAll;
                if (isSelectAll) {
                    selectedMoodIds.add(checkbox.value);
                } else {
                    selectedMoodIds.delete(checkbox.value);
                }
            });
            
            updateSelectedCount();
        });
        
        // Open single delete modal
        document.querySelectorAll('.delete-single-mood-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const moodId = this.getAttribute('data-id');
                const deleteUrl = this.getAttribute('data-url');
                
                deleteForm.action = deleteUrl;
                deleteModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Open multiple delete modal
        deleteSelectedBtn.addEventListener('click', function() {
            if (selectedMoodIds.size === 0) {
                showToast('Pilih setidaknya satu catatan mood untuk dihapus.', 'error');
                return;
            }
            
            multipleDeleteModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
        
        // Close single delete modal
        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
        }
        
        // Close multiple delete modal
        if (cancelMultipleDeleteBtn) {
            cancelMultipleDeleteBtn.addEventListener('click', function() {
                multipleDeleteModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
        }
        
        // Confirm multiple delete
        if (confirmMultipleDeleteBtn) {
            confirmMultipleDeleteBtn.addEventListener('click', function() {
                const moodIds = Array.from(selectedMoodIds);
                
                // Show loading
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
                this.disabled = true;
                
                // Send AJAX request
                fetch('{{ route("mood.tracking.destroy.multiple") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        mood_ids: moodIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove deleted entries from DOM
                        moodIds.forEach(id => {
                            const entry = document.querySelector(`.mood-entry[data-id="${id}"]`);
                            if (entry) {
                                entry.remove();
                            }
                        });
                        
                        // Reset selection
                        selectedMoodIds.clear();
                        checkboxes.forEach(cb => cb.checked = false);
                        updateSelectedCount();
                        
                        // Show success message
                        showToast(data.message, 'success');
                        
                        // Close modal
                        multipleDeleteModal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                        
                        // Reload page after 1.5 seconds to update stats
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus.', 'error');
                })
                .finally(() => {
                    // Reset button
                    this.innerHTML = 'Hapus Semua';
                    this.disabled = false;
                });
            });
        }
        
        // Close modals when clicking outside
        [deleteModal, multipleDeleteModal].forEach(modal => {
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            }
        });
        
        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!deleteModal.classList.contains('hidden')) {
                    deleteModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
                if (!multipleDeleteModal.classList.contains('hidden')) {
                    multipleDeleteModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }
        });
    }

    // Password toggle functionality
    function initializePasswordToggles() {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    }

    // Form reset functionality
    function resetForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
        }
    }

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium z-50 transform translate-x-full transition-transform duration-300 ${
            type === 'error' ? 'bg-red-500' : 
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

    // Handle form submissions with loading states
    document.addEventListener('DOMContentLoaded', function() {
        const moodForm = document.getElementById('mood-form');
        if (moodForm) {
            moodForm.addEventListener('submit', function(e) {
                const selectedMood = this.querySelector('input[name="mood"]:checked');
                if (!selectedMood) {
                    e.preventDefault();
                    showToast('Pilih mood terlebih dahulu!', 'error');
                    return;
                }
                
                // Add loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            });
        }

        // Handle profile form submission
        const profileForm = document.getElementById('profile-form');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            });
        }

        // Handle password form submission
        const passwordForm = document.getElementById('password-form');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengubah...';
                submitBtn.disabled = true;
            });
        }
    });
</script>
@endsection