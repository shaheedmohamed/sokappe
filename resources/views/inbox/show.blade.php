@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    @php
        $otherUser = $conversation->buyer_id === Auth::id() ? $conversation->seller : $conversation->buyer;
    @endphp
    
    <div class="chat-header">
        <a href="{{ route('conversations.index') }}" class="back-btn">← العودة للرسائل</a>
        <div class="chat-user-info">
            <div class="avatar">{{ substr($otherUser->name, 0, 1) }}</div>
            <div>
                <h2>{{ $otherUser->name }}</h2>
                <span class="user-status">متصل</span>
            </div>
        </div>
    </div>

    <div class="chat-container">
        <div class="messages-container" id="messages">
            @foreach($messages as $message)
                <div class="message {{ $message->user_id === Auth::id() ? 'message-sent' : 'message-received' }}">
                    <div class="message-content">
                        <p>{{ $message->body }}</p>
                        <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('conversations.store', $conversation) }}" method="POST" class="message-form">
            @csrf
            <div class="message-input-container">
                <textarea name="body" placeholder="اكتب رسالتك هنا..." required rows="3"></textarea>
                <button type="submit" class="send-btn">إرسال</button>
            </div>
        </form>
    </div>
</div>

<style>
.chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    background: white;
    border-radius: 12px 12px 0 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 0;
}

.back-btn {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}

.chat-user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-user-info .avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(45deg, #3b82f6, #8b5cf6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.chat-user-info h2 {
    margin: 0;
    font-size: 18px;
}

.user-status {
    font-size: 12px;
    color: #10b981;
}

.chat-container {
    background: white;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.messages-container {
    height: 400px;
    overflow-y: auto;
    padding: 20px;
    background: #f8f9fa;
}

.message {
    margin-bottom: 15px;
    display: flex;
}

.message-sent {
    justify-content: flex-end;
}

.message-received {
    justify-content: flex-start;
}

.message-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
}

.message-sent .message-content {
    background: #3b82f6;
    color: white;
}

.message-received .message-content {
    background: white;
    color: #333;
    border: 1px solid #e5e7eb;
}

.message-content p {
    margin: 0 0 5px 0;
    line-height: 1.4;
}

.message-time {
    font-size: 11px;
    opacity: 0.7;
}

.message-form {
    padding: 20px;
    border-top: 1px solid #e5e7eb;
}

.message-input-container {
    display: flex;
    gap: 10px;
    align-items: flex-end;
}

.message-input-container textarea {
    flex: 1;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 12px 16px;
    resize: none;
    font-family: inherit;
}

.send-btn {
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 12px 24px;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.2s;
}

.send-btn:hover {
    background: #2563eb;
}
</style>

<script>
// Auto scroll to bottom
document.addEventListener('DOMContentLoaded', function() {
    const messages = document.getElementById('messages');
    messages.scrollTop = messages.scrollHeight;
});
</script>
@endsection
