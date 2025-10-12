@extends('layouts.app')

@section('title', 'تقييم المحترف')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 30px; margin-bottom: 30px; color: white; text-align: center;">
        <h1 style="margin: 0 0 10px; font-size: 24px;">⭐ تقييم المحترف</h1>
        <p style="margin: 0; opacity: 0.9;">قيم تجربتك مع المحترف لمساعدة الآخرين في اتخاذ قرارات أفضل</p>
    </div>

    <!-- Project & Freelancer Info -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <!-- Project Info -->
            <div>
                <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 16px;">📋 المشروع</h3>
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                    <h4 style="margin: 0 0 8px; color: #1e293b;">{{ $project->title }}</h4>
                    <p style="margin: 0; color: #64748b; font-size: 13px;">{{ Str::limit($project->description, 100) }}</p>
                </div>
            </div>
            
            <!-- Freelancer Info -->
            <div>
                <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 16px;">👤 المحترف</h3>
                <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 15px; border-radius: 8px;">
                    <img src="{{ $freelancer->avatar_url }}" 
                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h4 style="margin: 0 0 3px; color: #1e293b;">{{ $freelancer->name }}</h4>
                        <p style="margin: 0; color: #64748b; font-size: 13px;">{{ $freelancer->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('ratings.store', $project) }}" method="POST">
        @csrf
        <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">

        <!-- Rating Categories -->
        <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                ⭐ التقييم التفصيلي
            </h2>

            @php
                $categories = [
                    'communication_rating' => 'التواصل والتفاهم',
                    'quality_rating' => 'جودة العمل المسلم',
                    'expertise_rating' => 'الخبرة بالمجال المطلوب',
                    'delivery_rating' => 'التسليم بالموعد',
                    'cooperation_rating' => 'التعامل والأخلاق المهنية',
                    'rehire_rating' => 'إعادة التوظيف'
                ];
            @endphp

            @foreach($categories as $field => $label)
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #374151;">{{ $label }}</label>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="rating-stars" data-field="{{ $field }}" style="display: flex; gap: 5px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star" data-rating="{{ $i }}" 
                                      style="font-size: 24px; color: #e5e7eb; cursor: pointer; transition: color 0.2s;"
                                      onmouseover="highlightStars('{{ $field }}', {{ $i }})"
                                      onclick="setRating('{{ $field }}', {{ $i }})">★</span>
                            @endfor
                        </div>
                        <span id="{{ $field }}_text" style="color: #64748b; font-size: 14px; margin-right: 10px;">اختر التقييم</span>
                        <input type="hidden" name="{{ $field }}" id="{{ $field }}" value="5" required>
                    </div>
                    @error($field)<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            @endforeach
        </div>

        <!-- Review Text -->
        <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 25px; color: #1e293b; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                💬 رأيك في المحترف
            </h2>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">اكتب تقييمك (اختياري)</label>
                <textarea name="review" rows="5" 
                          style="width: 100%; padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;"
                          placeholder="شارك تجربتك مع هذا المحترف... ما الذي أعجبك؟ ما الذي يمكن تحسينه؟">{{ old('review') }}</textarea>
                @error('review')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Submit -->
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="{{ route('projects.show', $project) }}" 
               style="padding: 15px 30px; background: #6b7280; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                إلغاء
            </a>
            <button type="submit" 
                    style="padding: 15px 30px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                ⭐ إرسال التقييم
            </button>
        </div>
    </form>
</div>

<script>
const ratingTexts = {
    1: 'ضعيف جداً',
    2: 'ضعيف',
    3: 'متوسط',
    4: 'جيد',
    5: 'ممتاز'
};

function highlightStars(field, rating) {
    const stars = document.querySelectorAll(`[data-field="${field}"] .star`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.style.color = '#fbbf24';
        } else {
            star.style.color = '#e5e7eb';
        }
    });
}

function setRating(field, rating) {
    document.getElementById(field).value = rating;
    document.getElementById(field + '_text').textContent = ratingTexts[rating];
    
    const stars = document.querySelectorAll(`[data-field="${field}"] .star`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.style.color = '#fbbf24';
        } else {
            star.style.color = '#e5e7eb';
        }
    });
}

// Initialize all ratings to 5 stars
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['communication_rating', 'quality_rating', 'expertise_rating', 'delivery_rating', 'cooperation_rating', 'rehire_rating'];
    fields.forEach(field => {
        setRating(field, 5);
    });
});

// Reset stars on mouse leave
document.querySelectorAll('.rating-stars').forEach(container => {
    container.addEventListener('mouseleave', function() {
        const field = this.dataset.field;
        const currentRating = document.getElementById(field).value;
        highlightStars(field, currentRating);
    });
});
</script>
@endsection
