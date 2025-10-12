@extends('admin.layout')

@section('title', 'عرض المحادثة')

@section('content')
<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline" style="margin-left: 15px;">
                ← العودة للقائمة
            </a>
            <h1>💬 عرض المحادثة</h1>
        </div>
    </div>

    <!-- Conversation Info -->
    <div class="admin-card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h3>📋 معلومات المحادثة</h3>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <!-- Project Info -->
                <div>
                    <h4 style="margin: 0 0 10px; color: #1e293b;">المشروع</h4>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">
                            <a href="{{ route('projects.show', $conversation->project) }}" 
                               style="color: #3b82f6; text-decoration: none;" target="_blank">
                                {{ $conversation->project->title }}
                            </a>
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            ID: {{ $conversation->project->id }}
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            الميزانية: ${{ number_format($conversation->project->budget_min, 2) }} - ${{ number_format($conversation->project->budget_max, 2) }}
                        </div>
                    </div>
                </div>

                <!-- Client Info -->
                <div>
                    <h4 style="margin: 0 0 10px; color: #1e293b;">العميل</h4>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <img src="{{ $conversation->client->avatar_url }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b;">{{ $conversation->client->name }}</div>
                                <div style="font-size: 12px; color: #64748b;">{{ $conversation->client->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Freelancer Info -->
                <div>
                    <h4 style="margin: 0 0 10px; color: #1e293b;">المحترف</h4>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <img src="{{ $conversation->freelancer->avatar_url }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b;">{{ $conversation->freelancer->name }}</div>
                                <div style="font-size: 12px; color: #64748b;">{{ $conversation->freelancer->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bid Info -->
                <div>
                    <h4 style="margin: 0 0 10px; color: #1e293b;">تفاصيل العرض</h4>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                        <div style="color: #10b981; font-weight: 700; font-size: 18px; margin-bottom: 5px;">
                            ${{ number_format($conversation->bid->amount, 2) }}
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            مدة التسليم: {{ $conversation->bid->delivery_time }} أيام
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            الحالة: 
                            @if($conversation->bid->status === 'pending')
                                <span style="color: #f59e0b;">⏳ قيد الانتظار</span>
                            @elseif($conversation->bid->status === 'accepted')
                                <span style="color: #10b981;">✅ مقبول</span>
                            @else
                                <span style="color: #ef4444;">❌ مرفوض</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="admin-card">
        <div class="card-header">
            <h3>💬 الرسائل ({{ $conversation->messages->count() }})</h3>
        </div>
        
        <div style="height: 600px; overflow-y: auto; padding: 20px; background: #f8fafc;">
            @if($conversation->messages->count() > 0)
                @foreach($conversation->messages as $message)
                    <div style="margin-bottom: 20px; display: flex; {{ $message->sender_id === $conversation->client_id ? 'justify-content: flex-end' : 'justify-content: flex-start' }};">
                        <div style="max-width: 70%; {{ $message->sender_id === $conversation->client_id ? 'margin-left: 50px' : 'margin-right: 50px' }};">
                            
                            @if($message->is_system_message)
                                <!-- System Message -->
                                <div style="text-align: center; margin: 20px 0;">
                                    <div style="background: #e2e8f0; color: #64748b; padding: 8px 16px; border-radius: 20px; font-size: 13px; display: inline-block;">
                                        {{ $message->message }}
                                    </div>
                                    <div style="color: #94a3b8; font-size: 11px; margin-top: 5px;">
                                        {{ $message->created_at->format('H:i d/m/Y') }}
                                    </div>
                                </div>
                            @else
                                <!-- Regular Message -->
                                <div style="display: flex; align-items: start; gap: 10px; {{ $message->sender_id === $conversation->client_id ? 'flex-direction: row-reverse' : '' }};">
                                    <img src="{{ $message->sender->avatar_url }}" 
                                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                                    
                                    <div style="flex: 1;">
                                        <!-- Sender Name -->
                                        <div style="font-size: 12px; color: #64748b; margin-bottom: 5px; {{ $message->sender_id === $conversation->client_id ? 'text-align: left' : 'text-align: right' }};">
                                            {{ $message->sender->name }}
                                            @if($message->sender_id === $conversation->client_id)
                                                <span style="background: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 8px; font-size: 10px; margin-right: 5px;">عميل</span>
                                            @else
                                                <span style="background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 8px; font-size: 10px; margin-right: 5px;">محترف</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Message Bubble -->
                                        <div style="background: {{ $message->sender_id === $conversation->client_id ? '#3b82f6' : 'white' }}; 
                                                   color: {{ $message->sender_id === $conversation->client_id ? 'white' : '#1e293b' }}; 
                                                   padding: 12px 16px; 
                                                   border-radius: {{ $message->sender_id === $conversation->client_id ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }}; 
                                                   word-wrap: break-word; 
                                                   line-height: 1.5;
                                                   border: {{ $message->sender_id === $conversation->client_id ? 'none' : '1px solid #e5e7eb' }};">
                                            {{ $message->message }}
                                        </div>
                                        
                                        <!-- Attachments -->
                                        @if($message->attachments && count($message->attachments) > 0)
                                            <div style="margin-top: 8px;">
                                                @foreach($message->attachments as $attachment)
                                                    <div style="background: {{ $message->sender_id === $conversation->client_id ? 'rgba(255,255,255,0.1)' : '#f1f5f9' }}; 
                                                               padding: 8px 12px; 
                                                               border-radius: 8px; 
                                                               margin-bottom: 5px; 
                                                               display: flex; 
                                                               align-items: center; 
                                                               gap: 8px;">
                                                        <span style="font-size: 14px;">📎</span>
                                                        <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                                           target="_blank" 
                                                           style="color: {{ $message->sender_id === $conversation->client_id ? 'rgba(255,255,255,0.9)' : '#3b82f6' }}; 
                                                                 text-decoration: none; 
                                                                 font-size: 13px;">
                                                            {{ $attachment['name'] }}
                                                        </a>
                                                        <span style="color: {{ $message->sender_id === $conversation->client_id ? 'rgba(255,255,255,0.7)' : '#64748b' }}; 
                                                                    font-size: 11px;">
                                                            ({{ number_format($attachment['size'] / 1024, 1) }} KB)
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <!-- Message Time -->
                                        <div style="margin-top: 5px; font-size: 11px; color: #94a3b8; {{ $message->sender_id === $conversation->client_id ? 'text-align: left' : 'text-align: right' }};">
                                            {{ $message->created_at->format('H:i d/m/Y') }}
                                            @if($message->isRead())
                                                <span style="color: #10b981;">✓✓ مقروء</span>
                                            @else
                                                <span style="color: #94a3b8;">✓ مرسل</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 40px; color: #64748b;">
                    <div style="font-size: 48px; margin-bottom: 15px;">💬</div>
                    <h3 style="margin: 0 0 10px; color: #1e293b;">لا توجد رسائل</h3>
                    <p style="margin: 0;">لم يتم إرسال أي رسائل في هذه المحادثة بعد</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.admin-header h1 {
    margin: 0;
    color: #1e293b;
    font-size: 28px;
    display: inline;
}

.admin-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
}

.card-header h3 {
    margin: 0;
    color: #1e293b;
    font-size: 18px;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    display: inline-block;
}

.btn-outline {
    background: transparent;
    color: #3b82f6;
    border: 1px solid #3b82f6;
}

.btn:hover {
    opacity: 0.8;
}
</style>
@endsection
