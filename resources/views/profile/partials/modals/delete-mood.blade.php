<!-- Modal Konfirmasi Hapus Single Mood -->
<div id="deleteMoodModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 shadow-xl">
        <div class="text-center">
            <!-- Icon Warning -->
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-neutral-800 mb-2">Hapus Catatan Mood</h3>
            
            <!-- Message -->
            <p class="text-neutral-600 mb-6">
                Apakah Anda yakin ingin menghapus catatan mood ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            
            <!-- Buttons -->
            <div class="flex space-x-3">
                <button type="button" id="cancelDelete" 
                        class="flex-1 px-4 py-2.5 border border-neutral-300 text-neutral-700 rounded-lg font-medium 
                               hover:bg-neutral-50 active:bg-neutral-100 transition-all duration-200 
                               focus:outline-none focus:ring-2 focus:ring-neutral-300 focus:ring-opacity-50">
                    Batal
                </button>
                
                <form id="deleteMoodForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg font-medium 
                                   hover:bg-red-600 active:bg-red-700 transition-all duration-200 
                                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 
                                   disabled:opacity-50 disabled:cursor-not-allowed">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Multiple Moods -->
<div id="deleteMultipleMoodsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
        <div class="text-center">
            <!-- Icon Warning -->
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash-alt text-red-600 text-2xl"></i>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-neutral-800 mb-3">Hapus Catatan Mood</h3>
            
            <!-- Message with dynamic count -->
            <div class="mb-6">
                <p class="text-neutral-600 mb-1">
                    Anda akan menghapus <span id="delete-count" class="font-bold text-red-600 text-lg">0</span> catatan mood.
                </p>
                <p class="text-neutral-500 text-sm">
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            
            <!-- Additional Warning -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-6 text-left">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-yellow-600 mt-0.5 mr-2"></i>
                    <div>
                        <p class="text-sm text-yellow-800 font-medium">Perhatian</p>
                        <p class="text-xs text-yellow-700 mt-1">
                            Semua catatan mood yang dipilih akan dihapus secara permanen. Statistik mood Anda akan diperbarui setelah penghapusan.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex space-x-3">
                <button type="button" id="cancelMultipleDelete" 
                        class="flex-1 px-4 py-2.5 border border-neutral-300 text-neutral-700 rounded-lg font-medium 
                               hover:bg-neutral-50 active:bg-neutral-100 transition-all duration-200 
                               focus:outline-none focus:ring-2 focus:ring-neutral-300 focus:ring-opacity-50">
                    Batal
                </button>
                
                <button type="button" id="confirmMultipleDelete" 
                        class="flex-1 px-4 py-2.5 bg-red-500 text-white rounded-lg font-medium 
                               hover:bg-red-600 active:bg-red-700 transition-all duration-200 
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50
                               disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="flex items-center justify-center">
                        <i class="fas fa-trash-alt mr-2"></i>
                        <span>Hapus Semua</span>
                    </span>
                </button>
            </div>
            
            <!-- Loading State (Hidden by default) -->
            <div id="deleteLoading" class="hidden mt-4">
                <div class="flex items-center justify-center">
                    <div class="w-8 h-8 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mr-3"></div>
                    <span class="text-sm text-neutral-600">Sedang menghapus...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal (Optional, bisa digunakan untuk feedback) -->
<div id="deleteSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 shadow-xl">
        <div class="text-center">
            <!-- Icon Success -->
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-neutral-800 mb-2">Berhasil!</h3>
            
            <!-- Message -->
            <p class="text-neutral-600 mb-6">
                Catatan mood berhasil dihapus.
            </p>
            
            <!-- Button -->
            <button type="button" id="closeSuccessModal" 
                    class="w-full px-4 py-2.5 bg-primary-500 text-white rounded-lg font-medium 
                        hover:bg-primary-600 active:bg-primary-700 transition-all duration-200 
                        focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    /* Modal Animation */
    #deleteMoodModal,
    #deleteMultipleMoodsModal,
    #deleteSuccessModal {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    
    #deleteMoodModal:not(.hidden),
    #deleteMultipleMoodsModal:not(.hidden),
    #deleteSuccessModal:not(.hidden) {
        opacity: 1;
        visibility: visible;
    }
    
    /* Modal Content Animation */
    #deleteMoodModal > div,
    #deleteMultipleMoodsModal > div,
    #deleteSuccessModal > div {
        transform: scale(0.95) translateY(-10px);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    
    #deleteMoodModal:not(.hidden) > div,
    #deleteMultipleMoodsModal:not(.hidden) > div,
    #deleteSuccessModal:not(.hidden) > div {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    
    /* Checkbox animation for mood entries */
    .mood-checkbox:checked {
        animation: checkboxChecked 0.3s ease;
    }
    
    @keyframes checkboxChecked {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    /* Loading spinner animation */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Button hover effects */
    button:not(:disabled):hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    button:not(:disabled):active {
        transform: translateY(0);
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    
    /* Focus styles for accessibility */
    button:focus-visible {
        outline: 2px solid #4caf50;
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        #deleteMoodModal > div,
        #deleteMultipleMoodsModal > div,
        #deleteSuccessModal > div {
            margin: 1rem;
            max-width: calc(100% - 2rem);
        }
        
        .flex.space-x-3 {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .flex.space-x-3 > button {
            width: 100%;
        }
    }
</style>

<script>
// Script khusus untuk modal yang tidak perlu di-load ulang saat tab switching
document.addEventListener('DOMContentLoaded', function() {
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = [
                'deleteMoodModal',
                'deleteMultipleMoodsModal', 
                'deleteSuccessModal'
            ];
            
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        }
    });
    
    // Close success modal
    const closeSuccessModalBtn = document.getElementById('closeSuccessModal');
    const deleteSuccessModal = document.getElementById('deleteSuccessModal');
    
    if (closeSuccessModalBtn && deleteSuccessModal) {
        closeSuccessModalBtn.addEventListener('click', function() {
            deleteSuccessModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        // Close when clicking outside
        deleteSuccessModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }
});
</script>