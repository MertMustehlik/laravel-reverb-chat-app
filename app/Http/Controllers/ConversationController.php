<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class ConversationController extends Controller
{
    public function index(): View
    {
        $conversations = Conversation::query()->get();
        return view('conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation): View
    {
        $conversation->load('messages');
        return view('conversations.show', compact('conversation'));
    }

    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => request()->input('message')
        ]);

        broadcast(new MessageSent($message))->toOthers();

        $message->load('user');

        return response()->json([
            'data' => $message
        ]);
    }
}
