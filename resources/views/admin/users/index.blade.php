@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
<style>
.action-buttons {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.action-buttons .btn {
    padding: 8px 12px !important;
    font-size: 11px !important;
    border-radius: 4px !important;
    text-decoration: none !important;
    display: inline-block !important;
    margin-bottom: 3px !important;
    border: none !important;
    cursor: pointer !important;
    white-space: nowrap !important;
}

.action-buttons .btn-primary {
    background: #3b82f6 !important;
    color: white !important;
}

.action-buttons .btn-success {
    background: #10b981 !important;
    color: white !important;
}

.action-buttons .btn-danger {
    background: #ef4444 !important;
    color: white !important;
}

.action-buttons form {
    display: inline-block !important;
    margin-bottom: 3px !important;
}
</style>
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">جميع المستخدمين</h3>
        <form method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="البحث بالاسم أو الإيميل..." 
                   style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; width: 250px;">
            <select name="role" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                <option value="">جميع الأدوار</option>
                <option value="freelancer" {{ request('role') === 'freelancer' ? 'selected' : '' }}>محترف</option>
                <option value="employer" {{ request('role') === 'employer' ? 'selected' : '' }}>عميل</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>مدير</option>
            </select>
            <button type="submit" class="btn btn-primary">🔍 بحث</button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="btn" style="background: #6b7280; color: white;">
                    ❌ مسح
                </a>
            @endif
        </form>
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
                            @if($user->is_banned ?? false)
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #7f1d1d; color: white;">
                                    🚫 محظور
                                </span>
                            @else
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                    {{ ($user->is_active ?? true) ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;' }}">
                                    {{ ($user->is_active ?? true) ? '🟢 نشط' : '🔴 معطل' }}
                                </span>
                            @endif
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
                        <td style="padding: 15px; min-width: 250px;">
                            <div class="action-buttons">
                                <!-- عرض -->
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary">
                                    👁️ عرض
                                </a>
                                
                                <!-- تعديل -->
                                <a href="{{ route('admin.users.show', $user) }}#edit" class="btn btn-success">
                                    ✏️ تعديل
                                </a>
                                
                                <!-- سجل النشاط -->
                                <a href="{{ route('admin.users.history', $user) }}" class="btn" style="background: #8b5cf6; color: white;">
                                    📊 النشاط
                                </a>
                                
                                @if($user->role !== 'admin')
                                    @if($user->is_banned ?? false)
                                        <!-- إلغاء الحظر -->
                                        <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">
                                                ✅ إلغاء الحظر
                                            </button>
                                        </form>
                                    @else
                                        <!-- حظر -->
                                        <button onclick="showBanModal({{ $user->id }}, '{{ $user->name }}')" class="btn" style="background: #7f1d1d; color: white;">
                                            🚫 حظر
                                        </button>
                                        
                                        <!-- إيقاف/تفعيل -->
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn {{ ($user->is_active ?? true) ? 'btn-danger' : 'btn-success' }}">
                                                {{ ($user->is_active ?? true) ? '⏸️ إيقاف' : '▶️ تفعيل' }}
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <!-- حذف -->
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
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

<!-- Ban User Modal -->
<div id="banModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 500px;">
        <h3 style="margin: 0 0 20px; color: #dc2626;">🚫 حظر المستخدم</h3>
        
        <form id="banForm" method="POST">
            @csrf
            @method('PATCH')
            
            <div style="margin-bottom: 20px;">
                <p style="margin: 0 0 15px; color: #374151;">
                    هل أنت متأكد من حظر المستخدم <strong id="banUserName"></strong>؟
                </p>
                <p style="margin: 0 0 15px; color: #dc2626; font-size: 14px;">
                    ⚠️ المستخدم المحظور لن يتمكن من تسجيل الدخول للمنصة نهائياً حتى يتم إلغاء الحظر.
                </p>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    سبب الحظر *
                </label>
                <textarea name="banned_reason" required rows="4" 
                          style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px; resize: vertical;"
                          placeholder="اكتب سبب حظر هذا المستخدم..."></textarea>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button type="button" onclick="closeBanModal()" class="btn" style="background: #6b7280; color: white;">
                    إلغاء
                </button>
                <button type="submit" class="btn" style="background: #dc2626; color: white;">
                    🚫 حظر المستخدم
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showBanModal(userId, userName) {
    document.getElementById('banUserName').textContent = userName;
    document.getElementById('banForm').action = `/admin/users/${userId}/ban`;
    document.getElementById('banModal').style.display = 'block';
}

function closeBanModal() {
    document.getElementById('banModal').style.display = 'none';
    document.querySelector('textarea[name="banned_reason"]').value = '';
}

// Close modal when clicking outside
document.getElementById('banModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBanModal();
    }
});
</script>
@endsection
