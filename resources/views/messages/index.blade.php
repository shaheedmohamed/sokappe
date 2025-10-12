@extends('layouts.app')

@section('title', 'الرسائل')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; color: #1e293b; font-size: 28px; display: flex; align-items: center; gap: 12px;">
            💬 الرسائل
        </h1>
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 20px; font-size: 14px;">
                {{ $conversations->total() }} محادثة
            </span>
        </div>
    </div>

    @if($conversations->count() > 0)
        <!-- Conversations List -->
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->getOtherParticipant(Auth::id());
                    $unreadCount = $conversation->getUnreadCountForUser(Auth::id());
                    $latestMessage = $conversation->latestMessage;
                @endphp
                
                <a href="{{ route('messages.show', $conversation) }}" 
                   style="display: block; padding: 20px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit; transition: all 0.2s;"
                   onmouseover="this.style.backgroundColor='#f8fafc'"
                   onmouseout="this.style.backgroundColor='white'">
                    
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <!-- Avatar -->
                        <div style="position: relative;">
                            <img src="{{ $otherUser->avatar_url }}" 
                                 style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @if($unreadCount > 0)
                                <div style="position: absolute; top: -2px; right: -2px; background: #ef4444; color: white; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div style="flex: 1; min-width: 0;">
                            <!-- Header -->
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 5px;">
                                <div>
                                    <h3 style="margin: 0; color: #1e293b; font-size: 16px; font-weight: 600;">
                                        {{ $otherUser->name }}
                                    </h3>
                                    <p style="margin: 2px 0 0; color: #64748b; font-size: 13px;">
                                        {{ $conversation->project->title }}
                                    </p>
                                </div>
                                <div style="text-align: left;">
                                    @if($latestMessage)
                                        <span style="color: #64748b; font-size: 12px;">
                                            {{ $latestMessage->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Latest Message -->
                            @if($latestMessage)
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    @if($latestMessage->sender_id === Auth::id())
                                        <span style="color: #64748b; font-size: 12px;">أنت:</span>
                                    @endif
                                    <p style="margin: 0; color: {{ $unreadCount > 0 ? '#1e293b' : '#64748b' }}; font-size: 14px; font-weight: {{ $unreadCount > 0 ? '600' : '400' }}; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                        @if($latestMessage->is_system_message)
                                            <span style="font-style: italic;">{{ $latestMessage->message }}</span>
                                        @else
                                            {{ Str::limit($latestMessage->message, 60) }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Bid Info -->
                        <div style="text-align: center; padding: 8px 12px; background: #f1f5f9; border-radius: 8px;">
                            <div style="color: #10b981; font-weight: 700; font-size: 16px;">
                                ${{ number_format($conversation->bid->amount, 2) }}
                            </div>
                            <div style="color: #64748b; font-size: 11px;">
                                {{ $conversation->bid->delivery_time }} أيام
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($conversations->hasPages())
            <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $conversations->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.5;">💬</div>
            <h3 style="margin: 0 0 12px; color: #1e293b; font-size: 24px;">لا توجد محادثات</h3>
            <p style="margin: 0 0 24px; color: #64748b; font-size: 16px;">
                ستظهر هنا المحادثات عندما تبدأ في التواصل مع المحترفين أو العملاء
            </p>
            <a href="{{ route('projects.index') }}" 
               style="display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                تصفح المشاريع
            </a>
        </div>
    @endif
</div>

<script>
// Auto refresh unread count every 30 seconds
setInterval(function() {
    fetch('/messages/unread-count')
        .then(response => response.json())
        .then(data => {
            // Update unread count in navigation if exists
            const unreadBadge = document.querySelector('.messages-unread-badge');
            if (unreadBadge) {
                if (data.count > 0) {
                    unreadBadge.textContent = data.count > 9 ? '9+' : data.count;
                    unreadBadge.style.display = 'block';
                } else {
                    unreadBadge.style.display = 'none';
                }
            }
        })
        .catch(error => console.log('Error fetching unread count:', error));
}, 30000);
</script>
@endsection
