<?php
// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SavedPost;
use App\Models\Vote;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function like(Post $post)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to like posts'
                ], 401);
            }

            $existingVote = Vote::where('user_id', $user->id)
                ->where('voteable_type', Post::class)
                ->where('voteable_id', $post->id)
                ->first();

            if ($existingVote) {
                if ($existingVote->type === 'upvote') {
                    $existingVote->delete();
                    $post->decrement('upvotes_count');
                    return response()->json([
                        'success' => true,
                        'action' => 'removed',
                        'likes_count' => $post->fresh()->upvotes_count
                    ]);
                } else {
                    $existingVote->update(['type' => 'upvote']);
                    $post->increment('upvotes_count');
                    $post->decrement('downvotes_count');
                }
            } else {
                Vote::create([
                    'user_id' => $user->id,
                    'voteable_type' => Post::class,
                    'voteable_id' => $post->id,
                    'type' => 'upvote'
                ]);
                $post->increment('upvotes_count');
            }

            return response()->json([
                'success' => true,
                'action' => 'added',
                'likes_count' => $post->fresh()->upvotes_count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing like: ' . $e->getMessage()
            ], 500);
        }
    }

    public function unlike(Post $post)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to unlike posts'
                ], 401);
            }

            $existingVote = Vote::where('user_id', $user->id)
                ->where('voteable_type', Post::class)
                ->where('voteable_id', $post->id)
                ->first();

            if ($existingVote) {
                if ($existingVote->type === 'downvote') {
                    $existingVote->delete();
                    $post->decrement('downvotes_count');
                    return response()->json([
                        'success' => true,
                        'action' => 'removed',
                        'likes_count' => $post->fresh()->upvotes_count
                    ]);
                } else {
                    $existingVote->update(['type' => 'downvote']);
                    $post->decrement('upvotes_count');
                    $post->increment('downvotes_count');
                }
            } else {
                Vote::create([
                    'user_id' => $user->id,
                    'voteable_type' => Post::class,
                    'voteable_id' => $post->id,
                    'type' => 'downvote'
                ]);
                $post->increment('downvotes_count');
            }

            return response()->json([
                'success' => true,
                'action' => 'added',
                'likes_count' => $post->fresh()->upvotes_count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing unlike: ' . $e->getMessage()
            ], 500);
        }
    }

    public function save(Post $post)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to save posts'
                ], 401);
            }

            if (!$post->isSavedBy($user)) {
                SavedPost::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id
                ]);

                $post->increment('saves_count');

                return response()->json([
                    'success' => true,
                    'action' => 'saved',
                    'message' => 'Post saved successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Post already saved'
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving post: ' . $e->getMessage()
            ], 500);
        }
    }
// Tambahkan method ini di PostController.php

public function show(Post $post)
{
    // Load semua relationships yang diperlukan
    $post->load([
        'user',
        'community',
        'votes',
        'comments' => function ($q) {
            $q->with(['user', 'replies.user'])
              ->withCount(['likes as upvotes_count'])
              ->withCount('replies')
              ->whereNull('parent_id')
              ->orderBy('created_at', 'desc');
        }
    ])->loadCount(['votes as upvotes_count' => function($query) {
        $query->where('type', 'upvote');
    }])->loadCount('comments');

    // Cek apakah user adalah member dari komunitas
    $user = Auth::user();
    $isMember = $user ? $post->community->isMember($user->id) : false;
    $isOwner = $user && $user->id === $post->user_id;

    // Related posts dari komunitas yang sama
    $relatedPosts = Post::where('community_id', $post->community_id)
                        ->where('id', '!=', $post->id)
                        ->with(['user', 'community'])
                        ->withCount(['votes as upvotes_count' => function($query) {
                            $query->where('type', 'upvote');
                        }])
                        ->withCount('comments')
                        ->where('is_approved', true)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();

    // Increment view count
    $post->increment('views_count');

    return view('community.posts.show', compact('post', 'isMember', 'isOwner', 'relatedPosts'));
}
    public function unsave(Post $post)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to unsave posts'
                ], 401);
            }

            $saved = SavedPost::where('user_id', $user->id)
                    ->where('post_id', $post->id)
                    ->first();

            if ($saved) {
                $saved->delete();
                $post->decrement('saves_count');

                return response()->json([
                    'success' => true,
                    'action' => 'unsaved',
                    'message' => 'Post removed from saved!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Post not found in saved items'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unsaving post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $communities = Auth::user()->communities()->where('status', 'approved')->get();
        return view('community.posts.create', compact('communities'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'community_id' => 'required|exists:communities,id',
                'mood' => 'nullable|in:happy,calm,anxious,sad,angry,neutral',
                'image' => 'nullable|image|max:2048',
                'is_anonymous' => 'boolean',
                'is_support_request' => 'boolean'
            ]);

            // Check if user is member of the community
            $community = Community::findOrFail($request->community_id);
            $user = Auth::user();
            
            if (!$community->isMember($user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be a member of this community to post'
                ], 403);
            }

            $postData = [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $user->id,
                'community_id' => $request->community_id,
                'mood' => $request->mood ?? 'neutral',
                'is_anonymous' => $request->boolean('is_anonymous', false),
                'is_support_request' => $request->boolean('is_support_request', false),
                'is_approved' => true // Auto-approve for now, bisa diganti dengan moderation system
            ];

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $postData['image'] = $path;
            }

            $post = Post::create($postData);

            // Load relationships for response
            $post->load(['user', 'community', 'comments.user']);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully!',
                'post' => $post
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Post creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating post: ' . $e->getMessage()
            ], 500);
        }
    }
}