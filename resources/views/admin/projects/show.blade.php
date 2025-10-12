@extends('layouts.admin')

@section('title', 'تفاصيل المشروع')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">
        ← العودة للمشاريع
    </a>
</div>

<!-- Project Header -->
<div class="admin-card" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0 0 10px; color: #1e293b; font-size: 24px;">{{ $project->title }}</h1>
            <div style="display: flex; gap: 15px; align-items: center;">
                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                    {{ $project->status === 'open' ? 'background: #dcfce7; color: #166534;' : 
                       ($project->status === 'in_progress' ? 'background: #fef3c7; color: #92400e;' : 'background: #f3f4f6; color: #374151;') }}">
                    {{ $project->status === 'open' ? '🟢 مفتوح' : ($project->status === 'in_progress' ? '🟡 قيد التنفيذ' : '✅ مكتمل') }}
                </span>
                <span style="color: #64748b; font-size: 14px;">
                    📅 نُشر في {{ $project->created_at->format('Y/m/d') }}
                </span>
                <span style="color: #64748b; font-size: 14px;">
                    🏷️ {{ $project->category }}
                </span>
            </div>
        </div>
        <div style="text-align: left;">
            <div style="font-size: 20px; font-weight: 700; color: #10b981; margin-bottom: 5px;">
                ${{ number_format($project->budget_min, 2) }} - ${{ number_format($project->budget_max, 2) }}
            </div>
            @if($project->duration || $project->duration_days)
                <div style="color: #64748b; font-size: 14px;">
                    ⏱️ 
                    @if($project->duration_days)
                        {{ $project->duration_days }} يوم
                    @endif
                    @if($project->duration && $project->duration_days)
                        ({{ $project->duration }})
                    @elseif($project->duration)
                        {{ $project->duration }}
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Content -->
    <div>
        <!-- Project Description -->
        <div class="admin-card" style="margin-bottom: 30px;">
            <h3 class="card-title">📋 وصف المشروع</h3>
            <div style="line-height: 1.6; color: #374151; font-size: 15px;">
                {!! nl2br(e($project->description)) !!}
            </div>
        </div>

        <!-- Skills Required -->
        @if($project->skills && $project->skills->count() > 0)
            <div class="admin-card" style="margin-bottom: 30px;">
                <h3 class="card-title">🛠️ المهارات المطلوبة</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach($project->skills as $skill)
                        <span style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 16px; font-size: 13px; font-weight: 500;">
                            {{ $skill->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Bids Section -->
        <div class="admin-card">
            <div class="card-header">
                <h3 class="card-title">💼 العروض المقدمة ({{ $project->bids->count() }})</h3>
                <div style="display: flex; gap: 10px;">
                    <select style="padding: 6px 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 12px;">
                        <option>جميع العروض</option>
                        <option>معلقة</option>
                        <option>مقبولة</option>
                        <option>مرفوضة</option>
                    </select>
                </div>
            </div>

            @forelse($project->bids as $bid)
                <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 15px; 
                    {{ $bid->status === 'accepted' ? 'background: #f0fdf4; border-color: #22c55e;' : 
                       ($bid->status === 'rejected' ? 'background: #fef2f2; border-color: #ef4444;' : 'background: #fefce8; border-color: #eab308;') }}">
                    
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px;">
                                {{ substr($bid->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1e293b; font-size: 16px;">{{ $bid->user->name }}</div>
                                <div style="color: #64748b; font-size: 13px;">{{ $bid->user->email }}</div>
                                <div style="color: #64748b; font-size: 12px;">عضو منذ {{ $bid->user->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        
                        <div style="text-align: left;">
                            <div style="font-size: 20px; font-weight: 700; color: #10b981; margin-bottom: 5px;">
                                ${{ number_format($bid->amount, 2) }}
                            </div>
                            <div style="color: #64748b; font-size: 13px; margin-bottom: 5px;">
                                ⏱️ {{ $bid->delivery_days }} يوم
                            </div>
                            <span style="padding: 3px 8px; border-radius: 10px; font-size: 11px; font-weight: 600;
                                {{ $bid->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : 
                                   ($bid->status === 'accepted' ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;') }}">
                                {{ $bid->status === 'pending' ? '⏳ معلق' : ($bid->status === 'accepted' ? '✅ مقبول' : '❌ مرفوض') }}
                            </span>
                        </div>
                    </div>

                    @if($bid->description)
                        <div style="background: rgba(255,255,255,0.7); padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                            <div style="font-weight: 600; color: #374151; margin-bottom: 8px;">💬 رسالة العرض:</div>
                            <div style="color: #4b5563; line-height: 1.5; font-size: 14px;">
                                {!! nl2br(e($bid->description)) !!}
                            </div>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="color: #64748b; font-size: 12px;">
                            📅 قُدم في {{ $bid->created_at->format('Y/m/d H:i') }}
                        </div>
                        
                        <div style="display: flex; gap: 8px;">
                            @if($bid->status === 'pending')
                                <button class="btn btn-success" style="padding: 6px 12px; font-size: 12px;">
                                    ✅ قبول
                                </button>
                                <button class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                    ❌ رفض
                                </button>
                            @endif
                            <button class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                                👁️ عرض الملف الشخصي
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                    <div style="font-size: 64px; margin-bottom: 20px;">💼</div>
                    <h4 style="margin: 0 0 12px; color: #1e293b;">لا توجد عروض بعد</h4>
                    <p style="margin: 0; font-size: 14px;">لم يتم تقديم أي عروض على هذا المشروع</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Project Owner -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">👤 صاحب المشروع</h3>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px;">
                    {{ substr($project->user->name, 0, 1) }}
                </div>
                <div>
                    <div style="font-weight: 600; color: #1e293b;">{{ $project->user->name }}</div>
                    <div style="color: #64748b; font-size: 13px;">{{ $project->user->email }}</div>
                </div>
            </div>
            <div style="background: #f8fafc; padding: 12px; border-radius: 6px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">المشاريع المنشورة:</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $project->user->projects->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">تاريخ الانضمام:</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $project->user->created_at->format('Y/m') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 13px;">الحالة:</span>
                    <span style="padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; background: #dcfce7; color: #166534;">
                        {{ $project->user->is_active ? '🟢 نشط' : '🔴 معطل' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Project Stats -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">📊 إحصائيات المشروع</h3>
            <div style="space-y: 12px;">
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">💼 العروض المقدمة:</span>
                    <span style="font-weight: 600; color: #3b82f6;">{{ $project->bids->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">⏳ العروض المعلقة:</span>
                    <span style="font-weight: 600; color: #f59e0b;">{{ $project->bids->where('status', 'pending')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">✅ العروض المقبولة:</span>
                    <span style="font-weight: 600; color: #10b981;">{{ $project->bids->where('status', 'accepted')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px;">
                    <span style="color: #64748b; font-size: 13px;">👁️ المشاهدات:</span>
                    <span style="font-weight: 600; color: #8b5cf6;">{{ $project->views ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-card">
            <h3 class="card-title">⚡ إجراءات سريعة</h3>
            <div style="space-y: 10px;">
                <button class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                    ✏️ تعديل المشروع
                </button>
                <button class="btn" style="background: #f59e0b; color: white; width: 100%; margin-bottom: 10px;">
                    📧 إرسال رسالة للعميل
                </button>
                <button class="btn" style="background: #8b5cf6; color: white; width: 100%; margin-bottom: 10px;">
                    📊 عرض التحليلات
                </button>
                <button class="btn btn-danger" style="width: 100%;">
                    🗑️ حذف المشروع
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
