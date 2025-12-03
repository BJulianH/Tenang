<div class="bg-white rounded-lg border border-neutral-200 p-6">
    <h3 class="text-xl font-bold text-neutral-800 mb-6">Ubah Kata Sandi</h3>

    <form id="password-form" action="{{ route('profile.password.update') }}" method="POST" class="max-w-md">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="current_password" class="block text-sm font-medium text-neutral-700 mb-2">Kata Sandi Saat Ini</label>
            <div class="relative">
                <input type="password" id="current_password" name="current_password" 
                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-10 @error('current_password') border-red-500 @enderror">
                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password" data-target="current_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('current_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="new_password" class="block text-sm font-medium text-neutral-700 mb-2">Kata Sandi Baru</label>
            <div class="relative">
                <input type="password" id="new_password" name="new_password" 
                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-10 @error('new_password') border-red-500 @enderror">
                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password" data-target="new_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <div class="mt-2 text-xs text-neutral-500">
                <p>Kata sandi harus mengandung setidaknya:</p>
                <ul class="list-disc ml-4 mt-1">
                    <li>8 karakter</li>
                    <li>1 huruf besar</li>
                    <li>1 angka</li>
                    <li>1 karakter khusus</li>
                </ul>
            </div>
            @error('new_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="new_password_confirmation" class="block text-sm font-medium text-neutral-700 mb-2">Konfirmasi Kata Sandi Baru</label>
            <div class="relative">
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg input-field focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-10">
                <button type="button" class="absolute right-3 top-3 text-neutral-500 hover:text-neutral-700 toggle-password" data-target="new_password_confirmation">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end">
            <button type="button" class="px-6 py-3 border border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition-colors mr-4" onclick="resetForm('password-form')">
                Batal
            </button>
            <button type="submit" class="px-6 py-3 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                Ubah Kata Sandi
            </button>
        </div>
    </form>
</div>