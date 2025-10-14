@extends('layouts.app')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>📊 لوحة التحكم</h1>
        <p>مرحباً {{ Auth::user()->name }}، إليك ملخص نشاطك</p>
    </div>
    
    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px;">
        <!-- Wallet Balance -->
        <div style="background: linear-gradient(135deg, #10b981, #059669); padding: 20px; border-radius: 12px; text-align: center; color: white; position: relative;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">${{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}</div>
            <div style="font-size: 14px; font-weight: 600;">رصيد المحفظة (USD)</div>
            <a href="{{ route('wallet.index') }}" style="position: absolute; top: 10px; left: 10px; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 18px;">💰</a>
        </div>
        
        <div style="background: linear-gradient(135deg, #dbeafe, #3b82f6); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ $myBids->count() }}</div>
            <div style="font-size: 14px; font-weight: 600;">العروض المقدمة</div>
        </div>
        <div style="background: linear-gradient(135deg, #dcfce7, #10b981); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ $myBids->where('status', 'accepted')->count() }}</div>
            <div style="font-size: 14px; font-weight: 600;">العروض المقبولة</div>
        </div>
        <div style="background: linear-gradient(135deg, #fef3c7, #fbbf24); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 28px; font-weight: 800; color: #92400e; margin-bottom: 4px;">{{ $myBids->where('status', 'pending')->count() }}</div>
            <div style="color: #92400e; font-size: 14px; font-weight: 600;">في الانتظار</div>
        </div>
        <div style="background: linear-gradient(135deg, #fce7f3, #ec4899); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ number_format($myBids->where('status', 'accepted')->sum('amount')) }}</div>
            <div style="font-size: 14px; font-weight: 600;">إجمالي الأرباح (ج)</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display: flex; gap: 15px; margin-bottom: 32px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('wallet.index') }}" style="padding: 12px 24px; background: linear-gradient(45deg, #10b981, #059669); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            💰 إدارة المحفظة
        </a>
        <a href="{{ route('wallet.deposit') }}" style="padding: 12px 24px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            💳 شحن الرصيد
        </a>
        @if(Auth::user()->wallet && Auth::user()->wallet->balance >= 50)
        <a href="{{ route('wallet.withdraw') }}" style="padding: 12px 24px; background: linear-gradient(45deg, #ef4444, #dc2626); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            🏦 سحب الرصيد
        </a>
        @endif
    </div>

    <!-- My Bids Section -->
    <div class="form-card">
        <h2 style="margin: 0 0 24px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
            💼 العروض المقدمة
        </h2>
        
        @forelse($myBids as $bid)
            <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 16px; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 8px; color: var(--dark); font-size: 18px;">
                            <a href="{{ route('projects.show', $bid->project) }}" style="color: inherit; text-decoration: none;">
                                {{ $bid->project->title }}
                            </a>
                        </h3>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                            @if($bid->status === 'pending')
                                <span style="background: var(--warning); color: white; padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 600;">
                                    ⏳ في الانتظار
                                </span>
                            @elseif($bid->status === 'accepted')
                                <span style="background: var(--secondary); color: white; padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 600;">
                                    ✅ مقبول
                                </span>
                            @else
                                <span style="background: var(--danger); color: white; padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 600;">
                                    ❌ مرفوض
                                </span>
                            @endif
                            <span style="color: var(--muted); font-size: 14px;">
                                قُدم {{ $bid->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div style="text-align: left; margin-right: 16px;">
                        <div style="font-size: 20px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">
                            {{ number_format($bid->amount) }} ج
                        </div>
                        <div style="font-size: 12px; color: var(--muted);">
                            خلال {{ $bid->delivery_time }} أيام
                        </div>
                    </div>
                </div>

                @if($bid->message)
                    <div style="background: var(--gray-50); padding: 12px; border-radius: 8px; margin-bottom: 12px;">
                        <p style="margin: 0; color: var(--muted); font-size: 14px; line-height: 1.5;">
                            {{ Str::limit($bid->message, 150) }}
                        </p>
                    </div>
                @endif

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--muted);">
                    <span>ميزانية المشروع: {{ $bid->project->budget_min }} - {{ $bid->project->budget_max }} ج</span>
                    <a href="{{ route('projects.show', $bid->project) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                        عرض المشروع →
                    </a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px 20px; color: var(--muted);">
                <div style="font-size: 64px; margin-bottom: 24px;">💼</div>
                <h3 style="margin: 0 0 12px; color: var(--dark);">لم تقدم أي عروض بعد</h3>
                <p style="margin: 0 0 24px; font-size: 16px;">ابدأ في تقديم عروضك على المشاريع المتاحة</p>
                <a href="{{ route('projects.index') }}" class="btn btn-primary" style="text-decoration: none;">
                    تصفح المشاريع
                </a>
            </div>
        @endforelse
    </div>

    <!-- Quick Actions -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 32px;">
        <a href="{{ route('projects.index') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 48px; margin-bottom: 12px;">📋</div>
            <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">تصفح المشاريع</h3>
            <p style="margin: 0; opacity: 0.9; font-size: 14px;">ابحث عن مشاريع جديدة</p>
        </a>
        
        <a href="{{ route('profile.edit') }}" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 48px; margin-bottom: 12px;">👤</div>
            <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">ملفي الشخصي</h3>
            <p style="margin: 0; opacity: 0.9; font-size: 14px;">عرض وتحديث البيانات</p>
        </a>
        
        @if(Auth::user()->role === 'freelancer')
            <a href="{{ route('services.create.new') }}" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 48px; margin-bottom: 12px;">⚡</div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">اعرض خدمة</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">أضف خدمة جديدة</p>
            </a>
        @else
            <a href="{{ route('projects.create.new') }}" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 48px; margin-bottom: 12px;">✍️</div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">أنشئ مشروع</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">انشر مشروع جديد</p>
            </a>
        @endif
    </div>
</div>
@endsection
