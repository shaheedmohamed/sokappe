@extends('layouts.admin')

@section('title', 'إضافة مشروع جديد')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">إضافة مشروع جديد</h3>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">← العودة للمشاريع</a>
        </div>

        <form action="{{ route('admin.projects.store') }}" method="POST" style="space-y: 20px;">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    📝 عنوان المشروع *
                </label>
                <input type="text" name="title" required 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                       placeholder="مثال: تصميم موقع إلكتروني لشركة ناشئة">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    📋 وصف المشروع *
                </label>
                <textarea name="description" required rows="6"
                          style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"
                          placeholder="اشرح تفاصيل المشروع والمتطلبات بوضوح..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                        💰 الميزانية الدنيا (بالدولار)
                    </label>
                    <input type="number" name="budget_min" required step="0.01"
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                           placeholder="100">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                        💰 الميزانية العليا (بالدولار)
                    </label>
                    <input type="number" name="budget_max" required step="0.01"
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                           placeholder="500">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    🏷️ فئة المشروع *
                </label>
                <select name="category" required 
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <option value="">اختر الفئة</option>
                    <option value="web-development">تطوير المواقع</option>
                    <option value="mobile-development">تطوير التطبيقات</option>
                    <option value="design">التصميم</option>
                    <option value="writing">الكتابة والترجمة</option>
                    <option value="marketing">التسويق</option>
                    <option value="data-entry">إدخال البيانات</option>
                    <option value="other">أخرى</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                        ⏱️ مدة المشروع (نص)
                    </label>
                    <input type="text" name="duration"
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                           placeholder="مثال: أسبوعين، شهر، حسب الاتفاق">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                        📅 مدة المشروع (بالأيام)
                    </label>
                    <input type="number" name="duration_days" min="1"
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                           placeholder="14">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    🛠️ المهارات المطلوبة
                </label>
                <input type="text" name="skills"
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                       placeholder="مثال: PHP, Laravel, JavaScript, تصميم UI/UX">
                <small style="color: #64748b; font-size: 12px;">افصل المهارات بفاصلة</small>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    👤 العميل (اختياري)
                </label>
                <select name="user_id" 
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <option value="">سيتم ربطه بحساب المدير</option>
                    @foreach(\App\Models\User::where('role', 'employer')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 15px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <button type="submit" class="btn btn-success" style="padding: 12px 30px;">
                    ✅ نشر المشروع
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn" style="background: #6b7280; color: white; padding: 12px 30px;">
                    ❌ إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
