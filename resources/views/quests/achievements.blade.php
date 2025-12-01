@extends('layouts.app')

@section('title', 'Achievements - Tenang')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-neutral-800">Achievements 🏆</h1>
    <p class="text-neutral-600">Unlock achievements and showcase your progress!</p>
</div>

<!-- Achievement Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Achievements -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Total Achievements</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $achievementStats['total_achievements'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                <i class="fas fa-trophy text-primary-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Unlocked -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Unlocked</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $achievementStats['unlocked_achievements'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-lock-open text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Completion -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Completion</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $achievementStats['completion_percentage'] }}%</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center">
                <i class="fas fa-chart-pie text-secondary-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-full bg-neutral-200 rounded-full h-2">
                <div class="bg-secondary-500 h-2 rounded-full" 
                     style="width: {{ $achievementStats['completion_percentage'] }}%"></div>
            </div>
        </div>
    </div>

    <!-- Quests Completed -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Quests Completed</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $achievementStats['quests_completed'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-accent-purple/20 flex items-center justify-center">
                <i class="fas fa-flag-checkered text-accent-purple text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Achievements Grid -->
<div class="space-y-8">
    <!-- Quest Achievements -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <h3 class="text-lg font-semibold text-neutral-800 mb-4 flex items-center">
            <i class="fas fa-flag-checkered text-primary-500 mr-2"></i>
            Quest Achievements
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($userAchievements as $achievement)
            @if(in_array($achievement['id'], [1, 2, 3, 12]))
            <div class="border-2 rounded-lg p-4 transition-all duration-300 
                {{ $achievement['is_unlocked'] ? 'border-green-500 bg-green-50 transform hover:scale-105' : 'border-neutral-200 bg-neutral-50 hover:bg-white' }} 
                hover:shadow-md relative overflow-hidden">
                
                <!-- Achievement Badge -->
                <div class="absolute top-2 right-2">
                    @if($achievement['is_unlocked'])
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    @else
                    <div class="w-8 h-8 bg-neutral-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-neutral-600 text-sm"></i>
                    </div>
                    @endif
                </div>

                <!-- Achievement Header -->
                <div class="flex items-start mb-3">
                    <div class="w-12 h-12 rounded-full 
                        {{ $achievement['is_unlocked'] ? 'bg-green-100 text-green-600' : 'bg-neutral-200 text-neutral-400' }} 
                        flex items-center justify-center mr-3 flex-shrink-0">
                        <span class="text-lg">{{ $achievement['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-neutral-800 text-lg">{{ $achievement['title'] }}</h4>
                        <p class="text-sm text-neutral-600 mt-1">{{ $achievement['description'] }}</p>
                    </div>
                </div>

                <!-- Progress -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm text-neutral-600 mb-1">
                        <span>Progress</span>
                        <span class="font-semibold">{{ $achievement['progress'] }}/{{ $achievement['requirement'] }}</span>
                    </div>
                    <div class="w-full bg-neutral-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500 
                            {{ $achievement['is_unlocked'] ? 'bg-green-500' : 'bg-primary-500' }}" 
                             style="width: {{ $achievement['progress_percentage'] }}%"></div>
                    </div>
                </div>

                <!-- Rewards -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if($achievement['reward_coins'] > 0)
                        <div class="flex items-center text-sm bg-secondary-100 px-2 py-1 rounded-full">
                            <i class="fas fa-coins text-secondary-500 mr-1"></i>
                            <span class="font-semibold text-secondary-600">+{{ $achievement['reward_coins'] }}</span>
                        </div>
                        @endif
                        @if($achievement['reward_diamonds'] > 0)
                        <div class="flex items-center text-sm bg-accent-blue/20 px-2 py-1 rounded-full">
                            <i class="fas fa-gem text-accent-blue mr-1"></i>
                            <span class="font-semibold text-accent-blue">+{{ $achievement['reward_diamonds'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Coin & Diamond Achievements -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <h3 class="text-lg font-semibold text-neutral-800 mb-4 flex items-center">
            <i class="fas fa-coins text-secondary-500 mr-2"></i>
            Currency Achievements
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($userAchievements as $achievement)
            @if(in_array($achievement['id'], [4, 5, 6]))
            <div class="border-2 rounded-lg p-4 transition-all duration-300 
                {{ $achievement['is_unlocked'] ? 'border-green-500 bg-green-50 transform hover:scale-105' : 'border-neutral-200 bg-neutral-50 hover:bg-white' }} 
                hover:shadow-md relative overflow-hidden">
                
                <!-- Achievement Badge -->
                <div class="absolute top-2 right-2">
                    @if($achievement['is_unlocked'])
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    @else
                    <div class="w-8 h-8 bg-neutral-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-neutral-600 text-sm"></i>
                    </div>
                    @endif
                </div>

                <!-- Achievement Header -->
                <div class="flex items-start mb-3">
                    <div class="w-12 h-12 rounded-full 
                        {{ $achievement['is_unlocked'] ? 'bg-green-100 text-green-600' : 'bg-neutral-200 text-neutral-400' }} 
                        flex items-center justify-center mr-3 flex-shrink-0">
                        <span class="text-lg">{{ $achievement['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-neutral-800 text-lg">{{ $achievement['title'] }}</h4>
                        <p class="text-sm text-neutral-600 mt-1">{{ $achievement['description'] }}</p>
                    </div>
                </div>

                <!-- Progress -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm text-neutral-600 mb-1">
                        <span>Progress</span>
                        <span class="font-semibold">{{ $achievement['progress'] }}/{{ $achievement['requirement'] }}</span>
                    </div>
                    <div class="w-full bg-neutral-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500 
                            {{ $achievement['is_unlocked'] ? 'bg-green-500' : 'bg-primary-500' }}" 
                             style="width: {{ $achievement['progress_percentage'] }}%"></div>
                    </div>
                </div>

                <!-- Rewards -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if($achievement['reward_coins'] > 0)
                        <div class="flex items-center text-sm bg-secondary-100 px-2 py-1 rounded-full">
                            <i class="fas fa-coins text-secondary-500 mr-1"></i>
                            <span class="font-semibold text-secondary-600">+{{ $achievement['reward_coins'] }}</span>
                        </div>
                        @endif
                        @if($achievement['reward_diamonds'] > 0)
                        <div class="flex items-center text-sm bg-accent-blue/20 px-2 py-1 rounded-full">
                            <i class="fas fa-gem text-accent-blue mr-1"></i>
                            <span class="font-semibold text-accent-blue">+{{ $achievement['reward_diamonds'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Streak Achievements -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <h3 class="text-lg font-semibold text-neutral-800 mb-4 flex items-center">
            <i class="fas fa-fire text-accent-red mr-2"></i>
            Streak Achievements
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($userAchievements as $achievement)
            @if(in_array($achievement['id'], [7, 8]))
            <div class="border-2 rounded-lg p-4 transition-all duration-300 
                {{ $achievement['is_unlocked'] ? 'border-green-500 bg-green-50 transform hover:scale-105' : 'border-neutral-200 bg-neutral-50 hover:bg-white' }} 
                hover:shadow-md relative overflow-hidden">
                
                <!-- Achievement Badge -->
                <div class="absolute top-2 right-2">
                    @if($achievement['is_unlocked'])
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    @else
                    <div class="w-8 h-8 bg-neutral-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-neutral-600 text-sm"></i>
                    </div>
                    @endif
                </div>

                <!-- Achievement Header -->
                <div class="flex items-start mb-3">
                    <div class="w-12 h-12 rounded-full 
                        {{ $achievement['is_unlocked'] ? 'bg-green-100 text-green-600' : 'bg-neutral-200 text-neutral-400' }} 
                        flex items-center justify-center mr-3 flex-shrink-0">
                        <span class="text-lg">{{ $achievement['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-neutral-800 text-lg">{{ $achievement['title'] }}</h4>
                        <p class="text-sm text-neutral-600 mt-1">{{ $achievement['description'] }}</p>
                    </div>
                </div>

                <!-- Progress -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm text-neutral-600 mb-1">
                        <span>Progress</span>
                        <span class="font-semibold">{{ $achievement['progress'] }}/{{ $achievement['requirement'] }}</span>
                    </div>
                    <div class="w-full bg-neutral-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500 
                            {{ $achievement['is_unlocked'] ? 'bg-green-500' : 'bg-primary-500' }}" 
                             style="width: {{ $achievement['progress_percentage'] }}%"></div>
                    </div>
                </div>

                <!-- Rewards -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if($achievement['reward_coins'] > 0)
                        <div class="flex items-center text-sm bg-secondary-100 px-2 py-1 rounded-full">
                            <i class="fas fa-coins text-secondary-500 mr-1"></i>
                            <span class="font-semibold text-secondary-600">+{{ $achievement['reward_coins'] }}</span>
                        </div>
                        @endif
                        @if($achievement['reward_diamonds'] > 0)
                        <div class="flex items-center text-sm bg-accent-blue/20 px-2 py-1 rounded-full">
                            <i class="fas fa-gem text-accent-blue mr-1"></i>
                            <span class="font-semibold text-accent-blue">+{{ $achievement['reward_diamonds'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Special Achievements -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <h3 class="text-lg font-semibold text-neutral-800 mb-4 flex items-center">
            <i class="fas fa-star text-yellow-500 mr-2"></i>
            Special Achievements
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($userAchievements as $achievement)
            @if(in_array($achievement['id'], [9, 10, 11]))
            <div class="border-2 rounded-lg p-4 transition-all duration-300 
                {{ $achievement['is_unlocked'] ? 'border-green-500 bg-green-50 transform hover:scale-105' : 'border-neutral-200 bg-neutral-50 hover:bg-white' }} 
                hover:shadow-md relative overflow-hidden">
                
                <!-- Achievement Badge -->
                <div class="absolute top-2 right-2">
                    @if($achievement['is_unlocked'])
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    @else
                    <div class="w-8 h-8 bg-neutral-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-neutral-600 text-sm"></i>
                    </div>
                    @endif
                </div>

                <!-- Achievement Header -->
                <div class="flex items-start mb-3">
                    <div class="w-12 h-12 rounded-full 
                        {{ $achievement['is_unlocked'] ? 'bg-green-100 text-green-600' : 'bg-neutral-200 text-neutral-400' }} 
                        flex items-center justify-center mr-3 flex-shrink-0">
                        <span class="text-lg">{{ $achievement['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-neutral-800 text-lg">{{ $achievement['title'] }}</h4>
                        <p class="text-sm text-neutral-600 mt-1">{{ $achievement['description'] }}</p>
                    </div>
                </div>

                <!-- Progress -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm text-neutral-600 mb-1">
                        <span>Progress</span>
                        <span class="font-semibold">{{ $achievement['progress'] }}/{{ $achievement['requirement'] }}</span>
                    </div>
                    <div class="w-full bg-neutral-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500 
                            {{ $achievement['is_unlocked'] ? 'bg-green-500' : 'bg-primary-500' }}" 
                             style="width: {{ $achievement['progress_percentage'] }}%"></div>
                    </div>
                </div>

                <!-- Rewards -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if($achievement['reward_coins'] > 0)
                        <div class="flex items-center text-sm bg-secondary-100 px-2 py-1 rounded-full">
                            <i class="fas fa-coins text-secondary-500 mr-1"></i>
                            <span class="font-semibold text-secondary-600">+{{ $achievement['reward_coins'] }}</span>
                        </div>
                        @endif
                        @if($achievement['reward_diamonds'] > 0)
                        <div class="flex items-center text-sm bg-accent-blue/20 px-2 py-1 rounded-full">
                            <i class="fas fa-gem text-accent-blue mr-1"></i>
                            <span class="font-semibold text-accent-blue">+{{ $achievement['reward_diamonds'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Achievement Tips -->
<div class="mt-8 bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl p-6 border border-primary-200">
    <h3 class="text-lg font-semibold text-neutral-800 mb-3 flex items-center">
        <i class="fas fa-lightbulb text-secondary-500 mr-2"></i>
        Tips for Unlocking More Achievements
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-neutral-600">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <span>Complete daily quests consistently to unlock quest-related achievements</span>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <span>Maintain your streak by using the app every day</span>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <span>Complete all daily quests in one day to unlock "Perfect Day"</span>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <span>Earn more coins and diamonds to unlock currency achievements</span>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Add hover effects and animations for achievements
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Achievements page loaded');
        
        // Add animation to achievement cards
        const achievementCards = document.querySelectorAll('.grid > div > div');
        achievementCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-slide-in');
        });

        // Add celebration effect for unlocked achievements on hover
        const unlockedAchievements = document.querySelectorAll('.border-green-500');
        unlockedAchievements.forEach(achievement => {
            achievement.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 8px 25px rgba(34, 197, 94, 0.15)';
            });
            
            achievement.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>

<style>
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

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Achievement glow effect for unlocked items */
    .border-green-500 {
        position: relative;
        transition: all 0.3s ease;
    }

    .border-green-500:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(34, 197, 94, 0.15);
    }
</style>
@endsection