<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::where('user_id', Auth::id())->latest()->get();
        return response()->json($chats);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_message' => 'required|string',
        ]);

        $chat = Chat::create([
            'user_id' => Auth::id(),
            'user_message' => $request->user_message,
            'ai_response' => 'Tenang... aku di sini untuk dengarkan kamu. 😊',
        ]);

        return response()->json($chat);
    }

    public function show(Chat $chat)
    {
        return response()->json($chat);
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();
        return response()->json(['message' => 'Chat dihapus.']);
    }
}
