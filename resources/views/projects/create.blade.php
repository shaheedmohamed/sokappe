@extends('layouts.app')

@section('content')
<div class="form-container">
  <div class="form-header">
    <h1>🚀 إضافة مشروع</h1>
    <p>أضف تفاصيل مشروعك وابدأ في استقبال العروض من أفضل المحترفين</p>
  </div>
  
  <div class="form-card">
    <form action="{{ route('projects.store') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label class="form-label" for="title">📝 عنوان المشروع *</label>
        <input class="form-input @error('title') error @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="مثال: تصميم موقع إلكتروني لشركة ناشئة" required>
        <div class="form-hint">اكتب عنواناً واضحاً يصف مشروعك في جملة واحدة</div>
        @error('title')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="category">🏷️ التصنيف *</label>
        <select class="form-input @error('category') error @enderror" id="category" name="category" required>
          <option value="">اختر التصنيف المناسب</option>
          <option value="web-development" {{ old('category') == 'web-development' ? 'selected' : '' }}>تطوير المواقع</option>
          <option value="mobile-development" {{ old('category') == 'mobile-development' ? 'selected' : '' }}>تطوير التطبيقات</option>
          <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>التصميم</option>
          <option value="writing" {{ old('category') == 'writing' ? 'selected' : '' }}>الكتابة والترجمة</option>
          <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>التسويق الرقمي</option>
          <option value="data-entry" {{ old('category') == 'data-entry' ? 'selected' : '' }}>إدخال البيانات</option>
          <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>الأعمال</option>
          <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>أخرى</option>
        </select>
        @error('category')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">📋 وصف المشروع *</label>
        <textarea class="form-input form-textarea @error('description') error @enderror" id="description" name="description" placeholder="اشرح تفاصيل مشروعك، المتطلبات، والنتائج المتوقعة بالتفصيل..." required rows="8">{{ old('description') }}</textarea>
        <div class="form-hint">كلما كان الوصف أكثر تفصيلاً، كانت العروض أكثر دقة ومناسبة</div>
        @error('description')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="budget_min">💰 الميزانية (حد أدنى)</label>
          <input class="form-input @error('budget_min') error @enderror" type="number" id="budget_min" name="budget_min" value="{{ old('budget_min') }}" placeholder="1000">
          @error('budget_min')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="budget_max">💰 الميزانية (حد أقصى)</label>
          <input class="form-input @error('budget_max') error @enderror" type="number" id="budget_max" name="budget_max" value="{{ old('budget_max') }}" placeholder="5000">
          @error('budget_max')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="duration">⏰ مدة التنفيذ</label>
          <input class="form-input @error('duration') error @enderror" type="text" id="duration" name="duration" value="{{ old('duration') }}" placeholder="14 يوم">
          @error('duration')<span class="form-error">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="skills">🛠️ المهارات المطلوبة *</label>
        <div class="skills-input-container">
          <input class="form-input @error('skills') error @enderror" type="text" id="skills" name="skills" value="{{ old('skills') }}" placeholder="اكتب المهارة واضغط Enter">
          <div class="skills-suggestions">
            <button type="button" class="skill-tag" data-skill="HTML">HTML</button>
            <button type="button" class="skill-tag" data-skill="CSS">CSS</button>
            <button type="button" class="skill-tag" data-skill="JavaScript">JavaScript</button>
            <button type="button" class="skill-tag" data-skill="PHP">PHP</button>
            <button type="button" class="skill-tag" data-skill="Laravel">Laravel</button>
            <button type="button" class="skill-tag" data-skill="React">React</button>
            <button type="button" class="skill-tag" data-skill="Vue.js">Vue.js</button>
            <button type="button" class="skill-tag" data-skill="WordPress">WordPress</button>
            <button type="button" class="skill-tag" data-skill="Photoshop">Photoshop</button>
            <button type="button" class="skill-tag" data-skill="Illustrator">Illustrator</button>
          </div>
          <div class="selected-skills" id="selectedSkills"></div>
        </div>
        <div class="form-hint">اختر المهارات التي يحتاجها المشروع أو اكتب مهارات أخرى</div>
        @error('skills')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-actions">
        <button type="button" class="btn" onclick="history.back()">حفظ كمسودة</button>
        <button type="submit" class="btn primary btn-lg">🚀 نشر المشروع الآن</button>
      </div>
    </form>
  </div>
  
  <div class="help-sidebar">
    <h3>🚀 نصائح للحصول على عروض أفضل</h3>
    <ul>
      <li>✅ وضح متطلبات المشروع بالتفصيل</li>
      <li>✅ حدد ميزانية واقعية ومناسبة</li>
      <li>✅ اختر المهارات المطلوبة بدقة</li>
      <li>✅ حدد مدة زمنية مناسبة للتنفيذ</li>
      <li>✅ أضف أمثلة أو مراجع للتصميم المطلوب</li>
      <li>✅ اذكر التسليمات المطلوبة بوضوح</li>
      <li>✅ حدد معايير قبول المشروع</li>
      <li>✅ اشرح الهدف من المشروع</li>
      <li>✅ حدد الجمهور المستهدف</li>
      <li>✅ اذكر أي متطلبات تقنية خاصة</li>
    </ul>
    
    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #cbd5e1;">
      <h4 style="color: #1e293b; margin-bottom: 12px; font-size: 14px;">💡 أمثلة لمشاريع واضحة:</h4>
      <div style="font-size: 12px; color: #475569; line-height: 1.6;">
        • "تصميم موقع تجارة إلكترونية بـ WordPress + نظام دفع"<br>
        • "تطبيق جوال لحجز المواعيد مع إشعارات push"<br>
        • "هوية بصرية كاملة لمطعم + دليل الاستخدام"
      </div>
    </div>
  </div>
