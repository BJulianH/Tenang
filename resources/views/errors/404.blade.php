{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.error')

@section('title', 'Page Not Found - Tenang')

@section('content')
<div class="fixed inset-0 z-50 flex items-center justify-center bg-white">
    <div class="text-center">
        <!-- Container dengan efek kartu Duolingo -->
        <div class="bg-white rounded-duo-xl p-8 shadow-duo-lg border-4 border-primary-100 transform transition-all duration-300 max-w-md mx-4">
            <!-- Gif dengan frame dekoratif -->
            <div class="relative mb-6">
                <div class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-sm opacity-50 animate-pulse"></div>
                <div class="relative bg-white rounded-full p-3 shadow-duo border-2 border-primary-300">
                    <img src="{{ asset('assets/video/icon.gif') }}" alt="Loading" class="mx-auto w-28 h-28 rounded-full">
                </div>
            </div>

            <!-- Konten error -->
            <div class="space-y-4">
                <h3 class="text-2xl font-bold text-neutral-800">404</h3>
                <p class="text-neutral-600 font-medium flex items-center justify-center space-x-2">
                    <span>Page not found</span>
                    <span class="loading-dots">
                        <span class="dot">.</span>
                        <span class="dot">.</span>
                        <span class="dot">.</span>
                    </span>
                </p>

                <!-- Progress bar Duolingo style -->
                <div class="w-48 mx-auto mt-4">
                    <div class="duo-progress bg-neutral-200 rounded-full h-3">
                        <div class="duo-progress-fill bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full h-3 progress-animation"></div>
                    </div>
                </div>

                <!-- Quote motivasional -->
                <p class="text-sm text-neutral-500 mt-4 italic max-w-xs">
                    "Even the best explorers sometimes take wrong turns"
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center pt-4">
                    <a href="{{ url('/') }}" class="app-button px-6 py-3 text-sm font-bold flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>
                        Back to Home
                    </a>
                    <button onclick="history.back()" class="app-button app-button-secondary px-6 py-3 text-sm font-bold flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Go Back
                    </button>
                </div>
            </div>
        </div>

        <!-- Elemen dekoratif floating -->
        <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-accent-blue rounded-full opacity-20 animate-bounce-gentle"></div>
        <div class="absolute bottom-1/4 right-1/4 w-6 h-6 bg-accent-purple rounded-full opacity-20 animate-bounce-gentle" style="animation-delay: 0.3s"></div>
        <div class="absolute top-1/3 right-1/3 w-4 h-4 bg-accent-red rounded-full opacity-20 animate-bounce-gentle" style="animation-delay: 0.6s"></div>
    </div>
</div>

<style>
    .loading-dots .dot {
        display: inline-block;
        animation: dot-pulse 1.5s infinite ease-in-out;
    }

    .loading-dots .dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .loading-dots .dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes dot-pulse {

        0%,
        100% {
            opacity: 0.3;
            transform: scale(0.8);
        }

        50% {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    .progress-animation {
        animation: progress-grow 3s forwards ease-in-out;
        width: 0%;
    }

    @keyframes progress-grow {
        0% {
            width: 0%;
        }

        50% {
            width: 70%;
        }

        100% {
            width: 95%;
        }
    }

    /* Error specific animations */
    @keyframes error-search {

        0%,
        100% {
            transform: rotate(0deg) scale(1);
        }

        25% {
            transform: rotate(10deg) scale(1.1);
        }

        50% {
            transform: rotate(-5deg) scale(1.05);
        }

        75% {
            transform: rotate(5deg) scale(1.1);
        }
    }

    .error-search-animation {
        animation: error-search 4s ease-in-out infinite;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add search animation to the magnifying glass
        const searchIcon = document.querySelector('.text-4xl');
        if (searchIcon) {
            searchIcon.classList.add('error-search-animation');
        }

        // Add celebration effect after progress completes
        setTimeout(() => {
            createErrorCelebration();
        }, 3000);

        // Auto-redirect after 8 seconds
        setTimeout(() => {
            window.location.href = "{{ url('/') }}";
        }, 8000);

        // Add interactive effects
        const buttons = document.querySelectorAll('.app-button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Enter key to go home
            if (e.key === 'Enter') {
                window.location.href = "{{ url('/') }}";
            }

            // Space key to go back
            if (e.key === ' ') {
                e.preventDefault();
                history.back();
            }
        });
    });

    function createErrorCelebration() {
        const container = document.querySelector('.text-center');
        const particles = ['❓', '🔍', '🚫', '💡', '✨'];

        for (let i = 0; i < 3; i++) {
            const particle = document.createElement('div');
            particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
            particle.className = 'absolute text-2xl animate-celebrate';
            particle.style.left = Math.random() * 80 + 10 + '%';
            particle.style.top = Math.random() * 80 + 10 + '%';

            container.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 1000);
        }
    }

    // Countdown display
    let countdown = 8;
    const countdownInterval = setInterval(() => {
        countdown--;
        const progressText = document.querySelector('.text-neutral-600');
        if (progressText && countdown > 0) {
            progressText.innerHTML = `Redirecting in ${countdown}s<span class="loading-dots"><span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></span>`;
        }

        if (countdown <= 0) {
            clearInterval(countdownInterval);
        }
    }, 1000);

</script>
@endsection
