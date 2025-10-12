@extends('layouts.app')

@section('title', $user->name . ' - معرض الأعمال')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
        <div>
            <h1 style="margin: 0 0 8px; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('profile.show', $user) }}" style="color: #64748b; text-decoration: none;">{{ $user->name }}</a>
                <span style="color: #64748b;">/</span>
                <span>🎨 معرض الأعمال</span>
            </h1>
            <p style="margin: 0; color: #64748b;">{{ $user->portfolios->count() }} عمل منجز</p>
        </div>
        <a href="{{ route('profile.show', $user) }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">
            ← العودة للملف الشخصي
        </a>
    </div>

    @if($user->portfolios->count() > 0)
        <!-- Portfolio Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 32px;">
            @foreach($user->portfolios as $portfolio)
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s; position: relative;" 
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.15)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                    
                    <!-- Portfolio Image -->
                    <div style="position: relative; overflow: hidden;">
                        <img src="{{ $portfolio->main_image }}" alt="{{ $portfolio->title }}" 
                             style="width: 100%; height: 250px; object-fit: cover; transition: all 0.3s;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
                        
                        <!-- Overlay with Links -->
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s; gap: 10px;"
                             onmouseover="this.style.opacity='1'"
                             onmouseout="this.style.opacity='0'">
                            @if($portfolio->project_url)
                                <a href="{{ $portfolio->project_url }}" target="_blank" 
                                   style="background: white; color: #1e293b; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; font-size: 14px;">
                                    🔗 معاينة
                                </a>
                            @endif
                            @if($portfolio->github_url)
                                <a href="{{ $portfolio->github_url }}" target="_blank" 
                                   style="background: #1f2937; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; font-size: 14px;">
                                    💻 GitHub
                                </a>
                            @endif
                        </div>
                        
                        <!-- Category Badge -->
                        @if($portfolio->category)
                            <div style="position: absolute; top: 12px; right: 12px; background: rgba(59, 130, 246, 0.9); color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                {{ $portfolio->category_name }}
                            </div>
                        @endif
                    </div>

                    <!-- Portfolio Details -->
                    <div style="padding: 24px;">
                        <h3 style="margin: 0 0 12px; color: #1e293b; font-size: 20px; line-height: 1.3;">
                            {{ $portfolio->title }}
                        </h3>
                        
                        <p style="margin: 0 0 16px; color: #64748b; line-height: 1.6; font-size: 15px;">
                            {{ Str::limit($portfolio->description, 120) }}
                        </p>

                        <!-- Technologies -->
                        @if($portfolio->technologies && count($portfolio->technologies) > 0)
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px;">
                                @foreach(array_slice($portfolio->technologies, 0, 4) as $tech)
                                    <span style="background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 500;">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                                @if(count($portfolio->technologies) > 4)
                                    <span style="background: #e2e8f0; color: #64748b; padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                                        +{{ count($portfolio->technologies) - 4 }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Portfolio Meta -->
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                            <div style="display: flex; align-items: center; gap: 16px; color: #64748b; font-size: 14px;">
                                @if($portfolio->completion_date)
                                    <span style="display: flex; align-items: center; gap: 4px;">
                                        📅 {{ $portfolio->completion_date->format('M Y') }}
                                    </span>
                                @endif
                                
                                @if($portfolio->views_count > 0)
                                    <span style="display: flex; align-items: center; gap: 4px;">
                                        👁️ {{ number_format($portfolio->views_count) }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($portfolio->is_featured)
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                    ⭐ مميز
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.5;">🎨</div>
            <h3 style="margin: 0 0 12px; color: #1e293b; font-size: 24px;">لا توجد أعمال</h3>
            <p style="margin: 0 0 24px; color: #64748b; font-size: 16px;">
                لم يتم إضافة أي أعمال إلى معرض الأعمال بعد
            </p>
            
            @auth
                @if(Auth::id() === $user->id)
                    <a href="{{ route('portfolio.create') }}" 
                       style="display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                        ➕ إضافة عمل جديد
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
@endsection
