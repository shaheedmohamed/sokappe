@extends('layouts.admin')

@section('title', 'إضافة خدمة جديدة')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">إضافة خدمة جديدة</h3>
            <a href="{{ route('admin.services.index') }}" class="btn btn-primary">← العودة للخدمات</a>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" style="space-y: 20px;">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    🎯 عنوان الخدمة *
                </label>
                <input type="text" name="title" required 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                       placeholder="مثال: تصميم لوجو احترافي مع 3 مفاهيم">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    📋 وصف الخدمة *
                </label>
                <textarea name="description" required rows="6"
                          style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"
                          placeholder="اشرح ما تقدمه في هذه الخدمة بالتفصيل..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                        💰 سعر الخدمة *
                    </label>
                    <input type="number" name="price" required min="5"
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                           placeholder="500">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                        ⏱️ مدة التسليم (بالأيام) *
                    </label>
                    <input type="number" name="delivery_days" required min="1"
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                           placeholder="7">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    🏷️ فئة الخدمة *
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

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    🛠️ المهارات المستخدمة
                </label>
                <input type="text" name="skills"
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;"
                       placeholder="مثال: Photoshop, Illustrator, تصميم الهوية البصرية">
                <small style="color: #64748b; font-size: 12px;">افصل المهارات بفاصلة</small>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    📦 ما يحصل عليه العميل
                </label>
                <textarea name="deliverables" rows="3"
                          style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"
                          placeholder="مثال: 3 مفاهيم للوجو، ملفات عالية الجودة، مراجعتين مجانيتين"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    👤 المحترف (اختياري)
                </label>
                <select name="user_id" 
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <option value="">سيتم ربطها بحساب المدير</option>
                    @foreach(\App\Models\User::where('role', 'freelancer')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 15px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <button type="submit" class="btn btn-success" style="padding: 12px 30px;">
                    ✅ نشر الخدمة
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn" style="background: #6b7280; color: white; padding: 12px 30px;">
                    ❌ إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
