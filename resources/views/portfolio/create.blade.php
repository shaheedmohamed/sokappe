@extends('layouts.app')

@section('title', 'إضافة عمل جديد')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 30px; margin-bottom: 30px; color: white; text-align: center;">
        <h1 style="margin: 0 0 10px; font-size: 24px;">🎨 إضافة عمل جديد</h1>
        <p style="margin: 0; opacity: 0.9;">أضف عملاً جديداً إلى معرض أعمالك لجذب المزيد من العملاء</p>
    </div>

    <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Basic Information -->
        <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                📋 المعلومات الأساسية
            </h2>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">عنوان العمل *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                       placeholder="مثال: تطوير موقع إلكتروني لشركة تجارية">
                @error('title')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">التخصص *</label>
                    <select name="category" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">اختر التخصص</option>
                        <option value="web-development" {{ old('category') === 'web-development' ? 'selected' : '' }}>تطوير المواقع</option>
                        <option value="mobile-development" {{ old('category') === 'mobile-development' ? 'selected' : '' }}>تطوير التطبيقات</option>
                        <option value="ui-ux-design" {{ old('category') === 'ui-ux-design' ? 'selected' : '' }}>تصميم UI/UX</option>
                        <option value="graphic-design" {{ old('category') === 'graphic-design' ? 'selected' : '' }}>التصميم الجرافيكي</option>
                        <option value="digital-marketing" {{ old('category') === 'digital-marketing' ? 'selected' : '' }}>التسويق الرقمي</option>
                        <option value="content-writing" {{ old('category') === 'content-writing' ? 'selected' : '' }}>كتابة المحتوى</option>
                        <option value="translation" {{ old('category') === 'translation' ? 'selected' : '' }}>الترجمة</option>
                        <option value="data-analysis" {{ old('category') === 'data-analysis' ? 'selected' : '' }}>تحليل البيانات</option>
                    </select>
                    @error('category')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">تاريخ الإكمال</label>
                    <input type="date" name="completion_date" value="{{ old('completion_date') }}"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    @error('completion_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">وصف العمل *</label>
                <textarea name="description" rows="5" required
                          style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;"
                          placeholder="اكتب وصفاً مفصلاً عن العمل، التحديات التي واجهتها، والحلول التي قدمتها...">{{ old('description') }}</textarea>
                @error('description')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                <label for="is_featured" style="color: #374151; cursor: pointer;">⭐ عمل مميز (سيظهر في المقدمة)</label>
            </div>
        </div>

        <!-- Technologies -->
        <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                🛠️ التقنيات المستخدمة
            </h2>

            <div id="technologiesContainer">
                @if(old('technologies'))
                    @foreach(old('technologies') as $tech)
                        <div class="tech-item" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center;">
                            <input type="text" name="technologies[]" value="{{ $tech }}" 
                                   style="flex: 1; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
                                   placeholder="اسم التقنية">
                            <button type="button" onclick="removeTech(this)" 
                                    style="padding: 10px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                ✕
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="tech-item" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center;">
                        <input type="text" name="technologies[]" 
                               style="flex: 1; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
                               placeholder="اسم التقنية">
                        <button type="button" onclick="removeTech(this)" 
                                style="padding: 10px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
                            ✕
                        </button>
                    </div>
                @endif
            </div>

            <button type="button" onclick="addTech()" 
                    style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; margin-top: 10px;">
                ➕ إضافة تقنية
            </button>

            <!-- Popular Technologies -->
            <div style="margin-top: 20px;">
                <p style="font-weight: 600; margin-bottom: 10px; color: #374151;">تقنيات شائعة:</p>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @php
                        $popularTechs = ['HTML', 'CSS', 'JavaScript', 'PHP', 'Laravel', 'React', 'Vue.js', 'Node.js', 'Python', 'MySQL', 'Photoshop', 'Illustrator', 'Figma', 'WordPress', 'Bootstrap', 'Tailwind CSS'];
                    @endphp
                    @foreach($popularTechs as $tech)
                        <button type="button" onclick="addPopularTech('{{ $tech }}')" 
                                style="padding: 6px 12px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 16px; font-size: 12px; cursor: pointer; transition: all 0.2s;">
                            {{ $tech }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Images -->
        <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                📷 صور العمل
            </h2>

            <div style="margin-bottom: 20px;">
                <input type="file" name="images[]" id="imagesInput" multiple accept="image/*" 
                       style="width: 100%; padding: 12px; border: 2px dashed #d1d5db; border-radius: 8px; background: #f9fafb;">
                <p style="margin: 10px 0 0; font-size: 12px; color: #6b7280;">
                    يمكنك رفع حتى 5 صور (JPG, PNG, GIF) - الحد الأقصى 2MB لكل صورة
                </p>
                @error('images')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                @error('images.*')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <!-- Image Preview -->
            <div id="imagePreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-top: 20px;"></div>
        </div>

        <!-- Links -->
        <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                🔗 الروابط
            </h2>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">رابط المشروع</label>
                    <input type="url" name="project_url" value="{{ old('project_url') }}"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                           placeholder="https://example.com">
                    @error('project_url')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">رابط GitHub</label>
                    <input type="url" name="github_url" value="{{ old('github_url') }}"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                           placeholder="https://github.com/username/project">
                    @error('github_url')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="{{ route('portfolio.index') }}" 
               style="padding: 15px 30px; background: #6b7280; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                إلغاء
            </a>
            <button type="submit" 
                    style="padding: 15px 30px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                💾 حفظ العمل
            </button>
        </div>
    </form>
</div>

<script>
function addTech() {
    const container = document.getElementById('technologiesContainer');
    const techItem = document.createElement('div');
    techItem.className = 'tech-item';
    techItem.style = 'display: flex; gap: 10px; margin-bottom: 10px; align-items: center;';
    techItem.innerHTML = `
        <input type="text" name="technologies[]" 
               style="flex: 1; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
               placeholder="اسم التقنية">
        <button type="button" onclick="removeTech(this)" 
                style="padding: 10px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
            ✕
        </button>
    `;
    container.appendChild(techItem);
}

function removeTech(button) {
    button.closest('.tech-item').remove();
}

function addPopularTech(techName) {
    const container = document.getElementById('technologiesContainer');
    const techInputs = container.querySelectorAll('input[name="technologies[]"]');
    
    // Check if tech already exists
    for (let input of techInputs) {
        if (input.value.toLowerCase() === techName.toLowerCase()) {
            return; // Tech already exists
        }
    }
    
    // Add new tech
    addTech();
    const newTechInput = container.querySelector('.tech-item:last-child input[name="technologies[]"]');
    newTechInput.value = techName;
}

// Image preview
document.getElementById('imagesInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    const files = Array.from(e.target.files);
    
    if (files.length > 5) {
        alert('يمكنك رفع حتى 5 صور فقط');
        e.target.value = '';
        return;
    }
    
    files.forEach((file, index) => {
        if (file.size > 2048 * 1024) {
            alert(`الصورة ${file.name} أكبر من 2MB`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.style = 'position: relative; border-radius: 8px; overflow: hidden; border: 2px solid #e5e7eb;';
            div.innerHTML = `
                <img src="${e.target.result}" style="width: 100%; height: 120px; object-fit: cover;">
                <div style="position: absolute; top: 5px; right: 5px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px;">
                    ${index + 1}
                </div>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
