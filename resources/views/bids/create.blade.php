@extends('layouts.app')

@section('content')
<div class="form-container">
  <div class="form-header">
    <h1>💼 تقديم عرض</h1>
    <p>{{ $project->title }}</p>
    <div style="background: #f1f5f9; padding: 16px; border-radius: 8px; margin-top: 16px; text-align: right;">
      <strong>وصف المشروع:</strong><br>
      {{ Str::limit($project->description, 200) }}
    </div>
  </div>
  
  <div class="form-card">
    <form action="{{ route('projects.bid.store', $project) }}" method="POST">
      @csrf
      
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="price">💰 السعر المقترح (جنيه)</label>
          <input class="form-input @error('price') error @enderror" type="number" id="price" name="price" value="{{ old('price') }}" placeholder="2500" required>
          @error('price')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="days">⏰ مدة التنفيذ (أيام)</label>
          <input class="form-input @error('days') error @enderror" type="number" id="days" name="days" value="{{ old('days') }}" placeholder="10" required>
          @error('days')<span class="form-error">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="message">📝 وصف عرضك وخبرتك</label>
        <textarea class="form-input form-textarea @error('message') error @enderror" id="message" name="message" placeholder="اشرح كيف ستنفذ هذا المشروع، خبرتك في المجال، والقيمة المضافة التي ستقدمها...">{{ old('message') }}</textarea>
        @error('message')<span class="form-error">{{ $message }}</span>@enderror
      </div>

      <div class="form-actions">
        <a href="/" class="btn">إلغاء</a>
        <button type="submit" class="btn primary btn-lg">🚀 إرسال العرض</button>
      </div>
    </form>
  </div>
</div>
@endsection
