@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
        <div>
            <h1 style="margin: 0 0 8px; color: var(--dark); display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('profile.show', $user) }}" style="color: var(--muted); text-decoration: none;">{{ $user->name }}</a>
                <span style="color: var(--muted);">/</span>
                <span>🎨 معرض الأعمال</span>
            </h1>
            <p style="margin: 0; color: var(--muted);">{{ $works->count() }} عمل منجز</p>
        </div>
        <a href="{{ route('profile.show', $user) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
            ← العودة للملف الشخصي
        </a>
    </div>

    @if($works->count() > 0)
        <!-- Portfolio Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 32px;">
            @foreach($works as $work)
                <div class="card" style="overflow: hidden; transition: all 0.3s; position: relative;" 
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgb(0 0 0 / 0.1)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgb(0 0 0 / 0.1)'">
                    
                    <!-- Work Image -->
                    <div style="position: relative; overflow: hidden;">
                        @if($work->thumbnail)
                            <img src="{{ asset('storage/' . $work->thumbnail) }}" alt="{{ $work->title }}" 
                                 style="width: 100%; height: 250px; object-fit: cover; transition: all 0.3s;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        @else
                            <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 64px;">
                                🖼️
                            </div>
                        @endif
                        
                        <!-- Overlay with Preview Link -->
                        @if($work->preview_url)
                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s;"
                                 onmouseover="this.style.opacity='1'"
                                 onmouseout="this.style.opacity='0'">
                                <a href="{{ $work->preview_url }}" target="_blank" 
                                   style="background: white; color: var(--dark); padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                    🔗 معاينة العمل
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Work Details -->
                    <div style="padding: 24px;">
                        <h3 style="margin: 0 0 12px; color: var(--dark); font-size: 20px; line-height: 1.3;">
                            {{ $work->title }}
                        </h3>
                        
                        <p style="margin: 0 0 16px; color: var(--muted); line-height: 1.6; font-size: 15px;">
                            {{ $work->description }}
                        </p>

                        <!-- Skills Tags -->
                        @if($work->skills)
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px;">
                                @foreach(explode(',', $work->skills) as $skill)
                                    <span style="background: var(--primary); color: white; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 500;">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Work Meta -->
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 16px; color: var(--muted); font-size: 14px;">
                                @if($work->delivered_at)
                                    <span style="display: flex; align-items: center; gap: 4px;">
                                        📅 {{ $work->delivered_at->format('M Y') }}
                                    </span>
                                @endif
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    👤 {{ $user->name }}
                                </span>
                            </div>
                            
                            @if($work->preview_url)
                                <a href="{{ $work->preview_url }}" target="_blank" 
                                   style="color: var(--primary); font-weight: 600; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 4px;">
                                    معاينة مباشرة →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More Button (if needed in future) -->
        @if($works->count() >= 12)
            <div style="text-align: center; margin-top: 48px;">
                <button style="background: var(--primary); color: white; border: none; padding: 16px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px -5px rgba(59, 130, 246, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    عرض المزيد من الأعمال
                </button>
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 20px; color: var(--muted);">
            <div style="font-size: 64px; margin-bottom: 24px;">🎨</div>
            <h3 style="margin: 0 0 12px; color: var(--dark);">لا توجد أعمال بعد</h3>
            <p style="margin: 0; font-size: 16px;">{{ $user->name }} لم يضف أي أعمال إلى معرضه حتى الآن.</p>
        </div>
    @endif

    <!-- Back to Profile -->
    <div style="text-align: center; margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--border);">
        <a href="{{ route('profile.show', $user) }}" 
           style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary); text-decoration: none; font-weight: 600; padding: 12px 24px; border: 2px solid var(--primary); border-radius: 8px; transition: all 0.3s;"
           onmouseover="this.style.background='var(--primary)'; this.style.color='white'"
           onmouseout="this.style.background='transparent'; this.style.color='var(--primary)'">
            ← العودة إلى الملف الشخصي
        </a>
    </div>
</div>
@endsection
