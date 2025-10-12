@extends('layouts.app')

@section('title', 'إدارة المشروع')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
            <div>
                <h1 style="margin: 0 0 8px; color: #1e293b; font-size: 24px;">🎯 إدارة المشروع</h1>
                <h2 style="margin: 0 0 12px; color: #3b82f6; font-size: 20px;">{{ $management->project->title }}</h2>
                <p style="margin: 0; color: #64748b; line-height: 1.6;">
                    {{ Str::limit($management->project->description, 200) }}
                </p>
            </div>
            
            <!-- Status Badge -->
            <div>
                @if($management->status === 'in_progress')
                    <span style="background: #fef3c7; color: #92400e; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                        🟡 قيد التنفيذ
                    </span>
                @elseif($management->status === 'delivered')
                    <span style="background: #dbeafe; color: #1e40af; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                        📦 تم التسليم
                    </span>
                @elseif($management->status === 'completed')
                    <span style="background: #dcfce7; color: #166534; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                        ✅ مكتمل
                    </span>
                @endif
            </div>
        </div>

        <!-- Project Details -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">العميل</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img src="{{ $management->client->avatar_url }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                    <span style="font-weight: 600; color: #1e293b;">{{ $management->client->name }}</span>
                </div>
            </div>
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">المحترف</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img src="{{ $management->freelancer->avatar_url }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                    <span style="font-weight: 600; color: #1e293b;">{{ $management->freelancer->name }}</span>
                </div>
            </div>
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">قيمة المشروع</div>
                <div style="color: #10b981; font-weight: 700; font-size: 16px;">
                    ${{ number_format($management->acceptedBid->amount, 2) }}
                </div>
            </div>
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">مدة التسليم</div>
                <div style="color: #1e293b; font-weight: 600;">
                    {{ $management->acceptedBid->delivery_time }} أيام
                </div>
            </div>
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">تاريخ البدء</div>
                <div style="color: #1e293b; font-weight: 600;">
                    {{ $management->started_at->format('d/m/Y') }}
                </div>
            </div>
            @if($management->delivered_at)
                <div>
                    <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">تاريخ التسليم</div>
                    <div style="color: #1e293b; font-weight: 600;">
                        {{ $management->delivered_at->format('d/m/Y') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px;">
        <!-- Chat Section -->
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="background: #f8fafc; padding: 20px; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; color: #1e293b; font-size: 18px;">💬 محادثة إدارة المشروع</h3>
                <p style="margin: 5px 0 0; color: #64748b; font-size: 14px;">جميع الاتفاقيات والمناقشات الخاصة بالمشروع</p>
            </div>

            <!-- Messages -->
            <div id="messages-container" style="height: 400px; overflow-y: auto; padding: 20px; background: #f8fafc;">
                @foreach($conversation->messages as $message)
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
                        <div style="margin-bottom: 20px; display: flex; {{ $message->sender_id === Auth::id() ? 'justify-content: flex-end' : 'justify-content: flex-start' }};">
                            <div style="max-width: 70%; {{ $message->sender_id === Auth::id() ? 'margin-left: 50px' : 'margin-right: 50px' }};">
                                <div style="display: flex; align-items: start; gap: 10px; {{ $message->sender_id === Auth::id() ? 'flex-direction: row-reverse' : '' }};">
                                    <img src="{{ $message->sender->avatar_url }}" 
                                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                                    
                                    <div style="flex: 1;">
                                        <div style="font-size: 12px; color: #64748b; margin-bottom: 5px; {{ $message->sender_id === Auth::id() ? 'text-align: left' : 'text-align: right' }};">
                                            {{ $message->sender->name }}
                                        </div>
                                        
                                        <div style="background: {{ $message->sender_id === Auth::id() ? '#3b82f6' : 'white' }}; 
                                                   color: {{ $message->sender_id === Auth::id() ? 'white' : '#1e293b' }}; 
                                                   padding: 12px 16px; 
                                                   border-radius: {{ $message->sender_id === Auth::id() ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }}; 
                                                   word-wrap: break-word; 
                                                   line-height: 1.5;
                                                   border: {{ $message->sender_id === Auth::id() ? 'none' : '1px solid #e5e7eb' }};">
                                            {{ $message->message }}
                                        </div>
                                        
                                        <div style="margin-top: 5px; font-size: 11px; color: #94a3b8; {{ $message->sender_id === Auth::id() ? 'text-align: left' : 'text-align: right' }};">
                                            {{ $message->created_at->format('H:i d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Message Input -->
            @if($management->status !== 'completed')
                <div style="padding: 20px; border-top: 1px solid #e5e7eb; background: white;">
                    <form method="POST" action="{{ route('projects.message', $management->project) }}">
                        @csrf
                        <div style="display: flex; gap: 12px; align-items: end;">
                            <div style="flex: 1;">
                                <textarea name="message" required rows="2" placeholder="اكتب رسالتك هنا..."
                                          style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
                            </div>
                            <button type="submit" 
                                    style="background: #3b82f6; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                إرسال
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- Actions Panel -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Delivery Action -->
            @if(Auth::id() === $management->freelancer_id && $management->canBeDelivered())
                <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h4 style="margin: 0 0 12px; color: #1e293b; font-size: 16px;">📦 تسليم المشروع</h4>
                    <p style="margin: 0 0 15px; color: #64748b; font-size: 14px; line-height: 1.5;">
                        عند الانتهاء من العمل، اضغط على زر التسليم لإرسال المشروع للعميل للمراجعة والتقييم.
                    </p>
                    <form method="POST" action="{{ route('projects.deliver', $management->project) }}">
                        @csrf
                        <button type="submit" 
                                style="width: 100%; background: #10b981; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;"
                                onclick="return confirm('هل أنت متأكد من تسليم المشروع؟')">
                            🚀 تسليم المشروع
                        </button>
                    </form>
                </div>
            @endif

            <!-- Rating Action -->
            @if(Auth::id() === $management->client_id && $management->isDelivered() && !$rating)
                <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h4 style="margin: 0 0 12px; color: #1e293b; font-size: 16px;">⭐ تقييم المشروع</h4>
                    <p style="margin: 0 0 15px; color: #64748b; font-size: 14px; line-height: 1.5;">
                        تم تسليم المشروع! يرجى مراجعة العمل وتقييم أداء المحترف.
                    </p>
                    <a href="{{ route('projects.rate', $management->project) }}" 
                       style="display: block; width: 100%; background: #f59e0b; color: white; text-decoration: none; text-align: center; padding: 12px 20px; border-radius: 8px; font-weight: 600;">
                        ⭐ تقييم الأداء
                    </a>
                </div>
            @endif

            <!-- Project Completed -->
            @if($management->isCompleted())
                <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h4 style="margin: 0 0 12px; color: #166534; font-size: 16px;">✅ المشروع مكتمل</h4>
                    <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.5;">
                        تم إنهاء المشروع بنجاح وتقييم الأداء. شكراً لكم على التعاون!
                    </p>
                    @if($rating)
                        <div style="margin-top: 15px; padding: 12px; background: #f0fdf4; border-radius: 8px; border: 1px solid #bbf7d0;">
                            <div style="color: #166534; font-weight: 600; margin-bottom: 5px;">
                                التقييم العام: {{ $rating->overall_rating }}/5 ⭐
                            </div>
                            @if($rating->comment)
                                <div style="color: #15803d; font-size: 13px;">
                                    "{{ $rating->comment }}"
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            <!-- Project Info -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h4 style="margin: 0 0 15px; color: #1e293b; font-size: 16px;">📋 معلومات المشروع</h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">الميزانية الأصلية</div>
                        <div style="color: #1e293b; font-weight: 600;">
                            ${{ number_format($management->project->budget_min, 2) }} - ${{ number_format($management->project->budget_max, 2) }}
                        </div>
                    </div>
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">المدة المتوقعة</div>
                        <div style="color: #1e293b; font-weight: 600;">
                            {{ $management->project->duration }} أيام
                        </div>
                    </div>
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">تاريخ النشر</div>
                        <div style="color: #1e293b; font-weight: 600;">
                            {{ $management->project->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('projects.show', $management->project) }}" 
                       style="color: #3b82f6; text-decoration: none; font-size: 14px;">
                        ← العودة لصفحة المشروع
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto scroll to bottom of messages
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
});
</script>
@endsection
