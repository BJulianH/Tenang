<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - MindWell')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .admin-sidebar {
            background: linear-gradient(180deg, #1e4621 0%, #2e6b34 100%);
        }

        .admin-content {
            transition: all 0.3s ease;
        }

        .card-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Admin Sidebar -->
        <div class="admin-sidebar w-64 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-green-700">
                <h1 class="text-xl font-bold">
                    <i class="fas fa-brain mr-2"></i>
                    MindWell Admin
                </h1>
            </div>

            <!-- Navigation -->
            <div class="flex-1 py-4">
                <nav class="space-y-1 px-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-green-100 bg-green-700 rounded-lg">
                        <i class="fas fa-chart-bar w-6"></i>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700 rounded-lg transition-colors">
                        <i class="fas fa-users w-6"></i>
                        <span class="ml-3 font-medium">Users</span>
                    </a>
                    
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700 rounded-lg transition-colors">
                        <i class="fas fa-file-alt w-6"></i>
                        <span class="ml-3 font-medium">Posts</span>
                    </a>
                    
                    <a href="{{ route('admin.communities.index') }}" class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700 rounded-lg transition-colors">
                        <i class="fas fa-users w-6"></i>
                        <span class="ml-3 font-medium">Communities</span>
                    </a>
                    
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700 rounded-lg transition-colors">
                        <i class="fas fa-flag w-6"></i>
                        <span class="ml-3 font-medium">Reports</span>
                    </a>
                    
                    <a href="{{ url('/') }}" class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left w-6"></i>
                        <span class="ml-3 font-medium">Back to Site</span>
                    </a>
                </nav>
            </div>

            <!-- User Info -->
            <div class="p-4 border-t border-green-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-green-400 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-green-200">Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-content flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        @yield('page_title', 'Admin Dashboard')
                    </h2>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Last login: {{ auth()->user()->last_login_at?->diffForHumans() ?? 'Never' }}</span>
                        
                        {{-- <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-800 transition-colors">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form> --}}
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Add hover effects
        document.querySelectorAll('.hover-lift').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>

    @yield('scripts')
</body>
</html>