{{-- resources/views/errors/503.blade.php --}}
@extends('layouts.error')

@section('title', 'Maintenance - Tenang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-accent-blue/10 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Animated Character -->
        <div class="relative mb-8">
            <div class="app-character mx-auto mb-6" style="background: #4a8cff; box-shadow: 0 4px 0 #3a7cff;"></div>
            <div class="absolute -top-4 -right-4 text-6xl">🔧</div>
            <div class="absolute -bottom-4 -left-4 text-4xl">⚡</div>
        </div>

        <!-- Maintenance Content -->
        <div class="card rounded-duo-xl p-8 mb-8">
            <div class="text-8xl font-bold text-accent-blue mb-4">503</div>
            <h1 class="text-4xl font-bold text-neutral-800 mb-4">We're Improving Your Experience!</h1>
            <p class="text-xl text-neutral-600 mb-8 leading-relaxed">
                Tenang is currently undergoing scheduled maintenance to bring you new features 
                and improvements. We'll be back online shortly, better than ever!
            </p>

            <!-- Maintenance Progress -->
            <div class="bg-accent-blue/10 rounded-duo p-6 mb-6">
                <h3 class="font-semibold text-neutral-800 mb-4 flex items-center justify-center">
                    <i class="fas fa-tools mr-2 text-accent-blue"></i>
                    Maintenance Progress
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">System Updates</span>
                        <span class="font-semibold text-accent-blue">90%</span>
                    </div>
                    <div class="duo-progress bg-neutral-200 rounded-full h-3">
                        <div class="duo-progress-fill bg-accent-blue rounded-full h-3" style="width: 90%"></div>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">Feature Deployment</span>
                        <span class="font-semibold text-accent-blue">75%</span>
                    </div>
                    <div class="duo-progress bg-neutral-200 rounded-full h-3">
                        <div class="duo-progress-fill bg-accent-blue rounded-full h-3" style="width: 75%"></div>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">Quality Testing</span>
                        <span class="font-semibold text-accent-blue">60%</span>
                    </div>
                    <div class="duo-progress bg-neutral-200 rounded-full h-3">
                        <div class="duo-progress-fill bg-accent-blue rounded-full h-3" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <!-- Estimated Time -->
            <div class="bg-primary-50 rounded-duo p-4 mb-6">
                <div class="flex items-center justify-center space-x-2">
                    <i class="fas fa-clock text-primary-500"></i>
                    <span class="font-semibold text-neutral-700">Estimated completion: 30 minutes</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" class="app-button px-6 py-3 flex items-center justify-center">
                    <i class="fas fa-sync mr-2"></i>
                    Check Status
                </button>
                <a href="https://status.Tenang.app" target="_blank" class="app-button app-button-secondary px-6 py-3 flex items-center justify-center">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Status Page
                </a>
            </div>
        </div>

        <!-- What's Coming -->
        <div class="card rounded-duo-xl p-6 bg-white">
            <h3 class="font-semibold text-neutral-800 mb-4 flex items-center justify-center">
                <i class="fas fa-gift mr-2 text-primary-500"></i>
                Exciting Updates Coming!
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-plus text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">New meditation sounds</span>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-plus text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Improved audio quality</span>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-plus text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Faster loading times</span>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-plus text-primary-500 mt-1"></i>
                    <span class="text-sm text-neutral-600">Mobile app enhancements</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh progress bars
        function updateProgress() {
            const progressBars = document.querySelectorAll('.duo-progress-fill');
            progressBars.forEach(bar => {
                const currentWidth = parseInt(bar.style.width);
                if (currentWidth < 100) {
                    bar.style.width = (currentWidth + Math.random() * 5) + '%';
                }
            });
        }
        
        setInterval(updateProgress, 5000);
        
        // Countdown timer
        let timeLeft = 30 * 60; // 30 minutes in seconds
        const timerElement = document.querySelector('.font-semibold.text-neutral-700');
        
        const timer = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            if (timerElement) {
                timerElement.textContent = `Estimated completion: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                if (timerElement) {
                    timerElement.textContent = 'Maintenance complete! Refresh the page.';
                    timerElement.classList.add('text-primary-500');
                }
            }
        }, 1000);
    });
</script>
@endsection