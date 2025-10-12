@extends('layouts.admin')

@section('title', 'سجل نشاط المستخدم')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary">
        ← العودة لملف المستخدم
    </a>
</div>

<!-- User Header -->
<div class="admin-card" style="margin-bottom: 30px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px;">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h1 style="margin: 0 0 5px; color: #1e293b; font-size: 24px;">سجل نشاط {{ $user->name }}</h1>
            <div style="color: #64748b; font-size: 14px;">{{ $user->email }} • {{ $activities->count() }} نشاط</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 30px;">
    <!-- Activity Timeline -->
    <div class="admin-card">
        <h3 class="card-title">📊 الخط الزمني للنشاط</h3>
        
        @if($activities->count() > 0)
            <div style="position: relative;">
                <!-- Timeline Line -->
                <div style="position: absolute; left: 30px; top: 0; bottom: 0; width: 2px; background: #e2e8f0;"></div>
                
                @foreach($activities as $activity)
                    <div style="position: relative; padding: 20px 0 20px 70px; border-bottom: 1px solid #f1f5f9;">
                        <!-- Timeline Dot -->
                        <div style="position: absolute; left: 20px; top: 25px; width: 20px; height: 20px; border-radius: 50%; background: {{ $activity['color'] }}; border: 3px solid white; box-shadow: 0 0 0 2px {{ $activity['color'] }}20;"></div>
                        
                        <!-- Activity Content -->
                        <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid {{ $activity['color'] }};">
                            <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 8px;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                        {{ $activity['icon'] }} {{ $activity['title'] }}
                                    </div>
                                    <div style="color: #4b5563; font-size: 14px; line-height: 1.5; margin-bottom: 8px;">
                                        {{ $activity['description'] }}
                                    </div>
                                    
                                    @if(isset($activity['ip']) || isset($activity['location']) || isset($activity['device']))
                                        <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px;">
                                            @if(isset($activity['ip']))
                                                <div style="display: flex; align-items: center; gap: 4px; background: #e0f2fe; padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                                                    <span style="color: #0369a1;">🌐 {{ $activity['ip'] }}</span>
                                                </div>
                                            @endif
                                            @if(isset($activity['location']) && $activity['location'] !== ', ')
                                                <div style="display: flex; align-items: center; gap: 4px; background: #f0fdf4; padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                                                    <span style="color: #166534;">📍 {{ $activity['location'] }}</span>
                                                </div>
                                            @endif
                                            @if(isset($activity['device']))
                                                <div style="display: flex; align-items: center; gap: 4px; background: #fef3c7; padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                                                    <span style="color: #92400e;">{{ $activity['device'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                                <div style="color: #64748b; font-size: 12px;">
                                    📅 {{ $activity['date']->format('Y/m/d H:i') }} 
                                    ({{ $activity['date']->diffForHumans() }})
                                </div>
                                
                                @if(isset($activity['link']))
                                    <a href="{{ $activity['link'] }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 11px;">
                                        👁️ عرض
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <div style="font-size: 64px; margin-bottom: 20px;">📊</div>
                <h4 style="margin: 0 0 12px; color: #1e293b;">لا يوجد نشاط</h4>
                <p style="margin: 0; font-size: 14px;">لم يقم المستخدم بأي نشاط بعد</p>
            </div>
        @endif
    </div>

    <!-- Activity Summary -->
    <div>
        <!-- Activity Stats -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">📈 إحصائيات النشاط</h3>
            <div style="space-y: 12px;">
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">📊 إجمالي الأنشطة:</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $activities->count() }}</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">🔑 تسجيلات الدخول:</span>
                    <span style="font-weight: 600; color: #10b981;">{{ $activities->where('type', 'login')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13px;">🚪 تسجيلات الخروج:</span>
                    <span style="font-weight: 600; color: #f59e0b;">{{ $activities->where('type', 'logout')->count() }}</span>
                </div>
                
                @if($user->role === 'freelancer')
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">⚡ الخدمات:</span>
                        <span style="font-weight: 600; color: #84cc16;">{{ $activities->where('type', 'service_create')->count() }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">💼 العروض:</span>
                        <span style="font-weight: 600; color: #f97316;">{{ $activities->where('type', 'bid_create')->count() }}</span>
                    </div>
                @else
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">📋 المشاريع:</span>
                        <span style="font-weight: 600; color: #06b6d4;">{{ $activities->where('type', 'project_create')->count() }}</span>
                    </div>
                @endif
                
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px;">
                    <span style="color: #64748b; font-size: 13px;">📅 آخر نشاط:</span>
                    <span style="font-weight: 600; color: #10b981;">
                        @if($activities->count() > 0)
                            {{ $activities->first()['date']->diffForHumans() }}
                        @else
                            لا يوجد
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Activity Types -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">🏷️ أنواع النشاط</h3>
            <div style="space-y: 8px;">
                <div style="display: flex; align-items: center; gap: 8px; padding: 8px; background: #f0fdf4; border-radius: 6px;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></div>
                    <span style="font-size: 13px; color: #166534;">👋 انضمام للمنصة</span>
                </div>
                
                @if($user->role === 'freelancer')
                    <div style="display: flex; align-items: center; gap: 8px; padding: 8px; background: #fefce8; border-radius: 6px;">
                        <div style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></div>
                        <span style="font-size: 13px; color: #92400e;">⚡ إضافة خدمات</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; padding: 8px; background: #faf5ff; border-radius: 6px;">
                        <div style="width: 12px; height: 12px; border-radius: 50%; background: #8b5cf6;"></div>
                        <span style="font-size: 13px; color: #7c3aed;">💼 تقديم عروض</span>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 8px; padding: 8px; background: #eff6ff; border-radius: 6px;">
                        <div style="width: 12px; height: 12px; border-radius: 50%; background: #3b82f6;"></div>
                        <span style="font-size: 13px; color: #1e40af;">📋 نشر مشاريع</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-card">
            <h3 class="card-title">⚡ إجراءات سريعة</h3>
            <div style="space-y: 10px;">
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary" style="width: 100%; margin-bottom: 10px; text-decoration: none; display: block; text-align: center;">
                    👤 عرض الملف الشخصي
                </a>
                
                <button class="btn" style="background: #f59e0b; color: white; width: 100%; margin-bottom: 10px;">
                    📧 إرسال رسالة
                </button>
                
                <button class="btn" style="background: #8b5cf6; color: white; width: 100%; margin-bottom: 10px;" onclick="window.print()">
                    🖨️ طباعة التقرير
                </button>
                
                <button class="btn" style="background: #10b981; color: white; width: 100%;" onclick="exportActivity()">
                    📊 تصدير البيانات
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function exportActivity() {
    const data = {
        user: @json($user->name),
        email: @json($user->email),
        total_activities: {{ $activities->count() }},
        export_date: @json(now()->format('Y-m-d H:i:s')),
        activities: []
    };
    
    @if($activities->count() > 0)
        @foreach($activities as $activity)
            data.activities.push({
                type: @json($activity['type']),
                title: @json($activity['title']),
                description: @json($activity['description']),
                date: @json($activity['date']->format('Y-m-d H:i:s'))
            });
        @endforeach
    @endif
    
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'user_activity_{{ $user->id }}_{{ now()->format("Y_m_d") }}.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script>
@endsection
