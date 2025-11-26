<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Community;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_communities' => Community::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_posts_today' => Post::whereDate('created_at', today())->count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_posts = Post::with('user')->latest()->take(5)->get();
        $recent_reports = Report::with(['reportable', 'reporter'])
                               ->where('status', 'pending')
                               ->latest()
                               ->take(5)
                               ->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_posts', 'recent_reports'));
    }
}