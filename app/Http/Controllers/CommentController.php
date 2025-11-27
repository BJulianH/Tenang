<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $post = Post::find($request->post_id);
            
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            $comment = Comment::create([
                'content' => $request->content,
                'user_id' => Auth::id(),
                'post_id' => $request->post_id,
                'parent_id' => $request->parent_id
            ]);

            // Update comments count di post
            $post->increment('comments_count');

            // Load relationships
            $comment->load(['user', 'replies']);

            return response()->json([
                'success' => true,
                'message' => $request->parent_id ? 'Reply posted successfully!' : 'Comment posted successfully!',
                'comment' => $comment,
                'comments_count' => $post->comments_count,
                'is_reply' => (bool)$request->parent_id
            ]);

        } catch (\Exception $e) {
            Log::error('Comment creation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function like(Comment $comment)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to like comments'
                ], 401);
            }

            $existingVote = $comment->votes()
                                  ->where('user_id', $user->id)
                                  ->first();

            if ($existingVote) {
                if ($existingVote->type === 'upvote') {
                    $existingVote->delete();
                    $action = 'removed';
                } else {
                    $existingVote->update(['type' => 'upvote']);
                    $action = 'added';
                }
            } else {
                Vote::create([
                    'user_id' => $user->id,
                    'voteable_type' => Comment::class,
                    'voteable_id' => $comment->id,
                    'type' => 'upvote'
                ]);
                $action = 'added';
            }

            // Refresh likes count
            $comment->loadCount('likes');

            return response()->json([
                'success' => true,
                'action' => $action,
                'likes_count' => $comment->likes_count,
                'message' => $action === 'added' ? 'Comment liked!' : 'Like removed!'
            ]);

        } catch (\Exception $e) {
            Log::error('Comment like error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing like: ' . $e->getMessage()
            ], 500);
        }
    }

    public function unlike(Comment $comment)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to unlike comments'
                ], 401);
            }

            $existingVote = $comment->votes()
                                  ->where('user_id', $user->id)
                                  ->first();

            if ($existingVote) {
                if ($existingVote->type === 'downvote') {
                    $existingVote->delete();
                    $action = 'removed';
                } else {
                    $existingVote->update(['type' => 'downvote']);
                    $action = 'added';
                }
            } else {
                Vote::create([
                    'user_id' => $user->id,
                    'voteable_type' => Comment::class,
                    'voteable_id' => $comment->id,
                    'type' => 'downvote'
                ]);
                $action = 'added';
            }

            $comment->loadCount('likes');

            return response()->json([
                'success' => true,
                'action' => $action,
                'likes_count' => $comment->likes_count,
                'message' => $action === 'added' ? 'Comment unliked!' : 'Unlike removed!'
            ]);

        } catch (\Exception $e) {
            Log::error('Comment unlike error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing unlike: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to delete comments'
                ], 401);
            }

            if ($comment->user_id !== $user->id && !$user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this comment'
                ], 403);
            }

            $post = $comment->post;
            $comment->delete();

            // Update comments count
            $post->decrement('comments_count');

            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully!',
                'comments_count' => $post->comments_count
            ]);

        } catch (\Exception $e) {
            Log::error('Comment delete error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting comment: ' . $e->getMessage()
            ], 500);
        }
    }
}