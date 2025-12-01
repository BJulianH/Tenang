<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserQuest;
use App\Models\DailyQuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    // Get today's quests for user
    public function index()
    {
        $user = Auth::user();
        
        // Check if user has quests for today, if not assign random ones
        $todayQuests = UserQuest::with('dailyQuest')
            ->where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->get();

        if ($todayQuests->isEmpty()) {
            $todayQuests = $this->assignRandomQuests($user);
        }

        $stats = $this->getQuestStats($user);

        return response()->json([
            'quests' => $todayQuests,
            'stats' => $stats
        ]);
    }

    // Get available quests for user to choose
    public function availableQuests()
    {
        $user = Auth::user();
        
        // Get quest IDs that user already has for today
        $existingQuestIds = UserQuest::where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->pluck('daily_quest_id');

        $availableQuests = DailyQuest::active()
            ->whereNotIn('id', $existingQuestIds)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return response()->json([
            'available_quests' => $availableQuests
        ]);
    }

    // Assign random quests to user
    public function assignRandomQuests($user = null, $count = 5)
    {
        if (!$user) {
            $user = Auth::user();
        }

        // Check if user already has quests for today
        $existingQuests = UserQuest::where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->count();

        if ($existingQuests > 0) {
            return UserQuest::where('user_id', $user->id)
                ->whereDate('assigned_date', today())
                ->with('dailyQuest')
                ->get();
        }

        // Get random active quests
        $randomQuests = DailyQuest::active()
            ->inRandomOrder()
            ->limit($count)
            ->get();

        $assignedQuests = [];

        foreach ($randomQuests as $quest) {
            $userQuest = UserQuest::create([
                'user_id' => $user->id,
                'daily_quest_id' => $quest->id,
                'assigned_date' => today(),
                'required_progress' => $quest->required_progress ?? 1,
                'status' => 'assigned'
            ]);

            $assignedQuests[] = $userQuest->load('dailyQuest');
        }

        return collect($assignedQuests);
    }

    // Let user choose specific quests
    public function chooseQuests(Request $request)
    {
        $request->validate([
            'quest_ids' => 'required|array|min:1|max:5',
            'quest_ids.*' => 'exists:daily_quests,id'
        ]);

        $user = Auth::user();

        // Check if user already has quests for today
        $existingQuests = UserQuest::where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->count();

        if ($existingQuests > 0) {
            return response()->json([
                'error' => 'You already have quests for today'
            ], 400);
        }

        $selectedQuests = DailyQuest::active()
            ->whereIn('id', $request->quest_ids)
            ->get();

        $assignedQuests = [];

        foreach ($selectedQuests as $quest) {
            $userQuest = UserQuest::create([
                'user_id' => $user->id,
                'daily_quest_id' => $quest->id,
                'assigned_date' => today(),
                'required_progress' => $quest->required_progress ?? 1,
                'status' => 'assigned'
            ]);

            $assignedQuests[] = $userQuest->load('dailyQuest');
        }

        return response()->json([
            'message' => 'Quests chosen successfully',
            'quests' => $assignedQuests
        ]);
    }

    public function completeQuest(UserQuest $userQuest)
    {
        // Check if user owns this quest
        if ($userQuest->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($userQuest->status === 'claimed') {
            return response()->json(['error' => 'Rewards already claimed'], 400);
        }

        DB::transaction(function () use ($userQuest) {
            $userQuest->markCompleted();
            
            // Reward user - HANYA coins dan diamonds
            $user = $userQuest->user;
            $quest = $userQuest->dailyQuest;

            $user->increment('coins', $quest->coins);
            $user->increment('diamonds', $quest->diamonds);
            
            // Update achievement progress setelah menyelesaikan quest
            $this->updateAchievementProgress($user, 'quests_completed', 1);
            $this->updateAchievementProgress($user, 'coins_earned', $quest->coins);
            $this->updateAchievementProgress($user, 'diamonds_earned', $quest->diamonds);
        });

        return response()->json([
            'message' => 'Quest completed successfully',
            'quest' => $userQuest->fresh()->load('dailyQuest'),
            'rewards' => [
                'coins' => $userQuest->dailyQuest->coins,
                'diamonds' => $userQuest->dailyQuest->diamonds,
            ]
        ]);
    }

    // Claim quest rewards (mark as claimed)
    public function claimRewards(UserQuest $userQuest)
    {
        // Check if user owns this quest
        if ($userQuest->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($userQuest->status !== 'completed') {
            return response()->json(['error' => 'Quest must be completed before claiming rewards'], 400);
        }

        $userQuest->markClaimed();

        return response()->json([
            'message' => 'Rewards claimed successfully',
            'quest' => $userQuest->fresh()
        ]);
    }

    // Update quest progress (for multi-step quests)
    public function updateProgress(UserQuest $userQuest, Request $request)
    {
        $request->validate([
            'progress' => 'required|integer|min:0'
        ]);

        // Check if user owns this quest
        if ($userQuest->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userQuest->updateProgress($request->progress);

        return response()->json([
            'message' => 'Progress updated successfully',
            'quest' => $userQuest->fresh()->load('dailyQuest')
        ]);
    }

    // Add progress to quest (increment)
    public function addProgress(UserQuest $userQuest, Request $request)
    {
        $request->validate([
            'amount' => 'integer|min:1|max:10'
        ]);

        // Check if user owns this quest
        if ($userQuest->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $amount = $request->amount ?? 1;
        $userQuest->addProgress($amount);

        $message = "Progress updated to {$userQuest->progress}/{$userQuest->required_progress}";

        if ($userQuest->isCompleted()) {
            $message .= " - Quest completed!";
        }

        return response()->json([
            'message' => $message,
            'quest' => $userQuest->fresh()->load('dailyQuest')
        ]);
    }

    // Get quest statistics
    public function getQuestStats($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        $todayQuests = UserQuest::with('dailyQuest')
            ->where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->get();

        return [
            'total' => $todayQuests->count(),
            'completed' => $todayQuests->where('status', 'completed')->count(),
            'claimed' => $todayQuests->where('status', 'claimed')->count(),
            'in_progress' => $todayQuests->whereIn('status', ['assigned', 'in_progress'])->count(),
            'completion_rate' => $todayQuests->count() > 0 ? 
                round(($todayQuests->whereIn('status', ['completed', 'claimed'])->count() / $todayQuests->count()) * 100) : 0,
            'total_rewards' => [
                'coins' => $todayQuests->whereIn('status', ['completed', 'claimed'])->sum(function ($quest) {
                    return $quest->dailyQuest->coins;
                }),
                'diamonds' => $todayQuests->whereIn('status', ['completed', 'claimed'])->sum(function ($quest) {
                    return $quest->dailyQuest->diamonds;
                }),
            ]
        ];
    }

    // Get quest statistics endpoint
    public function stats()
    {
        $user = Auth::user();
        $stats = $this->getQuestStats($user);

        return response()->json($stats);
    }

    // Reset today's quests (for testing)
    public function resetQuests()
    {
        $user = Auth::user();

        // Delete today's quests
        UserQuest::where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->delete();

        // Assign new random quests
        $newQuests = $this->assignRandomQuests($user);

        return response()->json([
            'message' => 'Quests reset successfully',
            'quests' => $newQuests
        ]);
    }

    public function indexView()
    {
        $todayQuests = UserQuest::with('dailyQuest')
            ->where('user_id', auth()->id())
            ->whereDate('assigned_date', today())
            ->orderBy('status')
            ->orderBy('created_at')
            ->get();

        $weeklyStats = $this->getWeeklyQuestStats();
        $monthlyStats = $this->getMonthlyQuestStats();
        $achievementStats = $this->getAchievementStats();

        return view('quests.index', compact(
            'todayQuests', 
            'weeklyStats', 
            'monthlyStats',
            'achievementStats'
        ));
    }

    // Halaman achievements tanpa model Achievement
    public function achievements()
    {
        $achievementStats = $this->getAchievementStats();
        $userAchievements = $this->getUserAchievements();

        return view('quests.achievements', compact(
            'achievementStats',
            'userAchievements'
        ));
    }

    // Stats mingguan untuk quest
    private function getWeeklyQuestStats()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return [
            'total_quests' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count(),
            'completed_quests' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->whereIn('status', ['completed', 'claimed'])
                ->count(),
            'total_coins' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->whereIn('status', ['completed', 'claimed'])
                ->with('dailyQuest')
                ->get()
                ->sum(function($userQuest) {
                    return $userQuest->dailyQuest->coins;
                }),
            'total_diamonds' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->whereIn('status', ['completed', 'claimed'])
                ->with('dailyQuest')
                ->get()
                ->sum(function($userQuest) {
                    return $userQuest->dailyQuest->diamonds;
                }),
        ];
    }

    // Stats bulanan untuk quest
    private function getMonthlyQuestStats()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            'total_quests' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count(),
            'completed_quests' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->whereIn('status', ['completed', 'claimed'])
                ->count(),
            'completion_rate' => UserQuest::where('user_id', auth()->id())
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count() > 0 ? 
                round((UserQuest::where('user_id', auth()->id())
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->whereIn('status', ['completed', 'claimed'])
                    ->count() / UserQuest::where('user_id', auth()->id())
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count()) * 100) : 0,
        ];
    }

    // Stats achievements tanpa model Achievement
    private function getAchievementStats()
    {
        $user = auth()->user();
        
        // Ambil data dari user atau cache
        $questsCompleted = $user->quests_completed ?? 0;
        $coinsEarned = $user->coins_earned ?? 0;
        $diamondsEarned = $user->diamonds_earned ?? 0;
        $loginStreak = $user->login_streak ?? 0;

        // Hitung achievement yang sudah unlocked
        $unlockedAchievements = $this->calculateUnlockedAchievements($user);

        return [
            'quests_completed' => $questsCompleted,
            'coins_earned' => $coinsEarned,
            'diamonds_earned' => $diamondsEarned,
            'login_streak' => $loginStreak,
            'unlocked_achievements' => $unlockedAchievements,
            'total_achievements' => 12, // Total predefined achievements
            'completion_percentage' => 12 > 0 ? round(($unlockedAchievements / 12) * 100) : 0,
        ];
    }

    // Get user achievements progress
    private function getUserAchievements()
    {
        $user = auth()->user();
        
        // Define achievements tanpa model
        $achievements = [
            // Quest achievements
            [
                'id' => 1,
                'title' => 'First Quest',
                'description' => 'Complete your first quest',
                'type' => 'quests_completed',
                'requirement' => 1,
                'reward_coins' => 100,
                'reward_diamonds' => 10,
                'icon' => '🎯'
            ],
            [
                'id' => 2,
                'title' => 'Quest Beginner',
                'description' => 'Complete 10 quests',
                'type' => 'quests_completed',
                'requirement' => 10,
                'reward_coins' => 500,
                'reward_diamonds' => 25,
                'icon' => '⚔️'
            ],
            [
                'id' => 3,
                'title' => 'Quest Master',
                'description' => 'Complete 50 quests',
                'type' => 'quests_completed',
                'requirement' => 50,
                'reward_coins' => 2000,
                'reward_diamonds' => 100,
                'icon' => '🏆'
            ],
            // Coin achievements
            [
                'id' => 4,
                'title' => 'Coin Collector',
                'description' => 'Earn 1000 coins',
                'type' => 'coins_earned',
                'requirement' => 1000,
                'reward_coins' => 200,
                'reward_diamonds' => 20,
                'icon' => '🪙'
            ],
            [
                'id' => 5,
                'title' => 'Rich Explorer',
                'description' => 'Earn 5000 coins',
                'type' => 'coins_earned',
                'requirement' => 5000,
                'reward_coins' => 1000,
                'reward_diamonds' => 50,
                'icon' => '💰'
            ],
            // Diamond achievements
            [
                'id' => 6,
                'title' => 'Diamond Hunter',
                'description' => 'Earn 100 diamonds',
                'type' => 'diamonds_earned',
                'requirement' => 100,
                'reward_coins' => 500,
                'reward_diamonds' => 25,
                'icon' => '💎'
            ],
            // Streak achievements
            [
                'id' => 7,
                'title' => 'Dedicated',
                'description' => '7-day login streak',
                'type' => 'login_streak',
                'requirement' => 7,
                'reward_coins' => 300,
                'reward_diamonds' => 30,
                'icon' => '🔥'
            ],
            [
                'id' => 8,
                'title' => 'Consistent',
                'description' => '30-day login streak',
                'type' => 'login_streak',
                'requirement' => 30,
                'reward_coins' => 1500,
                'reward_diamonds' => 75,
                'icon' => '🌟'
            ],
            // Special achievements
            [
                'id' => 9,
                'title' => 'Perfect Day',
                'description' => 'Complete all daily quests in one day',
                'type' => 'perfect_days',
                'requirement' => 1,
                'reward_coins' => 500,
                'reward_diamonds' => 50,
                'icon' => '⭐'
            ],
            [
                'id' => 10,
                'title' => 'Week Warrior',
                'description' => 'Complete 35 quests in a week',
                'type' => 'weekly_quests',
                'requirement' => 35,
                'reward_coins' => 1000,
                'reward_diamonds' => 100,
                'icon' => '⚡'
            ],
            [
                'id' => 11,
                'title' => 'Month Master',
                'description' => 'Complete 100 quests in a month',
                'type' => 'monthly_quests',
                'requirement' => 100,
                'reward_coins' => 3000,
                'reward_diamonds' => 150,
                'icon' => '👑'
            ],
            [
                'id' => 12,
                'title' => 'Quest Legend',
                'description' => 'Complete 500 quests total',
                'type' => 'quests_completed',
                'requirement' => 500,
                'reward_coins' => 5000,
                'reward_diamonds' => 250,
                'icon' => '🎖️'
            ]
        ];

        // Add progress and unlocked status to each achievement
        foreach ($achievements as &$achievement) {
            $achievement['progress'] = $this->getAchievementProgress($user, $achievement);
            $achievement['is_unlocked'] = $achievement['progress'] >= $achievement['requirement'];
            $achievement['progress_percentage'] = min(100, ($achievement['progress'] / $achievement['requirement']) * 100);
        }

        return $achievements;
    }

    // Calculate achievement progress
    private function getAchievementProgress($user, $achievement)
    {
        switch ($achievement['type']) {
            case 'quests_completed':
                return $user->quests_completed ?? 0;
            case 'coins_earned':
                return $user->coins_earned ?? 0;
            case 'diamonds_earned':
                return $user->diamonds_earned ?? 0;
            case 'login_streak':
                return $user->login_streak ?? 0;
            case 'perfect_days':
                return $user->perfect_days ?? 0;
            case 'weekly_quests':
                return $this->getWeeklyQuestCount($user);
            case 'monthly_quests':
                return $this->getMonthlyQuestCount($user);
            default:
                return 0;
        }
    }

    // Calculate unlocked achievements count
    private function calculateUnlockedAchievements($user)
    {
        $achievements = $this->getUserAchievements();
        $unlocked = 0;

        foreach ($achievements as $achievement) {
            if ($achievement['is_unlocked']) {
                $unlocked++;
            }
        }

        return $unlocked;
    }

    // Update achievement progress
    private function updateAchievementProgress($user, $type, $amount)
    {
        // Update user's achievement progress
        switch ($type) {
            case 'quests_completed':
                $user->increment('quests_completed', $amount);
                break;
            case 'coins_earned':
                $user->increment('coins_earned', $amount);
                break;
            case 'diamonds_earned':
                $user->increment('diamonds_earned', $amount);
                break;
        }

        // Check for new unlocked achievements
        $this->checkNewAchievements($user);
    }

    // Check for newly unlocked achievements
    private function checkNewAchievements($user)
    {
        $achievements = $this->getUserAchievements();
        $newlyUnlocked = [];

        foreach ($achievements as $achievement) {
            $progress = $this->getAchievementProgress($user, $achievement);
            
            if ($progress >= $achievement['requirement']) {
                // Check if this is newly unlocked (you might want to track claimed achievements)
                $newlyUnlocked[] = $achievement;
            }
        }

        return $newlyUnlocked;
    }

    // Helper methods for achievement calculations
    private function getWeeklyQuestCount($user)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return UserQuest::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['completed', 'claimed'])
            ->count();
    }

    private function getMonthlyQuestCount($user)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return UserQuest::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['completed', 'claimed'])
            ->count();
    }
}