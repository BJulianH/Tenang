<form method="POST" action="" id="forgotPasswordForm">
    @csrf

    <!-- Email Address -->
    <div class="mb-6">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
            </div>
            <input 
                id="email" 
                class="block mt-1 w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email') }}"
                required 
                autofocus 
                placeholder="Enter your email address" />
        </div>
        
        <!-- Display Laravel Validation Errors -->
        @error('email')
            <div class="text-red-600 text-sm mt-2 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $message }}
            </div>
        @enderror
        
        <div class="text-red-600 text-sm mt-2 hidden" id="email-error">
            <!-- Error messages will appear here -->
        </div>
    </div>

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-end mt-6">
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
            <i class="fas fa-paper-plane mr-2"></i>
            Email Password Reset Link
        </button>
    </div>
</form>