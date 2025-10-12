@extends('layouts.admin')

@section('title', 'إدارة العروض')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع العروض المقدمة</h3>
        <form method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="البحث بالمحترف أو المشروع..." 
                   style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; width: 250px;">
            <select name="status" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                <option value="">جميع الحالات</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلق</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>مقبول</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>مرفوض</option>
            </select>
            <button type="submit" class="btn btn-primary">🔍 بحث</button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.bids.index') }}" class="btn" style="background: #6b7280; color: white;">
                    ❌ مسح
                </a>
            @endif
        </form>
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
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bids as $bid)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                    {{ substr($bid->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.show', $bid->user) }}" style="font-weight: 500; font-size: 13px; color: #3b82f6; text-decoration: none;">
                                        {{ $bid->user->name }}
                                    </a>
                                    <div style="font-size: 11px; color: #64748b;">{{ $bid->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <a href="{{ route('admin.projects.show', $bid->project) }}" style="font-weight: 500; color: #1e293b; text-decoration: none;">
                                {{ Str::limit($bid->project->title, 40) }}
                            </a>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 600; color: #10b981; font-size: 16px;">
                                ${{ number_format($bid->amount, 2) }}
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
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <a href="{{ route('admin.bids.show', $bid) }}" class="btn btn-primary" style="padding: 6px 10px; font-size: 11px; text-decoration: none;">
                                    👁️ عرض العرض
                                </a>
                                <a href="{{ route('admin.projects.show', $bid->project) }}" class="btn" style="padding: 6px 10px; font-size: 11px; text-decoration: none; background: #8b5cf6; color: white;">
                                    📋 المشروع
                                </a>
                                <a href="{{ route('admin.users.show', $bid->user) }}" class="btn btn-success" style="padding: 6px 10px; font-size: 11px; text-decoration: none;">
                                    👤 المحترف
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 48px; margin-bottom: 15px;">💼</div>
                            <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد عروض</h4>
                            <p style="margin: 0; font-size: 14px;">لم يتم تقديم أي عروض بعد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($bids->hasPages())
        <div style="padding: 20px; border-top: 1px solid #e2e8f0;">
            {{ $bids->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Results Summary -->
@if(request('search') || request('status'))
    <div style="margin-top: 15px; padding: 12px; background: #f0f9ff; border-radius: 6px; border-left: 4px solid #3b82f6;">
        <div style="color: #1e40af; font-weight: 600; margin-bottom: 4px;">
            📊 نتائج البحث
        </div>
        <div style="color: #1e40af; font-size: 14px;">
            تم العثور على {{ $bids->total() }} عرض
            @if(request('search'))
                للبحث: "{{ request('search') }}"
            @endif
            @if(request('status'))
                بحالة: {{ request('status') === 'pending' ? 'معلق' : (request('status') === 'accepted' ? 'مقبول' : 'مرفوض') }}
            @endif
        </div>
    </div>
@endif
@endsection
