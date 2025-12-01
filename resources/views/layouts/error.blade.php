{{-- resources/views/layouts/error.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tenang - Mental Health App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('assets/icon/icon.png') }}">

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f7ea',
                            100: '#c2ebd0',
                            200: '#9bdfb5',
                            300: '#70d399',
                            400: '#4dc982',
                            500: '#58cc70',
                            600: '#45b259',
                            700: '#339847',
                            800: '#237e36',
                            900: '#156427',
                        },
                        secondary: {
                            50: '#fff9e6',
                            100: '#ffefbf',
                            200: '#ffe599',
                            300: '#ffdb70',
                            400: '#ffd14c',
                            500: '#ffc800',
                            600: '#e6b400',
                            700: '#cc9f00',
                            800: '#b38b00',
                            900: '#997700',
                        },
                        accent: {
                            blue: '#4a8cff',
                            red: '#ff6b6b',
                            purple: '#9b59b6',
                            orange: '#ff9f43',
                        },
                        neutral: {
                            50: '#f8f9fa',
                            100: '#e9ecef',
                            200: '#dee2e6',
                            300: '#ced4da',
                            400: '#adb5bd',
                            500: '#6c757d',
                            600: '#495057',
                            700: '#343a40',
                            800: '#212529',
                            900: '#121416',
                        }
                    },
                    fontFamily: {
                        'sans': ['Nunito', 'Inter', 'ui-sans-serif', 'system-ui'],
                        'duo': ['Nunito', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-gentle': 'bounce-gentle 2s infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                        'celebrate': 'celebrate 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'error-float': 'error-float 4s ease-in-out infinite',
                    },
                    keyframes: {
                        'bounce-gentle': {
                            '0%, 100%': { 
                                transform: 'translateY(0)',
                                animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)'
                            },
                            '50%': { 
                                transform: 'translateY(-8px)',
                                animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)'
                            },
                        },
                        'wiggle': {
                            '0%, 100%': { transform: 'rotate(-5deg)' },
                            '50%': { transform: 'rotate(5deg)' },
                        },
                        'celebrate': {
                            '0%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.2)' },
                            '100%': { transform: 'scale(1)' },
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        'error-float': {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '33%': { transform: 'translateY(-8px) rotate(2deg)' },
                            '66%': { transform: 'translateY(-4px) rotate(-1deg)' },
                        }
                    },
                    borderRadius: {
                        'duo': '16px',
                        'duo-lg': '24px',
                        'duo-xl': '32px',
                    },
                    boxShadow: {
                        'duo': '0 4px 0 rgba(0, 0, 0, 0.1)',
                        'duo-lg': '0 6px 0 rgba(0, 0, 0, 0.1)',
                        'duo-pressed': '0 2px 0 rgba(0, 0, 0, 0.1)',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .error-character {
            width: 120px;
            height: 120px;
            background: #58cc70;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 6px 0 #45b259;
            margin: 0 auto;
        }

        .error-character::before {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            top: 30px;
            left: 20px;
            box-shadow: 30px 0 white;
        }

        .error-character::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 15px;
            background: #ff6b6b;
            border-radius: 15px 15px 0 0;
            bottom: 25px;
            left: 45px;
        }

        .error-character.red {
            background: #ff6b6b;
            box-shadow: 0 6px 0 #e55a5a;
        }

        .error-character.purple {
            background: #9b59b6;
            box-shadow: 0 6px 0 #8e44ad;
        }

        .error-character.blue {
            background: #4a8cff;
            box-shadow: 0 6px 0 #3a7cff;
        }

        .error-character.orange {
            background: #ff9f43;
            box-shadow: 0 6px 0 #e58e3a;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 3px solid #f1f3f4;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
        }

        .app-button {
            background: #58cc70;
            color: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 #45b259;
            transition: all 0.2s ease;
            font-weight: 700;
            border: none;
            padding: 12px 24px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .app-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #45b259;
            color: white;
            text-decoration: none;
        }

        .app-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #45b259;
        }

        .app-button-secondary {
            background: #ffc800;
            box-shadow: 0 4px 0 #e6b400;
        }

        .app-button-secondary:hover {
            box-shadow: 0 6px 0 #e6b400;
        }

        .app-button-secondary:active {
            box-shadow: 0 2px 0 #e6b400;
        }

        .duo-progress {
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
        }

        .duo-progress-fill {
            height: 100%;
            background: #58cc70;
            border-radius: 6px;
            transition: width 0.5s ease;
        }

        .progress-animation {
            animation: progress-grow 3s forwards ease-in-out;
            width: 0%;
        }

        @keyframes progress-grow {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 95%; }
        }

        /* Error specific animations */
        @keyframes error-pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.05);
                opacity: 0.9;
            }
        }

        .error-pulse {
            animation: error-pulse 2s ease-in-out infinite;
        }

        /* Floating elements */
        .floating-element {
            animation: float 3s ease-in-out infinite;
        }

        .floating-element:nth-child(2) {
            animation-delay: 1s;
        }

        .floating-element:nth-child(3) {
            animation-delay: 2s;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #58cc70;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #45b259;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .error-character {
                width: 100px;
                height: 100px;
            }

            .error-character::before {
                width: 30px;
                height: 30px;
                top: 25px;
                left: 15px;
                box-shadow: 25px 0 white;
            }

            .error-character::after {
                width: 25px;
                height: 12px;
                bottom: 20px;
                left: 37px;
            }
        }

        /* Background patterns */
        .error-bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(88, 204, 112, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 200, 0, 0.1) 0%, transparent 50%);
            background-size: 50% 50%, 50% 50%;
            background-position: 0 0, 100% 100%;
            background-repeat: no-repeat;
        }

        /* Celebration effects */
        .celebration-particle {
            position: absolute;
            pointer-events: none;
            animation: celebrate 0.6s ease-out forwards;
        }

        /* Loading animation for error pages */
        .error-loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <!-- Additional Styles Section -->
    @yield('styles')
