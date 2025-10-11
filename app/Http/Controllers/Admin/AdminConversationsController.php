<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminConversationsController extends Controller
{
    public function index(Request $request)
    {
        $query = Conversation::with(['buyer', 'seller', 'messages']);

        if ($request->search) {
            $query->whereHas('buyer', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('seller', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $conversations = $query->latest()->paginate(20);

        return view('admin.conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $conversation->load(['buyer', 'seller', 'messages.user']);
        $messages = $conversation->messages()->with('user')->get();
        
        return view('admin.conversations.show', compact('conversation', 'messages'));
    }

    public function destroy(Conversation $conversation)
    {
        $conversation->delete();
        return back()->with('success', 'تم حذف المحادثة بنجاح');
    }
}
