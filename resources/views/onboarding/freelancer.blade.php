@extends('layouts.guest')

@section('content')
<div class="auth-header">
    <h1>👨‍💼 بيانات المستقل</h1>
    <p>أضف معلوماتك المهنية لإكمال ملفك الشخصي</p>
    
    <!-- Progress Steps -->
    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 20px;">
        @for($i = 1; $i <= $totalSteps; $i++)
            <div style="width: 40px; height: 4px; border-radius: 2px; background: {{ $i <= $step ? 'rgba(255,255,255,0.8)' : 'rgba(255,255,255,0.3)' }};"></div>
        @endfor
    </div>
    <div style="text-align: center; margin-top: 8px; opacity: 0.8; font-size: 14px;">
        الخطوة {{ $step }} من {{ $totalSteps }}
    </div>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('onboarding.freelancer.save') }}">
        @csrf
        
        <div class="form-group">
            <label for="title" class="form-label">🎯 المسمى الوظيفي</label>
            <input type="text" id="title" name="title" value="{{ old('title', $profile->title) }}" 
                   class="form-input @error('title') error @enderror" 
                   placeholder="مثال: مطور ويب، مصمم جرافيك، كاتب محتوى" required>
            @error('title')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category" class="form-label">📂 نوع المجال</label>
            <select id="category" name="category" class="form-input @error('category') error @enderror" required>
                <option value="">اختر مجال تخصصك</option>
                <option value="تطوير وبرمجة" {{ old('category', $profile->category) == 'تطوير وبرمجة' ? 'selected' : '' }}>تطوير وبرمجة</option>
                <option value="تصميم وجرافيك" {{ old('category', $profile->category) == 'تصميم وجرافيك' ? 'selected' : '' }}>تصميم وجرافيك</option>
                <option value="كتابة وترجمة" {{ old('category', $profile->category) == 'كتابة وترجمة' ? 'selected' : '' }}>كتابة وترجمة</option>
                <option value="تسويق رقمي" {{ old('category', $profile->category) == 'تسويق رقمي' ? 'selected' : '' }}>تسويق رقمي</option>
                <option value="صوتيات ومرئيات" {{ old('category', $profile->category) == 'صوتيات ومرئيات' ? 'selected' : '' }}>صوتيات ومرئيات</option>
                <option value="أعمال وإدارة" {{ old('category', $profile->category) == 'أعمال وإدارة' ? 'selected' : '' }}>أعمال وإدارة</option>
                <option value="تدريب وتعليم" {{ old('category', $profile->category) == 'تدريب وتعليم' ? 'selected' : '' }}>تدريب وتعليم</option>
                <option value="أخرى" {{ old('category', $profile->category) == 'أخرى' ? 'selected' : '' }}>أخرى</option>
            </select>
            @error('category')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="skills" class="form-label">🛠️ المهارات</label>
            <input type="text" id="skills" name="skills" value="{{ old('skills', $profile->skills) }}" 
                   class="form-input" 
                   placeholder="مثال: PHP, Laravel, JavaScript, React (افصل بينها بفاصلة)">
            <div style="font-size: 12px; color: var(--gray-500); margin-top: 4px;">
                💡 اكتب مهاراتك مفصولة بفواصل لتسهيل العثور عليك
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 16px; margin-top: 32px;">
            <a href="{{ route('onboarding.role') }}" class="btn btn-outline" style="flex: 1;">
                ← السابق
            </a>
            <button type="submit" class="btn btn-primary" style="flex: 2;" id="nextBtn" disabled>
                التالي ➡️
            </button>
        </div>
    </form>
</div>

<script>
// Enable/disable next button based on form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nextBtn = document.getElementById('nextBtn');
    const requiredFields = form.querySelectorAll('input[required], select[required]');
    
    function checkFormValidity() {
        let isValid = true;
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
            }
        });
        nextBtn.disabled = !isValid;
        nextBtn.style.opacity = isValid ? '1' : '0.5';
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
