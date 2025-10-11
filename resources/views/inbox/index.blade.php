@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div class="page-header">
        <h1>📬 صندوق الرسائل</h1>
        <p>تواصل مع العملاء والمحترفين</p>
    </div>

    @if($conversations->count() > 0)
        <div class="conversations-list">
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->buyer_id === Auth::id() ? $conversation->seller : $conversation->buyer;
                    $lastMessage = $conversation->messages->first();
                @endphp
                <div class="conversation-item">
                    <a href="{{ route('conversations.show', $conversation) }}" class="conversation-link">
                        <div class="conversation-avatar">
                            <div class="avatar">{{ substr($otherUser->name, 0, 1) }}</div>
                        </div>
                        <div class="conversation-content">
                            <div class="conversation-header">
                                <h3>{{ $otherUser->name }}</h3>
                                <span class="conversation-time">{{ $conversation->updated_at->diffForHumans() }}</span>
                            </div>
                            @if($lastMessage)
                                <p class="conversation-preview">{{ Str::limit($lastMessage->body, 80) }}</p>
                            @else
                                <p class="conversation-preview text-muted">لا توجد رسائل بعد</p>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">💬</div>
            <h3>لا توجد محادثات بعد</h3>
            <p>ستظهر محادثاتك هنا عندما تبدأ في التواصل مع العملاء أو المحترفين</p>
        </div>
    @endif
</div>

<style>
.conversations-list {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.conversation-item {
    border-bottom: 1px solid #f0f0f0;
}

.conversation-item:last-child {
    border-bottom: none;
}

.conversation-link {
    display: flex;
    padding: 20px;
    text-decoration: none;
    color: inherit;
    transition: background-color 0.2s;
}

.conversation-link:hover {
    background-color: #f8f9fa;
}

.conversation-avatar {
    margin-left: 15px;
}

.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(45deg, #3b82f6, #8b5cf6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.conversation-content {
    flex: 1;
}

.conversation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.conversation-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.conversation-time {
    font-size: 12px;
    color: #666;
}

.conversation-preview {
    margin: 0;
    color: #666;
    font-size: 14px;
    line-height: 1.4;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.empty-state h3 {
    margin-bottom: 10px;
    color: #333;
}

.empty-state p {
    color: #666;
    max-width: 400px;
    margin: 0 auto;
}
</style>
@endsection
