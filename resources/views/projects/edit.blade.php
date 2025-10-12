@extends('layouts.app')

@section('title', 'تعديل المشروع')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('projects.show', $project) }}" style="color: #64748b; text-decoration: none; font-size: 14px;">
            ← العودة للمشروع
        </a>
        <h1 style="margin: 10px 0 0; color: #1e293b; font-size: 28px;">✏️ تعديل المشروع</h1>
    </div>

    <!-- Edit Form -->
    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('PUT')
            
            <!-- Project Title -->
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">عنوان المشروع *</label>
                <input type="text" name="title" value="{{ old('title', $project->title) }}" required
                       style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px;"
                       placeholder="مثال: تطوير موقع إلكتروني للتجارة الإلكترونية">
                @error('title')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Project Description -->
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">وصف المشروع *</label>
                <textarea name="description" required rows="6"
                          style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px; resize: vertical;"
                          placeholder="اشرح تفاصيل مشروعك والمتطلبات المحددة...">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Budget Range -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">الحد الأدنى للميزانية ($) *</label>
                    <input type="number" name="budget_min" value="{{ old('budget_min', $project->budget_min) }}" required min="1" step="0.01"
                           style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px;"
                           placeholder="100">
                    @error('budget_min')
                        <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">الحد الأقصى للميزانية ($) *</label>
                    <input type="number" name="budget_max" value="{{ old('budget_max', $project->budget_max) }}" required min="1" step="0.01"
                           style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px;"
                           placeholder="500">
                    @error('budget_max')
                        <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Duration -->
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">مدة التنفيذ المتوقعة (بالأيام) *</label>
                <input type="number" name="duration" value="{{ old('duration', $project->duration) }}" required min="1"
                       style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px;"
                       placeholder="30">
                @error('duration')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            @if($categories->count() > 0)
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">التصنيف</label>
                    <select name="category_id" style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px;">
                        <option value="">اختر التصنيف...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <!-- Skills -->
            @if($skills->count() > 0)
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 12px; color: #374151;">المهارات المطلوبة</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; max-height: 200px; overflow-y: auto; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb;">
                        @foreach($skills as $skill)
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#e5e7eb'"
                                   onmouseout="this.style.backgroundColor='transparent'">
                                <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                                       {{ in_array($skill->id, old('skills', $project->skills->pluck('id')->toArray())) ? 'checked' : '' }}
                                       style="width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #374151;">{{ $skill->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('skills')
                        <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('projects.show', $project) }}" 
                   style="padding: 12px 24px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #d1d5db;">
                    إلغاء
                </a>
                <button type="submit" 
                        style="padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    💾 حفظ التعديلات
                </button>
            </div>
        </form>
    </div>

    <!-- Warning Note -->
    <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 16px; margin-top: 20px;">
        <div style="display: flex; align-items: start; gap: 12px;">
            <span style="color: #f59e0b; font-size: 20px;">⚠️</span>
            <div>
                <h4 style="margin: 0 0 8px; color: #92400e; font-size: 16px;">تنبيه مهم</h4>
                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.5;">
                    • يمكن تعديل المشروع فقط إذا كان مفتوحاً ولم يتم قبول أي عرض عليه بعد<br>
                    • بعد قبول عرض، سيتم تغيير حالة المشروع إلى "قيد التنفيذ" ولن يمكن تعديله<br>
                    • تأكد من صحة جميع البيانات قبل الحفظ
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
