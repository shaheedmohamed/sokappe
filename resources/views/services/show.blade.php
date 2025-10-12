@extends('layouts.app')

@section('title', $service->title)

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('services.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px;">
            ← العودة للخدمات
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        <!-- Main Content -->
        <div>
            <!-- Service Header -->
            <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h1 style="margin: 0 0 20px; color: #1e293b; font-size: 28px; line-height: 1.3;">
                    {{ $service->title }}
                </h1>
                
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
                @endif
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px; padding: 15px; background: #f8fafc; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10b981; font-size: 18px;">💰</span>
                        <span style="color: #64748b;">السعر:</span>
                        <span style="font-weight: 700; color: #1e293b; font-size: 20px;">${{ number_format($service->price, 2) }}</span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #3b82f6; font-size: 18px;">⏱️</span>
                        <span style="color: #64748b;">مدة التسليم:</span>
                        <span style="font-weight: 600; color: #1e293b;">{{ $service->delivery_time }} أيام</span>
                    </div>
                    
                    @if($service->category)
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #f59e0b; font-size: 18px;">🏷️</span>
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                {{ $service->category }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Service Description -->
            <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                    📝 وصف الخدمة
                </h2>
                <div style="color: #374151; line-height: 1.7; font-size: 15px; white-space: pre-line;">{{ $service->description }}</div>
            </div>

            <!-- What You Get -->
            @if($service->features && count($service->features) > 0)
                <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        ✅ ما ستحصل عليه
                    </h2>
                    <ul style="margin: 0; padding: 0; list-style: none;">
                        @foreach($service->features as $feature)
                            <li style="display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                                <span style="color: #10b981; font-size: 16px;">✓</span>
                                <span style="color: #374151;">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Requirements -->
            @if($service->requirements)
                <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        📋 متطلبات العمل
                    </h2>
                    <div style="color: #374151; line-height: 1.7; font-size: 15px; white-space: pre-line;">{{ $service->requirements }}</div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Provider Info -->
            <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">👤 مقدم الخدمة</h3>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <img src="{{ $service->user->avatar_url }}" 
                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h4 style="margin: 0 0 3px; color: #1e293b; font-size: 16px;">
                            <a href="{{ route('profile.show', $service->user) }}" style="color: #3b82f6; text-decoration: none;">
                                {{ $service->user->name }}
                            </a>
                        </h4>
                        @if($service->user->profile && $service->user->profile->title)
                            <p style="margin: 0; color: #64748b; font-size: 13px;">{{ $service->user->profile->title }}</p>
                        @endif
                    </div>
                </div>
                
                @if($service->user->ratings_count > 0)
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                        <div style="display: flex; align-items: center; gap: 2px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color: {{ $i <= $service->user->average_rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 14px;">★</span>
                            @endfor
                        </div>
                        <span style="font-weight: 600; color: #1e293b; font-size: 14px;">{{ number_format($service->user->average_rating, 1) }}</span>
                        <span style="color: #64748b; font-size: 12px;">({{ $service->user->ratings_count }} تقييم)</span>
                    </div>
                @endif
                
                <a href="{{ route('profile.show', $service->user) }}" 
                   style="display: block; width: 100%; padding: 10px; background: #f8fafc; color: #3b82f6; text-decoration: none; border-radius: 6px; text-align: center; font-weight: 600; border: 1px solid #e2e8f0;">
                    عرض الملف الشخصي
                </a>
            </div>

            <!-- Order Box -->
            <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: 2px solid #10b981;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="font-size: 32px; font-weight: 700; color: #10b981; margin-bottom: 5px;">
                        ${{ number_format($service->price, 2) }}
                    </div>
                    <div style="color: #64748b; font-size: 14px;">
                        التسليم خلال {{ $service->delivery_time }} أيام
                    </div>
                </div>
                
                @auth
                    @if(Auth::id() !== $service->user_id)
                        <button onclick="orderService()" 
                                style="width: 100%; padding: 15px; background: #10b981; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-bottom: 10px;">
                            🛒 اطلب الخدمة الآن
                        </button>
                        
                        <button onclick="contactProvider()" 
                                style="width: 100%; padding: 12px; background: transparent; color: #3b82f6; border: 2px solid #3b82f6; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                            💬 تواصل مع البائع
                        </button>
                    @else
                        <div style="text-align: center; padding: 15px; background: #f1f5f9; border-radius: 8px; color: #64748b;">
                            هذه خدمتك الخاصة
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" 
                       style="display: block; width: 100%; padding: 15px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 600; text-align: center; margin-bottom: 10px;">
                        🔑 سجل دخولك لطلب الخدمة
                    </a>
                @endauth
            </div>

            <!-- Service Stats -->
            <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 18px;">📊 إحصائيات الخدمة</h3>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b;">تاريخ النشر</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $service->created_at->format('d/m/Y') }}</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b;">مدة التسليم</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $service->delivery_time }} أيام</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b;">السعر</span>
                    <span style="font-weight: 600; color: #10b981; font-size: 18px;">${{ number_format($service->price, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function orderService() {
    alert('سيتم إضافة نظام طلب الخدمات قريباً!');
}

function contactProvider() {
    alert('سيتم إضافة نظام المراسلة قريباً!');
}
</script>
@endsection
