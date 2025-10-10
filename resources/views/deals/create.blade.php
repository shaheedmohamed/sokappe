@extends('layouts.app')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>💎 إنشاء صفقة جديدة</h1>
        <p>اعرض منتجك أو اطلب ما تحتاجه - نحن نضمن حقوقك</p>
    </div>
    
    <div class="form-card">
        <form action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Deal Type Selection -->
            <div class="form-group">
                <label class="form-label">🎯 نوع الصفقة</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <label for="offer" style="cursor: pointer;">
                        <div class="deal-type-option" data-type="offer" style="border: 2px solid var(--border); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s;">
                            <div style="font-size: 32px; margin-bottom: 8px;">🛍️</div>
                            <h3 style="margin: 0 0 4px; color: var(--dark);">عرض للبيع</h3>
                            <p style="margin: 0; font-size: 13px; color: var(--muted);">أعرض منتج أو خدمة للبيع</p>
                            <input type="radio" name="type" id="offer" value="offer" required style="margin-top: 8px;">
                        </div>
                    </label>
                    
                    <label for="request" style="cursor: pointer;">
                        <div class="deal-type-option" data-type="request" style="border: 2px solid var(--border); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s;">
                            <div style="font-size: 32px; margin-bottom: 8px;">🔍</div>
                            <h3 style="margin: 0 0 4px; color: var(--dark);">طلب للشراء</h3>
                            <p style="margin: 0; font-size: 13px; color: var(--muted);">أطلب منتج أو خدمة محددة</p>
                            <input type="radio" name="type" id="request" value="request" required style="margin-top: 8px;">
                        </div>
                    </label>
                </div>
                @error('type')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="title">📝 عنوان الصفقة</label>
                    <input class="form-input @error('title') error @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="مثال: بيع حساب PlayStation مع ألعاب" required>
                    @error('title')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">📂 الفئة</label>
                    <select class="form-input @error('category') error @enderror" id="category" name="category" required>
                        <option value="">اختر الفئة</option>
                        <option value="ألعاب" {{ old('category') == 'ألعاب' ? 'selected' : '' }}>🎮 ألعاب وحسابات</option>
                        <option value="حسابات سوشيال" {{ old('category') == 'حسابات سوشيال' ? 'selected' : '' }}>📱 حسابات سوشيال ميديا</option>
                        <option value="برامج" {{ old('category') == 'برامج' ? 'selected' : '' }}>💻 برامج وتطبيقات</option>
                        <option value="تصميم" {{ old('category') == 'تصميم' ? 'selected' : '' }}>🎨 تصاميم جاهزة</option>
                        <option value="كتب" {{ old('category') == 'كتب' ? 'selected' : '' }}>📚 كتب ومواد تعليمية</option>
                        <option value="خدمات رقمية" {{ old('category') == 'خدمات رقمية' ? 'selected' : '' }}>⚡ خدمات رقمية</option>
                        <option value="أخرى" {{ old('category') == 'أخرى' ? 'selected' : '' }}>📦 أخرى</option>
                    </select>
                    @error('category')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">📋 وصف تفصيلي</label>
                <textarea class="form-input form-textarea @error('description') error @enderror" id="description" name="description" placeholder="اشرح تفاصيل الصفقة، الشروط، وما يتضمنه العرض أو الطلب..." required>{{ old('description') }}</textarea>
                @error('description')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="price">💰 السعر (بالجنيه المصري)</label>
                <input class="form-input @error('price') error @enderror" type="number" id="price" name="price" value="{{ old('price') }}" placeholder="100" min="1" required>
                @error('price')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="images">🖼️ صور الصفقة (اختياري)</label>
                <div class="file-upload">
                    <input type="file" id="images" name="images[]" accept="image/*" multiple onchange="previewImages(this)">
                    <label for="images" class="file-upload-label">
                        📷 اختر صور من جهازك (يمكن اختيار عدة صور)
                    </label>
                </div>
                <div id="images-preview" class="file-preview" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-top: 12px;"></div>
                @error('images.*')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <!-- Terms and Conditions -->
            <div class="form-group">
                <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; border-left: 4px solid var(--warning);">
                    <h4 style="margin: 0 0 8px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                        🛡️ ضمان الموقع
                    </h4>
                    <ul style="margin: 0; padding-right: 20px; color: var(--muted); font-size: 14px; line-height: 1.6;">
                        <li>الموقع يحتفظ بالمبلغ حتى تأكيد تسليم الصفقة</li>
                        <li>حماية كاملة للمشتري والبائع</li>
                        <li>إمكانية فتح نزاع في حالة عدم الالتزام</li>
                        <li>دعم فني متاح 24/7</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                    <input type="checkbox" name="terms_accepted" value="1" required style="width: 18px; height: 18px; accent-color: var(--primary);">
                    <span style="font-size: 14px; color: var(--dark);">
                        أوافق على <a href="#" style="color: var(--primary);">شروط الاستخدام</a> وأؤكد صحة المعلومات المقدمة
                    </span>
                </label>
                @error('terms_accepted')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('deals.index') }}" class="btn btn-outline">إلغاء</a>
                <button type="submit" class="btn btn-primary">💎 نشر الصفقة</button>
            </div>
        </form>
    </div>
</div>

<script>
// Deal type selection
document.addEventListener('DOMContentLoaded', function() {
    const dealTypeOptions = document.querySelectorAll('.deal-type-option');
    
    dealTypeOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Reset all options
            dealTypeOptions.forEach(opt => {
                opt.style.borderColor = 'var(--border)';
                opt.style.background = 'white';
            });
            
            // Highlight selected option
            this.style.borderColor = 'var(--primary)';
            this.style.background = 'rgba(59, 130, 246, 0.05)';
        });
    });
});

// Image preview function
function previewImages(input) {
    const preview = document.getElementById('images-preview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.border = '2px solid var(--border)';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
