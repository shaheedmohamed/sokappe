@extends('layouts.guest')

@section('content')
<div class="auth-header">
    <h1>🎨 أضف أعمالك</h1>
    <p>أضف 3 أعمال على الأقل لإظهار خبرتك للعملاء</p>
    
    <!-- Progress Steps -->
    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 20px;">
        @for($i = 1; $i <= $totalSteps; $i++)
            <div style="width: 40px; height: 4px; border-radius: 2px; background: {{ $i <= $step ? 'rgba(255,255,255,0.8)' : 'rgba(255,255,255,0.3)' }};"></div>
        @endfor
    </div>
    <div style="text-align: center; margin-top: 8px; opacity: 0.8; font-size: 14px;">
        الخطوة {{ $step }} من {{ $totalSteps }}
    </div>
    
    <div style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 12px; margin-top: 16px;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
            <span style="font-size: 20px;">📊</span>
            <span>المضافة: {{ $worksCount }} / 3</span>
        </div>
    </div>
</div>

<div class="auth-body">
    @if (session('status') === 'work-added')
        <div class="success-message">
            ✅ تم إضافة العمل بنجاح! المتبقي: {{ max(0, 3 - $worksCount) }}
        </div>
    @endif

    <form method="POST" action="{{ route('onboarding.works.save') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title" class="form-label">📝 عنوان العمل</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" 
                   class="form-input @error('title') error @enderror" 
                   placeholder="مثال: تصميم موقع إلكتروني لشركة تقنية" required>
            @error('title')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="thumbnail" class="form-label">🖼️ صورة مصغرة للعمل</label>
            <div class="file-upload">
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(this, 'thumbnail-preview')">
                <label for="thumbnail" class="file-upload-label">
                    📷 اختر صورة من جهازك
                </label>
            </div>
            <div id="thumbnail-preview" class="file-preview"></div>
            @error('thumbnail')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">📋 وصف العمل</label>
            <textarea id="description" name="description" rows="4" 
                      class="form-input @error('description') error @enderror" 
                      placeholder="اشرح تفاصيل العمل، التحديات التي واجهتها، والحلول التي قدمتها..." required>{{ old('description') }}</textarea>
            @error('description')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="preview_url" class="form-label">🔗 رابط المعاينة</label>
                <input type="url" id="preview_url" name="preview_url" value="{{ old('preview_url') }}" 
                       class="form-input" placeholder="https://example.com">
            </div>
            <div class="form-group">
                <label for="delivered_at" class="form-label">📅 تاريخ الإنجاز</label>
                <input type="date" id="delivered_at" name="delivered_at" value="{{ old('delivered_at') }}" 
                       class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label for="skills" class="form-label">🛠️ المهارات المستخدمة</label>
            <input type="text" id="skills" name="skills" value="{{ old('skills') }}" 
                   class="form-input" 
                   placeholder="مثال: Photoshop, Illustrator, UI/UX Design">
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1" required>
            <label for="terms_accepted">أؤكد أن العمل من إنجازي ولدي صلاحية نشره</label>
        </div>
        @error('terms_accepted')
            <div class="form-error">⚠️ {{ $message }}</div>
        @enderror

        <div style="display: flex; justify-content: space-between; gap: 16px; margin-top: 32px;">
            <a href="{{ route('onboarding.freelancer') }}" class="btn btn-outline" style="flex: 1;">
                ← السابق
            </a>
            <button type="submit" class="btn btn-primary" style="flex: 2;" id="addWorkBtn" disabled>
                ✨ أضف العمل
            </button>
        </div>

        @if($worksCount >= 3)
            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.2);">
                <a href="{{ route('dashboard') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3);">
                    🎉 إنهاء وانتقال للوحة التحكم
                </a>
                <p style="margin-top: 12px; opacity: 0.8; font-size: 14px;">
                    تهانينا! لقد أكملت إعداد ملفك الشخصي بنجاح
                </p>
            </div>
        @endif
    </form>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="معاينة الصورة">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
}

// Enable/disable add work button based on form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const addWorkBtn = document.getElementById('addWorkBtn');
    const requiredFields = form.querySelectorAll('input[required], textarea[required], input[type="checkbox"][required]');
    
    function checkFormValidity() {
        let isValid = true;
        requiredFields.forEach(field => {
            if (field.type === 'checkbox') {
                if (!field.checked) isValid = false;
            } else {
                if (!field.value.trim()) isValid = false;
            }
        });
        addWorkBtn.disabled = !isValid;
        addWorkBtn.style.opacity = isValid ? '1' : '0.5';
    }
    
    // Check on page load
    checkFormValidity();
    
    // Check on input change
    requiredFields.forEach(field => {
        field.addEventListener('input', checkFormValidity);
        field.addEventListener('change', checkFormValidity);
    });
});
</script>
@endsection
