<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)
                   ->withCount(['posts', 'comments'])
                   ->firstOrFail();

        $isOwnProfile = Auth::check() && Auth::id() === $user->id;
        
        // Posts oleh user ini
        $posts = Post::where('user_id', $user->id)
                    ->with([
                        'community',
                        'votes',
                        'comments' => function ($q) {
                            $q->with('user')
                              ->withCount(['likes as upvotes_count'])
                              ->withCount('replies')
                              ->with([
                                  'replies' => function ($r) {
                                      $r->with('user')
                                        ->withCount(['likes as upvotes_count'])
                                        ->withCount('replies');
                                  }
                              ]);
                        }
                    ])
                    ->withCount(['votes as upvotes_count' => function($query) {
                        $query->where('type', 'upvote');
                    }])
                    ->withCount('comments')
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        // Komunitas yang diikuti
        $communities = $user->communities()
                           ->withCount('members')
                           ->orderBy('community_user.created_at', 'desc')
                           ->limit(8)
                           ->get();

        // Stats untuk profile
        $stats = [
            'total_posts' => $user->posts_count,
            'total_comments' => $user->comments_count,
            'total_communities' => $user->communities()->count(),
            'member_since' => $user->created_at->diffForHumans(),
        ];

        return view('profile.show', compact(
            'user', 
            'posts', 
            'communities', 
            'stats', 
            'isOwnProfile'
        ));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|alpha_dash|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'profile_image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'show_email' => 'boolean',
            'show_date_of_birth' => 'boolean',
            'profile_visibility' => 'in:public,private,followers_only',
        ]);

        $data = $request->only([
            'name', 'username', 'email', 'bio', 'website', 'location',
            'date_of_birth', 'gender', 'show_email', 'show_date_of_birth',
            'profile_visibility'
        ]);

        // Handle social links
        $socialLinks = [
            'facebook_url', 'twitter_url', 'instagram_url', 
            'linkedin_url', 'github_url'
        ];
        
        foreach ($socialLinks as $social) {
            if ($request->has($social)) {
                $data[$social] = $request->$social;
            }
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old profile image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = $path;
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }
            
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.community', $user->username)
                        ->with('success', 'Profile updated successfully!');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'notification_settings' => 'sometimes|array',
            'preferences' => 'sometimes|array',
            'timezone' => 'sometimes|string|max:255',
            'locale' => 'sometimes|string|max:10',
        ]);

        $data = $request->only(['timezone', 'locale']);

        if ($request->has('notification_settings')) {
            $data['notification_settings'] = array_merge(
                $user->notification_settings ?? [],
                $request->notification_settings
            );
        }

        if ($request->has('preferences')) {
            $data['preferences'] = array_merge(
                $user->preferences ?? [],
                $request->preferences
            );
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Preferences updated successfully!'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('profile.edit')
                        ->with('success', 'Password updated successfully!');
    }

    public function posts($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $posts = Post::where('user_id', $user->id)
                    ->with(['community', 'votes', 'comments.user'])
                    ->withCount(['votes as upvotes_count' => function($query) {
                        $query->where('type', 'upvote');
                    }])
                    ->withCount('comments')
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);

        return view('profile.posts', compact('user', 'posts'));
    }

    public function comments($username)
{
    $user = User::where('username', $username)->firstOrFail();

    $comments = Comment::with([
        'post.community',
        'replies.user'
    ])
    ->where('user_id', $user->id)
    ->withCount(['likes', 'replies'])
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    $isOwnProfile = auth()->check() && auth()->id() === $user->id;

    return view('profile.comments', compact('user', 'comments', 'isOwnProfile'));
}


public function communities(Request $request, $username)
{
    $user = User::where('username', $username)->firstOrFail();

    // FILTER (all / owned / joined)
    $filter = $request->get('filter', 'all');

    // Ambil komunitas sesuai filter
    $query = $user->communities()->withCount(['members', 'posts']);

    if ($filter === 'owned') {
        $query->where('creator_id', $user->id);
    } elseif ($filter === 'joined') {
        $query->where('creator_id', '!=', $user->id);
    }

    $communities = $query
        ->orderBy('community_user.created_at', 'desc')
        ->paginate(12);

    // Total semua member di semua komunitas user
    $totalMembers = $user->communities()
                        ->withCount('members')
                        ->get()
                        ->sum('members_count');

    // Jumlah komunitas yang user buat
    $ownedCommunitiesCount = Community::where('creator_id', $user->id)->count();

    // Cek apakah profile milik sendiri
    $isOwnProfile = auth()->check() && auth()->id() === $user->id;

    return view('profile.communities', compact(
        'user',
        'communities',
        'totalMembers',
        'ownedCommunitiesCount',
        'isOwnProfile',
        'filter'
    ));
}



    public function deleteProfileImage()
    {
        $user = Auth::user();

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
            $user->update(['profile_image' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile image removed successfully!'
        ]);
    }

    public function deleteCoverImage()
    {
        $user = Auth::user();

        if ($user->cover_image) {
            Storage::disk('public')->delete($user->cover_image);
            $user->update(['cover_image' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cover image removed successfully!'
        ]);
    }
}