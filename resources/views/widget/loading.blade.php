<div id="loading-section" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-all duration-500">
        <div class="text-center">
            <!-- Container dengan efek kartu Duolingo -->
            <div class="bg-white rounded-duo-xl p-8 shadow-duo-lg border-4 border-primary-100 transform transition-all duration-300 hover:scale-105">
                <!-- Gif dengan frame dekoratif -->
                <div class="relative mb-6">
                    <div class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full blur-sm opacity-50 animate-pulse"></div>
                    <div class="relative bg-white rounded-full p-3 shadow-duo border-2 border-primary-300">
                        <img src="{{ asset('assets/video/icon.gif') }}" alt="Loading" class="mx-auto w-28 h-28 rounded-full">
                    </div>
                </div>
                
                <!-- Teks loading dengan animasi -->
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-neutral-800">Tenang</h3>
                    <p class="text-neutral-600 font-medium flex items-center justify-center space-x-2">
                        <span>Loading your journey</span>
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
                        "Every step forward is progress"
                    </p>
                </div>
            </div>
            
            <!-- Elemen dekoratif floating -->
            <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-accent-blue rounded-full opacity-20 animate-bounce-gentle"></div>
            <div class="absolute bottom-1/4 right-1/4 w-6 h-6 bg-accent-purple rounded-full opacity-20 animate-bounce-gentle" style="animation-delay: 0.3s"></div>
            <div class="absolute top-1/3 right-1/3 w-4 h-4 bg-accent-red rounded-full opacity-20 animate-bounce-gentle" style="animation-delay: 0.6s"></div>
        </div>
    </div>
    <script>
        function hideLoading() {
            const loadingSection = document.getElementById('loading-section');
            loadingSection.style.opacity = '0';
            loadingSection.style.transform = 'scale(0.95)';
            setTimeout(() => {
                loadingSection.style.display = 'none';
            }, 500);
        }

        window.addEventListener('load', function() {
            setTimeout(hideLoading, 1500);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.target === '_blank') return;
                    if (this.hasAttribute('data-no-loading')) return;
                    
                    const loadingSection = document.getElementById('loading-section');
                    loadingSection.style.display = 'flex';
                    loadingSection.style.opacity = '1';
                    loadingSection.style.transform = 'scale(1)';
                });
            });
            
            const loadingSection = document.getElementById('loading-section');
            setTimeout(() => {
                loadingSection.style.transform = 'scale(1)';
                loadingSection.style.opacity = '1';
            }, 100);
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                // Reset mobile menu state on larger screens
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>