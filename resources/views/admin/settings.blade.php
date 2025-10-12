@extends('layouts.admin')

@section('title', 'إعدادات النظام')

@section('content')
<!-- Real-time Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
    <div class="admin-card" style="text-align: center; padding: 20px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
        <div style="font-size: 32px; font-weight: 800; margin-bottom: 8px;">
            {{ $systemStats['total_users'] }}
        </div>
        <div style="font-size: 14px; opacity: 0.9;">إجمالي المستخدمين</div>
        <div style="font-size: 12px; opacity: 0.7; margin-top: 4px;">
            {{ $systemStats['active_users'] }} نشط
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 20px; background: linear-gradient(135deg, #10b981, #059669); color: white;">
        <div style="font-size: 32px; font-weight: 800; margin-bottom: 8px;">
            {{ $systemStats['total_projects'] }}
        </div>
        <div style="font-size: 14px; opacity: 0.9;">إجمالي المشاريع</div>
        <div style="font-size: 12px; opacity: 0.7; margin-top: 4px;">
            {{ $systemStats['active_projects'] }} مفتوح
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 20px; background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
        <div style="font-size: 32px; font-weight: 800; margin-bottom: 8px;">
            {{ $systemStats['total_services'] }}
        </div>
        <div style="font-size: 14px; opacity: 0.9;">إجمالي الخدمات</div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 20px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
        <div style="font-size: 32px; font-weight: 800; margin-bottom: 8px;">
            {{ $systemStats['total_conversations'] }}
        </div>
        <div style="font-size: 14px; opacity: 0.9;">المحادثات النشطة</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <!-- System Information -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">معلومات النظام</h3>
            <button onclick="location.reload()" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                🔄 تحديث
            </button>
        </div>
        <div style="space-y: 15px;">
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">📊 حجم قاعدة البيانات:</span>
                <span style="color: #3b82f6; font-weight: 600;">{{ $systemStats['database_size'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">💾 حجم الكاش:</span>
                <span style="color: #10b981; font-weight: 600;">{{ $systemStats['cache_size'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">🕐 وقت الخادم:</span>
                <span style="color: #f59e0b; font-weight: 600;">{{ now()->format('H:i:s') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">📅 تاريخ اليوم:</span>
                <span style="color: #8b5cf6; font-weight: 600;">{{ now()->format('Y-m-d') }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">النشاط الحديث</h3>
        </div>
        <div style="space-y: 15px;">
            <div style="padding: 15px; background: #f0f9ff; border-radius: 8px; border-left: 4px solid #3b82f6; margin-bottom: 15px;">
                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">📈 اليوم</div>
                <div style="font-size: 13px; color: #64748b;">
                    {{ $recentActivity['users_today'] }} مستخدم جديد • 
                    {{ $recentActivity['projects_today'] }} مشروع • 
                    {{ $recentActivity['services_today'] }} خدمة
                </div>
            </div>
            
            <div style="padding: 15px; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #10b981; margin-bottom: 15px;">
                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">📊 هذا الأسبوع</div>
                <div style="font-size: 13px; color: #64748b;">
                    {{ $recentActivity['users_this_week'] }} مستخدم جديد • 
                    {{ $recentActivity['projects_this_week'] }} مشروع جديد
                </div>
            </div>

            <div style="padding: 15px; background: #fefce8; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 15px;">
                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">⚡ الأداء</div>
                <div style="font-size: 13px; color: #64748b;">
                    النظام يعمل بكفاءة عالية
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Actions -->
<div class="admin-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3 class="card-title">إجراءات النظام</h3>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <form method="POST" action="{{ route('admin.settings.clear-cache') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; text-align: center;">
                <div style="font-size: 24px; margin-bottom: 10px;">🔄</div>
                مسح الكاش
            </button>
        </form>
        
        <a href="{{ route('admin.settings.export-data') }}" class="btn" style="background: #f59e0b; color: white; padding: 20px; text-align: center; text-decoration: none; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">📊</div>
            تصدير البيانات
        </a>
        
        <button onclick="window.open('{{ route('admin.analytics') }}', '_blank')" class="btn" style="background: #8b5cf6; color: white; padding: 20px; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 10px;">📈</div>
            عرض التحليلات
        </button>
        
        <button onclick="if(confirm('هل أنت متأكد؟')) location.reload()" class="btn" style="background: #6b7280; color: white; padding: 20px; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 10px;">🔄</div>
            إعادة تحميل
        </button>
    </div>
</div>

<!-- Auto-refresh every 10 seconds -->
<script>
setInterval(() => {
    // Update time display
    const timeElements = document.querySelectorAll('[data-time]');
    timeElements.forEach(el => {
        el.textContent = new Date().toLocaleTimeString('ar-EG');
    });
}, 1000);

// Auto-refresh page every 30 seconds
setInterval(() => {
    location.reload();
}, 30000);
</script>
@endsection
