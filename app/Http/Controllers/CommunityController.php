<?php
// app/Http/Controllers/CommunityController.php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
     public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all');
        
        // Base query untuk posts
        $postsQuery = Post::where('is_approved', true)
                        ->with([
                            'user', 
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
                        ->withCount('comments');


        // Apply filters
        switch ($filter) {
            case 'support':
                $postsQuery->where('is_support_request', true);
                break;
            case 'happy':
                $postsQuery->where('mood', 'happy');
                break;
            case 'anxious':
                $postsQuery->where('mood', 'anxious');
                break;
            case 'featured':
                $postsQuery->where('is_featured', true)
                          ->where(function($q) {
                              $q->whereNull('featured_until')
                                ->orWhere('featured_until', '>', now());
                          });
                break;
            case 'all':
            default:
                // No additional filters
                break;
        }

        // Jika user login, tampilkan posts dari komunitas yang diikuti + posts sendiri
        if ($user) {
            $communityIds = $user->communities()->pluck('communities.id');
            $postsQuery->where(function($query) use ($user, $communityIds) {
                $query->whereIn('community_id', $communityIds)
                      ->orWhere('user_id', $user->id);
            });
        } else {
            // Untuk guest, hanya tampilkan posts dari komunitas public
            $postsQuery->whereHas('community', function($q) {
                $q->where('type', 'public');
            });
        }

        $posts = $postsQuery->orderBy('created_at', 'desc')
                           ->paginate(10);

        // Komunitas trending
        $trendingCommunities = Community::withCount(['members', 'posts'])
            ->where('is_main', false)
            ->orderBy('members_count', 'desc')
            ->limit(5)
            ->get();

        // Komunitas rekomendasi
        $recommendedCommunities = $user ? 
            Community::whereNotIn('id', $user->communities()->pluck('communities.id'))
                ->withCount('members')
                ->orderBy('members_count', 'desc')
                ->limit(3)
                ->get() : 
            Community::withCount('members')
                ->orderBy('members_count', 'desc')
                ->limit(3)
                ->get();
        $isOwnProfile = Auth::check() && Auth::id() === $user->id;
$stats = [
            'total_posts' => $user->posts_count,
            'total_comments' => $user->comments_count,
            'total_communities' => $user->communities()->count(),
            'member_since' => $user->created_at->diffForHumans(),
        ];
        return view('community.index', compact('posts', 'trendingCommunities', 'recommendedCommunities', 'filter','user','isOwnProfile','stats'));
    }

    public function join(Community $community)
    {
        $user = Auth::user();

        if (!$community->isMember($user->id)) {
            $community->members()->attach($user->id, [
                'role' => 'member',
                'status' => $community->type === 'public' ? 'approved' : 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => $community->type === 'public' ? 'Successfully joined community!' : 'Join request sent!',
                'status' => $community->type === 'public' ? 'approved' : 'pending'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Already a member of this community'
        ], 422);
    }

    public function leave(Community $community)
    {
        $user = Auth::user();

        if ($community->isMember($user->id)) {
            $community->members()->detach($user->id);

            return response()->json([
                'success' => true,
                'message' => 'Successfully left community!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Not a member of this community'
        ], 422);
    }
     public function show($slug)
    {
        $community = Community::where('slug', $slug)
                            ->withCount(['members', 'posts'])
                            ->firstOrFail();

        $user = Auth::user();
        $isMember = $user ? $community->isMember($user->id) : false;
        $isAdmin = $user ? $community->isAdmin($user->id) : false;

        // Posts untuk community ini
        $posts = Post::where('community_id', $community->id)
                    ->with([
    'user',
    'votes',
    'comments' => function ($q) {
        $q->with('user')
          ->withCount(['likes as upvotes_count']) // COUNT likes
          ->withCount('replies')                 // COUNT replies
          ->with([
              'replies' => function ($r) {
                  $r->with('user')
                    ->withCount(['likes as upvotes_count']) // REPLY LIKE COUNT
                    ->withCount('replies');                // nested reply count
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

        // Recent members
        $recentMembers = $community->members()
                                 ->orderBy('community_user.created_at', 'desc')
                                 ->limit(8)
                                 ->get();

        // Related communities
        $relatedCommunities = Community::where('id', '!=', $community->id)
                                     ->where('type', 'public')
                                     ->withCount('members')
                                     ->orderBy('members_count', 'desc')
                                     ->limit(4)
                                     ->get();

        return view('community.show', compact(
            'community', 
            'posts', 
            'isMember', 
            'isAdmin', 
            'recentMembers', 
            'relatedCommunities'
        ));
    }

    public function explore()
    {
        $communities = Community::where('is_main', false)
                              ->withCount(['members', 'posts'])
                              ->orderBy('members_count', 'desc')
                              ->paginate(12);

        $categories = [
            'Mental Health' => Community::where('name', 'like', '%mental%')->count(),
            'Support Groups' => Community::where('name', 'like', '%support%')->count(),
            'Wellness' => Community::where('name', 'like', '%wellness%')->count(),
            'Discussion' => Community::where('name', 'like', '%discussion%')->count(),
        ];

        return view('community.explore', compact('communities', 'categories'));
    }

    public function create()
    {
        return view('community.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:communities',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:public,private,restricted',
            'rules' => 'nullable|string|max:2000'
        ]);

        $community = Community::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
            'type' => $request->type,
            'creator_id' => Auth::id(),
            'is_main' => false
        ]);

        // Add creator as admin
        $community->members()->attach(Auth::id(), [
            'role' => 'admin',
            'status' => 'approved'
        ]);

        return redirect()->route('community.show', $community->slug)
                        ->with('success', 'Community created successfully!');
    }

    public function myCommunities()
    {
        $user = Auth::user();
        
        $joinedCommunities = $user->communities()
                                ->withCount('members')
                                ->get();
        
        $ownedCommunities = $user->ownedCommunities()
                               ->withCount('members')
                               ->get();

        return view('community.my', compact('joinedCommunities', 'ownedCommunities'));
    }
}
