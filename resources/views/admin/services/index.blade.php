@extends('layouts.admin')

@section('title', 'إدارة الخدمات')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع الخدمات</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.services.create') }}" class="btn btn-success">
                ➕ إضافة خدمة جديدة
            </a>
            <input type="text" placeholder="البحث في الخدمات..." style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; width: 250px;">
            <button class="btn btn-primary">بحث</button>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الخدمة</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المحترف</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">السعر</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">مدة التسليم</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">تاريخ النشر</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Service::with('user')->latest()->take(20)->get() as $service)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                    {{ Str::limit($service->title, 50) }}
                                </div>
                                <div style="font-size: 12px; color: #64748b;">
                                    {{ Str::limit($service->description, 80) }}
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                    {{ substr($service->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500; font-size: 13px;">{{ $service->user->name }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $service->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 600; color: #10b981; font-size: 16px;">
                                {{ number_format($service->price) }} ج
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                {{ $service->delivery_days ?? $service->delivery_time ?? 'غير محدد' }} يوم
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-size: 12px; color: #64748b;">
                                {{ $service->created_at->format('Y/m/d') }}
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('services.show', $service) }}" class="btn btn-primary" style="padding: 6px 10px; font-size: 11px;">
                                    👁️ عرض
                                </a>
                                <button class="btn btn-danger" style="padding: 6px 10px; font-size: 11px;">
                                    🗑️ حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 48px; margin-bottom: 15px;">⚡</div>
                            <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد خدمات</h4>
                            <p style="margin: 0; font-size: 14px;">لم يتم نشر أي خدمات بعد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
