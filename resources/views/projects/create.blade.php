@extends('layouts.app')

@section('content')
<div class="form-container">
  <div class="form-header">
    <h1>🚀 إنشاء مشروع جديد</h1>
    <p>أضف تفاصيل مشروعك وابدأ في استقبال العروض من أفضل المستقلين</p>
  </div>
  
  <div class="form-card">
    <form action="{{ route('projects.store') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label class="form-label" for="title">📝 عنوان المشروع</label>
        <input class="form-input @error('title') error @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="مثال: تصميم موقع إلكتروني لشركة ناشئة" required>
        @error('title')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">📋 وصف المشروع</label>
        <textarea class="form-input form-textarea @error('description') error @enderror" id="description" name="description" placeholder="اشرح تفاصيل مشروعك، المتطلبات، والنتائج المتوقعة..." required>{{ old('description') }}</textarea>
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
          <label class="form-label" for="duration_days">⏰ مدة التنفيذ (أيام)</label>
          <input class="form-input @error('duration_days') error @enderror" type="number" id="duration_days" name="duration_days" value="{{ old('duration_days') }}" placeholder="14">
          @error('duration_days')<span class="form-error">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-actions">
        <a href="/" class="btn">إلغاء</a>
        <button type="submit" class="btn primary btn-lg">🚀 نشر المشروع</button>
      </div>
    </form>
  </div>
</div>
@endsection
