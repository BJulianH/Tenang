{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.error')

@section('title', 'Access Denied - Tenang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-accent-red/10 to-secondary-50 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Animated Character -->
        <div class="relative mb-8">
            <div class="app-character mx-auto mb-6" style="background: #ff6b6b; box-shadow: 0 4px 0 #e55a5a;"></div>
            <div class="absolute -top-4 -right-4 text-6xl">🚫</div>
        </div>

        <!-- Error Content -->
        <div class="card rounded-duo-xl p-8 mb-8">
            <div class="text-8xl font-bold text-accent-red mb-4">403</div>
            <h1 class="text-4xl font-bold text-neutral-800 mb-4">Access Denied</h1>
            <p class="text-xl text-neutral-600 mb-8 leading-relaxed">
                Whoa there! This area is off-limits. It seems you don't have the required permissions 
                to access this page. Even the most adventurous explorers need the right keys!
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="{{ url('/') }}" class="app-button px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-home mr-3"></i>
                    Back to Safety
                </a>
                @auth
                <a href="{{ url('/dashboard') }}" class="app-button app-button-secondary px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Go to Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="app-button app-button-secondary px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-3"></i>
                    Sign In
                </a>
                @endauth
            </div>

            <!-- Help Section -->
            <div class="bg-accent-red/10 rounded-duo p-6">
                <h3 class="font-semibold text-neutral-800 mb-3 flex items-center justify-center">
                    <i class="fas fa-lock mr-2 text-accent-red"></i>
                    Need Access?
                </h3>
                <p class="text-neutral-600 mb-4">
                    If you believe this is a mistake, please contact support or check if you're signed in to the correct account.
                </p>
                <a href="mailto:support@Tenang.app" class="app-button px-6 py-3 inline-flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Support
                </a>
            </div>
        </div>

        <!-- Security Tips -->
        <div class="card rounded-duo-xl p-6 bg-white">
            <h3 class="font-semibold text-neutral-800 mb-4 flex items-center justify-center">
                <i class="fas fa-shield-alt mr-2 text-accent-blue"></i>
                Security Tips
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Always sign out on shared devices</span>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Use strong, unique passwords</span>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Keep your app updated</span>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Report suspicious activity</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection