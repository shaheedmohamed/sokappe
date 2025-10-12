@extends('layouts.admin')

@section('title', 'تفاصيل المستخدم')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
        ← العودة للمستخدمين
    </a>
</div>

<!-- User Header -->
<div class="admin-card" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 32px;">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h1 style="margin: 0 0 8px; color: #1e293b; font-size: 24px;">{{ $user->name }}</h1>
                <div style="color: #64748b; font-size: 16px; margin-bottom: 8px;">{{ $user->email }}</div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                        {{ $user->role === 'admin' ? 'background: #fef3c7; color: #92400e;' : 
                           ($user->role === 'freelancer' ? 'background: #dbeafe; color: #1e40af;' : 'background: #dcfce7; color: #166534;') }}">
                        {{ $user->role === 'admin' ? '👑 مدير' : ($user->role === 'freelancer' ? '💼 محترف' : '🏢 عميل') }}
                    </span>
                    <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                        {{ $user->is_active ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;' }}">
                        {{ $user->is_active ? '🟢 نشط' : '🔴 معطل' }}
                    </span>
                    <span style="color: #64748b; font-size: 14px;">
                        📅 انضم في {{ $user->created_at->format('Y/m/d') }}
                    </span>
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="toggleEditMode()" class="btn btn-success" id="editBtn">
                ✏️ تعديل البيانات
            </button>
            <a href="{{ route('admin.users.history', $user) }}" class="btn" style="background: #8b5cf6; color: white;">
                📊 سجل النشاط
            </a>
        </div>
    </div>
</div>

<!-- Auto-activate edit mode if coming from edit link -->
<script>
// Check if URL has #edit fragment
if (window.location.hash === '#edit') {
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(toggleEditMode, 100);
    });
}
</script>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Content -->
    <div>
        <!-- User Information (Editable) -->
        <div class="admin-card" style="margin-bottom: 30px;">
            <h3 class="card-title">👤 معلومات المستخدم</h3>
            
            <form id="userForm" action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">الاسم الكامل</label>
                        <input type="text" name="name" value="{{ $user->name }}" 
                               style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px;" 
                               class="edit-field" readonly>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">البريد الإلكتروني</label>
                        <input type="email" name="email" value="{{ $user->email }}" 
                               style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px;" 
                               class="edit-field" readonly>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">الدور</label>
                        <select name="role" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px;" 
                                class="edit-field" disabled>
                            <option value="freelancer" {{ $user->role === 'freelancer' ? 'selected' : '' }}>محترف</option>
                            <option value="employer" {{ $user->role === 'employer' ? 'selected' : '' }}>عميل</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>مدير</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">الحالة</label>
                        <select name="is_active" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px;" 
                                class="edit-field" disabled>
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>معطل</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">كلمة المرور الجديدة (اختياري)</label>
                    <input type="password" name="password" placeholder="اتركه فارغاً إذا لم ترد تغيير كلمة المرور" 
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px;" 
                           class="edit-field" readonly>
                </div>

                <div id="editActions" style="display: none; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                    <div style="display: flex; gap: 15px;">
                        <button type="submit" class="btn btn-success">✅ حفظ التغييرات</button>
                        <button type="button" onclick="cancelEdit()" class="btn" style="background: #6b7280; color: white;">❌ إلغاء</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- User Activity -->
        @if($user->role === 'freelancer')
            <div class="admin-card" style="margin-bottom: 30px;">
                <h3 class="card-title">⚡ الخدمات المقدمة</h3>
                @forelse($user->services->take(5) as $service)
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">{{ $service->title }}</div>
                                <div style="color: #64748b; font-size: 13px;">{{ Str::limit($service->description, 100) }}</div>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: #10b981;">${{ number_format($service->price, 2) }}</div>
                                <div style="color: #64748b; font-size: 12px;">{{ $service->delivery_days }} يوم</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #64748b; text-align: center; padding: 20px;">لا توجد خدمات</p>
                @endforelse
            </div>

            <div class="admin-card">
                <h3 class="card-title">💼 العروض المقدمة</h3>
                @forelse($user->bids->take(5) as $bid)
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">{{ $bid->project->title }}</div>
                                <div style="color: #64748b; font-size: 13px;">{{ Str::limit($bid->description, 100) }}</div>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: #10b981;">${{ number_format($bid->amount, 2) }}</div>
                                <span style="padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600;
                                    {{ $bid->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : 
                                       ($bid->status === 'accepted' ? 'background: #dcfce7; color: #166534;' : 'background: #fef2f2; color: #dc2626;') }}">
                                    {{ $bid->status === 'pending' ? 'معلق' : ($bid->status === 'accepted' ? 'مقبول' : 'مرفوض') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #64748b; text-align: center; padding: 20px;">لا توجد عروض</p>
                @endforelse
            </div>
        @else
            <div class="admin-card">
                <h3 class="card-title">📋 المشاريع المنشورة</h3>
                @forelse($user->projects->take(5) as $project)
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">{{ $project->title }}</div>
                                <div style="color: #64748b; font-size: 13px;">{{ Str::limit($project->description, 100) }}</div>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: #10b981;">${{ number_format($project->budget_min, 2) }} - ${{ number_format($project->budget_max, 2) }}</div>
                                <div style="color: #64748b; font-size: 12px;">{{ $project->bids->count() }} عرض</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #64748b; text-align: center; padding: 20px;">لا توجد مشاريع</p>
                @endforelse
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <!-- User Stats -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title">📊 الإحصائيات</h3>
            <div style="space-y: 12px;">
                @if($user->role === 'freelancer')
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">⚡ الخدمات:</span>
                        <span style="font-weight: 600; color: #3b82f6;">{{ $user->services->count() }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">💼 العروض:</span>
                        <span style="font-weight: 600; color: #f59e0b;">{{ $user->bids->count() }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">✅ العروض المقبولة:</span>
                        <span style="font-weight: 600; color: #10b981;">{{ $user->bids->where('status', 'accepted')->count() }}</span>
                    </div>
                @else
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">📋 المشاريع:</span>
                        <span style="font-weight: 600; color: #3b82f6;">{{ $user->projects->count() }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13px;">💼 العروض المستلمة:</span>
                        <span style="font-weight: 600; color: #f59e0b;">{{ $user->projects->sum(function($p) { return $p->bids->count(); }) }}</span>
                    </div>
                @endif
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 6px;">
                    <span style="color: #64748b; font-size: 13px;">📅 تاريخ الانضمام:</span>
                    <span style="font-weight: 600; color: #8b5cf6;">{{ $user->created_at->format('Y/m/d') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-card">
            <h3 class="card-title">⚡ إجراءات سريعة</h3>
            <div style="space-y: 10px;">
                @if($user->role !== 'admin')
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="margin-bottom: 10px;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }}" style="width: 100%;">
                            {{ $user->is_active ? '⏸️ إيقاف المستخدم' : '▶️ تفعيل المستخدم' }}
                        </button>
                    </form>
                @endif
                
                <button class="btn" style="background: #f59e0b; color: white; width: 100%; margin-bottom: 10px;">
                    📧 إرسال رسالة
                </button>
                
                <a href="{{ route('admin.users.history', $user) }}" class="btn" style="background: #8b5cf6; color: white; width: 100%; margin-bottom: 10px; text-decoration: none; display: block; text-align: center;">
                    📊 سجل النشاط الكامل
                </a>
                
                @if($user->role !== 'admin')
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%;">
                            🗑️ حذف المستخدم
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function toggleEditMode() {
    const editFields = document.querySelectorAll('.edit-field');
    const editActions = document.getElementById('editActions');
    const editBtn = document.getElementById('editBtn');
    
    editFields.forEach(field => {
        if (field.tagName === 'SELECT') {
            field.disabled = !field.disabled;
        } else {
            field.readOnly = !field.readOnly;
        }
        
        if (field.readOnly || field.disabled) {
            field.style.backgroundColor = '#f8fafc';
        } else {
            field.style.backgroundColor = 'white';
        }
    });
    
    if (editActions.style.display === 'none') {
        editActions.style.display = 'block';
        editBtn.textContent = '❌ إلغاء التعديل';
        editBtn.className = 'btn btn-danger';
    } else {
        editActions.style.display = 'none';
        editBtn.textContent = '✏️ تعديل البيانات';
        editBtn.className = 'btn btn-success';
    }
}

function cancelEdit() {
    location.reload();
}
</script>
@endsection
