<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'community'])
                    ->withCount(['comments', 'votes as upvotes_count' => function($query) {
                        $query->where('type', 'upvote');
                    }, 'votes as downvotes_count' => function($query) {
                        $query->where('type', 'downvote');
                    }])
                    ->latest()
                    ->paginate(15);

        $stats = [
            'total' => Post::count(),
            'published_today' => Post::whereDate('created_at', today())->count(),
            'anonymous' => Post::where('is_anonymous', true)->count(),
            'support_requests' => Post::where('is_support_request', true)->count(),
            'pending_approval' => Post::where('is_approved', false)->count(),
        ];

        return view('admin.posts.index', compact('posts', 'stats'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'community', 'comments.user', 'votes.user']);
        
        $related_posts = Post::where('user_id', $post->user_id)
                            ->where('id', '!=', $post->id)
                            ->with('user')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.posts.show', compact('post', 'related_posts'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
            'is_support_request' => 'boolean',
            'featured_until' => 'nullable|date',
        ]);

        $post->update($validated);

        return back()->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $postTitle = $post->title;
        $post->delete();

        return redirect()->route('admin.posts.index')
                        ->with('success', "Post '{$postTitle}' deleted successfully.");
    }

    public function feature(Post $post)
    {
        $post->update([
            'is_featured' => true,
            'featured_until' => now()->addDays(7)
        ]);

        return back()->with('success', 'Post featured successfully.');
    }

    public function unfeature(Post $post)
    {
        $post->update([
            'is_featured' => false,
            'featured_until' => null
        ]);

        return back()->with('success', 'Post unfeatured successfully.');
    }

    public function approve(Post $post)
    {
        $post->update(['is_approved' => true]);

        return back()->with('success', 'Post approved successfully.');
    }

    public function disapprove(Post $post)
    {
        $post->update(['is_approved' => false]);

        return back()->with('success', 'Post disapproved successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,disapprove,feature,unfeature,delete',
            'post_ids' => 'required|array',
            'post_ids.*' => 'exists:posts,id'
        ]);

        $action = $validated['action'];
        $postIds = $validated['post_ids'];

        switch ($action) {
            case 'approve':
                Post::whereIn('id', $postIds)->update(['is_approved' => true]);
                $message = 'Posts approved successfully.';
                break;
                
            case 'disapprove':
                Post::whereIn('id', $postIds)->update(['is_approved' => false]);
                $message = 'Posts disapproved successfully.';
                break;
                
            case 'feature':
                Post::whereIn('id', $postIds)->update([
                    'is_featured' => true,
                    'featured_until' => now()->addDays(7)
                ]);
                $message = 'Posts featured successfully.';
                break;
                
            case 'unfeature':
                Post::whereIn('id', $postIds)->update([
                    'is_featured' => false,
                    'featured_until' => null
                ]);
                $message = 'Posts unfeatured successfully.';
                break;
                
            case 'delete':
                Post::whereIn('id', $postIds)->delete();
                $message = 'Posts deleted successfully.';
                break;
        }

        return back()->with('success', $message);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $posts = Post::with(['user', 'community'])
                    ->withCount(['comments', 'votes as upvotes_count' => function($query) {
                        $query->where('type', 'upvote');
                    }])
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('content', 'like', "%{$query}%")
                          ->orWhereHas('user', function($q) use ($query) {
                              $q->where('name', 'like', "%{$query}%")
                                ->orWhere('username', 'like', "%{$query}%");
                          });
                    })
                    ->latest()
                    ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }
}