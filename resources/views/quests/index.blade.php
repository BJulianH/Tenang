@extends('layouts.app')

@section('title', 'Quests - Tenang')

@section('content')
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
        <div id="rewardsPreview" class="bg-primary-50 rounded-lg p-4 mb-6">
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
            <button onclick="closeQuestConfirmation()" 
                    class="flex-1 px-4 py-3 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition-colors font-medium">
                Cancel
            </button>
            <button onclick="confirmQuestCompletion()" 
                    class="flex-1 px-4 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium app-button">
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

        <button onclick="closeQuestSuccess()" 
                class="w-full px-4 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium app-button">
            <i class="fas fa-check mr-2"></i>
            Awesome!
        </button>
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

<div class="mb-8">
    <h1 class="text-3xl font-bold text-neutral-800">Daily Quests 🎯</h1>
    <p class="text-neutral-600">Complete quests to earn rewards and level up!</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Today's Progress -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Today's Progress</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">
                    {{ $todayQuests->whereIn('status', ['completed', 'claimed'])->count() }}/{{ $todayQuests->count() }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                <i class="fas fa-flag-checkered text-primary-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-full bg-neutral-200 rounded-full h-2">
                <div class="bg-primary-500 h-2 rounded-full" 
                     style="width: {{ $todayQuests->count() > 0 ? ($todayQuests->whereIn('status', ['completed', 'claimed'])->count() / $todayQuests->count()) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Weekly Stats -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Weekly Quests</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $weeklyStats['completed_quests'] }}/{{ $weeklyStats['total_quests'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center">
                <i class="fas fa-calendar-week text-secondary-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-2 text-sm text-neutral-500">
            {{ $weeklyStats['total_coins'] }} coins earned
        </div>
    </div>

    <!-- Monthly Stats -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Monthly Rate</p>
                <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $monthlyStats['completion_rate'] }}%</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-accent-purple/20 flex items-center justify-center">
                <i class="fas fa-chart-line text-accent-purple text-xl"></i>
            </div>
        </div>
        <div class="mt-2 text-sm text-neutral-500">
            {{ $monthlyStats['completed_quests'] }} quests completed
        </div>
    </div>

    <!-- Rewards Earned -->
    <div class="bg-white rounded-xl p-6 card border border-neutral-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-neutral-500 text-sm">Today's Rewards</p>
                <div class="flex items-center space-x-4 mt-1">
                    <div class="flex items-center">
                        <i class="fas fa-coins text-secondary-500 mr-1"></i>
                        <span class="font-bold text-neutral-800">+{{ $todayQuests->whereIn('status', ['completed', 'claimed'])->sum('dailyQuest.coins') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-gem text-accent-blue mr-1"></i>
                        <span class="font-bold text-neutral-800">+{{ $todayQuests->whereIn('status', ['completed', 'claimed'])->sum('dailyQuest.diamonds') }}</span>
                    </div>
                </div>
            </div>
            <div class="w-12 h-12 rounded-full bg-accent-blue/20 flex items-center justify-center">
                <i class="fas fa-gift text-accent-blue text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quest Actions -->
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-neutral-800">Today's Quests</h2>
    <div class="flex space-x-3">
        <button onclick="showAvailableQuests()" 
                class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button">
            <i class="fas fa-plus mr-2"></i>Choose Quests
        </button>
        <button onclick="assignRandomQuests()" 
                class="px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors app-button">
            <i class="fas fa-random mr-2"></i>Random Quests
        </button>
    </div>
</div>

<!-- Quest List -->
<div class="bg-white rounded-xl p-6 card border border-neutral-200">
    @if($todayQuests->count() > 0)
        <div class="space-y-4">
            @foreach($todayQuests as $quest)
            <div class="flex items-center p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors cursor-pointer quest-item" 
                 data-quest-id="{{ $quest->id }}" 
                 onclick="handleQuestClick({{ $quest->id }}, '{{ $quest->status }}')">
                
                <!-- Quest Status Icon -->
                <div class="w-12 h-12 rounded-full 
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
                    text-lg"></i>
                </div>

                <!-- Quest Details -->
                <div class="flex-1">
                    <h3 class="font-semibold text-neutral-800 text-lg">{{ $quest->dailyQuest->title }}</h3>
                    <p class="text-neutral-600 mt-1">{{ $quest->dailyQuest->description }}</p>
                    
                    <!-- Quest Meta -->
                    <div class="flex items-center mt-3 space-x-4">
                        <span class="inline-flex items-center px-3 py-1 bg-neutral-100 rounded-full text-sm text-neutral-700">
                            <i class="fas fa-tag mr-2"></i>
                            {{ ucfirst($quest->dailyQuest->category) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 bg-neutral-100 rounded-full text-sm text-neutral-700">
                            <i class="fas fa-{{ $quest->dailyQuest->type === 'daily' ? 'calendar-day' : 'star' }} mr-2"></i>
                            {{ ucfirst($quest->dailyQuest->type) }}
                        </span>
                    </div>

                    <!-- Progress Bar (for multi-step quests) -->
                    @if($quest->required_progress > 1)
                    <div class="mt-3">
                        <div class="flex items-center justify-between text-sm text-neutral-600 mb-2">
                            <span>Progress</span>
                            <span class="font-semibold progress-text">{{ $quest->progress }}/{{ $quest->required_progress }}</span>
                        </div>
                        <div class="w-full bg-neutral-200 rounded-full h-3">
                            <div class="bg-primary-500 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ ($quest->progress / $quest->required_progress) * 100 }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Rewards and Actions -->
                <div class="text-right min-w-[120px]">
                    <!-- Rewards Display -->
                    <div class="flex items-center justify-end space-x-4 mb-3">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-8 h-8 bg-secondary-100 rounded-full mb-1">
                                <i class="fas fa-coins text-secondary-500 text-sm"></i>
                            </div>
                            <span class="text-sm font-semibold text-secondary-600">+{{ $quest->dailyQuest->coins }}</span>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-8 h-8 bg-accent-blue/20 rounded-full mb-1">
                                <i class="fas fa-gem text-accent-blue text-sm"></i>
                            </div>
                            <span class="text-sm font-semibold text-accent-blue">+{{ $quest->dailyQuest->diamonds }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($quest->status === 'completed')
                    <button onclick="event.stopPropagation(); claimRewards({{ $quest->id }})" 
                            class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors app-button text-sm">
                        Claim Rewards
                    </button>
                    @elseif($quest->status === 'claimed')
                    <span class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-semibold">
                        <i class="fas fa-check mr-2"></i>Claimed
                    </span>
                    @elseif($quest->required_progress > 1 && $quest->status !== 'completed')
                    <button onclick="event.stopPropagation(); addQuestProgress({{ $quest->id }})" 
                            class="w-full px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button text-sm">
                        Add Progress
                    </button>
                    @elseif($quest->status === 'assigned' || $quest->status === 'in_progress')
                    <button onclick="event.stopPropagation(); handleQuestClick({{ $quest->id }}, '{{ $quest->status }}')" 
                            class="w-full px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button text-sm">
                        Complete Quest
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-neutral-100 flex items-center justify-center">
                <i class="fas fa-quest text-neutral-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-neutral-600 mb-2">No Quests Today</h3>
            <p class="text-neutral-500 mb-6">Get started by choosing some quests for today!</p>
            <div class="flex justify-center space-x-3">
                <button onclick="showAvailableQuests()" 
                        class="px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors app-button">
                    <i class="fas fa-plus mr-2"></i>Choose Quests
                </button>
                <button onclick="assignRandomQuests()" 
                        class="px-6 py-3 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors app-button">
                    <i class="fas fa-random mr-2"></i>Random Quests
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Quest History Section -->
<div class="mt-8">
    <h2 class="text-xl font-bold text-neutral-800 mb-4">Quest History</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Weekly Progress -->
        <div class="bg-white rounded-xl p-6 card border border-neutral-200">
            <h3 class="text-lg font-semibold text-neutral-800 mb-4 flex items-center">
                <i class="fas fa-calendar-week text-secondary-500 mr-2"></i>
                This Week
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-neutral-600">Quests Completed</span>
                    <span class="font-semibold text-neutral-800">{{ $weeklyStats['completed_quests'] }}/{{ $weeklyStats['total_quests'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-neutral-600">Coins Earned</span>
                    <span class="font-semibold text-secondary-600">{{ $weeklyStats['total_coins'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-neutral-600">Diamonds Earned</span>
                    <span class="font-semibold text-accent-blue">{{ $weeklyStats['total_diamonds'] }}</span>
                </div>
            </div>
        </div>

        <!-- Monthly Progress -->
        <div class="bg-white rounded-xl p-6 card border border-neutral-200">
            <h3 class="text-lg font-semibold text-neutral-800 mb-4 flex items-center">
                <i class="fas fa-calendar-alt text-accent-purple mr-2"></i>
                This Month
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-neutral-600">Completion Rate</span>
                    <span class="font-semibold text-neutral-800">{{ $monthlyStats['completion_rate'] }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-neutral-600">Total Quests</span>
                    <span class="font-semibold text-neutral-800">{{ $monthlyStats['total_quests'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-neutral-600">Completed</span>
                    <span class="font-semibold text-green-600">{{ $monthlyStats['completed_quests'] }}</span>
                </div>
            </div>
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
        const questTitle = questElement.querySelector('h3')?.textContent || 'Unknown Quest';
        const coinsElement = questElement.querySelector('.text-secondary-600');
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
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
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
        
        const progressText = questElement.querySelector('.progress-text')?.textContent;
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
            progressTitle.textContent = questElement.querySelector('h3')?.textContent || 'Unknown Quest';
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
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
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

    // Toggle quest selection
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

    function updateSelectedCount() {
        const selectedCount = document.getElementById('selected-count');
        if (selectedCount) selectedCount.textContent = selectedQuestIds.length;
    }

    // Confirm quest selection
    function confirmQuestSelection() {
        console.log('Confirming selection with quests:', selectedQuestIds);

        if (selectedQuestIds.length === 0) {
            showNotification('Please select at least one quest', 'warning');
            return;
        }

        showNotification('Assigning quests...', 'info');

        fetch('/quests/choose', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
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

    // Assign random quests
    function assignRandomQuests() {
        showNotification('Assigning random quests...', 'info');
        
        fetch('/quests/assign-random', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
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

    // Claim rewards
    function claimRewards(questId) {
        console.log('Claiming rewards for quest:', questId);
        
        if (!questId) {
            showNotification('Error: Invalid quest ID', 'error');
            return;
        }

        showNotification('Claiming rewards...', 'info');
        
        fetch(`/quests/${questId}/claim`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
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

    // Show notification
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(notification => {
            notification.remove();
        });

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            type === 'warning' ? 'bg-yellow-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${
                    type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-circle' :
                    type === 'warning' ? 'fa-exclamation-triangle' :
                    'fa-info-circle'
                } mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 4 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    // Add animation to quest items
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Quests page JavaScript loaded');
        
        const questItems = document.querySelectorAll('.quest-item');
        console.log('Found quest items:', questItems.length);
        
        questItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('animate-slide-in');
        });
    });

    // Global error handler for debugging
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);
        console.error('File:', e.filename);
        console.error('Line:', e.lineno);
        console.error('Column:', e.colno);
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

    /* Celebration particles */
    .celebration-particle {
        animation: celebrateParticle 1s ease-out forwards;
        pointer-events: none;
    }

    @keyframes celebrateParticle {
        0% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        50% {
            opacity: 0.8;
            transform: translateY(-20px) scale(1.2);
        }
        100% {
            opacity: 0;
            transform: translateY(-40px) scale(0.5);
        }
    }
</style>
@endsection