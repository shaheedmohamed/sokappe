@extends('layouts.app')

@section('content')
<div class="form-container">
  <div class="form-header">
    <h1>⭐ إضافة خدمة جاهزة</h1>
    <p>اعرض خدماتك المميزة واحصل على طلبات من العملاء مباشرة</p>
  </div>
  
  <div class="form-card">
    <form action="{{ route('services.store') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label class="form-label" for="title">🎯 عنوان الخدمة *</label>
        <input class="form-input @error('title') error @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="مثال: تصميم لوجو احترافي مع 3 مفاهيم" required>
        <div class="form-hint">اكتب عنواناً جذاباً يوضح ما تقدمه بدقة</div>
        @error('title')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="category">🏷️ التصنيف *</label>
        <select class="form-input @error('category') error @enderror" id="category" name="category" required>
          <option value="">اختر تصنيف الخدمة</option>
          <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>التصميم والجرافيك</option>
          <option value="web-development" {{ old('category') == 'web-development' ? 'selected' : '' }}>تطوير المواقع</option>
          <option value="mobile-development" {{ old('category') == 'mobile-development' ? 'selected' : '' }}>تطوير التطبيقات</option>
          <option value="writing" {{ old('category') == 'writing' ? 'selected' : '' }}>الكتابة والترجمة</option>
          <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>التسويق الرقمي</option>
          <option value="video-editing" {{ old('category') == 'video-editing' ? 'selected' : '' }}>المونتاج والفيديو</option>
          <option value="voice-over" {{ old('category') == 'voice-over' ? 'selected' : '' }}>التعليق الصوتي</option>
          <option value="data-entry" {{ old('category') == 'data-entry' ? 'selected' : '' }}>إدخال البيانات</option>
          <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>خدمات الأعمال</option>
        </select>
        @error('category')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">📝 وصف الخدمة *</label>
        <textarea class="form-input form-textarea @error('description') error @enderror" id="description" name="description" placeholder="اشرح ما تقدمه في هذه الخدمة، المميزات، والتسليمات بالتفصيل..." required rows="6">{{ old('description') }}</textarea>
        <div class="form-hint">وضح بالتفصيل ما سيحصل عليه العميل وما يميز خدمتك</div>
        @error('description')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="price">💵 السعر *</label>
          <div class="price-input-container">
            <input class="form-input @error('price') error @enderror" type="number" id="price" name="price" value="{{ old('price') }}" placeholder="250" required min="5">
            <span class="price-currency">جنيه</span>
          </div>
          <div class="form-hint">حدد سعراً تنافسياً يتناسب مع جودة خدمتك</div>
          @error('price')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="delivery_days">🚀 مدة التسليم *</label>
          <select class="form-input @error('delivery_days') error @enderror" id="delivery_days" name="delivery_days" required>
            <option value="">اختر مدة التسليم</option>
            <option value="1" {{ old('delivery_days') == '1' ? 'selected' : '' }}>يوم واحد</option>
            <option value="2" {{ old('delivery_days') == '2' ? 'selected' : '' }}>يومان</option>
            <option value="3" {{ old('delivery_days') == '3' ? 'selected' : '' }}>3 أيام</option>
            <option value="5" {{ old('delivery_days') == '5' ? 'selected' : '' }}>5 أيام</option>
            <option value="7" {{ old('delivery_days') == '7' ? 'selected' : '' }}>أسبوع</option>
            <option value="14" {{ old('delivery_days') == '14' ? 'selected' : '' }}>أسبوعان</option>
            <option value="30" {{ old('delivery_days') == '30' ? 'selected' : '' }}>شهر</option>
          </select>
          @error('delivery_days')<span class="form-error">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="image">🖼️ صورة الخدمة</label>
        <input class="form-input @error('image') error @enderror" type="url" id="image" name="image" value="{{ old('image') }}" placeholder="https://example.com/image.jpg">
        <div class="form-hint">أضف رابط صورة توضح خدمتك (اختياري)</div>
        @error('image')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="skills">🛠️ المهارات المستخدمة</label>
        <div class="skills-input-container">
          <input class="form-input" type="text" id="skills" name="skills" value="{{ old('skills') }}" placeholder="اكتب المهارة واضغط Enter">
          <div class="skills-suggestions">
            <button type="button" class="skill-tag" data-skill="Photoshop">Photoshop</button>
            <button type="button" class="skill-tag" data-skill="Illustrator">Illustrator</button>
            <button type="button" class="skill-tag" data-skill="HTML">HTML</button>
            <button type="button" class="skill-tag" data-skill="CSS">CSS</button>
            <button type="button" class="skill-tag" data-skill="JavaScript">JavaScript</button>
            <button type="button" class="skill-tag" data-skill="WordPress">WordPress</button>
            <button type="button" class="skill-tag" data-skill="SEO">SEO</button>
            <button type="button" class="skill-tag" data-skill="Social Media">Social Media</button>
          </div>
          <div class="selected-skills" id="selectedSkills"></div>
        </div>
        <div class="form-hint">أضف المهارات التي تستخدمها في هذه الخدمة</div>
      </div>

      <div class="form-actions">
        <button type="button" class="btn" onclick="history.back()">حفظ كمسودة</button>
        <button type="submit" class="btn success btn-lg">⭐ نشر الخدمة الآن</button>
      </div>
    </form>
  </div>
  
  <div class="help-sidebar">
    <h3>💡 نصائح لخدمة ناجحة</h3>
    <ul>
      <li>✅ اكتب عنواناً جذاباً وواضحاً</li>
      <li>✅ اشرح ما تقدمه بالتفصيل</li>
      <li>✅ حدد سعراً تنافسياً</li>
      <li>✅ أضف صوراً توضيحية جذابة</li>
      <li>✅ حدد مدة تسليم واقعية</li>
      <li>✅ استخدم كلمات مفتاحية مناسبة</li>
      <li>✅ وضح ما يحصل عليه العميل بالضبط</li>
      <li>✅ اذكر عدد المراجعات المتاحة</li>
      <li>✅ أضف أمثلة من أعمالك السابقة</li>
      <li>✅ كن واضحاً في شروط الخدمة</li>
    </ul>
    
    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #93c5fd;">
      <h4 style="color: #1e40af; margin-bottom: 12px; font-size: 14px;">🎯 أمثلة لعناوين ناجحة:</h4>
      <div style="font-size: 12px; color: #1e40af; line-height: 1.6;">
        • "تصميم لوجو احترافي مع 3 مفاهيم + ملفات مفتوحة"<br>
        • "كتابة مقال SEO 1000 كلمة + بحث الكلمات المفتاحية"<br>
        • "تطوير موقع ووردبريس متجاوب + تدريب مجاني"
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
    background: linear-gradient(135deg, #f0f9ff 0%, #dbeafe 100%);
    padding: 30px;
    border-radius: 12px;
    border: 1px solid #bfdbfe;
    min-height: 500px;
    display: flex;
    flex-direction: column;
    order: 2;
}

.help-sidebar h3 {
    color: #1e40af;
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
    color: #1e40af;
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

.price-input-container {
    position: relative;
    display: flex;
    align-items: center;
}

.price-currency {
    position: absolute;
    right: 15px;
    color: #64748b;
    font-size: 14px;
    pointer-events: none;
}

.price-input-container input {
    padding-right: 50px;
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
    background: #f0f9ff;
    border-radius: 8px;
    border: 1px solid #bfdbfe;
}

.skill-tag {
    background: white;
    border: 1px solid #93c5fd;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
    color: #1e40af;
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
