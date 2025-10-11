@extends('layouts.admin')

@section('title', 'عرض المحادثة')

@section('content')
<div style="display: grid; grid-template-columns: 300px 1fr; gap: 20px;">
    <!-- Conversation Info -->
    <div class="admin-card">
        <h3 class="card-title" style="margin-bottom: 20px;">معلومات المحادثة</h3>
        
        <div style="margin-bottom: 20px;">
            <h4 style="font-size: 14px; color: #64748b; margin-bottom: 10px;">المشاركين</h4>
            
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding: 12px; background: #f8fafc; border-radius: 8px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                    {{ substr($conversation->buyer->name, 0, 1) }}
                </div>
                <div>
                    <div style="font-weight: 600; color: #1e293b;">{{ $conversation->buyer->name }}</div>
                    <div style="font-size: 12px; color: #64748b;">العميل</div>
                    <div style="font-size: 11px; color: #94a3b8;">{{ $conversation->buyer->email }}</div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #f0fdf4; border-radius: 8px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                    {{ substr($conversation->seller->name, 0, 1) }}
                </div>
                <div>
                    <div style="font-weight: 600; color: #1e293b;">{{ $conversation->seller->name }}</div>
                    <div style="font-size: 12px; color: #64748b;">المحترف</div>
                    <div style="font-size: 11px; color: #94a3b8;">{{ $conversation->seller->email }}</div>
                </div>
            </div>
        </div>

        @if($conversation->project)
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 14px; color: #64748b; margin-bottom: 10px;">المشروع المرتبط</h4>
                <div style="padding: 12px; background: #fef3c7; border-radius: 8px;">
                    <div style="font-weight: 600; color: #92400e; margin-bottom: 5px;">
                        {{ $conversation->project->title }}
                    </div>
                    <div style="font-size: 12px; color: #a16207;">
                        {{ number_format($conversation->project->budget_min) }} - {{ number_format($conversation->project->budget_max) }} ج
                    </div>
                </div>
            </div>
        @endif

        <div>
            <h4 style="font-size: 14px; color: #64748b; margin-bottom: 10px;">إحصائيات</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div style="text-align: center; padding: 10px; background: #dbeafe; border-radius: 6px;">
                    <div style="font-size: 18px; font-weight: 700; color: #1e40af;">{{ $messages->count() }}</div>
                    <div style="font-size: 11px; color: #1e40af;">رسالة</div>
                </div>
                <div style="text-align: center; padding: 10px; background: #dcfce7; border-radius: 6px;">
                    <div style="font-size: 18px; font-weight: 700; color: #166534;">{{ $conversation->created_at->diffInDays() }}</div>
                    <div style="font-size: 11px; color: #166534;">يوم</div>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <form method="POST" action="{{ route('admin.conversations.destroy', $conversation) }}" 
                  onsubmit="return confirm('هل أنت متأكد من حذف هذه المحادثة؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%;">
                    🗑️ حذف المحادثة
                </button>
            </form>
        </div>
    </div>

    <!-- Messages -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">الرسائل</h3>
            <a href="{{ route('admin.conversations.index') }}" class="btn btn-primary">← العودة للمحادثات</a>
        </div>

        <div style="max-height: 600px; overflow-y: auto; padding: 20px; background: #f8fafc; border-radius: 8px;">
            @forelse($messages as $message)
                <div style="margin-bottom: 20px; display: flex; {{ $message->user_id === $conversation->buyer_id ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }}">
                    <div style="max-width: 70%; {{ $message->user_id === $conversation->buyer_id ? 'background: #3b82f6; color: white;' : 'background: white; color: #1e293b; border: 1px solid #e2e8f0;' }} padding: 12px 16px; border-radius: 16px; position: relative;">
                        <div style="font-size: 11px; margin-bottom: 5px; opacity: 0.8;">
                            {{ $message->user->name }} • {{ $message->created_at->format('H:i') }}
                        </div>
                        <div style="line-height: 1.5;">
                            {{ $message->body }}
                        </div>
                        @if($message->attachment_path)
                            <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.2);">
                                <a href="{{ $message->attachment_path }}" style="color: inherit; text-decoration: underline; font-size: 12px;">
                                    📎 مرفق
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: #64748b;">
                    <div style="font-size: 48px; margin-bottom: 15px;">💬</div>
                    <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد رسائل</h4>
                    <p style="margin: 0; font-size: 14px;">لم يتم تبادل أي رسائل في هذه المحادثة بعد</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
