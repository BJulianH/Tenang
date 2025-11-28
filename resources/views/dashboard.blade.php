@extends('layouts.app')

@section('title', 'Dashboard - MindWell')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-neutral-800">Welcome back, {{ auth()->user()->name ?? 'Explorer' }}! 👋</h1>
        <p class="text-neutral-600">How are you feeling today?</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Current Streak -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Current Streak</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $stats['streak'] }} days</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center animate-pulse">
                    <i class="fas fa-fire text-accent-red text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-primary-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Keep going!</span>
                </div>
            </div>
        </div>

        <!-- Level Progress -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Your Level</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">Level {{ $stats['level'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                    <i class="fas fa-trophy text-primary-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-neutral-200 rounded-full h-2">
                    <div class="bg-primary-500 h-2 rounded-full" style="width: {{ ($stats['level'] % 10) * 10 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Quest Completion -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Today's Progress</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">{{ $stats['quest_completion_rate'] }}%</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-accent-purple/20 flex items-center justify-center">
                    <i class="fas fa-flag-checkered text-accent-purple text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-neutral-500">
                    <span>{{ $todayQuests->whereIn('status', ['completed', 'claimed'])->count() }}/{{ $todayQuests->count() }} quests</span>
                </div>
            </div>
        </div>

        <!-- Today's Mood -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 text-sm">Today's Mood</p>
                    <h3 class="text-2xl font-bold text-neutral-800 mt-1">
                        @if($todayMood)
                            {{ ucfirst($this->getMoodLabel($todayMood->rate)) }}
                        @else
                            Not set
                        @endif
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center animate-bounce-gentle">
                    <i class="fas fa-smile text-primary-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-neutral-500">
                    <span>
                        {{-- @if($todayMood)
                            Rate: {{ $todayMood->rate }}/10
                        @else
                            <a href="{{ route('mood.create') }}" class="text-primary-600 hover:text-primary-700">Log your mood</a>
                        @endif --}}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Currency & Rewards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Coins -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-secondary-100 flex items-center justify-center mr-3">
                        <i class="fas fa-coins text-secondary-500"></i>
                    </div>
                    <div>
                        <p class="text-neutral-500 text-sm">Coins</p>
                        <h3 class="text-xl font-bold text-neutral-800">{{ $stats['coins'] }}</h3>
                    </div>
                </div>
                <span class="text-sm text-secondary-600 font-medium">+5 today</span>
            </div>
        </div>

        <!-- Diamonds -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-accent-blue/20 flex items-center justify-center mr-3">
                        <i class="fas fa-gem text-accent-blue"></i>
                    </div>
                    <div>
                        <p class="text-neutral-500 text-sm">Diamonds</p>
                        <h3 class="text-xl font-bold text-neutral-800">{{ $stats['diamonds'] }}</h3>
                    </div>
                </div>
                <span class="text-sm text-accent-blue font-medium">+2 today</span>
            </div>
        </div>

        <!-- Weekly Activity -->
        <div class="bg-white rounded-xl p-6 card hover-lift border border-neutral-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                        <i class="fas fa-chart-line text-primary-600"></i>
                    </div>
                    <div>
                        <p class="text-neutral-500 text-sm">Weekly Activity</p>
                        <h3 class="text-xl font-bold text-neutral-800">{{ $stats['journal_count'] + $stats['mood_count'] + $stats['post_count'] }}</h3>
                    </div>
                </div>
                <span class="text-sm text-primary-600 font-medium">Active</span>
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
                    {{-- <a href="{{ route('quests.index') }}" class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View All</a> --}}
                </div>
                <div class="space-y-4">
                    @forelse($todayQuests as $quest)
                        <div class="flex items-center p-4 border border-neutral-200 rounded-lg hover:bg-primary-50 transition-colors cursor-pointer quest-item"
                             data-quest-id="{{ $quest->id }}">
                            <div class="w-10 h-10 rounded-full 
                                @if($quest->status === 'completed' || $quest->status === 'claimed') 
                                    bg-primary-100 text-primary-600
                                @elseif($quest->status === 'in_progress')
                                    bg-secondary-100 text-secondary-600
                                @else
                                    bg-neutral-100 text-neutral-400
                                @endif
                                flex items-center justify-center mr-4">
                                <i class="fas 
                                    @if($quest->status === 'completed' || $quest->status === 'claimed') 
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
                                @if($quest->required_progress > 1)
                                    <div class="mt-2">
                                        <div class="flex items-center justify-between text-xs text-neutral-500 mb-1">
                                            <span>Progress</span>
                                            <span>{{ $quest->progress }}/{{ $quest->required_progress }}</span>
                                        </div>
                                        <div class="w-full bg-neutral-200 rounded-full h-2">
                                            <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" 
                                                 style="width: {{ $quest->completion_percentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="text-secondary-500 font-medium">+{{ $quest->dailyQuest->coins }}</span>
                                    <i class="fas fa-coins text-secondary-500 text-sm"></i>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-accent-blue font-medium">+{{ $quest->dailyQuest->diamonds }}</span>
                                    <i class="fas fa-gem text-accent-blue text-sm"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-neutral-500">
                            <i class="fas fa-quest text-4xl mb-3"></i>
                            <p>No quests for today. Check back tomorrow!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Mood Chart -->
            <div class="bg-white rounded-xl p-6 card border border-neutral-200">
                {{-- <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-neutral-800">Mood Trends 📊</h2>
                    <a href="{{ route('mood.history') }}" class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">View Details</a>
                </div> --}}
                {{-- <div class="h-64 flex items-end justify-between space-x-2">
                    @php
                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        $maxMood = 10;
                    @endphp
                    @foreach($days as $index => $day)
                        @php
                            $dayMood = $moodData->where('date', now()->startOfWeek()->addDays($index))->first();
                            $height = $dayMood ? ($dayMood->rate / $maxMood) * 100 : 20;
                            $colorClass = $this->getMoodColor($dayMood ? $dayMood->rate : 5);
                        @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full {{ $colorClass }} rounded-t-lg transition-all duration-500 ease-in-out" 
                                 style="height: {{ $height }}%"
                                 title="{{ $dayMood ? 'Rate: ' . $dayMood->rate : 'No data' }}">
                            </div>
                            <span class="text-xs text-neutral-500 mt-2">{{ $day }}</span>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 card border border-neutral-200">
                <h2 class="text-lg font-bold text-neutral-800 mb-4">Quick Actions ⚡</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('journal.index') }}" 
                       class="flex flex-col items-center justify-center p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors border border-primary-200 app-button">
                        <i class="fas fa-book text-primary-600 text-xl mb-2"></i>
                        <span class="text-sm font-medium text-primary-700">Write Journal</span>
                    </a>
                    {{-- <a href="{{ route('mood.create') }}" 
                       class="flex flex-col items-center justify-center p-4 bg-secondary-50 rounded-lg hover:bg-secondary-100 transition-colors border border-secondary-200 app-button">
                        <i class="fas fa-smile text-secondary-600 text-xl mb-2"></i>
                        <span class="text-sm font-medium text-secondary-700">Log Mood</span>
                    </a> --}}
                    <a href="{{ route('community.create') }}" 
                       class="flex flex-col items-center justify-center p-4 bg-accent-purple/20 rounded-lg hover:bg-accent-purple/30 transition-colors border border-accent-purple/30 app-button">
                        <i class="fas fa-users text-accent-purple text-xl mb-2"></i>
                        <span class="text-sm font-medium text-accent-purple">Community</span>
                    </a>
                    <a href="{{ route('noises.index') }}" 
                       class="flex flex-col items-center justify-center p-4 bg-accent-blue/20 rounded-lg hover:bg-accent-blue/30 transition-colors border border-accent-blue/30 app-button">
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
                                        {{ ucfirst($journal->mood) }}
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
@endsection

@section('scripts')
<script>
    // Quest interactions
    document.querySelectorAll('.quest-item').forEach(item => {
        item.addEventListener('click', function() {
            const questId = this.dataset.questId;
            // Mark quest as completed or show details
            fetch(`/quests/${questId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.add('completed');
                    // Update UI
                    location.reload(); // Simple reload for demo
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Animate stats cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards for animation
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
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
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .quest-item.completed {
        background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e8 100%);
        border-color: #58cc70;
    }

    /* Mood color classes */
    .bg-mood-excellent { background: linear-gradient(to top, #58cc70, #45b259); }
    .bg-mood-good { background: linear-gradient(to top, #87ceeb, #6baed6); }
    .bg-mood-okay { background: linear-gradient(to top, #ffc800, #e6b400); }
    .bg-mood-poor { background: linear-gradient(to top, #ff9f43, #ff8c00); }
    .bg-mood-bad { background: linear-gradient(to top, #ff6b6b, #e74c3c); }
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