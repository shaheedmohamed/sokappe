@extends('layouts.app')

@section('title', 'تأكيد قبول العرض')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="margin: 0 0 12px; color: #1e293b; font-size: 28px;">⚠️ تأكيد قبول العرض</h1>
        <p style="margin: 0; color: #64748b; font-size: 16px;">
            هل أنت متأكد من قبول هذا العرض؟ سيتم رفض باقي العروض تلقائياً.
        </p>
    </div>

    <!-- Bid Details -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="margin: 0 0 15px; color: #1e293b; font-size: 20px;">{{ $bid->project->title }}</h2>
        
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <img src="{{ $bid->freelancer->avatar_url }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
            <div>
                <div style="font-weight: 600; color: #1e293b; font-size: 16px;">{{ $bid->freelancer->name }}</div>
                @if($bid->freelancer->profile && $bid->freelancer->profile->title)
                    <div style="color: #64748b; font-size: 14px;">{{ $bid->freelancer->profile->title }}</div>
                @endif
                @if($bid->freelancer->ratings_count > 0)
                    <div style="display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color: {{ $i <= $bid->freelancer->average_rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 14px;">★</span>
                        @endfor
                        <span style="color: #64748b; font-size: 12px; margin-right: 4px;">
                            ({{ $bid->freelancer->ratings_count }})
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 15px; background: #f8fafc; border-radius: 8px;">
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">قيمة العرض</div>
                <div style="color: #10b981; font-weight: 700; font-size: 20px;">
                    ${{ number_format($bid->amount, 2) }}
                </div>
            </div>
            <div>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">مدة التسليم</div>
                <div style="color: #1e293b; font-weight: 600; font-size: 16px;">
                    {{ $bid->delivery_time }} أيام
                </div>
            </div>
        </div>

        @if($bid->message)
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="color: #0369a1; font-weight: 600; margin-bottom: 8px;">رسالة العرض:</div>
                <div style="color: #0c4a6e; line-height: 1.6;">{{ $bid->message }}</div>
            </div>
        @endif
    </div>

    <!-- Warning -->
    <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <div style="display: flex; align-items: start; gap: 12px;">
            <span style="color: #f59e0b; font-size: 24px;">⚠️</span>
            <div>
                <h4 style="margin: 0 0 8px; color: #92400e; font-size: 16px;">تنبيه مهم</h4>
                <ul style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
                    <li>سيتم قبول هذا العرض وبدء العمل على المشروع</li>
                    <li>سيتم رفض جميع العروض الأخرى تلقائياً</li>
                    <li>سيتم تحويل حالة المشروع إلى "قيد التنفيذ"</li>
                    <li>ستتم إعادة توجيهك لصفحة إدارة المشروع</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 15px; justify-content: center;">
        <a href="{{ route('projects.show', $bid->project) }}" 
           style="padding: 12px 30px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #d1d5db;">
            ← إلغاء والعودة
        </a>
        
        <form method="POST" action="{{ route('bids.accept', $bid) }}" style="display: inline;">
            @csrf
            <button type="submit" 
                    style="padding: 12px 30px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                ✅ تأكيد قبول العرض
            </button>
        </form>
    </div>
</div>
@endsection
