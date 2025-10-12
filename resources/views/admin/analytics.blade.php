@extends('layouts.admin')

@section('title', 'التحليلات والإحصائيات')

@section('content')
<!-- Analytics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="admin-card">
        <h3 class="card-title">📊 إحصائيات المستخدمين الشهرية</h3>
        <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 8px;">
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">📈</div>
                <p style="color: #64748b;">رسم بياني للمستخدمين الجدد</p>
                <small style="color: #94a3b8;">سيتم إضافة Chart.js قريباً</small>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <h3 class="card-title">💰 إحصائيات المشاريع والأرباح</h3>
        <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 8px;">
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">💹</div>
                <p style="color: #64748b;">رسم بياني للمشاريع والأرباح</p>
                <small style="color: #94a3b8;">سيتم إضافة Chart.js قريباً</small>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #3b82f6; margin-bottom: 8px;">
            {{ $stats['total_users'] }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي المستخدمين</div>
        <div style="font-size: 12px; color: #10b981;">
            +{{ $stats['users_this_month'] }} هذا الشهر
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #10b981; margin-bottom: 8px;">
            {{ \App\Models\Project::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي المشاريع</div>
        <div style="font-size: 12px; color: #f59e0b;">
            {{ \App\Models\Project::where('status', 'open')->count() }} مفتوح
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #f59e0b; margin-bottom: 8px;">
            {{ \App\Models\Service::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي الخدمات</div>
        <div style="font-size: 12px; color: #8b5cf6;">
            {{ \App\Models\Service::whereDate('created_at', today())->count() }} جديد اليوم
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #8b5cf6; margin-bottom: 8px;">
            {{ \App\Models\Bid::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي العروض</div>
        <div style="font-size: 12px; color: #ef4444;">
            {{ \App\Models\Bid::where('status', 'pending')->count() }} معلق
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #06b6d4; margin-bottom: 8px;">
            {{ \App\Models\Conversation::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">المحادثات النشطة</div>
        <div style="font-size: 12px; color: #10b981;">
            {{ \App\Models\Message::whereDate('created_at', today())->count() }} رسالة اليوم
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #84cc16; margin-bottom: 8px;">
            {{ \App\Models\User::where('role', 'freelancer')->count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">المحترفين</div>
        <div style="font-size: 12px; color: #3b82f6;">
            {{ \App\Models\User::where('role', 'employer')->count() }} عميل
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">📋 النشاط الأخير</h3>
        <div style="display: flex; gap: 10px;">
            <select style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                <option>آخر 24 ساعة</option>
                <option>آخر أسبوع</option>
                <option>آخر شهر</option>
            </select>
            <button class="btn btn-primary">تحديث</button>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">النوع</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المستخدم</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">التفاصيل</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">التوقيت</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\User::latest()->take(10)->get() as $user)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px;">
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                👤 مستخدم جديد
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500; font-size: 13px;">{{ $user->name }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            <div style="font-size: 13px; color: #1e293b;">انضم للمنصة</div>
                            <div style="font-size: 11px; color: #64748b;">
                                دور: {{ $user->role === 'freelancer' ? 'محترف' : 'عميل' }}
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            <div style="font-size: 12px; color: #64748b;">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
