{{-- resources/views/errors/500.blade.php --}}
@extends('layouts.error')

@section('title', 'Server Error - Tenang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-neutral-50 to-accent-purple/10 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Animated Character -->
        <div class="relative mb-8">
            <div class="app-character mx-auto mb-6 animate-wiggle" style="background: #9b59b6; box-shadow: 0 4px 0 #8e44ad;"></div>
            <div class="absolute -top-4 -right-4 text-6xl">⚡</div>
        </div>

        <!-- Error Content -->
        <div class="card rounded-duo-xl p-8 mb-8">
            <div class="text-8xl font-bold text-accent-purple mb-4">500</div>
            <h1 class="text-4xl font-bold text-neutral-800 mb-4">Server Error</h1>
            <p class="text-xl text-neutral-600 mb-8 leading-relaxed">
                Oops! Something went wrong on our end. Our team of digital mechanics has been alerted 
                and is working to fix the issue. Please try again in a moment!
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <button onclick="window.location.reload()" class="app-button px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-redo mr-3"></i>
                    Try Again
                </button>
                <a href="{{ url('/') }}" class="app-button app-button-secondary px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-home mr-3"></i>
                    Go Home
                </a>
            </div>

            <!-- Status Updates -->
            <div class="bg-accent-purple/10 rounded-duo p-6">
                <h3 class="font-semibold text-neutral-800 mb-3 flex items-center justify-center">
                    <i class="fas fa-wrench mr-2 text-accent-purple"></i>
                    We're On It!
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-600">Server Status</span>
                        <span class="bg-primary-500 text-white px-3 py-1 rounded-duo text-sm font-bold">Investigating</span>
                    </div>
                    <div class="duo-progress bg-neutral-200 rounded-full h-2">
                        <div class="duo-progress-fill bg-accent-purple rounded-full h-2 progress-animation"></div>
                    </div>
                    <p class="text-sm text-neutral-500">
                        Our team is working to resolve the issue. Thank you for your patience.
                    </p>
                </div>
            </div>
        </div>

        <!-- What You Can Do -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card p-4 rounded-duo-xl text-center">
                <div class="text-2xl mb-2">🕒</div>
                <h4 class="font-semibold text-neutral-800 mb-2">Wait a Bit</h4>
                <p class="text-sm text-neutral-600">Try again in a few minutes</p>
            </div>
            <div class="card p-4 rounded-duo-xl text-center">
                <div class="text-2xl mb-2">🔧</div>
                <h4 class="font-semibold text-neutral-800 mb-2">Check Status</h4>
                <p class="text-sm text-neutral-600">Visit our status page</p>
            </div>
            <div class="card p-4 rounded-duo-xl text-center">
                <div class="text-2xl mb-2">📧</div>
                <h4 class="font-semibold text-neutral-800 mb-2">Contact Us</h4>
                <p class="text-sm text-neutral-600">Let us know what happened</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-retry after 30 seconds
        setTimeout(() => {
            const retryButton = document.querySelector('button');
            if (retryButton) {
                retryButton.classList.add('animate-pulse');
                retryButton.innerHTML = '<i class="fas fa-bell mr-3"></i>Ready to Try Again?';
            }
        }, 30000);
    });
</script>
@endsection