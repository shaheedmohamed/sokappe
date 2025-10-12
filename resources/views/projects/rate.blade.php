@extends('layouts.app')

@section('title', 'تقييم المشروع')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('projects.manage', $management->project) }}" style="color: #64748b; text-decoration: none; font-size: 14px;">
            ← العودة لإدارة المشروع
        </a>
        <h1 style="margin: 10px 0 0; color: #1e293b; font-size: 28px;">⭐ تقييم المشروع</h1>
    </div>

    <!-- Project Info -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="margin: 0 0 12px; color: #1e293b; font-size: 20px;">{{ $management->project->title }}</h2>
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ $management->freelancer->avatar_url }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                <div>
                    <div style="font-weight: 600; color: #1e293b;">{{ $management->freelancer->name }}</div>
                    <div style="color: #64748b; font-size: 13px;">المحترف</div>
                </div>
            </div>
            <div style="color: #10b981; font-weight: 700; font-size: 18px;">
                ${{ number_format($management->acceptedBid->amount, 2) }}
            </div>
            <div style="color: #64748b;">
                {{ $management->acceptedBid->delivery_time }} أيام
            </div>
        </div>
        <p style="margin: 0; color: #64748b; line-height: 1.6;">
            {{ Str::limit($management->project->description, 200) }}
        </p>
    </div>

    <!-- Rating Form -->
    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('projects.rate.store', $management->project) }}">
            @csrf
            
            <div style="margin-bottom: 30px;">
                <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">قيم أداء المحترف في النقاط التالية:</h3>
                
                @php
                    $ratings = [
                        'professionalism_rating' => 'الاحترافية بالتعامل',
                        'communication_rating' => 'التواصل والمتابعة',
                        'quality_rating' => 'جودة العمل المسلم',
                        'experience_rating' => 'الخبرة بمجال المشروع',
                        'delivery_rating' => 'التسليم في الموعد',
                        'cooperation_rating' => 'التعامل معه مرة أخرى',
                    ];
                @endphp

                @foreach($ratings as $key => $label)
                    <div style="margin-bottom: 25px; padding: 20px; background: #f8fafc; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <label style="display: block; font-weight: 600; margin-bottom: 12px; color: #374151;">{{ $label }}</label>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            @for($i = 1; $i <= 5; $i++)
                                <label style="cursor: pointer; display: flex; align-items: center;">
                                    <input type="radio" name="{{ $key }}" value="{{ $i }}" required
                                           style="display: none;" 
                                           onchange="updateStars('{{ $key }}', {{ $i }})">
                                    <span class="star" data-rating="{{ $key }}" data-value="{{ $i }}"
                                          style="font-size: 28px; color: #e5e7eb; transition: color 0.2s; user-select: none;"
                                          onclick="selectRating('{{ $key }}', {{ $i }})">★</span>
                                </label>
                            @endfor
                            <span id="{{ $key }}_text" style="margin-right: 15px; color: #64748b; font-size: 14px; font-weight: 600;"></span>
                        </div>
                        @error($key)
                            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Comment -->
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">تعليق إضافي (اختياري)</label>
                <textarea name="comment" rows="4" placeholder="شارك تجربتك مع هذا المحترف..."
                          style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px; resize: vertical;">{{ old('comment') }}</textarea>
                @error('comment')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Overall Rating Display -->
            <div id="overall-rating" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px; margin-bottom: 30px; text-align: center; display: none;">
                <div style="color: #166534; font-size: 18px; font-weight: 700; margin-bottom: 8px;">
                    التقييم العام: <span id="overall-score">0</span>/5
                </div>
                <div id="overall-stars" style="font-size: 24px; color: #fbbf24;"></div>
            </div>

            <!-- Submit Button -->
            <div style="text-align: center;">
                <button type="submit" 
                        style="background: #f59e0b; color: white; border: none; padding: 15px 40px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                    ⭐ إرسال التقييم
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const ratingTexts = {
    1: 'ضعيف جداً',
    2: 'ضعيف',
    3: 'متوسط',
    4: 'جيد',
    5: 'ممتاز'
};

const ratings = {};

function selectRating(category, value) {
    // Update radio button
    document.querySelector(`input[name="${category}"][value="${value}"]`).checked = true;
    
    // Update stars
    updateStars(category, value);
    
    // Store rating
    ratings[category] = value;
    
    // Update overall rating
    updateOverallRating();
}

function updateStars(category, value) {
    const stars = document.querySelectorAll(`[data-rating="${category}"]`);
    const textElement = document.getElementById(`${category}_text`);
    
    stars.forEach((star, index) => {
        if (index < value) {
            star.style.color = '#fbbf24';
        } else {
            star.style.color = '#e5e7eb';
        }
    });
    
    textElement.textContent = ratingTexts[value];
    textElement.style.color = value >= 4 ? '#10b981' : value >= 3 ? '#f59e0b' : '#ef4444';
}

function updateOverallRating() {
    const ratingKeys = ['professionalism_rating', 'communication_rating', 'quality_rating', 'experience_rating', 'delivery_rating', 'cooperation_rating'];
    
    let total = 0;
    let count = 0;
    
    ratingKeys.forEach(key => {
        if (ratings[key]) {
            total += ratings[key];
            count++;
        }
    });
    
    if (count > 0) {
        const average = (total / count).toFixed(1);
        document.getElementById('overall-score').textContent = average;
        
        // Update stars display
        const starsContainer = document.getElementById('overall-stars');
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.round(average)) {
                starsHtml += '<span style="color: #fbbf24;">★</span>';
            } else {
                starsHtml += '<span style="color: #e5e7eb;">★</span>';
            }
        }
        starsContainer.innerHTML = starsHtml;
        
        document.getElementById('overall-rating').style.display = 'block';
    }
}

// Add hover effects
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const category = this.dataset.rating;
            const value = parseInt(this.dataset.value);
            const categoryStars = document.querySelectorAll(`[data-rating="${category}"]`);
            
            categoryStars.forEach((s, index) => {
                if (index < value) {
                    s.style.color = '#fbbf24';
                } else {
                    s.style.color = '#e5e7eb';
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            const category = this.dataset.rating;
            const currentValue = ratings[category];
            
            if (currentValue) {
                updateStars(category, currentValue);
            } else {
                const categoryStars = document.querySelectorAll(`[data-rating="${category}"]`);
                categoryStars.forEach(s => {
                    s.style.color = '#e5e7eb';
                });
            }
        });
    });
});
</script>
@endsection
