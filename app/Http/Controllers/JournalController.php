<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $journals = $user->journals()->latest()->get();
        
        $journal = null;
        if ($request->has('edit')) {
            $journal = Journal::where('user_id', $user->id)->find($request->edit);
        }

        return view('journal', compact('journals', 'journal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mood' => 'nullable|string|max:50'
        ]);

        Journal::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'mood' => $validated['mood']
        ]);

        return redirect()->route('journal.index')->with('success', 'Journal entry saved successfully!');
    }

    public function update(Request $request, Journal $journal)
    {
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mood' => 'nullable|string|max:50'
        ]);

        $journal->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'mood' => $validated['mood']
        ]);

        return redirect()->route('journal.index')->with('success', 'Journal entry updated successfully!');
    }

    public function destroy(Journal $journal)
    {
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $journal->delete();

        return redirect()->route('journal.index')->with('success', 'Journal entry deleted successfully!');
    }
}