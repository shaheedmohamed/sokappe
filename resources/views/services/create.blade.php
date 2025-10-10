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
        <label class="form-label" for="title">🎯 عنوان الخدمة</label>
        <input class="form-input @error('title') error @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="مثال: تصميم لوجو احترافي مع 3 مفاهيم" required>
        @error('title')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">📝 وصف الخدمة</label>
        <textarea class="form-input form-textarea @error('description') error @enderror" id="description" name="description" placeholder="اشرح ما تقدمه في هذه الخدمة، المميزات، والتسليمات...">{{ old('description') }}</textarea>
        @error('description')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="price">💵 السعر (جنيه)</label>
          <input class="form-input @error('price') error @enderror" type="number" id="price" name="price" value="{{ old('price') }}" placeholder="250" required>
          @error('price')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="delivery_days">🚀 مدة التسليم (أيام)</label>
          <input class="form-input @error('delivery_days') error @enderror" type="number" id="delivery_days" name="delivery_days" value="{{ old('delivery_days') }}" placeholder="3">
          @error('delivery_days')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="image">🖼️ رابط صورة الخدمة</label>
          <input class="form-input @error('image') error @enderror" type="url" id="image" name="image" value="{{ old('image') }}" placeholder="https://example.com/image.jpg">
          @error('image')<span class="form-error">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-actions">
        <a href="/" class="btn">إلغاء</a>
        <button type="submit" class="btn success btn-lg">⭐ نشر الخدمة</button>
      </div>
    </form>
  </div>
</div>
@endsection
