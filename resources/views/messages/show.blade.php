@extends('layouts.app')

@section('title', 'محادثة مع ' . $otherUser->name)

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="background: white; border-radius: 12px 12px 0 0; padding: 20px; border-bottom: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('messages.index') }}" 
                   style="color: #64748b; text-decoration: none; font-size: 20px; padding: 8px;">
                    ←
                </a>
                <img src="{{ $otherUser->avatar_url }}" 
                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                <div>
                    <h2 style="margin: 0; color: #1e293b; font-size: 18px; font-weight: 600;">
                        {{ $otherUser->name }}
                    </h2>
                    <p style="margin: 2px 0 0; color: #64748b; font-size: 14px;">
                        {{ $conversation->project->title }}
                    </p>
                </div>
            </div>
            
            <!-- Project & Bid Info -->
            <div style="text-align: left;">
                <div style="background: #f1f5f9; padding: 8px 12px; border-radius: 8px; margin-bottom: 5px;">
                    <span style="color: #10b981; font-weight: 700; font-size: 16px;">
                        ${{ number_format($conversation->bid->amount, 2) }}
                    </span>
                    <span style="color: #64748b; font-size: 12px; margin-right: 8px;">
                        {{ $conversation->bid->delivery_time }} أيام
                    </span>
                </div>
                @if(Auth::id() === $conversation->client_id && $conversation->bid->status === 'pending')
                    <form action="{{ route('bids.accept', $conversation->bid) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" 
                                style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;"
                                onclick="return confirm('هل أنت متأكد من قبول هذا العرض؟')">
                            ✅ قبول العرض
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div id="messages-container" 
         style="background: white; height: 500px; overflow-y: auto; padding: 20px; border-bottom: 1px solid #e5e7eb;">
        
        @foreach($conversation->messages as $message)
            <div style="margin-bottom: 20px; display: flex; {{ $message->sender_id === Auth::id() ? 'justify-content: flex-end' : 'justify-content: flex-start' }};">
                <div style="max-width: 70%; {{ $message->sender_id === Auth::id() ? 'margin-left: 50px' : 'margin-right: 50px' }};">
                    
                    @if($message->is_system_message)
                        <!-- System Message -->
                        <div style="text-align: center; margin: 20px 0;">
                            <div style="background: #f1f5f9; color: #64748b; padding: 8px 16px; border-radius: 20px; font-size: 13px; display: inline-block;">
                                {{ $message->message }}
                            </div>
                            <div style="color: #94a3b8; font-size: 11px; margin-top: 5px;">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    @else
                        <!-- Regular Message -->
                        <div style="display: flex; align-items: start; gap: 10px; {{ $message->sender_id === Auth::id() ? 'flex-direction: row-reverse' : '' }};">
                            <img src="{{ $message->sender->avatar_url }}" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            
                            <div style="flex: 1;">
                                <!-- Message Bubble -->
                                <div style="background: {{ $message->sender_id === Auth::id() ? '#3b82f6' : '#f1f5f9' }}; 
                                           color: {{ $message->sender_id === Auth::id() ? 'white' : '#1e293b' }}; 
                                           padding: 12px 16px; 
                                           border-radius: {{ $message->sender_id === Auth::id() ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }}; 
                                           word-wrap: break-word; 
                                           line-height: 1.5;">
                                    {{ $message->message }}
                                </div>
                                
                                <!-- Attachments -->
                                @if($message->attachments && count($message->attachments) > 0)
                                    <div style="margin-top: 8px;">
                                        @foreach($message->attachments as $attachment)
                                            <div style="background: {{ $message->sender_id === Auth::id() ? 'rgba(255,255,255,0.1)' : '#e2e8f0' }}; 
                                                       padding: 8px 12px; 
                                                       border-radius: 8px; 
                                                       margin-bottom: 5px; 
                                                       display: flex; 
                                                       align-items: center; 
                                                       gap: 8px;">
                                                <span style="font-size: 14px;">📎</span>
                                                <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                                   target="_blank" 
                                                   style="color: {{ $message->sender_id === Auth::id() ? 'rgba(255,255,255,0.9)' : '#3b82f6' }}; 
                                                         text-decoration: none; 
                                                         font-size: 13px;">
                                                    {{ $attachment['name'] }}
                                                </a>
                                                <span style="color: {{ $message->sender_id === Auth::id() ? 'rgba(255,255,255,0.7)' : '#64748b' }}; 
                                                            font-size: 11px;">
                                                    ({{ number_format($attachment['size'] / 1024, 1) }} KB)
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Message Time -->
                                <div style="margin-top: 5px; font-size: 11px; color: #94a3b8; {{ $message->sender_id === Auth::id() ? 'text-align: left' : 'text-align: right' }};">
                                    {{ $message->created_at->format('H:i') }}
                                    @if($message->sender_id === Auth::id() && $message->isRead())
                                        <span style="color: #10b981;">✓✓</span>
                                    @elseif($message->sender_id === Auth::id())
                                        <span style="color: #94a3b8;">✓</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input -->
    <div style="background: white; border-radius: 0 0 12px 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <form id="message-form" action="{{ route('messages.store', $conversation) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- File Attachments Preview -->
            <div id="attachments-preview" style="margin-bottom: 10px; display: none;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-size: 13px; color: #64748b; font-weight: 600;">المرفقات المحددة:</span>
                        <button type="button" onclick="clearAttachments()" 
                                style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 12px;">
                            إزالة الكل
                        </button>
                    </div>
                    <div id="attachments-list"></div>
                </div>
            </div>
            
            <div style="display: flex; gap: 10px; align-items: end;">
                <!-- File Upload -->
                <label style="cursor: pointer; padding: 10px; background: #f1f5f9; border-radius: 8px; color: #64748b; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e2e8f0'"
                       onmouseout="this.style.backgroundColor='#f1f5f9'">
                    <input type="file" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx" 
                           style="display: none;" onchange="previewAttachments(this)">
                    📎
                </label>
                
                <!-- Message Input -->
                <div style="flex: 1;">
                    <textarea name="message" 
                              placeholder="اكتب رسالتك هنا..." 
                              required
                              style="width: 100%; min-height: 50px; max-height: 120px; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 25px; resize: vertical; font-family: inherit; font-size: 14px; line-height: 1.5;"
                              onkeydown="handleEnterKey(event)"></textarea>
                </div>
                
                <!-- Send Button -->
                <button type="submit" 
                        style="background: #3b82f6; color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='#2563eb'"
                        onmouseout="this.style.backgroundColor='#3b82f6'">
                    إرسال
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto scroll to bottom
function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

// Initial scroll to bottom
scrollToBottom();

// Handle Enter key in textarea
function handleEnterKey(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        document.getElementById('message-form').submit();
    }
}

// Preview attachments
function previewAttachments(input) {
    const preview = document.getElementById('attachments-preview');
    const list = document.getElementById('attachments-list');
    
    if (input.files.length > 0) {
        preview.style.display = 'block';
        list.innerHTML = '';
        
        Array.from(input.files).forEach((file, index) => {
            const item = document.createElement('div');
            item.style.cssText = 'display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 12px; color: #64748b;';
            item.innerHTML = `
                <span>📎</span>
                <span>${file.name}</span>
                <span>(${(file.size / 1024).toFixed(1)} KB)</span>
            `;
            list.appendChild(item);
        });
    } else {
        preview.style.display = 'none';
    }
}

// Clear attachments
function clearAttachments() {
    document.querySelector('input[type="file"]').value = '';
    document.getElementById('attachments-preview').style.display = 'none';
}

// Auto refresh messages every 5 seconds
let lastMessageId = {{ $conversation->messages->last()->id ?? 0 }};

setInterval(function() {
    fetch(`/messages/{{ $conversation->id }}/new-messages?last_message_id=${lastMessageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.messages.length > 0) {
                const container = document.getElementById('messages-container');
                
                data.messages.forEach(message => {
                    // Add new message to container
                    const messageHtml = createMessageHtml(message);
                    container.insertAdjacentHTML('beforeend', messageHtml);
                    lastMessageId = message.id;
                });
                
                scrollToBottom();
            }
        })
        .catch(error => console.log('Error fetching new messages:', error));
}, 5000);

// Create message HTML
function createMessageHtml(message) {
    const isOwn = message.sender_id === {{ Auth::id() }};
    const alignClass = isOwn ? 'justify-content: flex-end' : 'justify-content: flex-start';
    const marginClass = isOwn ? 'margin-left: 50px' : 'margin-right: 50px';
    const bgColor = isOwn ? '#3b82f6' : '#f1f5f9';
    const textColor = isOwn ? 'white' : '#1e293b';
    const borderRadius = isOwn ? '16px 16px 4px 16px' : '16px 16px 16px 4px';
    
    return `
        <div style="margin-bottom: 20px; display: flex; ${alignClass};">
            <div style="max-width: 70%; ${marginClass};">
                <div style="display: flex; align-items: start; gap: 10px; ${isOwn ? 'flex-direction: row-reverse' : ''};">
                    <img src="${message.sender.avatar_url}" 
                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                    
                    <div style="flex: 1;">
                        <div style="background: ${bgColor}; color: ${textColor}; padding: 12px 16px; border-radius: ${borderRadius}; word-wrap: break-word; line-height: 1.5;">
                            ${message.message}
                        </div>
                        <div style="margin-top: 5px; font-size: 11px; color: #94a3b8; ${isOwn ? 'text-align: left' : 'text-align: right'};">
                            ${new Date(message.created_at).toLocaleTimeString('ar-EG', {hour: '2-digit', minute:'2-digit'})}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}
</script>
@endsection
