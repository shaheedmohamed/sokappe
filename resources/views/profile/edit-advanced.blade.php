@extends('layouts.app')

@section('title', 'تعديل الملف الشخصي')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 40px; margin-bottom: 30px; color: white; text-align: center;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 20px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 600;">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h1 style="margin: 0; font-size: 28px;">{{ Auth::user()->name }}</h1>
                <p style="margin: 5px 0 0; opacity: 0.9;">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <p style="margin: 0; opacity: 0.8;">قم بتحديث ملفك الشخصي لجذب المزيد من العملاء والفرص</p>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update-advanced') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            <!-- Main Content -->
            <div>
                <!-- Basic Information -->
                <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                        👤 المعلومات الأساسية
                    </h2>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">الاسم الكامل *</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                            @error('name')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">اسم المستخدم *</label>
                            <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" required
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="username123">
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                سيكون رابط ملفك: /u/{{ old('username', Auth::user()->username ?: 'username') }}
                            </div>
                            @error('username')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">البريد الإلكتروني *</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        @error('email')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">المسمى الوظيفي</label>
                        <input type="text" name="title" value="{{ old('title', $profile->title) }}"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                               placeholder="مثال: مطور Full Stack، مصمم UI/UX">
                        @error('title')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">التخصص</label>
                        <select name="specialization" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                            <option value="">اختر التخصص</option>
                            <option value="web-development" {{ old('specialization', $profile->specialization) === 'web-development' ? 'selected' : '' }}>تطوير المواقع</option>
                            <option value="mobile-development" {{ old('specialization', $profile->specialization) === 'mobile-development' ? 'selected' : '' }}>تطوير التطبيقات</option>
                            <option value="ui-ux-design" {{ old('specialization', $profile->specialization) === 'ui-ux-design' ? 'selected' : '' }}>تصميم UI/UX</option>
                            <option value="graphic-design" {{ old('specialization', $profile->specialization) === 'graphic-design' ? 'selected' : '' }}>التصميم الجرافيكي</option>
                            <option value="digital-marketing" {{ old('specialization', $profile->specialization) === 'digital-marketing' ? 'selected' : '' }}>التسويق الرقمي</option>
                            <option value="content-writing" {{ old('specialization', $profile->specialization) === 'content-writing' ? 'selected' : '' }}>كتابة المحتوى</option>
                            <option value="translation" {{ old('specialization', $profile->specialization) === 'translation' ? 'selected' : '' }}>الترجمة</option>
                            <option value="data-analysis" {{ old('specialization', $profile->specialization) === 'data-analysis' ? 'selected' : '' }}>تحليل البيانات</option>
                        </select>
                        @error('specialization')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">الموقع</label>
                            <input type="text" name="location" value="{{ old('location', $profile->location) }}"
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="مثال: القاهرة، مصر">
                            @error('location')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="+20 123 456 7890">
                            @error('phone')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <!-- Bio & Experience -->
                <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                        📝 النبذة التعريفية والخبرة
                    </h2>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">النبذة التعريفية</label>
                        <textarea name="bio" rows="4" 
                                  style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;"
                                  placeholder="اكتب نبذة مختصرة عن نفسك وخبراتك...">{{ old('bio', $profile->bio) }}</textarea>
                        @error('bio')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">الخبرة والإنجازات</label>
                        <textarea name="experience" rows="6" 
                                  style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;"
                                  placeholder="اكتب تفاصيل خبراتك المهنية والمشاريع التي عملت عليها...">{{ old('experience', $profile->experience) }}</textarea>
                        @error('experience')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">السعر بالساعة (بالدولار)</label>
                        <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $profile->hourly_rate) }}" step="0.01" min="0"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                               placeholder="25.00">
                        @error('hourly_rate')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Skills -->
                <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                        🛠️ المهارات
                    </h2>

                    <div id="skillsContainer">
                        @if($skills->count() > 0)
                            @foreach($skills as $skill)
                                <div class="skill-item" style="display: grid; grid-template-columns: 1fr 150px 40px; gap: 15px; margin-bottom: 15px; align-items: end;">
                                    <div>
                                        <input type="text" name="skills[]" value="{{ $skill->skill_name }}" 
                                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                               placeholder="اسم المهارة">
                                    </div>
                                    <div>
                                        <select name="skill_levels[]" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                                            <option value="beginner" {{ $skill->proficiency === 'beginner' ? 'selected' : '' }}>مبتدئ</option>
                                            <option value="intermediate" {{ $skill->proficiency === 'intermediate' ? 'selected' : '' }}>متوسط</option>
                                            <option value="advanced" {{ $skill->proficiency === 'advanced' ? 'selected' : '' }}>متقدم</option>
                                            <option value="expert" {{ $skill->proficiency === 'expert' ? 'selected' : '' }}>خبير</option>
                                        </select>
                                    </div>
                                    <button type="button" onclick="removeSkill(this)" style="padding: 12px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer;">
                                        ✕
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="skill-item" style="display: grid; grid-template-columns: 1fr 150px 40px; gap: 15px; margin-bottom: 15px; align-items: end;">
                                <div>
                                    <input type="text" name="skills[]" 
                                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                           placeholder="اسم المهارة">
                                </div>
                                <div>
                                    <select name="skill_levels[]" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                                        <option value="beginner">مبتدئ</option>
                                        <option value="intermediate" selected>متوسط</option>
                                        <option value="advanced">متقدم</option>
                                        <option value="expert">خبير</option>
                                    </select>
                                </div>
                                <button type="button" onclick="removeSkill(this)" style="padding: 12px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer;">
                                    ✕
                                </button>
                            </div>
                        @endif
                    </div>

                    <button type="button" onclick="addSkill()" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 8px; cursor: pointer; margin-top: 15px;">
                        ➕ إضافة مهارة
                    </button>

                    <!-- Popular Skills -->
                    <div style="margin-top: 20px;">
                        <p style="font-weight: 600; margin-bottom: 10px; color: #374151;">مهارات شائعة:</p>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @php
                                $popularSkills = ['HTML', 'CSS', 'JavaScript', 'PHP', 'Laravel', 'React', 'Vue.js', 'Node.js', 'Python', 'MySQL', 'Photoshop', 'Illustrator', 'Figma', 'WordPress'];
                            @endphp
                            @foreach($popularSkills as $skill)
                                <button type="button" onclick="addPopularSkill('{{ $skill }}')" 
                                        style="padding: 6px 12px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 16px; font-size: 12px; cursor: pointer; transition: all 0.2s;">
                                    {{ $skill }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Links & Portfolio -->
                <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                        🔗 الروابط والأعمال
                    </h2>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">الموقع الشخصي</label>
                            <input type="url" name="website" value="{{ old('website', $profile->website) }}"
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="https://example.com">
                            @error('website')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">LinkedIn</label>
                            <input type="url" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}"
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="https://linkedin.com/in/username">
                            @error('linkedin')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">GitHub</label>
                            <input type="url" name="github" value="{{ old('github', $profile->github) }}"
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="https://github.com/username">
                            @error('github')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">فيديو تعريفي</label>
                            <input type="url" name="portfolio_video" value="{{ old('portfolio_video', $profile->portfolio_video) }}"
                                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                   placeholder="رابط فيديو من YouTube أو Vimeo">
                            @error('portfolio_video')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Avatar Upload -->
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                    <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">📷 الصورة الشخصية</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <img id="avatarPreview" src="{{ Auth::user()->avatar_url }}" 
                             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #f3f4f6;">
                    </div>
                    
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                    <button type="button" onclick="document.getElementById('avatarInput').click()" 
                            style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; margin-bottom: 10px;">
                        📁 اختر صورة
                    </button>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">JPG, PNG, GIF حتى 2MB</p>
                    @error('avatar')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <!-- Availability -->
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">💼 حالة التوظيف</h3>
                    
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="available_for_hire" value="1" 
                               {{ old('available_for_hire', $profile->available_for_hire) ? 'checked' : '' }}
                               style="margin-left: 10px;">
                        <span style="color: #374151;">متاح للتوظيف</span>
                    </label>
                </div>

                <!-- Languages -->
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">🌍 اللغات</h3>
                    
                    <div id="languagesContainer">
                        @if($profile->languages && count($profile->languages) > 0)
                            @foreach($profile->languages as $language)
                                <div class="language-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                    <input type="text" name="languages[]" value="{{ $language }}" 
                                           style="flex: 1; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
                                           placeholder="اللغة">
                                    <button type="button" onclick="removeLanguage(this)" 
                                            style="padding: 8px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                        ✕
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="language-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="languages[]" value="العربية" 
                                       style="flex: 1; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
                                       placeholder="اللغة">
                                <button type="button" onclick="removeLanguage(this)" 
                                        style="padding: 8px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                    ✕
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    <button type="button" onclick="addLanguage()" 
                            style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px;">
                        ➕ إضافة لغة
                    </button>
                </div>

                <!-- Quick Links -->
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 18px;">🔗 روابط سريعة</h3>
                    
                    <a href="{{ route('portfolio.index') }}" style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                        🎨 معرض الأعمال
                    </a>
                    
                    <a href="{{ route('ratings.show', Auth::user()) }}" style="display: block; width: 100%; padding: 12px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                        ⭐ التقييمات ({{ Auth::user()->ratings_count }})
                    </a>
                    
                    <a href="{{ route('profile.show', Auth::user()) }}" style="display: block; width: 100%; padding: 12px; background: #8b5cf6; color: white; text-decoration: none; border-radius: 6px; text-align: center;">
                        👁️ عرض الملف العام
                    </a>
                </div>

                <!-- Save Button -->
                <button type="submit" style="width: 100%; padding: 15px; background: #10b981; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                    💾 حفظ التغييرات
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function addSkill() {
    const container = document.getElementById('skillsContainer');
    const skillItem = document.createElement('div');
    skillItem.className = 'skill-item';
    skillItem.style = 'display: grid; grid-template-columns: 1fr 150px 40px; gap: 15px; margin-bottom: 15px; align-items: end;';
    skillItem.innerHTML = `
        <div>
            <input type="text" name="skills[]" 
                   style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                   placeholder="اسم المهارة">
        </div>
        <div>
            <select name="skill_levels[]" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                <option value="beginner">مبتدئ</option>
                <option value="intermediate" selected>متوسط</option>
                <option value="advanced">متقدم</option>
                <option value="expert">خبير</option>
            </select>
        </div>
        <button type="button" onclick="removeSkill(this)" style="padding: 12px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer;">
            ✕
        </button>
    `;
    container.appendChild(skillItem);
}

function removeSkill(button) {
    button.closest('.skill-item').remove();
}

function addPopularSkill(skillName) {
    const container = document.getElementById('skillsContainer');
    const skillInputs = container.querySelectorAll('input[name="skills[]"]');
    
    // Check if skill already exists
    for (let input of skillInputs) {
        if (input.value.toLowerCase() === skillName.toLowerCase()) {
            return; // Skill already exists
        }
    }
    
    // Add new skill
    addSkill();
    const newSkillInput = container.querySelector('.skill-item:last-child input[name="skills[]"]');
    newSkillInput.value = skillName;
}

function addLanguage() {
    const container = document.getElementById('languagesContainer');
    const languageItem = document.createElement('div');
    languageItem.className = 'language-item';
    languageItem.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
    languageItem.innerHTML = `
        <input type="text" name="languages[]" 
               style="flex: 1; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
               placeholder="اللغة">
        <button type="button" onclick="removeLanguage(this)" 
                style="padding: 8px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
            ✕
        </button>
    `;
    container.appendChild(languageItem);
}

function removeLanguage(button) {
    button.closest('.language-item').remove();
}
</script>
@endsection
