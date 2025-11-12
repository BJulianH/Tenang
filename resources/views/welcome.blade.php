    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Study Anywhere and Everywhere</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

            body {
                font-family: 'Poppins', sans-serif;
            }

            .gradient-bg {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            }

            .card-shadow {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            /* ===== ANIMASI CUSTOM ===== */

            /* Fade In Animations */
            .fade-in {
                animation: fadeIn 0.6s ease-in-out;
            }

            .fade-in-up {
                animation: fadeInUp 0.8s ease-out;
            }

            .fade-in-down {
                animation: fadeInDown 0.8s ease-out;
            }

            .fade-in-left {
                animation: fadeInLeft 0.8s ease-out;
            }

            .fade-in-right {
                animation: fadeInRight 0.8s ease-out;
            }

            /* Slide Animations */
            .slide-in-left {
                animation: slideInLeft 0.8s ease-out;
            }

            .slide-in-right {
                animation: slideInRight 0.8s ease-out;
            }

            .slide-in-up {
                animation: slideInUp 0.8s ease-out;
            }

            .slide-in-down {
                animation: slideInDown 0.8s ease-out;
            }

            /* Scale Animations */
            .scale-in {
                animation: scaleIn 0.5s ease-out;
            }

            .scale-in-up {
                animation: scaleInUp 0.6s ease-out;
            }

            .pulse-slow {
                animation: pulse 3s infinite;
            }

            .bounce-slow {
                animation: bounce 2s infinite;
            }

            .float {
                animation: float 6s ease-in-out infinite;
            }

            /* Hover Effects */
            .hover-lift {
                transition: all 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
            }

            .hover-scale {
                transition: all 0.3s ease;
            }

            .hover-scale:hover {
                transform: scale(1.05);
            }

            .hover-glow:hover {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }

            /* Gradient Text */
            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .gradient-text-blue {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Custom Shadows */
            .shadow-soft {
                box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08);
            }

            .shadow-medium {
                box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
            }

            .shadow-strong {
                box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .shadow-inner-lg {
                box-shadow: inset 0 4px 8px 0 rgba(0, 0, 0, 0.06);
            }

            /* Glass Morphism */
            .glass {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }

            .glass-dark {
                background: rgba(0, 0, 0, 0.25);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Custom Borders */
            .border-gradient {
                border: 2px solid transparent;
                background: linear-gradient(white, white) padding-box,
                    linear-gradient(135deg, #3b82f6, #8b5cf6) border-box;
            }

            /* Loading Animations */
            .spin-slow {
                animation: spin 3s linear infinite;
            }

            .ping-slow {
                animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
            }

            /* Staggered Animations */
            .stagger-1 {
                animation-delay: 0.1s;
            }

            .stagger-2 {
                animation-delay: 0.2s;
            }

            .stagger-3 {
                animation-delay: 0.3s;
            }

            .stagger-4 {
                animation-delay: 0.4s;
            }

            .stagger-5 {
                animation-delay: 0.5s;
            }

            /* Text Effects */
            .text-shadow {
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .text-shadow-lg {
                text-shadow: 0 4px 8px rgba(0, 0, 0, 0.12), 0 2px 4px rgba(0, 0, 0, 0.08);
            }

            /* Custom Transitions */
            .transition-slow {
                transition: all 0.5s ease;
            }

            .transition-fast {
                transition: all 0.2s ease;
            }

            .transition-all-smooth {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Background Patterns */
            .pattern-dots {
                background-image: radial-gradient(currentColor 1px, transparent 1px);
                background-size: 16px 16px;
            }

            .pattern-grid {
                background-image:
                    linear-gradient(currentColor 1px, transparent 1px),
                    linear-gradient(90deg, currentColor 1px, transparent 1px);
                background-size: 20px 20px;
            }

            /* ===== KEYFRAMES ===== */

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slideInLeft {
                from {
                    transform: translateX(-100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideInUp {
                from {
                    transform: translateY(100%);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @keyframes slideInDown {
                from {
                    transform: translateY(-100%);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @keyframes scaleIn {
                from {
                    transform: scale(0.9);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            @keyframes scaleInUp {
                from {
                    transform: scale(0.9) translateY(20px);
                    opacity: 0;
                }

                to {
                    transform: scale(1) translateY(0);
                    opacity: 1;
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.7;
                }
            }

            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-5px);
                }
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes ping {

                75%,
                100% {
                    transform: scale(2);
                    opacity: 0;
                }
            }

        </style>

        <style type="text/tailwindcss">
            @layer components {
            /* --- Headings --- */
            .h1 {
                @apply text-5xl md:text-6xl font-extrabold text-gray-800 leading-tight;
            }

            .h2 {
                @apply text-4xl md:text-5xl font-bold text-gray-800 leading-snug;
            }

            .h3 {
                @apply text-3xl font-semibold text-gray-700 leading-snug;
            }

            .h4 {
                @apply text-2xl font-semibold text-gray-700 leading-normal;
            }

            .h5 {
                @apply text-xl font-medium text-gray-600 leading-relaxed;
            }

            .h6 {
                @apply text-lg font-medium text-gray-500 uppercase tracking-wide;
            }

            /* --- Optional Accent Variants --- */
            .h1-accent {
                @apply text-8xl md:text-9xl font-extrabold leading-tight text-blue-900;
            }

            .h2-accent {
                @apply text-6xl font-light text-blue-900 leading-snug;
            }

            .h3-accent {
                @apply text-3xl font-light text-blue-900 leading-snug;
            }

            /* --- Custom Components dengan Animasi --- */
            
            /* Animated Card */
            .animated-card {
                @apply bg-white rounded-xl p-6 card-shadow transition-all-smooth hover-lift;
            }
            
            /* Feature Item dengan Animasi */
            .feature-item {
                @apply animated-card fade-in-up stagger-1;
            }
            
            /* Hero Section dengan Animasi */
            .hero-title {
                @apply h1-accent fade-in-down;
            }
            
            .hero-subtitle {
                @apply h3-accent fade-in-up stagger-1;
            }
            
            /* Button dengan Efek */
            .btn-primary {
                @apply px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-all-smooth hover-scale;
            }
            
            .btn-secondary {
                @apply px-6 py-3 bg-transparent border-2 border-blue-600 text-blue-600 font-bold rounded-lg hover:bg-blue-600 hover:text-white transition-all-smooth;
            }
            
            .btn-glow {
                @apply btn-primary hover-glow;
            }
            
            /* Navigation Item dengan Animasi */
            .nav-item {
                @apply text-gray-700 hover:text-blue-600 font-medium transition-fast relative;
            }
            
            .nav-item::after {
                content: '';
                @apply absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-slow;
            }
            
            .nav-item:hover::after {
                @apply w-full;
            }
            
            /* Loading Spinner */
            .spinner {
                @apply w-8 h-8 border-4 border-blue-200 border-t-blue-600 rounded-full spin-slow;
            }
            
            /* Progress Bar */
            .progress-bar {
                @apply w-full bg-gray-200 rounded-full h-2 overflow-hidden;
            }
            
            .progress-fill {
                @apply h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-slow;
            }
            
            /* Testimonial Card */
            .testimonial-card {
                @apply bg-white rounded-2xl p-6 card-shadow hover-lift border-gradient;
            }
            
            /* Stats Counter */
            .stat-number {
                @apply text-4xl font-bold gradient-text-blue;
            }
            
            /* Gradient Backgrounds */
            .gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .gradient-secondary {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            }
            
            .gradient-success {
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            }
            
            /* Section dengan Animasi */
            .section-fade-in {
                @apply opacity-0 fade-in-up;
            }
        }
    </style>

    </head>
    <body class="bg-white min-h-screen py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <header class="flex justify-between items-center mb-12">
                <div class="text-2xl font-bold text-gray-800">Study<span class="text-blue-600">Hub</span></div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">About</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Courses</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Resources</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                </nav>
    <div class="flex space-x-4">
    <a href="{{ route('login') }}"
        class="px-4 py-2 text-white font-bold border border-transparent rounded transition-all duration-300 hover:border-white hover:rounded-lg">
        LOG IN
        </a>
        <a href="{{ route('register') }}">
        <button class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">SIGN UP</button>
        </a>
    </div>
            </header>

            <!-- Main Content -->
            <main class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-8">
                    <div class="space-y-1">
                        <h1 class="h1-accent font-bold text-blue-900 leading-tight">
                            Study
                        </h1>
                        <h2 class="h3-accent text-blue-400 -mt-1">
                            Anywhere and everywhere
                        </h2>
                    </div>


                    <p class="text-lg text-gray-600 leading-relaxed">
                        dung dung pk dung dung, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </p>

                    <div class="pt-4">
                        <a>
                        <button class="px-6 py-3 bg-yellow-500 text-grey-900 font-bold rounded-md hover:bg-blue-700 transition-colors flex items-center">
                            Start Learning Now
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        </a>
                    </div>

                    <!-- Learn More Section -->

                </div>

                <!-- Illustration Section -->
                <div class="absolute top-0 right-0 -z-20 h-[100%] max-h-screen object-cover">
                    <svg class="w-full h-full object-contain" viewBox="0 0 1215 1138" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M917.5 0C917.5 0 847.932 31.7568 810.113 62C777.517 88.0658 770.58 115.63 736 139C695.875 166.118 665.281 165.704 619.5 181.5C562.702 201.097 524.426 197.428 473 228.5C423.83 258.209 403.574 286.198 367 330.5C217.913 511.087 367.499 718.227 244.5 917.5C218.712 959.28 204.578 983.679 171 1019.5C115.511 1078.7 0 1137.5 0 1137.5H1215V0H917.5Z" fill="#B5DEDD" />
                    </svg>

                </div>
                <div class="absolute top-0 right-0 -z-10 h-[100%] max-h-screen object-cover">
                    <svg class="w-full h-full object-contain" viewBox="0 0 1345 1153" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M772 0C772 0 674.688 89.6891 690 143C700.331 178.969 727.5 177 727.5 177C727.5 177 876.464 194.36 971 177C1197 135.5 1344.5 354 1344.5 354V0H772Z" fill="#008F97" />
                        <path d="M1344.5 885C1344.5 885 1205.52 987.246 1101 1005.5C1008.18 1021.71 954.494 979.344 860.5 986C714.816 996.316 650.031 1101.22 504 1099C377.565 1097.07 316.506 974.168 194 1005.5C101.795 1029.08 0 1153 0 1153H1344.5V885Z" fill="#008F97" />
                    </svg>


                </div>
                <div class="relative">

                    <!-- Background decorative elements -->
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-blue-200 rounded-full opacity-30"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-green-200 rounded-full opacity-30"></div>
                </div>
            </main>

        </div>
    </body>
    </html>