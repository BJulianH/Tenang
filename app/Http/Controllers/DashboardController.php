<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\MoodRate;
use App\Models\UserQuest;
use App\Models\Post;
use App\Models\Noise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get today's quests
        $todayQuests = UserQuest::with('dailyQuest')
            ->where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->get();

        // If no quests for today, assign random ones
        if ($todayQuests->isEmpty()) {
            $todayQuests = $this->assignRandomQuests($user);
        }

        // Get recent journals
        $recentJournals = Journal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get mood data for chart (last 7 days)
        $moodData = MoodRate::where('user_id', $user->id)
            ->whereDate('date', '>=', now()->subDays(7))
            ->orderBy('date', 'asc')
            ->get();

        // Get recent community posts
        $recentPosts = Post::with('user')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get today's mood
        $todayMood = MoodRate::where('user_id', $user->id)
            ->whereDate('date', today())
            ->first();

        // Get meditation/audio usage
        $audioUsage = Noise::where('is_active', true)
            ->orderBy('play_count', 'desc')
            ->limit(5)
            ->get();

        // Calculate stats
        $stats = $this->calculateStats($user);

        return view('dashboard', compact(
            'todayQuests',
            'recentJournals',
            'moodData',
            'recentPosts',
            'todayMood',
            'audioUsage',
            'stats'
        ));
    }

    private function assignRandomQuests($user)
    {
        // Get 3 random active quests
        $randomQuests = \App\Models\DailyQuest::active()
            ->inRandomOrder()
            ->limit(3)
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

    private function calculateStats($user)
    {
        // Journal count this week
        $journalCount = Journal::where('user_id', $user->id)
            ->whereDate('created_at', '>=', now()->startOfWeek())
            ->count();

        // Mood entries this week
        $moodCount = MoodRate::where('user_id', $user->id)
            ->whereDate('date', '>=', now()->startOfWeek())
            ->count();

        // Community posts this month
        $postCount = Post::where('user_id', $user->id)
            ->whereDate('created_at', '>=', now()->startOfMonth())
            ->count();

        // Quest completion rate
        $totalQuests = UserQuest::where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->count();
        $completedQuests = UserQuest::where('user_id', $user->id)
            ->whereDate('assigned_date', today())
            ->whereIn('status', ['completed', 'claimed'])
            ->count();

        $completionRate = $totalQuests > 0 ? round(($completedQuests / $totalQuests) * 100) : 0;

        return [
            'journal_count' => $journalCount,
            'mood_count' => $moodCount,
            'post_count' => $postCount,
            'quest_completion_rate' => $completionRate,
            'streak' => $user->streak ?? 0,
            'level' => $user->level ?? 1,
            'coins' => $user->coins ?? 0,
            'diamonds' => $user->diamonds ?? 0,
        ];
    }
}