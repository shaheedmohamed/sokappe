@extends('layouts.admin')

@section('title', 'تفاصيل العرض')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.bids.index') }}" class="btn btn-primary">
        ← العودة للعروض
    </a>
</div>

<!-- Bid Header -->
<div class="admin-card" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0 0 10px; color: #1e293b; font-size: 24px;">عرض على مشروع: {{ $bid->project->title }}</h1>
            <div style="display: flex; gap: 15px; align-items: center;">
                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                    {{ $bid->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : 
                       ($bid->status === 'accepted' ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;') }}">
                    {{ $bid->status === 'pending' ? '⏳ معلق' : ($bid->status === 'accepted' ? '✅ مقبول' : '❌ مرفوض') }}
                </span>
                <span style="color: #64748b; font-size: 14px;">
                    📅 قُدم في {{ $bid->created_at->format('Y/m/d H:i') }}
                </span>
            </div>
        </div>
        <div style="text-align: left;">
            <div style="font-size: 24px; font-weight: 700; color: #10b981; margin-bottom: 5px;">
                {{ number_format($bid->amount) }} ج
            </div>
            <div style="color: #64748b; font-size: 14px;">
                ⏱️ {{ $bid->delivery_days }} يوم للتسليم
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Content -->
    <div>
        <!-- Bid Description -->
        @if($bid->description)
            <div class="admin-card" style="margin-bottom: 30px;">
                <h3 class="card-title">💬 رسالة العرض</h3>
                <div style="line-height: 1.6; color: #374151; font-size: 15px; background: #f8fafc; padding: 20px; border-radius: 8px;">
                    {!! nl2br(e($bid->description)) !!}
                </div>
            </div>
        @endif

        <!-- Project Details -->
        <div class="admin-card" style="margin-bottom: 30px;">
            <h3 class="card-title">📋 تفاصيل المشروع</h3>
            <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                    <div>
                        <h4 style="margin: 0 0 8px; color: #1e293b;">
                            <a href="{{ route('admin.projects.show', $bid->project) }}" style="color: #3b82f6; text-decoration: none;">
                                {{ $bid->project->title }}
                            </a>
                        </h4>
                        <div style="color: #64748b; font-size: 13px;">
                            نُشر بواسطة: 
                            <a href="{{ route('admin.users.show', $bid->project->user) }}" style="color: #3b82f6; text-decoration: none;">
                                {{ $bid->project->user->name }}
                            </a>
                        </div>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-weight: 600; color: #10b981;">
                            {{ number_format($bid->project->budget_min) }} - {{ number_format($bid->project->budget_max) }} ج
                        </div>
                        <div style="color: #64748b; font-size: 12px;">
                            {{ $bid->project->bids->count() }} عرض مقدم
                        </div>
                    </div>
                </div>
                <div style="color: #4b5563; line-height: 1.5; font-size: 14px;">
                    {{ Str::limit($bid->project->description, 200) }}
                </div>
            </div>
        </div>

        <!-- Status Actions -->
        @if($bid->status === 'pending')
            <div class="admin-card">
                <h3 class="card-title">⚡ إجراءات العرض</h3>
                <div style="display: flex; gap: 15px;">
                    <form method="POST" action="{{ route('admin.bids.update-status', $bid) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="btn btn-success" style="padding: 12px 20px;">
                            ✅ قبول العرض
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.bids.update-status', $bid) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger" style="padding: 12px 20px;">
                            ❌ رفض العرض
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Freelancer Info -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">👤 المحترف</h3>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px;">
                    {{ substr($bid->user->name, 0, 1) }}
                </div>
                <div>
                    <a href="{{ route('admin.users.show', $bid->user) }}" style="font-weight: 600; color: #1e293b; text-decoration: none; font-size: 16px;">
                        {{ $bid->user->name }}
                    </a>
                    <div style="color: #64748b; font-size: 13px;">{{ $bid->user->email }}</div>
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 15px; border-radius: 6px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">⚡ الخدمات:</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $bid->user->services->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">💼 العروض المقدمة:</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $bid->user->bids->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">✅ العروض المقبولة:</span>
                    <span style="font-weight: 600; color: #10b981;">{{ $bid->user->bids->where('status', 'accepted')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 13px;">📅 عضو منذ:</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $bid->user->created_at->format('Y/m') }}</span>
                </div>
            </div>
        </div>

        <!-- Bid Comparison -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">📊 مقارنة العروض</h3>
            @php
                $projectBids = $bid->project->bids()->orderBy('amount')->get();
                $bidPosition = $projectBids->search(function($item) use ($bid) {
                    return $item->id === $bid->id;
                }) + 1;
            @endphp
            
            <div style="space-y: 12px;">
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">💼 إجمالي العروض:</span>
                    <span style="font-weight: 600; color: #3b82f6;">{{ $projectBids->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">🏆 ترتيب هذا العرض:</span>
                    <span style="font-weight: 600; color: #f59e0b;">{{ $bidPosition }} من {{ $projectBids->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">💰 أقل عرض:</span>
                    <span style="font-weight: 600; color: #10b981;">{{ number_format($projectBids->min('amount')) }} ج</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px;">
                    <span style="color: #64748b; font-size: 13px;">💰 أعلى عرض:</span>
                    <span style="font-weight: 600; color: #ef4444;">{{ number_format($projectBids->max('amount')) }} ج</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-card">
            <h3 class="card-title">⚡ إجراءات سريعة</h3>
            <div style="space-y: 10px;">
                <a href="{{ route('admin.users.show', $bid->user) }}" class="btn btn-primary" style="width: 100%; margin-bottom: 10px; text-decoration: none; display: block; text-align: center;">
                    👤 ملف المحترف
                </a>
                
                <a href="{{ route('admin.projects.show', $bid->project) }}" class="btn btn-success" style="width: 100%; margin-bottom: 10px; text-decoration: none; display: block; text-align: center;">
                    📋 تفاصيل المشروع
                </a>
                
                <button class="btn" style="background: #f59e0b; color: white; width: 100%; margin-bottom: 10px;">
                    📧 إرسال رسالة
                </button>
                
                <form method="POST" action="{{ route('admin.bids.destroy', $bid) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا العرض؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        🗑️ حذف العرض
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
