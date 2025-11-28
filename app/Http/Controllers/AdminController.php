<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Community;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'total_posts' => Post::count(),
                'total_communities' => Community::count(),
                'pending_reports' => Report::where('status', 'pending')->count(),
                'new_users_today' => User::whereDate('created_at', today())->count(),
                'new_posts_today' => Post::whereDate('created_at', today())->count(),
                'active_today' => User::whereDate('last_login_at', today())->count(),
            ];

            $recent_users = User::withCount(['posts', 'comments'])
                               ->latest()
                               ->take(5)
                               ->get();

            $recent_posts = Post::with(['user', 'community'])
                               ->withCount(['comments', 'votes as upvotes_count' => function($query) {
                                   $query->where('type', 'upvote');
                               }])
                               ->latest()
                               ->take(5)
                               ->get();

            // Fix untuk reports - gunakan eager loading yang aman
            $recent_reports = Report::with(['reporter', 'resolver'])
                                  ->with(['reportable' => function($query) {
                                      // Load morphable relations safely
                                      $query->morphWith([
                                          Post::class => ['user'],
                                          User::class => [],
                                          Community::class => ['creator'],
                                      ]);
                                  }])
                                  ->where('status', 'pending')
                                  ->latest()
                                  ->take(5)
                                  ->get();

            // Chart data untuk 7 hari terakhir
            $userRegistrations = $this->getUserRegistrationsLast7Days();
            $postCreations = $this->getPostCreationsLast7Days();

            return view('admin.dashboard', compact(
                'stats', 
                'recent_users', 
                'recent_posts', 
                'recent_reports',
                'userRegistrations',
                'postCreations'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            $stats = [
                'total_users' => 0,
                'total_posts' => 0,
                'total_communities' => 0,
                'pending_reports' => 0,
                'new_users_today' => 0,
                'new_posts_today' => 0,
                'active_today' => 0,
            ];

            $recent_users = collect();
            $recent_posts = collect();
            $recent_reports = collect();
            $userRegistrations = [];
            $postCreations = [];

            return view('admin.dashboard', compact(
                'stats', 
                'recent_users', 
                'recent_posts', 
                'recent_reports',
                'userRegistrations',
                'postCreations'
            ));
        }
    }

    /**
     * Get user registration data for the last 7 days
     */
    private function getUserRegistrationsLast7Days()
    {
        return User::where('created_at', '>=', now()->subDays(7))
                  ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                  ->groupBy('date')
                  ->orderBy('date')
                  ->pluck('count', 'date')
                  ->toArray();
    }

    /**
     * Get post creation data for the last 7 days
     */
    private function getPostCreationsLast7Days()
    {
        return Post::where('created_at', '>=', now()->subDays(7))
                  ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                  ->groupBy('date')
                  ->orderBy('date')
                  ->pluck('count', 'date')
                  ->toArray();
    }

    /**
     * Get system overview with more detailed statistics
     */
    public function systemOverview()
    {
        $overview = [
            'users' => [
                'total' => User::count(),
                'active_today' => User::whereDate('last_login_at', today())->count(),
                'new_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
                'verified' => User::where('is_verified', true)->count(),
            ],
            'content' => [
                'total_posts' => Post::count(),
                'total_comments' => DB::table('comments')->count(),
                'posts_today' => Post::whereDate('created_at', today())->count(),
                'anonymous_posts' => Post::where('is_anonymous', true)->count(),
            ],
            'communities' => [
                'total' => Community::count(),
                'main_communities' => Community::where('is_main', true)->count(),
                'sub_communities' => Community::where('is_main', false)->count(),
                'active_today' => Community::whereHas('posts', function($query) {
                    $query->whereDate('created_at', today());
                })->count(),
            ],
            'moderation' => [
                'pending_reports' => Report::where('status', 'pending')->count(),
                'resolved_reports' => Report::where('status', 'resolved')->count(),
                'critical_reports' => Report::where('severity', 'critical')->where('status', 'pending')->count(),
                'reports_today' => Report::whereDate('created_at', today())->count(),
            ]
        ];

        return response()->json($overview);
    }

    /**
     * Get activity metrics for charts
     */
    public function activityMetrics()
    {
        $metrics = [
            'daily_users' => $this->getDailyActiveUsers(7),
            'post_activity' => $this->getDailyPostActivity(7),
            'report_trends' => $this->getReportTrends(7),
        ];

        return response()->json($metrics);
    }

    private function getDailyActiveUsers($days = 7)
    {
        return User::where('last_login_at', '>=', now()->subDays($days))
                  ->selectRaw('DATE(last_login_at) as date, COUNT(DISTINCT id) as count')
                  ->groupBy('date')
                  ->orderBy('date')
                  ->pluck('count', 'date')
                  ->toArray();
    }

    private function getDailyPostActivity($days = 7)
    {
        return Post::where('created_at', '>=', now()->subDays($days))
                  ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                  ->groupBy('date')
                  ->orderBy('date')
                  ->pluck('count', 'date')
                  ->toArray();
    }

    private function getReportTrends($days = 7)
    {
        return Report::where('created_at', '>=', now()->subDays($days))
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('count', 'date')
                    ->toArray();
    }
}