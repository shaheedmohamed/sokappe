<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessagesController extends Controller
{
    /**
     * Display all conversations for admin
     */
    public function index()
    {
        $conversations = Conversation::with([
            'project', 
            'bid', 
            'client', 
            'freelancer', 
            'latestMessage.sender'
        ])
        ->orderBy('last_message_at', 'desc')
        ->paginate(20);

        return view('admin.messages.index', compact('conversations'));
    }

    /**
     * Show a specific conversation for admin
     */
    public function show(Conversation $conversation)
    {
        $conversation->load([
            'project', 
            'bid', 
            'client', 
            'freelancer', 
            'messages.sender'
        ]);

        return view('admin.messages.show', compact('conversation'));
    }

    /**
     * Get conversation statistics
     */
    public function stats()
    {
        $stats = [
            'total_conversations' => Conversation::count(),
            'active_conversations' => Conversation::where('is_active', true)->count(),
            'total_messages' => Message::count(),
            'messages_today' => Message::whereDate('created_at', today())->count(),
            'unread_messages' => Message::whereNull('read_at')->count(),
        ];

        return response()->json($stats);
    }
}
