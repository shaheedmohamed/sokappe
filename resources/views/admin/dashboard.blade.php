@extends('layouts.admin')

@section('title', 'لوحة التحكم الرئيسية')

@section('content')
<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="admin-card" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 32px; font-weight: 800; margin: 0;">{{ $stats['total_users'] }}</h3>
                <p style="margin: 5px 0 0; opacity: 0.9;">إجمالي المستخدمين</p>
                <small style="opacity: 0.7;">+{{ $stats['new_users_today'] }} اليوم</small>
            </div>
            <div style="font-size: 48px; opacity: 0.3;">👥</div>
        </div>
    </div>

    <div class="admin-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 32px; font-weight: 800; margin: 0;">{{ $stats['total_projects'] }}</h3>
                <p style="margin: 5px 0 0; opacity: 0.9;">إجمالي المشاريع</p>
                <small style="opacity: 0.7;">{{ $stats['active_projects'] }} نشط</small>
            </div>
            <div style="font-size: 48px; opacity: 0.3;">📋</div>
        </div>
    </div>

    <div class="admin-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 32px; font-weight: 800; margin: 0;">{{ $stats['total_services'] }}</h3>
                <p style="margin: 5px 0 0; opacity: 0.9;">إجمالي الخدمات</p>
            </div>
            <div style="font-size: 48px; opacity: 0.3;">⚡</div>
        </div>
    </div>

    <div class="admin-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 32px; font-weight: 800; margin: 0;">{{ $stats['total_conversations'] }}</h3>
                <p style="margin: 5px 0 0; opacity: 0.9;">المحادثات النشطة</p>
            </div>
            <div style="font-size: 48px; opacity: 0.3;">💬</div>
        </div>
    </div>

    <div class="admin-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 32px; font-weight: 800; margin: 0;">${{ number_format($stats['total_transactions_volume'] ?? 0, 0) }}</h3>
                <p style="margin: 5px 0 0; opacity: 0.9;">حجم المعاملات</p>
                <small style="opacity: 0.7;">{{ $stats['pending_transactions'] ?? 0 }} معلقة</small>
            </div>
            <div style="font-size: 48px; opacity: 0.3;">💳</div>
        </div>
    </div>

    <div class="admin-card" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 32px; font-weight: 800; margin: 0;">{{ $stats['pending_withdrawals'] ?? 0 }}</h3>
                <p style="margin: 5px 0 0; opacity: 0.9;">طلبات سحب معلقة</p>
                <small style="opacity: 0.7;">تحتاج مراجعة</small>
            </div>
            <div style="font-size: 48px; opacity: 0.3;">🏦</div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <!-- Recent Users -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">المستخدمين الجدد</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">عرض الكل</a>
        </div>
        <div style="space-y: 15px;">
            @forelse($recent_users as $user)
                <div style="display: flex; align-items: center; padding: 12px; border-radius: 8px; background: #f8fafc; margin-bottom: 10px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; margin-left: 15px;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                        <div style="font-size: 12px; color: #64748b;">{{ $user->email }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ $user->created_at->diffForHumans() }}</div>
                    </div>
                    <div style="padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: 600; 
                        {{ $user->role === 'admin' ? 'background: #fef3c7; color: #92400e;' : 
                           ($user->role === 'freelancer' ? 'background: #dcfce7; color: #166534;' : 'background: #dbeafe; color: #1e40af;') }}">
                        {{ $user->role === 'admin' ? 'مدير' : ($user->role === 'freelancer' ? 'محترف' : 'عميل') }}
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #64748b; padding: 20px;">لا توجد مستخدمين جدد</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">المشاريع الحديثة</h3>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">عرض الكل</a>
        </div>
        <div>
            @forelse($recent_projects as $project)
                <div style="padding: 15px; border-bottom: 1px solid #f1f5f9; margin-bottom: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                        <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #1e293b;">
                            {{ Str::limit($project->title, 40) }}
                        </h4>
                        <span style="padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600;
                            {{ $project->status === 'open' ? 'background: #dcfce7; color: #166534;' : 
                               ($project->status === 'in_progress' ? 'background: #fef3c7; color: #92400e;' : 'background: #f3f4f6; color: #374151;') }}">
                            {{ $project->status === 'open' ? 'مفتوح' : ($project->status === 'in_progress' ? 'قيد التنفيذ' : 'مكتمل') }}
                        </span>
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 5px;">
                        بواسطة: {{ $project->user->name }}
                    </div>
                    <div style="font-size: 12px; color: #10b981; font-weight: 600;">
                        {{ number_format($project->budget_min) }} - {{ number_format($project->budget_max) }} ج
                    </div>
                    <div style="font-size: 11px; color: #94a3b8; margin-top: 5px;">
                        {{ $project->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #64748b; padding: 20px;">لا توجد مشاريع حديثة</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3 class="card-title">إجراءات سريعة</h3>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="padding: 20px; text-align: center; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">👥</div>
            إدارة المستخدمين
        </a>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-success" style="padding: 20px; text-align: center; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">📋</div>
            إدارة المشاريع
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="btn" style="background: #ef4444; color: white; padding: 20px; text-align: center; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">💳</div>
            المعاملات المالية
        </a>
        <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="btn" style="background: #f59e0b; color: white; padding: 20px; text-align: center; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">⏳</div>
            المعاملات المعلقة
        </a>
        <a href="{{ route('admin.conversations.index') }}" class="btn" style="background: #8b5cf6; color: white; padding: 20px; text-align: center; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">💬</div>
            مراقبة المحادثات
        </a>
        <a href="{{ route('admin.transactions.analytics') }}" class="btn" style="background: #06b6d4; color: white; padding: 20px; text-align: center; display: block;">
            <div style="font-size: 24px; margin-bottom: 10px;">📊</div>
            إحصائيات المعاملات
        </a>
    </div>
</div>
@endsection
