@extends('layouts.guest')

@section('content')
<div class="auth-header">
    <h1>🎯 اختر نوع حسابك</h1>
    <p>حدد كيف تريد استخدام Sokappe</p>
    
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
    <form method="POST" action="{{ route('onboarding.role.save') }}">
        @csrf
        
        <div style="display: grid; gap: 20px; margin-bottom: 30px;">
            <label for="roleEmployer" style="cursor: pointer;">
                <div style="border: 2px solid var(--gray-200); border-radius: 16px; padding: 24px; transition: all 0.3s; background: var(--gray-50);" 
                     class="role-option" data-role="employer">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <input type="radio" name="role" id="roleEmployer" value="employer" required style="width: 20px; height: 20px; accent-color: var(--primary);">
                        <div>
                            <div style="font-size: 48px; margin-bottom: 8px;">💼</div>
                            <h3 style="margin: 0 0 8px; color: var(--gray-800);">طالب خدمة</h3>
                            <p style="margin: 0; color: var(--gray-600); font-size: 14px;">أنشر مشاريعك واحصل على عروض من المستقلين المحترفين</p>
                        </div>
                    </div>
                </div>
            </label>

            <label for="roleFreelancer" style="cursor: pointer;">
                <div style="border: 2px solid var(--gray-200); border-radius: 16px; padding: 24px; transition: all 0.3s; background: var(--gray-50);" 
                     class="role-option" data-role="freelancer">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <input type="radio" name="role" id="roleFreelancer" value="freelancer" required style="width: 20px; height: 20px; accent-color: var(--primary);">
                        <div>
                            <div style="font-size: 48px; margin-bottom: 8px;">⭐</div>
                            <h3 style="margin: 0 0 8px; color: var(--gray-800);">مستقل</h3>
                            <p style="margin: 0; color: var(--gray-600); font-size: 14px;">اعرض خدماتك وابدأ في كسب المال من مهاراتك</p>
                        </div>
                    </div>
                </div>
            </label>
        </div>

        @error('role')
            <div class="form-error" style="margin-bottom: 20px;">⚠️ {{ $message }}</div>
        @enderror

        <div style="display: flex; justify-content: flex-end; margin-top: 32px;">
            <button type="submit" class="btn btn-primary" id="nextBtn" disabled style="flex: 1; max-width: 200px;">
                التالي 🚀
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nextBtn = document.getElementById('nextBtn');
    const roleInputs = document.querySelectorAll('input[name="role"]');
    
    function checkSelection() {
        const isSelected = Array.from(roleInputs).some(input => input.checked);
        nextBtn.disabled = !isSelected;
        nextBtn.style.opacity = isSelected ? '1' : '0.5';
    }
    
    // Check on page load
    checkSelection();
    
    // Handle role selection
    document.querySelectorAll('.role-option').forEach(option => {
        option.addEventListener('click', function() {
            // Visual feedback
            document.querySelectorAll('.role-option').forEach(opt => {
                opt.style.borderColor = 'var(--gray-200)';
                opt.style.background = 'var(--gray-50)';
            });
            this.style.borderColor = 'var(--primary)';
            this.style.background = 'rgba(59, 130, 246, 0.05)';
            
            // Check form validity
            setTimeout(checkSelection, 10);
        });
    });
    
    // Listen to radio button changes
    roleInputs.forEach(input => {
        input.addEventListener('change', checkSelection);
    });
});
</script>
@endsection
