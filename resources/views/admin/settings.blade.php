@extends('layouts.admin')

@section('title', 'إعدادات النظام')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <!-- General Settings -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">الإعدادات العامة</h3>
        </div>
        <div style="space-y: 20px;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">اسم المنصة</label>
                <input type="text" value="Sokappe" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">وصف المنصة</label>
                <textarea style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; height: 80px;">منصة العمل الحر الرائدة في الوطن العربي</textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">إيميل التواصل</label>
                <input type="email" value="info@sokappe.com" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            <button class="btn btn-primary">حفظ التغييرات</button>
        </div>
    </div>

    <!-- System Stats -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">إحصائيات النظام</h3>
        </div>
        <div style="space-y: 15px;">
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">إجمالي المستخدمين:</span>
                <span style="color: #3b82f6;">{{ \App\Models\User::count() }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">إجمالي المشاريع:</span>
                <span style="color: #10b981;">{{ \App\Models\Project::count() }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">إجمالي الخدمات:</span>
                <span style="color: #f59e0b;">{{ \App\Models\Service::count() }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 10px;">
                <span style="font-weight: 600;">المحادثات النشطة:</span>
                <span style="color: #8b5cf6;">{{ \App\Models\Conversation::count() }}</span>
            </div>
        </div>
    </div>
</div>

<!-- System Actions -->
<div class="admin-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3 class="card-title">إجراءات النظام</h3>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <button class="btn btn-primary" style="padding: 20px; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 10px;">🔄</div>
            مسح الكاش
        </button>
        <button class="btn" style="background: #f59e0b; color: white; padding: 20px; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 10px;">📊</div>
            تصدير البيانات
        </button>
        <button class="btn" style="background: #8b5cf6; color: white; padding: 20px; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 10px;">🔧</div>
            صيانة النظام
        </button>
        <button class="btn btn-danger" style="padding: 20px; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 10px;">⚠️</div>
            إعادة تشغيل
        </button>
    </div>
</div>
@endsection