</head>
<body class="error-bg-pattern">
    <!-- Floating Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-primary-200 rounded-full opacity-20 floating-element"></div>
        <div class="absolute top-3/4 right-1/4 w-6 h-6 bg-secondary-200 rounded-full opacity-20 floating-element"></div>
        <div class="absolute bottom-1/4 left-3/4 w-4 h-4 bg-accent-blue rounded-full opacity-20 floating-element"></div>
        <div class="absolute top-1/2 right-1/2 w-10 h-10 bg-accent-purple rounded-full opacity-10 floating-element"></div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center p-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="fixed bottom-0 left-0 right-0 p-4 text-center">
        <div class="text-neutral-500 text-sm">
            <p>Tenang &copy; {{ date('Y') }} - Mental Health Support</p>
            <div class="mt-2 flex justify-center space-x-4">
                <a href="{{ url('/') }}" class="text-neutral-500 hover:text-primary-500 transition-colors">
                    <i class="fas fa-home"></i>
                </a>
                <a href="{{ route('noises.index') }}" class="text-neutral-500 hover:text-primary-500 transition-colors">
                    <i class="fas fa-music"></i>
                </a>
                <a href="{{ route('journal.index') }}" class="text-neutral-500 hover:text-primary-500 transition-colors">
                    <i class="fas fa-book"></i>
                </a>
                <a href="{{ route('community.index') }}" class="text-neutral-500 hover:text-primary-500 transition-colors">
                    <i class="fas fa-users"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Scripts Section -->
    @yield('scripts')

    <script>
        // Common error page functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add celebration effect on load
            setTimeout(() => {
                createCelebrationParticles();
            }, 500);

            // Add interactive effects to buttons
            const buttons = document.querySelectorAll('.app-button');
            buttons.forEach(button => {
                button.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(2px)';
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                });
                
                button.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                });
            });

            // Auto-refresh functionality for certain pages
            const autoRefresh = document.querySelector('[data-auto-refresh]');
            if (autoRefresh) {
                const seconds = parseInt(autoRefresh.getAttribute('data-auto-refresh'));
                setTimeout(() => {
                    window.location.reload();
                }, seconds * 1000);
            }

            // Add loading state to action buttons
            const actionButtons = document.querySelectorAll('a[href], button[type="button"]');
            actionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.getAttribute('href') || this.getAttribute('type') === 'button') {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<span class="error-loading mr-2"></span> Loading...';
                        this.disabled = true;
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 2000);
                    }
                });
            });
        });

        function createCelebrationParticles() {
            const particles = ['🎉', '✨', '🌟', '💫', '🎊'];
            const container = document.body;
            
            for (let i = 0; i < 5; i++) {
                const particle = document.createElement('div');
                particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
                particle.className = 'celebration-particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.fontSize = (Math.random() * 20 + 16) + 'px';
                particle.style.animationDelay = (Math.random() * 0.5) + 's';
                
                container.appendChild(particle);
                
                setTimeout(() => {
                    particle.remove();
                }, 1000);
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Alt + H for home
            if (e.altKey && e.key === 'h') {
                e.preventDefault();
                window.location.href = '/';
            }
            
            // Alt + R for refresh
            if (e.altKey && e.key === 'r') {
                e.preventDefault();
                window.location.reload();
            }
            
            // Escape key to go back
            if (e.key === 'Escape') {
                if (document.referrer) {
                    window.history.back();
                }
            }
        });

        // Error reporting (optional)
        function reportError(errorType) {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'error_page_view', {
                    'event_category': 'error',
                    'event_label': errorType,
                    'value': 1
                });
            }
        }

        // Track error page views
        @if(isset($status))
            reportError({{ $status }});
        @endif
    </script>
</body>
</html>