@extends('layouts.admin')

@section('title', 'إدارة العروض')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع العروض المقدمة</h3>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المحترف</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المشروع</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المبلغ</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المدة</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الحالة</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">تاريخ التقديم</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Bid::with(['user', 'project'])->latest()->take(20)->get() as $bid)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                    {{ substr($bid->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500; font-size: 13px;">{{ $bid->user->name }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $bid->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 500; color: #1e293b;">
                                {{ Str::limit($bid->project->title, 40) }}
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 600; color: #10b981; font-size: 16px;">
                                {{ number_format($bid->amount) }} ج
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                {{ $bid->delivery_days }} يوم
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                {{ $bid->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : 
                                   ($bid->status === 'accepted' ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;') }}">
                                {{ $bid->status === 'pending' ? '⏳ معلق' : ($bid->status === 'accepted' ? '✅ مقبول' : '❌ مرفوض') }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-size: 12px; color: #64748b;">
                                {{ $bid->created_at->format('Y/m/d') }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 48px; margin-bottom: 15px;">💼</div>
                            <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد عروض</h4>
                            <p style="margin: 0; font-size: 14px;">لم يتم تقديم أي عروض بعد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
