@extends('layouts.admin')

@section('title', 'إدارة المشاريع')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع المشاريع</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.projects.create') }}" class="btn btn-success">
                ➕ إضافة مشروع جديد
            </a>
            <select style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                <option>جميع الحالات</option>
                <option>مفتوح</option>
                <option>قيد التنفيذ</option>
                <option>مكتمل</option>
            </select>
            <button class="btn btn-primary">فلترة</button>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المشروع</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">العميل</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الميزانية</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الحالة</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">العروض</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">تاريخ النشر</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Project::with('user', 'bids')->latest()->paginate(20) as $project)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                    {{ Str::limit($project->title, 50) }}
                                </div>
                                <div style="font-size: 12px; color: #64748b;">
                                    {{ Str::limit($project->description, 80) }}
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                    {{ substr($project->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500; font-size: 13px;">{{ $project->user->name }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $project->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 600; color: #10b981;">
                                {{ number_format($project->budget_min) }} - {{ number_format($project->budget_max) }} ج
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                {{ $project->status === 'open' ? 'background: #dcfce7; color: #166534;' : 
                                   ($project->status === 'in_progress' ? 'background: #fef3c7; color: #92400e;' : 'background: #f3f4f6; color: #374151;') }}">
                                {{ $project->status === 'open' ? '🟢 مفتوح' : ($project->status === 'in_progress' ? '🟡 قيد التنفيذ' : '✅ مكتمل') }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                {{ $project->bids->count() }} عرض
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-size: 12px; color: #64748b;">
                                {{ $project->created_at->format('Y/m/d') }}
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-primary" style="padding: 6px 10px; font-size: 11px;">
                                    👁️ عرض
                                </a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 11px;">
                                        🗑️ حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 48px; margin-bottom: 15px;">📋</div>
                            <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد مشاريع</h4>
                            <p style="margin: 0; font-size: 14px;">لم يتم نشر أي مشاريع بعد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
