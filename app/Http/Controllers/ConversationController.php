<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('buyer_id', Auth::id())
            ->orWhere('seller_id', Auth::id())
            ->with(['buyer', 'seller', 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->latest()
            ->get();

        return view('inbox.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // التحقق من أن المستخدم جزء من المحادثة
        if ($conversation->buyer_id !== Auth::id() && $conversation->seller_id !== Auth::id()) {
            abort(403);
        }

        $messages = $conversation->messages()->with('user')->get();
        
        return view('inbox.show', compact('conversation', 'messages'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        // التحقق من أن المستخدم جزء من المحادثة
        if ($conversation->buyer_id !== Auth::id() && $conversation->seller_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
}
