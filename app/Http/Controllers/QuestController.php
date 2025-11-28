<?php

namespace App\Http\Controllers;

use App\Models\DailyQuest;
use App\Models\UserQuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // Complete a quest manually
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
            
            // Reward user
            $user = $userQuest->user;
            $quest = $userQuest->dailyQuest;

            $user->increment('coins', $quest->coins);
            $user->increment('diamonds', $quest->diamonds);
            $user->increment('points', $quest->points);
        });

        return response()->json([
            'message' => 'Quest completed successfully',
            'quest' => $userQuest->fresh()->load('dailyQuest'),
            'rewards' => [
                'coins' => $userQuest->dailyQuest->coins,
                'diamonds' => $userQuest->dailyQuest->diamonds,
                'points' => $userQuest->dailyQuest->points,
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
                'points' => $todayQuests->whereIn('status', ['completed', 'claimed'])->sum(function ($quest) {
                    return $quest->dailyQuest->points;
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
}