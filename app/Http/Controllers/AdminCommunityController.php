<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCommunityController extends Controller
{
    public function index()
    {
        $communities = Community::with(['creator', 'parent'])
                               ->withCount(['members', 'posts', 'children'])
                               ->latest()
                               ->paginate(15);

        $stats = [
            'total' => Community::count(),
            'main_communities' => Community::where('is_main', true)->count(),
            'sub_communities' => Community::where('is_main', false)->count(),
            'active_today' => Community::whereHas('posts', function($query) {
                $query->whereDate('created_at', today());
            })->count(),
            'total_members' => DB::table('community_user')->count(),
        ];

        return view('admin.communities.index', compact('communities', 'stats'));
    }

    public function show(Community $community)
    {
        $community->load(['creator', 'parent', 'children.creator']);
        
        $recent_posts = $community->posts()
                                 ->with('user')
                                 ->withCount(['comments', 'votes as upvotes_count' => function($query) {
                                     $query->where('type', 'upvote');
                                 }])
                                 ->latest()
                                 ->take(10)
                                 ->get();

        $top_members = $community->members()
                                ->withCount(['posts' => function($query) use ($community) {
                                    $query->where('community_id', $community->id);
                                }])
                                ->orderBy('posts_count', 'desc')
                                ->take(10)
                                ->get();

        return view('admin.communities.show', compact('community', 'recent_posts', 'top_members'));
    }

    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:public,private,restricted',
            'is_main' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Jika name diupdate, generate slug baru
        if (isset($validated['name']) && $validated['name'] !== $community->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $community->update($validated);

        return back()->with('success', 'Community updated successfully.');
    }

    public function destroy(Community $community)
    {
        $communityName = $community->name;
        
        // Cek apakah community memiliki posts
        if ($community->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete community that has posts. Please delete or move the posts first.');
        }

        $community->delete();

        return redirect()->route('admin.communities.index')
                        ->with('success', "Community '{$communityName}' deleted successfully.");
    }

    public function addModerator(Request $request, Community $community)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($validated['user_id']);

        // Cek apakah user sudah menjadi member
        if (!$community->members()->where('user_id', $user->id)->exists()) {
            $community->members()->attach($user->id, ['role' => 'member', 'status' => 'approved']);
        }

        // Update ke role moderator
        $community->members()->updateExistingPivot($user->id, [
            'role' => 'moderator',
            'status' => 'approved'
        ]);

        return back()->with('success', "{$user->name} has been added as moderator.");
    }

    public function removeModerator(Community $community, User $user)
    {
        $community->members()->updateExistingPivot($user->id, [
            'role' => 'member'
        ]);

        return back()->with('success', "{$user->name} has been removed as moderator.");
    }

    public function updateMemberRole(Request $request, Community $community, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:member,moderator,admin'
        ]);

        $community->members()->updateExistingPivot($user->id, [
            'role' => $validated['role']
        ]);

        return back()->with('success', "{$user->name}'s role has been updated to {$validated['role']}.");
    }

    public function removeMember(Community $community, User $user)
    {
        $community->members()->detach($user->id);

        return back()->with('success', "{$user->name} has been removed from the community.");
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,make_main,make_sub,change_type',
            'community_ids' => 'required|array',
            'community_ids.*' => 'exists:communities,id',
            'type' => 'required_if:action,change_type|in:public,private,restricted'
        ]);

        $action = $validated['action'];
        $communityIds = $validated['community_ids'];

        switch ($action) {
            case 'delete':
                // Cek apakah ada communities yang memiliki posts
                $communitiesWithPosts = Community::whereIn('id', $communityIds)
                                               ->whereHas('posts')
                                               ->count();
                
                if ($communitiesWithPosts > 0) {
                    return back()->with('error', 'Cannot delete communities that have posts. Please delete or move the posts first.');
                }

                Community::whereIn('id', $communityIds)->delete();
                $message = 'Communities deleted successfully.';
                break;
                
            case 'make_main':
                Community::whereIn('id', $communityIds)->update(['is_main' => true]);
                $message = 'Communities set as main communities successfully.';
                break;
                
            case 'make_sub':
                Community::whereIn('id', $communityIds)->update(['is_main' => false]);
                $message = 'Communities set as sub-communities successfully.';
                break;
                
            case 'change_type':
                Community::whereIn('id', $communityIds)->update(['type' => $validated['type']]);
                $message = 'Community types updated successfully.';
                break;
        }

        return back()->with('success', $message);
    }

    public function getMembers(Community $community)
    {
        $members = $community->members()
                           ->withCount(['posts' => function($query) use ($community) {
                               $query->where('community_id', $community->id);
                           }])
                           ->orderBy('community_user.role')
                           ->orderBy('posts_count', 'desc')
                           ->paginate(20);

        return view('admin.communities.members', compact('community', 'members'));
    }

    public function create()
    {
        $mainCommunities = Community::where('is_main', true)->get();
        $users = User::where('is_active', true)->get();

        return view('admin.communities.create', compact('mainCommunities', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:communities',
            'description' => 'nullable|string',
            'type' => 'required|in:public,private,restricted',
            'parent_id' => 'nullable|exists:communities,id',
            'creator_id' => 'required|exists:users,id',
            'is_main' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_main'] = $validated['is_main'] ?? (!$validated['parent_id']);

        $community = Community::create($validated);

        // Add creator as admin
        $community->members()->attach($validated['creator_id'], [
            'role' => 'admin',
            'status' => 'approved'
        ]);

        return redirect()->route('admin.communities.show', $community)
                        ->with('success', 'Community created successfully.');
    }
}