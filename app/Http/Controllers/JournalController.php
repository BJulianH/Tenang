<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('user_id', auth::id())->get();
        return response()->json($journals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $journal = Journal::create([
            'user_id' => auth::id(),
            $request->input('title'),
            'content' => $request->input('content'),
            'date' => now()->toDateString(),
        ]);

        return response()->json($journal);
    }

    public function show(Journal $journal)
    {
        return response()->json($journal);
    }

    public function update(Request $request, Journal $journal)
    {
        $request->validate([
            'title' => 'string',
            'content' => 'string',
        ]);

        $journal->update($request->only(['title', 'content']));
        return response()->json($journal);
    }

    public function destroy(Journal $journal)
    {
        $journal->delete();
        return response()->json(['message' => 'Jurnal berhasil dihapus.']);
    }
}