</div>
<style>
.form-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
}

.form-header {
    grid-column: 1 / -1;
    text-align: center;
    margin-bottom: 30px;
}

.help-sidebar {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 30px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    min-height: 500px;
    display: flex;
    flex-direction: column;
    order: 2;
}

.help-sidebar h3 {
    color: #1e293b;
    margin-bottom: 15px;
    font-size: 16px;
}

.help-sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.help-sidebar li {
    padding: 8px 0;
    font-size: 14px;
    color: #475569;
    line-height: 1.5;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-hint {
    font-size: 12px;
    color: #64748b;
    margin-top: 6px;
    line-height: 1.4;
}

.skills-input-container {
    position: relative;
}

.skills-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.skill-tag {
    background: white;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
    color: #475569;
}

.skill-tag:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.skill-tag.selected {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.selected-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

.selected-skill {
    background: #3b82f6;
    color: white;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.remove-skill {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 14px;
    padding: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-skill:hover {
    background: rgba(255,255,255,0.2);
}

@media (max-width: 768px) {
    .form-container {
        grid-template-columns: 1fr;
        padding: 15px;
    }
    
    .help-sidebar {
        position: static;
        order: -1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const skillsInput = document.getElementById('skills');
    const selectedSkillsContainer = document.getElementById('selectedSkills');
    const skillTags = document.querySelectorAll('.skill-tag');
    let selectedSkills = [];

    // Load existing skills from input
    if (skillsInput.value) {
        selectedSkills = skillsInput.value.split(',').map(s => s.trim()).filter(s => s);
        updateSelectedSkillsDisplay();
    }

    // Handle skill tag clicks
    skillTags.forEach(tag => {
        tag.addEventListener('click', function() {
            const skill = this.dataset.skill;
            if (!selectedSkills.includes(skill)) {
                selectedSkills.push(skill);
                updateSelectedSkillsDisplay();
                updateSkillsInput();
                this.classList.add('selected');
            }
        });
    });

    // Handle Enter key in skills input
    skillsInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const skill = this.value.trim();
            if (skill && !selectedSkills.includes(skill)) {
                selectedSkills.push(skill);
                updateSelectedSkillsDisplay();
                updateSkillsInput();
                this.value = '';
            }
        }
    });

    function updateSelectedSkillsDisplay() {
        selectedSkillsContainer.innerHTML = '';
        selectedSkills.forEach(skill => {
            const skillElement = document.createElement('div');
            skillElement.className = 'selected-skill';
            skillElement.innerHTML = `
                ${skill}
                <button type="button" class="remove-skill" onclick="removeSkill('${skill}')">×</button>
            `;
            selectedSkillsContainer.appendChild(skillElement);
        });

        // Update skill tag states
        skillTags.forEach(tag => {
            if (selectedSkills.includes(tag.dataset.skill)) {
                tag.classList.add('selected');
            } else {
                tag.classList.remove('selected');
            }
        });
    }

    function updateSkillsInput() {
        skillsInput.value = selectedSkills.join(', ');
    }

    // Make removeSkill function global
    window.removeSkill = function(skill) {
        selectedSkills = selectedSkills.filter(s => s !== skill);
        updateSelectedSkillsDisplay();
        updateSkillsInput();
    };
});
</script>
@endsection
