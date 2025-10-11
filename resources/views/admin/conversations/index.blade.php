@extends('layouts.admin')

@section('title', 'مراقبة المحادثات')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع المحادثات</h3>
        <div style="display: flex; gap: 10px;">
            <form method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="البحث في المحادثات..." 
                       value="{{ request('search') }}" 
                       style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; width: 250px;">
                <button type="submit" class="btn btn-primary">بحث</button>
            </form>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المشاركين</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المشروع</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">عدد الرسائل</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">آخر رسالة</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conversations as $conversation)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                        {{ substr($conversation->buyer->name, 0, 1) }}
                                    </div>
                                    <span style="font-size: 13px; color: #1e293b;">{{ $conversation->buyer->name }}</span>
                                </div>
                                <span style="color: #64748b;">↔</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                        {{ substr($conversation->seller->name, 0, 1) }}
                                    </div>
                                    <span style="font-size: 13px; color: #1e293b;">{{ $conversation->seller->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            @if($conversation->project)
                                <div style="font-size: 13px; color: #1e293b; font-weight: 500;">
                                    {{ Str::limit($conversation->project->title, 30) }}
                                </div>
                            @else
                                <span style="color: #94a3b8; font-size: 12px;">غير محدد</span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                {{ $conversation->messages->count() }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            @if($conversation->messages->last())
                                <div style="font-size: 12px; color: #64748b;">
                                    {{ $conversation->messages->last()->created_at->diffForHumans() }}
                                </div>
                            @else
                                <span style="color: #94a3b8; font-size: 12px;">لا توجد رسائل</span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.conversations.show', $conversation) }}" 
                                   class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                                    👁️ عرض
                                </a>
                                <form method="POST" action="{{ route('admin.conversations.destroy', $conversation) }}" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه المحادثة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                        🗑️ حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 48px; margin-bottom: 15px;">💬</div>
                            <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد محادثات</h4>
                            <p style="margin: 0; font-size: 14px;">لم يتم العثور على أي محادثات</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($conversations->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $conversations->links() }}
        </div>
    @endif
</div>
@endsection
