@extends('layouts.app')

@section('title', 'Dashboard - MindWell')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-neutral-800">Welcome back, {{ auth()->user()->name ?? 'Explorer' }}!</h1>
        <p class="text-neutral-600">How are you feeling today?</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Mood Card -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Current Mood</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">Good</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center animate-breathe">
                    <i class="fas fa-smile text-primary-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-neutral-500">
                    <span>Last updated: 2 hours ago</span>
                </div>
            </div>
        </div>

        <!-- Meditation Minutes -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Meditation Minutes</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">45 min</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center">
                    <i class="fas fa-wind text-secondary-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-neutral-500">
                    <span>This week: 120 min</span>
                </div>
            </div>
        </div>

        <!-- Challenges Completed -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Challenges Completed</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">12/15</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                    <i class="fas fa-flag-checkered text-primary-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-neutral-200 rounded-full h-2">
                    <div class="bg-primary-500 h-2 rounded-full" style="width: 80%"></div>
                </div>
            </div>
        </div>

        <!-- Current Streak -->
        <div class="bg-white rounded-xl p-6 card-shadow hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Current Streak</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">7 days</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center">
                    <i class="fas fa-fire text-secondary-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-primary-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>+2 days from last week</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Mood Chart -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-neutral-800">Mood Trends</h2>
                    <button class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View Details</button>
                </div>
                <div class="h-64 flex items-end justify-between space-x-2">
                    <!-- Chart bars with primary colors -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-200 rounded-t-lg" style="height: 60%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Mon</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-300 rounded-t-lg" style="height: 70%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Tue</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-400 rounded-t-lg" style="height: 80%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Wed</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-500 rounded-t-lg" style="height: 90%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Thu</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-600 rounded-t-lg" style="height: 85%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Fri</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-400 rounded-t-lg" style="height: 75%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Sat</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-primary-300 rounded-t-lg" style="height: 65%"></div>
                        <span class="text-xs text-neutral-500 mt-2">Sun</span>
                    </div>
                </div>
            </div>

            <!-- Daily Challenges -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-neutral-800">Today's Challenges</h2>
                    <button class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View All</button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                            <i class="fas fa-check text-primary-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-neutral-800">5-minute breathing exercise</h3>
                            <p class="text-sm text-neutral-500">Complete before 8 PM</p>
                        </div>
                        <span class="text-primary-600 font-medium">+10 XP</span>
                    </div>
                    <div class="flex items-center p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-secondary-100 flex items-center justify-center mr-4">
                            <i class="fas fa-running text-secondary-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-neutral-800">15-minute walk outside</h3>
                            <p class="text-sm text-neutral-500">Complete anytime today</p>
                        </div>
                        <span class="text-secondary-600 font-medium">+15 XP</span>
                    </div>
                    <div class="flex items-center p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-accent-gold/20 flex items-center justify-center mr-4">
                            <i class="fas fa-pencil-alt text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-neutral-800">Journal about your day</h3>
                            <p class="text-sm text-neutral-500">Write at least 100 words</p>
                        </div>
                        <span class="text-yellow-600 font-medium">+20 XP</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Progress Ring -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <h2 class="text-lg font-bold text-neutral-800 mb-4">Weekly Progress</h2>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-40">
                        <svg class="w-full h-full" viewBox="0 0 100 100">
                            <!-- Background circle -->
                            <circle cx="50" cy="50" r="40" stroke="#e8f0e5" stroke-width="8" fill="none" />
                            <!-- Progress circle -->
                            <circle cx="50" cy="50" r="40" stroke="#4caf50" stroke-width="8" fill="none" 
                                    stroke-dasharray="251.2" stroke-dashoffset="75.36" 
                                    stroke-linecap="round" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-neutral-800">70%</span>
                            <span class="text-sm text-neutral-500">Complete</span>
                        </div>
                    </div>
                    <p class="text-center text-neutral-600 mt-4">You're on track to complete your weekly goals!</p>
                </div>
            </div>

            <!-- Recent Achievements -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-neutral-800">Recent Achievements</h2>
                    <button class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View All</button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-accent-gold/20 flex items-center justify-center mr-3">
                            <i class="fas fa-medal text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-neutral-800">7-Day Streak</h3>
                            <p class="text-sm text-neutral-500">Unlocked yesterday</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                            <i class="fas fa-gem text-primary-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-neutral-800">Meditation Master</h3>
                            <p class="text-sm text-neutral-500">Completed 10 sessions</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center mr-3">
                            <i class="fas fa-heart text-secondary-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-neutral-800">Mood Tracker</h3>
                            <p class="text-sm text-neutral-500">Logged mood for 14 days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 card-shadow border border-neutral-200">
                <h2 class="text-lg font-bold text-neutral-800 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-3">
                    <button class="flex flex-col items-center justify-center p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors border border-primary-200">
                        <i class="fas fa-heart text-primary-600 text-xl mb-2"></i>
                        <span class="text-sm font-medium text-primary-700">Log Mood</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 bg-secondary-50 rounded-lg hover:bg-secondary-100 transition-colors border border-secondary-200">
                        <i class="fas fa-wind text-secondary-600 text-xl mb-2"></i>
                        <span class="text-sm font-medium text-secondary-700">Meditate</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 bg-neutral-50 rounded-lg hover:bg-neutral-100 transition-colors border border-neutral-200">
                        <i class="fas fa-book text-neutral-600 text-xl mb-2"></i>
                        <span class="text-sm font-medium text-neutral-700">Journal</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 bg-accent-gold/20 rounded-lg hover:bg-yellow-100 transition-colors border border-yellow-200">
                        <i class="fas fa-tasks text-yellow-600 text-xl mb-2"></i>
                        <span class="text-sm font-medium text-yellow-700">Challenges</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Additional scripts for dashboard page -->
    <script>
        // Dashboard-specific JavaScript can go here
        console.log('Dashboard loaded successfully');
    </script>
@endsection