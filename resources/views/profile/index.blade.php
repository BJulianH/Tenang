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
        
        // Initialize delete confirmation modal
        initializeDeleteModal();
    }

    // Delete Confirmation Modal
    function initializeDeleteModal() {
        const modal = document.getElementById('deleteMoodModal');
        if (!modal) return;
        
        const cancelBtn = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteMoodForm');
        let currentMoodId = null;
        
        // Open modal when delete button is clicked
        document.querySelectorAll('.delete-mood-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentMoodId = this.getAttribute('data-id');
                const deleteUrl = this.getAttribute('data-url');
                deleteForm.action = deleteUrl;
                modal.classList.remove('hidden');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Close modal when cancel button is clicked
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
                currentMoodId = null;
            });
        }
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
                currentMoodId = null;
            }
        });
        
        // Handle form submission
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                // The form will submit normally
                modal.classList.add('hidden');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });
        }
        
        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                modal.classList.add('hidden');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
                currentMoodId = null;
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