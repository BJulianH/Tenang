@extends('layouts.app')

@section('title', 'Dashboard - Tenang')
@section('style')
<style>
    /* Tambahkan ke section style atau stylesheet terpisah */

    /* Animations untuk welcome container */
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spin-slow 20s linear infinite;
    }

    /* Gradient text untuk highlights */
    .gradient-text {
        background: linear-gradient(90deg, #58cc70, #4a8cff, #9b59b6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Floating animation untuk decorative elements */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    /* Glass morphism effect */
    .glass-effect {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Pulsing ring effect */
    .pulse-ring {
        animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(0.8);
            opacity: 0.8;
        }

        70%,
        100% {
            transform: scale(1.2);
            opacity: 0;
        }
    }

</style>
@endsection
@section('content')
{{-- @extends('widget.avatar-message')
@extends('widget.avatar-widget') --}}
<!-- Quest Confirmation Modal -->
<div id="questConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-neutral-800">Complete Quest</h3>
            <button onclick="closeQuestConfirmation()" class="text-neutral-500 hover:text-neutral-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-primary-600 text-2xl"></i>
            </div>
            <h4 id="confirmationQuestTitle" class="text-lg font-semibold text-neutral-800 mb-2"></h4>
            <p class="text-neutral-600">Are you sure you want to mark this quest as completed?</p>
        </div>

        <!-- Rewards Preview -->
        <div id="rewardsPreview" class="bg-primary-50 rounded-lg p-4 mb-6 hidden">
            <p class="text-sm font-medium text-neutral-700 mb-2">You'll earn:</p>
            <div class="flex justify-center space-x-6">
                <div class="text-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-secondary-100 rounded-full mx-auto mb-1">
                        <i class="fas fa-coins text-secondary-500 text-sm"></i>
                    </div>
                    <span id="rewardCoins" class="text-sm font-semibold text-secondary-600">+0</span>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-accent-blue/20 rounded-full mx-auto mb-1">
                        <i class="fas fa-gem text-accent-blue text-sm"></i>
                    </div>
                    <span id="rewardDiamonds" class="text-sm font-semibold text-accent-blue">+0</span>
                </div>
            </div>
        </div>

        <div class="flex space-x-3">
            <button onclick="closeQuestConfirmation()" class="flex-1 px-4 py-3 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition-colors font-medium">
                Cancel
            </button>
            <button onclick="confirmQuestCompletion()" class="flex-1 px-4 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium app-button">
                <i class="fas fa-check mr-2"></i>
                Complete Quest
            </button>
        </div>
    </div>
</div>

<!-- Quest Success Modal -->
<div id="questSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 text-center">
        <div class="animate-celebrate mb-4">
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto">
                <i class="fas fa-trophy text-green-600 text-3xl"></i>
            </div>
        </div>

        <h3 class="text-xl font-bold text-neutral-800 mb-2">Quest Completed! 🎉</h3>
        <p class="text-neutral-600 mb-4">Great job! You've completed the quest.</p>

        <!-- Rewards Earned -->
        <div class="bg-gradient-to-r from-green-50 to-primary-50 rounded-lg p-4 mb-6 border border-green-200">
            <p class="text-sm font-medium text-neutral-700 mb-3">Rewards Earned:</p>
            <div class="flex justify-center space-x-8">
                <div class="text-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-secondary-100 rounded-full mx-auto mb-2 animate-bounce-gentle">
                        <i class="fas fa-coins text-secondary-500 text-lg"></i>
                    </div>
                    <span id="successCoins" class="text-lg font-bold text-secondary-600">+0</span>
                    <p class="text-xs text-neutral-500">Coins</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-accent-blue/20 rounded-full mx-auto mb-2 animate-bounce-gentle" style="animation-delay: 0.2s">
                        <i class="fas fa-gem text-accent-blue text-lg"></i>
                    </div>
                    <span id="successDiamonds" class="text-lg font-bold text-accent-blue">+0</span>
                    <p class="text-xs text-neutral-500">Diamonds</p>
                </div>
            </div>
        </div>

        <button onclick="closeQuestSuccess()" class="w-full px-4 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium app-button">
            <i class="fas fa-check mr-2"></i>
            Awesome!
        </button>
    </div>
</div>

<div class="mb-8">
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <!-- Content -->
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <!-- Left: Profile Section -->
                <div class="flex items-center space-x-4">
                    <!-- Profile Photo Container -->
                    <div class="relative">
                        <!-- Profile Ring -->
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-500 to-accent-blue p-1.5">
                            <!-- Profile Image -->
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" 
                                         alt="{{ auth()->user()->name }}" 
                                         class="w-full h-full object-cover rounded-full cursor-pointer hover:opacity-90 transition-opacity"
                                         onclick="document.getElementById('profileUpload').click()"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=58cc70&color=fff&size=128'">
                                @elseif(auth()->user()->profile_photo_url)
                                    <img src="{{ auth()->user()->profile_photo_url }}" 
                                         alt="{{ auth()->user()->name }}" 
                                         class="w-full h-full object-cover rounded-full cursor-pointer hover:opacity-90 transition-opacity"
                                         onclick="document.getElementById('profileUpload').click()">
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-primary-500 to-accent-blue flex items-center justify-center cursor-pointer hover:opacity-90 transition-opacity"
                                         onclick="document.getElementById('profileUpload').click()">
                                        <span class="text-3xl font-bold text-white">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Hidden File Input -->
                        <input type="file" id="profileUpload" class="hidden" accept="image/*">
                        
                        <!-- Camera Icon Overlay -->
                        <div class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:bg-primary-600 transition-colors"
                             onclick="document.getElementById('profileUpload').click()"
                             title="Change profile photo">
                            <i class="fas fa-camera text-white text-xs"></i>
                        </div>
                    </div>
                    
                    <!-- Greeting Message -->
                    <div class="flex-1">
                        <!-- Greeting with time-based emoji -->
                        <div class="flex items-center gap-2 mb-2">
                            @php
                                $hour = date('H');
                                $greetings = [
                                    ['emoji' => '🌅', 'text' => 'Good morning'],
                                    ['emoji' => '☀️', 'text' => 'Good afternoon'],
                                    ['emoji' => '🌇', 'text' => 'Good evening'],
                                    ['emoji' => '🌙', 'text' => 'Good night']
                                ];
                                $greeting = $hour < 12 ? $greetings[0] : ($hour < 17 ? $greetings[1] : ($hour < 21 ? $greetings[2] : $greetings[3]));
                            @endphp
                            <span class="text-2xl">{{ $greeting['emoji'] }}</span>
                            <h1 class="text-2xl lg:text-3xl font-bold text-neutral-800">
                                {{ $greeting['text'] }},
                                <span class="text-primary-600">{{ auth()->user()->name ?? 'Explorer' }}</span>!
                                <span class="wave-animation inline-block ml-2">👋</span>
                            </h1>
                        </div>

                        <!-- Encouraging message -->
                        <p class="text-neutral-600 mb-3 text-sm lg:text-base">
                            @php
                                $messages = [
                                    "Ready to level up your wellness today?",
                                    "Small steps lead to big changes. Let's go!",
                                    "Your mental health journey continues...",
                                    "Every moment is a new opportunity to grow.",
                                    "Take a deep breath. You've got this!"
                                ];
                                echo $messages[array_rand($messages)];
                            @endphp
                        </p>

                        <!-- Quick Stats -->
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Daily Progress -->
                            <a href="#daily-quests" class="flex items-center gap-2 px-3 py-2 bg-primary-50 hover:bg-primary-100 transition-colors rounded-lg border border-primary-200 cursor-pointer group">
                                <div class="w-6 h-6 rounded-full bg-primary-100 group-hover:bg-primary-200 transition-colors flex items-center justify-center">
                                    <i class="fas fa-check text-primary-600 text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-700">
                                    {{ $todayQuests->where('status', 'completed')->count() }}/{{ $todayQuests->count() }} quests
                                </span>
                            </a>

                            <!-- Streak -->
                            {{-- <a href="{{ route('profile.stats') }}" class="flex items-center gap-2 px-3 py-2 bg-secondary-50 hover:bg-secondary-100 transition-colors rounded-lg border border-secondary-200 cursor-pointer group">
                                <div class="w-6 h-6 rounded-full bg-secondary-100 group-hover:bg-secondary-200 transition-colors flex items-center justify-center">
                                    <i class="fas fa-fire text-secondary-500 text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-700">
                                    {{ $streakDays ?? '0' }} day streak
                                </span>
                            </a> --}}

                            <!-- Date -->
                            <div class="flex items-center gap-2 px-3 py-2 bg-accent-blue/10 hover:bg-accent-blue/20 transition-colors rounded-lg border border-accent-blue/20 cursor-default">
                                <div class="w-6 h-6 rounded-full bg-accent-blue/20 flex items-center justify-center">
                                    <i class="fas fa-calendar text-accent-blue text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-neutral-700">
                                    {{ date('M j, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Wilson's Message Bubble (Desktop) -->
                <div class="hidden lg:block">
                    <div class="relative group cursor-default">
                        <!-- Chat bubble -->
                        <div class="bg-white rounded-2xl p-4 border-2 border-primary-300 shadow-lg hover:shadow-xl transition-shadow max-w-xs">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-accent-blue flex items-center justify-center cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="toggleWilsonMessage()"
                                     title="Click to change message">
                                    <span class="text-white font-bold">W</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-neutral-800">Wilson Assistant</h3>
                                    <p class="text-xs text-neutral-500">Always here for you</p>
                                </div>
                            </div>
                            <p class="text-neutral-700 text-sm italic select-none" id="wilson-message">
                                "{{ $messages[array_rand($messages)] }}"
                            </p>

                            <!-- Typing indicator -->
                            <div class="flex items-center gap-1 mt-3">
                                <div class="w-2 h-2 bg-primary-400 rounded-full animate-pulse"></div>
                                <div class="w-2 h-2 bg-primary-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-primary-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                                <span class="text-xs text-neutral-500 ml-2">Online</span>
                            </div>
                        </div>

                        <!-- Speech bubble tail -->
                        <div class="absolute -left-3 top-1/2 transform -translate-y-1/2">
                            <div class="w-4 h-4 bg-white border-l-2 border-b-2 border-primary-300 transform rotate-45"></div>
                        </div>
                        
                        <!-- Hover Tooltip -->
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-neutral-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">
                            Click Wilson to change message
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="flex items-center justify-between text-sm text-neutral-600 mb-2">
                    <span>Daily Progress</span>
                    <span class="font-semibold">{{ $todayQuests->where('status', 'completed')->count() * 100 / max($todayQuests->count(), 1) }}%</span>
                </div>
                <div class="h-3 bg-neutral-200 rounded-full overflow-hidden cursor-default">
                    <div class="h-full bg-gradient-to-r from-primary-500 to-accent-blue rounded-full transition-all duration-500" 
                         style="width: {{ $todayQuests->where('status', 'completed')->count() * 100 / max($todayQuests->count(), 1) }}%"
                         title="{{ $todayQuests->where('status', 'completed')->count() }}/{{ $todayQuests->count() }} quests completed">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Wilson Message -->
    <div class="lg:hidden mt-4">
        <div class="bg-gradient-to-r from-primary-50 to-accent-blue/20 rounded-xl p-4 border border-primary-200 cursor-pointer hover:from-primary-100 hover:to-accent-blue/30 transition-all"
             onclick="toggleWilsonMessage()">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-500 to-accent-blue flex items-center justify-center">
                    <span class="text-white font-bold">W</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-neutral-800">Wilson says:</h3>
                        <span class="text-xs text-neutral-500">Just now</span>
                    </div>
                    <p class="text-sm text-neutral-700 mt-1 italic">
                        "{{ $messages[array_rand($messages)] }}"
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Main Content Area -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Daily Quests -->
        <div class="bg-white rounded-xl p-6 card border border-neutral-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-neutral-800">Today's Quests 🎯</h2>
                <div class="flex space-x-2">
                    <button onclick="refreshQuests()" class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh
                    </button>
                    <button onclick="showAvailableQuests()" class="text-sm text-secondary-600 font-medium hover:text-secondary-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i>Choose Quests
                    </button>
                </div>
            </div>

            <!-- Quest Stats -->
            <div class="grid grid-cols-4 gap-4 mb-4 p-3 bg-neutral-50 rounded-lg">
                <div class="text-center">
                    <div class="text-lg font-bold text-neutral-800">{{ $todayQuests->count() }}</div>
                    <div class="text-xs text-neutral-500">Total</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-green-600">{{ $todayQuests->where('status', 'completed')->count() }}</div>
                    <div class="text-xs text-neutral-500">Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-blue-600">{{ $todayQuests->where('status', 'in_progress')->count() }}</div>
                    <div class="text-xs text-neutral-500">In Progress</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-neutral-600">{{ $todayQuests->where('status', 'assigned')->count() }}</div>
                    <div class="text-xs text-neutral-500">Assigned</div>
                </div>
            </div>

            <div class="space-y-4" id="quests-container">
                @forelse($todayQuests as $quest)
                <div class="flex items-center p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors cursor-pointer quest-item" data-quest-id="{{ $quest->id }}" onclick="handleQuestClick({{ $quest->id }}, '{{ $quest->status }}')">
                    <div class="w-10 h-10 rounded-full 
                        @if($quest->status === 'claimed') 
                            bg-green-100 text-green-600
                        @elseif($quest->status === 'completed')
                            bg-blue-100 text-blue-600
                        @elseif($quest->status === 'in_progress')
                            bg-secondary-100 text-secondary-600
                        @else
                            bg-neutral-100 text-neutral-400
                        @endif
                        flex items-center justify-center mr-4">
                        <i class="fas 
                            @if($quest->status === 'claimed') 
                                fa-check-double
                            @elseif($quest->status === 'completed')
                                fa-check 
                            @elseif($quest->status === 'in_progress')
                                fa-spinner fa-spin
                            @else
                                fa-circle
                            @endif
                        "></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-neutral-800">{{ $quest->dailyQuest->title }}</h3>
                        <p class="text-sm text-neutral-500">{{ $quest->dailyQuest->description }}</p>
                        <div class="flex items-center mt-2 text-xs text-neutral-500">
                            <span class="capitalize bg-neutral-100 px-2 py-1 rounded">{{ $quest->dailyQuest->category }}</span>
                            <span class="mx-2">•</span>
                            <span class="capitalize">{{ $quest->dailyQuest->type }}</span>
                        </div>
                        @if($quest->required_progress > 1)
                        <div class="mt-2">
                            <div class="flex items-center justify-between text-xs text-neutral-500 mb-1">
                                <span>Progress</span>
                                <span class="progress-text">{{ $quest->progress }}/{{ $quest->required_progress }}</span>
                            </div>
                            <div class="w-full bg-neutral-200 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" style="width: {{ ($quest->progress / $quest->required_progress) * 100 }}%"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="flex items-center space-x-2 mb-1 justify-end">
                            <span class="text-secondary-500 font-medium">+{{ $quest->dailyQuest->coins }}</span>
                            <i class="fas fa-coins text-secondary-500 text-sm"></i>
                        </div>
                        <div class="flex items-center space-x-2 justify-end">
                            <span class="text-accent-blue font-medium">+{{ $quest->dailyQuest->diamonds }}</span>
                            <i class="fas fa-gem text-accent-blue text-sm"></i>
                        </div>
                        <div class="flex items-center space-x-2 justify-end mt-1">
                            <span class="text-accent-purple font-medium">+{{ $quest->dailyQuest->points }}</span>
                            <i class="fas fa-star text-accent-purple text-sm"></i>
                        </div>
                        @if($quest->status === 'completed')
                        <button onclick="event.stopPropagation(); claimRewards({{ $quest->id }})" class="mt-2 px-3 py-1 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600 transition-colors app-button">
                            Claim Rewards
                        </button>
                        @elseif($quest->status === 'claimed')
                        <span class="mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-lg">
                            Claimed ✓
                        </span>
                        @elseif($quest->required_progress > 1 && $quest->status !== 'completed')
                        <button onclick="event.stopPropagation(); addQuestProgress({{ $quest->id }})" class="mt-2 px-3 py-1 bg-primary-500 text-white text-xs rounded-lg hover:bg-primary-600 transition-colors app-button">
                            Add Progress
                        </button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-neutral-500">
                    <i class="fas fa-quest text-4xl mb-3"></i>
                    <p>No quests for today.</p>
                    <button onclick="assignRandomQuests()" class="mt-2 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button">
                        Get Today's Quests
                    </button>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-6 card border border-neutral-200">
            <h2 class="text-lg font-bold text-neutral-800 mb-4">Quick Actions ⚡</h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('journal.index') }}" class="flex flex-col items-center justify-center p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors border border-primary-200 app-button">
                    <i class="fas fa-book text-primary-600 text-xl mb-2"></i>
                    <span class="text-sm font-medium text-primary-700">Write Journal</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-secondary-50 rounded-lg hover:bg-secondary-100 transition-colors border border-secondary-200 app-button">
                    <i class="fas fa-smile text-secondary-600 text-xl mb-2"></i>
                    <span class="text-sm font-medium text-secondary-700">Log Mood</span>
                </a>
                <a href="{{ route('community.index') }}" class="flex flex-col items-center justify-center p-4 bg-accent-purple/20 rounded-lg hover:bg-accent-purple/30 transition-colors border border-accent-purple/30 app-button">
                    <i class="fas fa-users text-accent-purple text-xl mb-2"></i>
                    <span class="text-sm font-medium text-accent-purple">Community</span>
                </a>
                <a href="{{ route('noises.index') }}" class="flex flex-col items-center justify-center p-4 bg-accent-blue/20 rounded-lg hover:bg-accent-blue/30 transition-colors border border-accent-blue/30 app-button">
                    <i class="fas fa-headphones text-accent-blue text-xl mb-2"></i>
                    <span class="text-sm font-medium text-accent-blue">Relax Sounds</span>
                </a>
            </div>
        </div>

        <!-- Recent Journals -->
        <div class="bg-white rounded-xl p-6 card border border-neutral-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-neutral-800">Recent Journals 📝</h2>
                <a href="{{ route('journal.index') }}" class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View All</a>
            </div>
            <div class="space-y-4">
                @forelse($recentJournals as $journal)
                <div class="flex items-start p-3 rounded-lg hover:bg-primary-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-book-open text-primary-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-neutral-800 truncate">{{ $journal->title }}</h3>
                        <p class="text-sm text-neutral-500 mt-1">{{ Str::limit($journal->content, 60) }}</p>
                        <div class="flex items-center mt-2 text-xs text-neutral-500">
                            <span>{{ $journal->created_at->format('M j') }}</span>
                            <span class="mx-2">•</span>
                            <span class="flex items-center">
                                <i class="fas fa-smile mr-1"></i>
                                {{ ucfirst($journal->mood ?? 'neutral') }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-neutral-500">
                    <i class="fas fa-book text-2xl mb-2"></i>
                    <p class="text-sm">No journals yet</p>
                    <a href="{{ route('journal.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">Write your first journal</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Community Activity -->
        <div class="bg-white rounded-xl p-6 card border border-neutral-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-neutral-800">Community Activity 👥</h2>
                <a href="{{ route('community.index') }}" class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPosts as $post)
                <div class="flex items-start p-3 rounded-lg hover:bg-primary-50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-secondary-100 flex items-center justify-center mr-3 flex-shrink-0 text-xs">
                        <i class="fas fa-comment text-secondary-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-neutral-800 line-clamp-2">{{ Str::limit($post->content, 80) }}</p>
                        <div class="flex items-center mt-1 text-xs text-neutral-500">
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            @if($post->mood)
                            <span class="mx-2">•</span>
                            <span>{{ $post->mood }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-neutral-500">
                    <i class="fas fa-users text-2xl mb-2"></i>
                    <p class="text-sm">No community activity</p>
                    <a href="{{ route('community.create') }}" class="text-primary-600 hover:text-primary-700 text-sm">Join the conversation</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Available Quests Modal -->
<div id="availableQuestsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Choose Your Quests</h3>
            <button onclick="closeAvailableQuests()" class="text-neutral-500 hover:text-neutral-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="available-quests-list" class="space-y-3">
            <!-- Available quests will be loaded here -->
        </div>
        <div class="mt-4 flex justify-between">
            <button onclick="assignRandomQuests()" class="px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors app-button">
                Get Random Quests
            </button>
            <button onclick="confirmQuestSelection()" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button">
                Confirm Selection ( <span id="selected-count">0</span> / 5 )
            </button>
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div id="progressModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Add Progress</h3>
            <button onclick="closeProgressModal()" class="text-neutral-500 hover:text-neutral-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="space-y-4">
            <p id="progressQuestTitle" class="text-neutral-600"></p>
            <div class="flex items-center space-x-4">
                <button onclick="updateProgress(-1)" class="w-10 h-10 bg-neutral-200 rounded-full flex items-center justify-center hover:bg-neutral-300">
                    <i class="fas fa-minus"></i>
                </button>
                <span id="progressDisplay" class="text-xl font-bold">0/1</span>
                <button onclick="updateProgress(1)" class="w-10 h-10 bg-neutral-200 rounded-full flex items-center justify-center hover:bg-neutral-300">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="w-full bg-neutral-200 rounded-full h-3">
                <div id="progressBar" class="bg-primary-500 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
            <button onclick="saveProgress()" class="w-full px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button">
                Save Progress
            </button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    let selectedQuestIds = [];
    let currentQuestId = null;
    let currentProgress = 0;
    let maxProgress = 1;
    let pendingQuestId = null;

    // Handle quest click - show confirmation modal
    function handleQuestClick(questId, status) {
        console.log('Quest clicked:', questId, 'Status:', status);

        // Debug: cek semua data quest
        const questElement = document.querySelector(`[data-quest-id="${questId}"]`);
        console.log('Quest element:', questElement);

        if (!questId || questId === 'null' || questId === 'undefined') {
            console.error('Invalid quest ID received:', questId);
            showNotification('Error: Invalid quest selection', 'error');
            return;
        }

        // Convert to number dan validasi
        const numericQuestId = parseInt(questId);
        if (isNaN(numericQuestId)) {
            console.error('Quest ID is not a number:', questId);
            showNotification('Error: Invalid quest ID format', 'error');
            return;
        }

        console.log('Numeric quest ID:', numericQuestId);

        if (status === 'assigned' || status === 'in_progress') {
            showQuestConfirmation(numericQuestId);
        } else if (status === 'completed') {
            showNotification('Quest already completed!', 'info');
        } else if (status === 'claimed') {
            showNotification('Rewards already claimed!', 'info');
        }
    }


    // Show quest confirmation modal
    function showQuestConfirmation(questId) {
        console.log('Showing confirmation for quest:', questId);

        // Validate questId again
        if (!questId) {
            console.error('No quest ID provided to showQuestConfirmation');
            showNotification('Error: No quest selected', 'error');
            return;
        }

        const questElement = document.querySelector(`[data-quest-id="${questId}"]`);
        if (!questElement) {
            console.error('Quest element not found for ID:', questId);
            showNotification('Error: Quest not found in page', 'error');
            return;
        }

        // Get quest details
        const questTitle = questElement.querySelector('h3') ? .textContent || 'Unknown Quest';
        const coinsElement = questElement.querySelector('.text-secondary-500');
        const diamondsElement = questElement.querySelector('.text-accent-blue');

        const coins = coinsElement ? coinsElement.textContent.replace('+', '') : '0';
        const diamonds = diamondsElement ? diamondsElement.textContent.replace('+', '') : '0';

        console.log('Quest details - Title:', questTitle, 'Coins:', coins, 'Diamonds:', diamonds);

        // Update modal content
        const confirmationTitle = document.getElementById('confirmationQuestTitle');
        const rewardCoins = document.getElementById('rewardCoins');
        const rewardDiamonds = document.getElementById('rewardDiamonds');

        if (confirmationTitle) confirmationTitle.textContent = questTitle;
        if (rewardCoins) rewardCoins.textContent = `+${coins}`;
        if (rewardDiamonds) rewardDiamonds.textContent = `+${diamonds}`;

        // Show rewards preview
        const rewardsPreview = document.getElementById('rewardsPreview');
        if (rewardsPreview) rewardsPreview.classList.remove('hidden');

        // Store quest ID for confirmation
        pendingQuestId = questId;
        console.log('Pending quest ID set to:', pendingQuestId);

        // Show modal
        const modal = document.getElementById('questConfirmationModal');
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.error('Confirmation modal not found!');
            showNotification('Error: Confirmation modal not found', 'error');
        }
    }

    // Close confirmation modal
    function closeQuestConfirmation() {
        console.log('Closing confirmation modal');
        const modal = document.getElementById('questConfirmationModal');
        if (modal) modal.classList.add('hidden');
        pendingQuestId = null;
    }

    // Confirm quest completion
    function confirmQuestCompletion() {
        console.log('Confirming quest completion, pendingQuestId:', pendingQuestId);

        if (!pendingQuestId) {
            console.error('No pending quest ID found in confirmQuestCompletion');
            showNotification('Error: No quest selected for completion', 'error');
            return;
        }

        completeQuest(pendingQuestId);
        closeQuestConfirmation();
    }

    // Complete quest dengan modal success
    function completeQuest(questId) {
        console.log('Completing quest:', questId);

        if (!questId) {
            console.error('Invalid quest ID in completeQuest:', questId);
            showNotification('Error: Invalid quest ID', 'error');
            return;
        }

        showNotification('Completing quest...', 'info');

        // Ensure URL is correct
        const url = `/quests/${questId}/complete`;
        console.log('Making POST request to:', url);

        fetch(url, {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({})
            })
            .then(response => {
                console.log('Response status:', response.status, 'URL:', response.url);

                // Check if response is HTML (error page)
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        console.error('HTML response received. Route might not exist.');
                        console.error('HTML snippet:', html.substring(0, 500));
                        throw new Error('Server returned HTML instead of JSON. Route may not exist: ' + url);
                    });
                }

                // Check if response is OK
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return response.json();
            })
            .then(data => {
                console.log('Response data received:', data);

                if (data.message) {
                    console.log('Quest completed successfully');
                    showQuestSuccess(data.rewards);
                } else if (data.error) {
                    console.error('Server returned error:', data.error);
                    showNotification('Error: ' + data.error, 'error');
                } else {
                    console.error('Unexpected response format:', data);
                    showNotification('Error: Unexpected response from server', 'error');
                }
            })
            .catch(error => {
                console.error('Error completing quest:', error);

                if (error.message.includes('Route may not exist')) {
                    showNotification('Error: Quest completion route not found. Please check server configuration.', 'error');
                } else if (error.message.includes('HTTP error')) {
                    showNotification('Error: Server returned ' + error.message, 'error');
                } else {
                    showNotification('Error completing quest: ' + error.message, 'error');
                }
            });
    }

    // Show quest success modal
    function showQuestSuccess(rewards) {
        console.log('Showing success modal with rewards:', rewards);

        // Update rewards in success modal
        const successCoins = document.getElementById('successCoins');
        const successDiamonds = document.getElementById('successDiamonds');

        if (successCoins) successCoins.textContent = `+${rewards?.coins || 0}`;
        if (successDiamonds) successDiamonds.textContent = `+${rewards?.diamonds || 0}`;

        // Show success modal
        const modal = document.getElementById('questSuccessModal');
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.error('Success modal not found!');
            showNotification('Quest completed! Reloading page...', 'success');
            setTimeout(() => location.reload(), 2000);
            return;
        }

        // Add celebration effects
        createCelebrationEffects();
    }

    // Close success modal and reload
    function closeQuestSuccess() {
        console.log('Closing success modal and reloading page');
        const modal = document.getElementById('questSuccessModal');
        if (modal) modal.classList.add('hidden');
        setTimeout(() => {
            location.reload();
        }, 500);
    }

    // Celebration effects for success
    function createCelebrationEffects() {
        const container = document.getElementById('questSuccessModal');
        if (!container) return;

        const particles = ['🎉', '✨', '🌟', '💫', '🥳', '🎊'];

        for (let i = 0; i < 8; i++) {
            setTimeout(() => {
                const particle = document.createElement('div');
                particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
                particle.className = 'absolute text-2xl celebration-particle';
                particle.style.left = Math.random() * 80 + 10 + '%';
                particle.style.top = Math.random() * 80 + 10 + '%';
                particle.style.animationDelay = (Math.random() * 0.5) + 's';
                particle.style.zIndex = '60';

                container.appendChild(particle);

                setTimeout(() => {
                    if (particle.parentNode) {
                        particle.remove();
                    }
                }, 1000);
            }, i * 100);
        }
    }

    // Add progress to quest
    function addQuestProgress(questId) {
        console.log('Adding progress to quest:', questId);

        const questElement = document.querySelector(`[data-quest-id="${questId}"]`);
        if (!questElement) {
            console.error('Quest element not found for progress:', questId);
            return;
        }

        const progressText = questElement.querySelector('.progress-text') ? .textContent;
        if (!progressText) {
            console.error('Progress text not found for quest:', questId);
            return;
        }

        const [current, max] = progressText.split('/').map(Number);

        currentQuestId = questId;
        currentProgress = current;
        maxProgress = max;

        const progressTitle = document.getElementById('progressQuestTitle');
        if (progressTitle) {
            progressTitle.textContent = questElement.querySelector('h3') ? .textContent || 'Unknown Quest';
        }

        updateProgressDisplay();

        const modal = document.getElementById('progressModal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function updateProgress(change) {
        currentProgress = Math.max(0, Math.min(maxProgress, currentProgress + change));
        updateProgressDisplay();
    }

    function updateProgressDisplay() {
        const progressDisplay = document.getElementById('progressDisplay');
        const progressBar = document.getElementById('progressBar');

        if (progressDisplay) {
            progressDisplay.textContent = `${currentProgress}/${maxProgress}`;
        }

        if (progressBar) {
            const percentage = (currentProgress / maxProgress) * 100;
            progressBar.style.width = `${percentage}%`;
        }
    }

    function saveProgress() {
        if (!currentQuestId) {
            showNotification('Error: No quest selected', 'error');
            return;
        }

        showNotification('Updating progress...', 'info');

        fetch(`/quests/${currentQuestId}/progress`, {
                method: 'PATCH'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({
                    progress: currentProgress
                })
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.message) {
                    showNotification('Progress updated successfully!', 'success');
                    closeProgressModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else if (data.error) {
                    showNotification(data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating progress: ' + error.message, 'error');
            });
    }

    function closeProgressModal() {
        const modal = document.getElementById('progressModal');
        if (modal) modal.classList.add('hidden');
        currentQuestId = null;
    }

    // Show available quests
    function showAvailableQuests() {
        showNotification('Loading available quests...', 'info');

        fetch('/quests/available', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('available-quests-list');
                if (!container) return;

                container.innerHTML = '';

                if (data.available_quests && data.available_quests.length === 0) {
                    container.innerHTML = `
                <div class="text-center py-4 text-neutral-500">
                    <i class="fas fa-quest text-2xl mb-2"></i>
                    <p>No available quests at the moment</p>
                </div>
            `;
                    return;
                }

                if (data.available_quests) {
                    data.available_quests.forEach(quest => {
                        const questElement = document.createElement('div');
                        questElement.className = 'flex items-center p-3 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors';
                        questElement.innerHTML = `
                    <input type="checkbox" value="${quest.id}" 
                            class="mr-3 quest-checkbox rounded text-primary-500">
                    <div class="flex-1">
                        <h4 class="font-medium text-neutral-800">${quest.title}</h4>
                        <p class="text-sm text-neutral-500">${quest.description}</p>
                        <div class="flex items-center space-x-4 mt-2 text-xs">
                            <span class="text-secondary-500">
                                <i class="fas fa-coins mr-1"></i>${quest.coins || 0}
                            </span>
                            <span class="text-accent-blue">
                                <i class="fas fa-gem mr-1"></i>${quest.diamonds || 0}
                            </span>
                            <span class="capitalize bg-neutral-100 px-2 py-1 rounded">${quest.category || 'general'}</span>
                        </div>
                    </div>
                `;

                        // Add event listener properly
                        const checkbox = questElement.querySelector('.quest-checkbox');
                        checkbox.addEventListener('change', function() {
                            toggleQuestSelection(quest.id, this.checked);
                        });

                        container.appendChild(questElement);
                    });
                }

                const modal = document.getElementById('availableQuestsModal');
                if (modal) modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error loading available quests: ' + error.message, 'error');
            });
    }

    // Toggle quest selection - FIXED VERSION
    function toggleQuestSelection(questId, isChecked) {
        console.log('Toggle quest selection:', questId, 'Checked:', isChecked);

        // Validate questId
        if (!questId) {
            console.error('Invalid quest ID in toggleQuestSelection:', questId);
            return;
        }

        const numericQuestId = parseInt(questId);

        if (isChecked) {
            // Add to selection
            if (selectedQuestIds.length < 5) {
                if (!selectedQuestIds.includes(numericQuestId)) {
                    selectedQuestIds.push(numericQuestId);
                    console.log('Added quest to selection:', numericQuestId);
                }
            } else {
                // Maximum reached, uncheck the box
                showNotification('Maximum 5 quests allowed', 'warning');
                const checkbox = document.querySelector(`input[value="${questId}"]`);
                if (checkbox) checkbox.checked = false;
                return;
            }
        } else {
            // Remove from selection
            const index = selectedQuestIds.indexOf(numericQuestId);
            if (index > -1) {
                selectedQuestIds.splice(index, 1);
                console.log('Removed quest from selection:', numericQuestId);
            }
        }

        console.log('Current selected quests:', selectedQuestIds);
        updateSelectedCount();
    }

    function debugSelectedQuests() {
        console.log('=== DEBUG SELECTED QUESTS ===');
        console.log('Selected Quest IDs:', selectedQuestIds);
        console.log('Selected Count:', selectedQuestIds.length);
        console.log('Checkboxes:');

        document.querySelectorAll('.quest-checkbox').forEach(checkbox => {
            console.log(`Checkbox value: ${checkbox.value}, checked: ${checkbox.checked}`);
        });
        console.log('=== END DEBUG ===');
    }
    // Confirm quest selection - FIXED VERSION
    function confirmQuestSelection() {
        console.log('Confirming selection with quests:', selectedQuestIds);
        debugSelectedQuests();

        if (selectedQuestIds.length === 0) {
            showNotification('Please select at least one quest', 'warning');
            return;
        }

        showNotification('Assigning quests...', 'info');

        fetch('/quests/choose', {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({
                    quest_ids: selectedQuestIds
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        console.error('HTML response received:', html.substring(0, 500));
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Selection response:', data);
                if (data.message) {
                    showNotification('Quests assigned successfully!', 'success');
                    closeAvailableQuests();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else if (data.error) {
                    showNotification(data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error assigning quests: ' + error.message, 'error');
            });
    }

    // Toggle quest selection
    function toggleQuestSelection(questId) {
        const index = selectedQuestIds.indexOf(questId);
        if (index > -1) {
            selectedQuestIds.splice(index, 1);
        } else {
            if (selectedQuestIds.length < 5) {
                selectedQuestIds.push(questId);
            } else {
                showNotification('Maximum 5 quests allowed', 'warning');
                const checkbox = document.querySelector(`input[value="${questId}"]`);
                if (checkbox) checkbox.checked = false;
            }
        }
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const selectedCount = document.getElementById('selected-count');
        if (selectedCount) selectedCount.textContent = selectedQuestIds.length;
    }

    // Confirm quest selection
    function confirmQuestSelection() {
        if (selectedQuestIds.length === 0) {
            showNotification('Please select at least one quest', 'warning');
            return;
        }

        showNotification('Assigning quests...', 'info');

        fetch('/quests/choose', {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({
                    quest_ids: selectedQuestIds
                })
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.message) {
                    showNotification('Quests assigned successfully!', 'success');
                    closeAvailableQuests();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else if (data.error) {
                    showNotification(data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error assigning quests: ' + error.message, 'error');
            });
    }

    // Assign random quests
    function assignRandomQuests() {
        showNotification('Assigning random quests...', 'info');

        fetch('/quests/assign-random', {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({})
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.message || (Array.isArray(data) && data.length > 0)) {
                    showNotification('Random quests assigned!', 'success');
                    closeAvailableQuests();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error assigning quests: ' + error.message, 'error');
            });
    }

    // Close available quests modal
    function closeAvailableQuests() {
        const modal = document.getElementById('availableQuestsModal');
        if (modal) modal.classList.add('hidden');
        selectedQuestIds = [];
        updateSelectedCount();
    }

    // Refresh quests
    function refreshQuests() {
        location.reload();
    }


    function claimRewards(questId) {
        console.log('Claiming rewards for quest:', questId); // Debug log

        if (!questId) {
            showNotification('Error: Invalid quest ID', 'error');
            return;
        }

        showNotification('Claiming rewards...', 'info');

        fetch(`/quests/${questId}/claim`, {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({})
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    return response.text().then(html => {
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.message) {
                    showNotification('Rewards claimed successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else if (data.error) {
                    showNotification(data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error claiming rewards: ' + error.message, 'error');
            });
    }

    function showDailyWelcomeMessage() {
        const today = new Date().toISOString().slice(0, 10);
        const lastShown = localStorage.getItem("avatarMessageLastShown");

        // Jika belum pernah muncul hari ini → tampilkan
        if (lastShown !== today) {
            showAvatarMessage("welcome back dear {{ auth()->user()->name ?? 'Explorer' }}");

            // Simpan tanggal hari ini
            localStorage.setItem("avatarMessageLastShown", today);
        }
    }

    // Add animation to quest items
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard JavaScript loaded');

        const questItems = document.querySelectorAll('.quest-item');
        console.log('Found quest items:', questItems.length);
        // showDailyWelcomeMessage();
        //         showAvatarPopup("Welcome back, {{ auth()->user()->name ?? 'Explorer' }}!");

        questItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('animate-slide-in');

            // Debug: log each quest item
            const questId = item.getAttribute('data-quest-id');
            const onclick = item.getAttribute('onclick');
            console.log(`Quest ${index + 1}: ID=${questId}, onclick=${onclick}`);
        });

        // Test if modals exist
        const modals = [
            'questConfirmationModal'
            , 'questSuccessModal'
            , 'progressModal'
            , 'availableQuestsModal'
        ];

        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            console.log(`Modal ${modalId}:`, modal ? 'Found' : 'NOT FOUND');
        });

    });

    // Global error handler for debugging
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);
        console.error('File:', e.filename);
        console.error('Line:', e.lineno);
        console.error('Column:', e.colno);
    });
    // Dalam JavaScript section, tambahkan:
    function toggleWilsonMessage() {
        const messageBubble = document.querySelector('.wilson-message-bubble');
        if (messageBubble) {
            messageBubble.classList.toggle('hidden');
        }
    }

    // Wilson greeting berdasarkan waktu
    function getWilsonGreeting() {
        const hour = new Date().getHours();
        const greetings = [{
                time: "morning"
                , emoji: "🌅"
                , message: "Rise and shine! A new day for growth."
            }
            , {
                time: "afternoon"
                , emoji: "☀️"
                , message: "Hope you're having a productive day!"
            }
            , {
                time: "evening"
                , emoji: "🌙"
                , message: "Time to unwind and reflect on your day."
            }
            , {
                time: "night"
                , emoji: "⭐"
                , message: "Don't forget to rest and recharge."
            }
        ];

        let timeOfDay;
        if (hour < 12) timeOfDay = "morning";
        else if (hour < 17) timeOfDay = "afternoon";
        else if (hour < 21) timeOfDay = "evening";
        else timeOfDay = "night";

        return greetings.find(g => g.time === timeOfDay);
    }

    // Update greeting secara dinamis
    document.addEventListener('DOMContentLoaded', function() {
        const greeting = getWilsonGreeting();
        const greetingElement = document.getElementById('wilson-greeting');
        if (greetingElement) {
            greetingElement.innerHTML = `${greeting.emoji} ${greeting.message}`;
        }

        // Pulsing effect untuk Wilson icon
        const wilsonIcon = document.querySelector('.wilson-icon-container');
        if (wilsonIcon) {
            setInterval(() => {
                wilsonIcon.classList.toggle('pulse-gentle');
            }, 3000);
        }
    });

</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .quest-item {
        transition: all 0.3s ease;
    }

    .quest-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .quest-item.completed {
        background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e8 100%);
        border-color: #58cc70;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>
@endsection

@php
function getMoodLabel($rate) {
if ($rate >= 9) return 'Excellent';
if ($rate >= 7) return 'Good';
if ($rate >= 5) return 'Okay';
if ($rate >= 3) return 'Poor';
return 'Bad';
}

function getMoodColor($rate) {
if ($rate >= 9) return 'bg-mood-excellent';
if ($rate >= 7) return 'bg-mood-good';
if ($rate >= 5) return 'bg-mood-okay';
if ($rate >= 3) return 'bg-mood-poor';
return 'bg-mood-bad';
}
@endphp
