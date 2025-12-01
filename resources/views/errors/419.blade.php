{{-- resources/views/errors/419.blade.php --}}
@extends('layouts.error')

@section('title', 'Page Expired - Tenang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-secondary-50 to-accent-orange/10 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Animated Character -->
        <div class="relative mb-8">
            <div class="app-character mx-auto mb-6" style="background: #ff9f43; box-shadow: 0 4px 0 #e58e3a;"></div>
            <div class="absolute -top-4 -right-4 text-6xl">⏰</div>
        </div>

        <!-- Error Content -->
        <div class="card rounded-duo-xl p-8 mb-8">
            <div class="text-8xl font-bold text-accent-orange mb-4">419</div>
            <h1 class="text-4xl font-bold text-neutral-800 mb-4">Page Expired</h1>
            <p class="text-xl text-neutral-600 mb-8 leading-relaxed">
                This page has timed out for security reasons. Don't worry, it happens to the best of us 
                when we take too long to complete a form or stay inactive for a while.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <button onclick="window.location.reload()" class="app-button px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-redo mr-3"></i>
                    Refresh Page
                </button>
                <a href="{{ url('/') }}" class="app-button app-button-secondary px-8 py-4 text-lg font-bold flex items-center justify-center">
                    <i class="fas fa-home mr-3"></i>
                    Go Home
                </a>
            </div>

            <!-- Prevention Tips -->
            <div class="bg-accent-orange/10 rounded-duo p-6">
                <h3 class="font-semibold text-neutral-800 mb-3 flex items-center justify-center">
                    <i class="fas fa-lightbulb mr-2 text-accent-orange"></i>
                    Quick Tips to Avoid This
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-bolt text-primary-500 mt-1"></i>
                        <span class="text-sm text-neutral-600">Complete forms quickly</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-save text-primary-500 mt-1"></i>
                        <span class="text-sm text-neutral-600">Save your work regularly</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-user-check text-primary-500 mt-1"></i>
                        <span class="text-sm text-neutral-600">Stay signed in when possible</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-sync text-primary-500 mt-1"></i>
                        <span class="text-sm text-neutral-600">Keep the page active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection