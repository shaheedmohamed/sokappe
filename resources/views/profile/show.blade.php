@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Profile Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 40px; margin-bottom: 30px; color: white; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 30px; position: relative; z-index: 2;">
            <img src="{{ $user->avatar_url }}" 
                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">
            <div style="flex: 1;">
                <h1 style="margin: 0 0 10px; font-size: 32px; font-weight: 700;">{{ $user->name }}</h1>
                @if($user->profile && $user->profile->title)
                    <p style="margin: 0 0 15px; font-size: 18px; opacity: 0.9;">{{ $user->profile->title }}</p>
                @endif
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 15px;">
                    @if($user->ratings_count > 0)
                        <div style="display: flex; align-items: center; gap: 5px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color: {{ $i <= $user->average_rating ? '#fbbf24' : 'rgba(255,255,255,0.3)' }}; font-size: 18px;">★</span>
                            @endfor
                            <span style="margin-right: 8px; font-weight: 600;">{{ number_format($user->average_rating, 1) }}</span>
                            <span style="opacity: 0.8;">({{ $user->ratings_count }} تقييم)</span>
                        </div>
                    @else
                        <span style="opacity: 0.8;">لم يتم التقييم بعد</span>
                    @endif
                    
                    @if($user->profile && $user->profile->location)
                        <div style="display: flex; align-items: center; gap: 5px; opacity: 0.9;">
                            <span>📍</span>
                            <span>{{ $user->profile->location }}</span>
                        </div>
                    @endif
                </div>
                
                @if($user->profile && $user->profile->available_for_hire)
                    <div style="display: inline-block; background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.3);">
                        ✅ متاح للتوظيف
                    </div>
                @endif
            </div>
            
            @if($user->profile && $user->profile->hourly_rate)
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 24px; font-weight: 700; margin-bottom: 5px;">${{ number_format($user->profile->hourly_rate, 0) }}</div>
                    <div style="font-size: 14px; opacity: 0.8;">السعر بالساعة</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div style="background: white; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
            <!-- Tabs -->
            <div style="display: flex;">
                <button class="tab-btn active" onclick="showTab('overview')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid #3b82f6;">
                    📊 نظرة عامة
                </button>
                <button class="tab-btn" onclick="showTab('portfolio')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent;">
                    🎨 معرض الأعمال ({{ $user->portfolios->count() }})
                </button>
                <button class="tab-btn" onclick="showTab('ratings')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent;">
                    ⭐ التقييمات ({{ $user->ratings_count }})
                </button>
            </div>
            
            <!-- Action Buttons -->
            @auth
                @if(Auth::id() === $user->id)
                    <div style="display: flex; gap: 10px; padding: 16px 24px;">
                        <!-- Edit Profile Button (Always visible) -->
                        <a href="{{ route('profile.edit-advanced') }}" 
                           style="padding: 8px 16px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                            ✏️ تعديل الملف الشخصي
                        </a>
                        
                        <!-- Add Work Button (Only visible on portfolio tab) -->
                        <a href="{{ route('portfolio.create') }}" id="addWorkBtn"
                           style="padding: 8px 16px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; display: none; align-items: center; gap: 6px;">
                            ➕ إضافة عمل
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <!-- Main Content -->
        <div>
            <!-- Overview Tab -->
            <div id="overview-tab" class="tab-content">
                <!-- Bio -->
                @if($user->profile && $user->profile->bio)
                    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                            👤 نبذة تعريفية
                        </h2>
                        <p style="margin: 0; color: #374151; line-height: 1.7; font-size: 15px;">{{ $user->profile->bio }}</p>
                    </div>
                @endif

                <!-- Experience -->
                @if($user->profile && $user->profile->experience)
                    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                            💼 الخبرة والإنجازات
                        </h2>
                        <div style="color: #374151; line-height: 1.7; font-size: 15px; white-space: pre-line;">{{ $user->profile->experience }}</div>
                    </div>
                @endif

                <!-- Skills -->
                @if($user->skills->count() > 0)
                    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                            🛠️ المهارات
                        </h2>
                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                            @foreach($user->skills as $skill)
                                <div style="background: {{ $skill->proficiency_color }}20; color: {{ $skill->proficiency_color }}; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500; border: 1px solid {{ $skill->proficiency_color }}40;">
                                    {{ $skill->skill_name }} - {{ $skill->proficiency_text }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Portfolio Tab -->
            <div id="portfolio-tab" class="tab-content" style="display: none;">
                @if($user->portfolios->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                        @foreach($user->portfolios as $portfolio)
                            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <img src="{{ $portfolio->main_image }}" 
                                     style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px;">
                                    <h3 style="margin: 0 0 10px; color: #1e293b; font-size: 16px;">{{ $portfolio->title }}</h3>
                                    <p style="margin: 0 0 15px; color: #64748b; font-size: 13px;">{{ Str::limit($portfolio->description, 100) }}</p>
                                    
                                    @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 15px;">
                                            @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                                                <span style="background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 8px; font-size: 10px;">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div style="display: flex; gap: 8px;">
                                        @if($portfolio->project_url)
                                            <a href="{{ $portfolio->project_url }}" target="_blank" 
                                               style="padding: 6px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 11px;">
                                                👁️ عرض المشروع
                                            </a>
                                        @endif
                                        @if($portfolio->github_url)
                                            <a href="{{ $portfolio->github_url }}" target="_blank" 
                                               style="padding: 6px 12px; background: #1f2937; color: white; text-decoration: none; border-radius: 6px; font-size: 11px;">
                                                💻 GitHub
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div style="font-size: 48px; margin-bottom: 15px;">🎨</div>
                        <h3 style="margin: 0 0 10px; color: #1e293b;">لا توجد أعمال</h3>
                        <p style="margin: 0; color: #64748b;">لم يتم إضافة أي أعمال إلى معرض الأعمال بعد</p>
                    </div>
                @endif
            </div>

            <!-- Ratings Tab -->
            <div id="ratings-tab" class="tab-content" style="display: none;">
                @if($user->ratings->count() > 0)
                    @foreach($user->ratings as $rating)
                        <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                                <img src="{{ $rating->client->avatar_url }}" 
                                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                <div>
                                    <h4 style="margin: 0 0 3px; color: #1e293b; font-size: 16px;">{{ $rating->client->name }}</h4>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="display: flex; align-items: center; gap: 2px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span style="color: {{ $i <= $rating->overall_rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 14px;">★</span>
                                            @endfor
                                            <span style="font-weight: 600; color: #1e293b; margin-left: 5px; font-size: 14px;">{{ $rating->overall_rating }}</span>
                                        </div>
                                        <span style="color: #64748b; font-size: 12px;">{{ $rating->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($rating->review)
                                <div style="color: #374151; line-height: 1.6; margin-bottom: 15px;">
                                    "{{ $rating->review }}"
                                </div>
                            @endif

                            <div style="background: #f8fafc; padding: 12px; border-radius: 8px;">
                                <span style="color: #64748b; font-size: 12px;">المشروع:</span>
                                <span style="color: #3b82f6; font-weight: 500; margin-right: 5px;">{{ $rating->project->title }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 60px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div style="font-size: 48px; margin-bottom: 15px;">⭐</div>
                        <h3 style="margin: 0 0 10px; color: #1e293b;">لم يتم التقييم بعد</h3>
                        <p style="margin: 0; color: #64748b;">لا توجد تقييمات لهذا المحترف حتى الآن</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Contact Info -->
            <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">📞 معلومات التواصل</h3>
                
                @if($user->profile && $user->profile->phone)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: #64748b;">📱</span>
                        <span style="color: #374151;">{{ $user->profile->phone }}</span>
                    </div>
                @endif
                
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="color: #64748b;">✉️</span>
                    <span style="color: #374151;">{{ $user->email }}</span>
                </div>
                
                @if($user->profile && $user->profile->website)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: #64748b;">🌐</span>
                        <a href="{{ $user->profile->website }}" target="_blank" style="color: #3b82f6; text-decoration: none;">الموقع الشخصي</a>
                    </div>
                @endif
                
                @if($user->profile && $user->profile->linkedin)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: #64748b;">💼</span>
                        <a href="{{ $user->profile->linkedin }}" target="_blank" style="color: #3b82f6; text-decoration: none;">LinkedIn</a>
                    </div>
                @endif
                
                @if($user->profile && $user->profile->github)
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="color: #64748b;">💻</span>
                        <a href="{{ $user->profile->github }}" target="_blank" style="color: #3b82f6; text-decoration: none;">GitHub</a>
                    </div>
                @endif
            </div>

            <!-- Languages -->
            @if($user->profile && $user->profile->languages && count($user->profile->languages) > 0)
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 18px;">🌍 اللغات</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($user->profile->languages as $language)
                            <span style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 16px; font-size: 13px;">
                                {{ $language }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 18px;">⚡ إجراءات سريعة</h3>
                
                @auth
                    @if(Auth::id() === $user->id)
                        <!-- Owner Actions -->
                        <a href="{{ route('profile.edit-advanced') }}" 
                           style="display: block; width: 100%; padding: 12px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                            ✏️ تعديل الملف الشخصي
                        </a>
                        
                        <a href="{{ route('portfolio.create') }}" 
                           style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                            ➕ إضافة عمل جديد
                        </a>
                        
                        <a href="{{ route('portfolio.index') }}" 
                           style="display: block; width: 100%; padding: 12px; background: #8b5cf6; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                            🎨 إدارة معرض الأعمال
                        </a>
                    @else
                        <!-- Visitor Actions -->
                        <button onclick="showTab('ratings')" 
                                style="display: block; width: 100%; padding: 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                            ⭐ التقييمات ({{ $user->ratings_count }})
                        </button>
                        
                        <button onclick="showTab('portfolio')" 
                                style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                            🎨 معرض الأعمال ({{ $user->portfolios->count() }})
                        </button>
                        
                        <button style="width: 100%; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer;">
                            💬 إرسال رسالة
                        </button>
                    @endif
                @else
                    <!-- Guest Actions -->
                    <button onclick="showTab('ratings')" 
                            style="display: block; width: 100%; padding: 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                        ⭐ التقييمات ({{ $user->ratings_count }})
                    </button>
                    
                    <button onclick="showTab('portfolio')" 
                            style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                        🎨 معرض الأعمال ({{ $user->portfolios->count() }})
                    </button>
                    
                    <a href="{{ route('login') }}" 
                       style="display: block; width: 100%; padding: 12px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; text-align: center;">
                        🔑 تسجيل الدخول للتواصل
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.style.borderBottomColor = 'transparent';
        btn.style.color = '#64748b';
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').style.display = 'block';
    
    // Add active class to selected button
    event.target.style.borderBottomColor = '#3b82f6';
    event.target.style.color = '#3b82f6';
    
    // Show/Hide "Add Work" button based on current tab
    const addWorkBtn = document.getElementById('addWorkBtn');
    if (addWorkBtn) {
        if (tabName === 'portfolio') {
            addWorkBtn.style.display = 'flex';
        } else {
            addWorkBtn.style.display = 'none';
        }
    }
}
</script>
@endsection
