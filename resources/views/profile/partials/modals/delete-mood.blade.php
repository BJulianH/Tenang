<div id="deleteMoodModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 modal-content">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-neutral-800 mb-2">Hapus Catatan Mood</h3>
            <p class="text-neutral-600 mb-6">Apakah Anda yakin ingin menghapus catatan mood ini? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex space-x-3">
                <button type="button" id="cancelDelete" class="flex-1 px-4 py-2 border border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition-colors">
                    Batal
                </button>
                <form id="deleteMoodForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>