<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['posts', 'comments'])
                    ->latest()
                    ->paginate(10);
                    
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount(['posts', 'comments', 'ownedCommunities']);
        $recent_posts = $user->posts()->latest()->take(5)->get();
        
        return view('admin.users.show', compact('user', 'recent_posts'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:user,moderator,admin',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
        ]);

        $user->update($validated);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}