<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display all conversations for the authenticated user
     */
    public function index()
    {
        $conversations = Conversation::where('client_id', Auth::id())
            ->orWhere('freelancer_id', Auth::id())
            ->with(['project', 'bid', 'client', 'freelancer', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->paginate(20);

        return view('messages.index', compact('conversations'));
    }

    /**
     * Start a new conversation from a bid
     */
    public function startFromBid(Bid $bid)
    {
        // Check if user is authorized (either project owner or bid owner)
        if (Auth::id() !== $bid->project->user_id && Auth::id() !== $bid->user_id) {
            abort(403, 'غير مصرح لك بالوصول لهذه المحادثة');
        }

        // Check if conversation already exists
        $conversation = Conversation::where('bid_id', $bid->id)->first();

        if (!$conversation) {
            // Create new conversation
            $conversation = Conversation::create([
                'project_id' => $bid->project_id,
                'bid_id' => $bid->id,
                'client_id' => $bid->project->user_id,
                'freelancer_id' => $bid->user_id,
                'subject' => 'مناقشة العرض: ' . $bid->project->title,
                'last_message_at' => now(),
            ]);

            // Create initial system message
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'message' => 'تم بدء المحادثة حول العرض المقدم على مشروع: ' . $bid->project->title,
                'is_system_message' => true,
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    /**
     * Display a specific conversation
     */
    public function show(Conversation $conversation)
    {
        // Check if user is part of this conversation
        if (Auth::id() !== $conversation->client_id && Auth::id() !== $conversation->freelancer_id) {
            abort(403, 'غير مصرح لك بالوصول لهذه المحادثة');
        }

        // Load conversation with relationships
        $conversation->load(['project', 'bid', 'client', 'freelancer', 'messages.sender']);

        // Mark messages as read for current user
        $conversation->markAsReadForUser(Auth::id());

        // Get other participant
        $otherUser = $conversation->getOtherParticipant(Auth::id());

        return view('messages.show', compact('conversation', 'otherUser'));
    }

    /**
     * Send a new message
     */
    public function store(Request $request, Conversation $conversation)
    {
        // Check if user is part of this conversation
        if (Auth::id() !== $conversation->client_id && Auth::id() !== $conversation->freelancer_id) {
            abort(403, 'غير مصرح لك بإرسال رسائل في هذه المحادثة');
        }

        $request->validate([
            'message' => 'required|string|max:2000',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx',
        ]);

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message-attachments', 'public');
                $attachmentPaths[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'attachments' => $attachmentPaths,
        ]);

        // Update conversation last message time
        $conversation->updateLastMessageTime();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->route('messages.show', $conversation)->with('success', 'تم إرسال الرسالة بنجاح');
    }

    /**
     * Get new messages for a conversation (AJAX)
     */
    public function getNewMessages(Conversation $conversation, Request $request)
    {
        // Check if user is part of this conversation
        if (Auth::id() !== $conversation->client_id && Auth::id() !== $conversation->freelancer_id) {
            abort(403);
        }

        $lastMessageId = $request->get('last_message_id', 0);
        
        $messages = $conversation->messages()
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->get();

        // Mark new messages as read
        $messages->where('sender_id', '!=', Auth::id())->each(function ($message) {
            $message->markAsRead();
        });

        return response()->json([
            'messages' => $messages,
            'conversation_updated_at' => $conversation->updated_at,
        ]);
    }

    /**
     * Get unread messages count
     */
    public function getUnreadCount()
    {
        $count = Conversation::where('client_id', Auth::id())
            ->orWhere('freelancer_id', Auth::id())
            ->get()
            ->sum(function ($conversation) {
                return $conversation->getUnreadCountForUser(Auth::id());
            });

        return response()->json(['count' => $count]);
    }
}
