@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع المستخدمين</h3>
        <div style="display: flex; gap: 10px;">
            <form method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="البحث بالاسم أو الإيميل..." 
                       value="{{ request('search') }}" 
                       style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; width: 250px;">
                <select name="role" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                    <option value="">جميع الأدوار</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>مدير</option>
                    <option value="freelancer" {{ request('role') === 'freelancer' ? 'selected' : '' }}>محترف</option>
                    <option value="employer" {{ request('role') === 'employer' ? 'selected' : '' }}>عميل</option>
                </select>
                <button type="submit" class="btn btn-primary">بحث</button>
            </form>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المستخدم</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الدور</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الحالة</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">تاريخ التسجيل</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">النشاط</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 2px;">{{ $user->name }}</div>
                                    <div style="font-size: 13px; color: #64748b;">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div style="font-size: 12px; color: #94a3b8;">{{ $user->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                {{ $user->role === 'admin' ? 'background: #fef3c7; color: #92400e;' : 
                                   ($user->role === 'freelancer' ? 'background: #dcfce7; color: #166534;' : 'background: #dbeafe; color: #1e40af;') }}">
                                {{ $user->role === 'admin' ? '🛡️ مدير' : ($user->role === 'freelancer' ? '💼 محترف' : '👤 عميل') }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                {{ $user->is_active ?? true ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;' }}">
                                {{ $user->is_active ?? true ? '✅ نشط' : '❌ معطل' }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-size: 13px; color: #1e293b;">{{ $user->created_at->format('Y/m/d') }}</div>
                            <div style="font-size: 11px; color: #64748b;">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @if($user->role === 'freelancer')
                                    <div style="font-size: 12px; color: #10b981;">
                                        📋 {{ $user->projects()->count() }} مشروع
                                    </div>
                                    <div style="font-size: 12px; color: #f59e0b;">
                                        ⚡ {{ $user->services()->count() }} خدمة
                                    </div>
                                @else
                                    <div style="font-size: 12px; color: #3b82f6;">
                                        💼 {{ $user->bids()->count() }} عرض
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="btn btn-primary" style="padding: 6px 10px; font-size: 11px;">
                                    👁️ عرض
                                </a>
                                @if($user->role !== 'admin')
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $user->is_active ?? true ? 'btn-danger' : 'btn-success' }}" 
                                                style="padding: 6px 10px; font-size: 11px;">
                                            {{ $user->is_active ?? true ? '⏸️ إيقاف' : '▶️ تفعيل' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 11px;">
                                            🗑️ حذف
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 48px; margin-bottom: 15px;">👥</div>
                            <h4 style="margin: 0 0 8px; color: #1e293b;">لا توجد مستخدمين</h4>
                            <p style="margin: 0; font-size: 14px;">لم يتم العثور على أي مستخدمين</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Stats Summary -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
    <div class="admin-card" style="text-align: center; padding: 20px;">
        <div style="font-size: 24px; font-weight: 800; color: #3b82f6; margin-bottom: 5px;">
            {{ \App\Models\User::where('role', 'admin')->count() }}
        </div>
        <div style="font-size: 12px; color: #64748b;">المديرين</div>
    </div>
    <div class="admin-card" style="text-align: center; padding: 20px;">
        <div style="font-size: 24px; font-weight: 800; color: #10b981; margin-bottom: 5px;">
            {{ \App\Models\User::where('role', 'freelancer')->count() }}
        </div>
        <div style="font-size: 12px; color: #64748b;">المحترفين</div>
    </div>
    <div class="admin-card" style="text-align: center; padding: 20px;">
        <div style="font-size: 24px; font-weight: 800; color: #f59e0b; margin-bottom: 5px;">
            {{ \App\Models\User::where('role', 'employer')->count() }}
        </div>
        <div style="font-size: 12px; color: #64748b;">العملاء</div>
    </div>
    <div class="admin-card" style="text-align: center; padding: 20px;">
        <div style="font-size: 24px; font-weight: 800; color: #8b5cf6; margin-bottom: 5px;">
            {{ \App\Models\User::whereDate('created_at', today())->count() }}
        </div>
        <div style="font-size: 12px; color: #64748b;">جديد اليوم</div>
    </div>
</div>
@endsection
