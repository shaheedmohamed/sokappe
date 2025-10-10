@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Profile Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 40px; margin-bottom: 24px; color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');"></div>
        
        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 24px;">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: bold; border: 4px solid rgba(255,255,255,0.3);">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div style="flex: 1;">
                <h1 style="margin: 0 0 8px; font-size: 32px; font-weight: 800;">{{ $user->name }}</h1>
                @if($profile)
                    <p style="margin: 0 0 12px; font-size: 18px; opacity: 0.9;">{{ $profile->title }}</p>
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                        <span style="background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 14px;">📂 {{ $profile->category }}</span>
                        <span style="background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 14px;">⭐ مستقل محترف</span>
                    </div>
                @endif
                <div style="display: flex; align-items: center; gap: 20px; font-size: 14px; opacity: 0.9;">
                    <span>📅 انضم في {{ $user->created_at->format('M Y') }}</span>
                    <span>🎯 {{ $works->count() }} عمل منجز</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div style="border-bottom: 2px solid var(--border); margin-bottom: 32px;" data-tabs>
        <div style="display: flex; gap: 0;">
            <button class="tab active" data-tab-target="#tab-overview" style="padding: 16px 24px; border: none; background: transparent; color: var(--muted); cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent; transition: all 0.3s;">
                📊 نظرة عامة
            </button>
            @if($user->role === 'freelancer' && $works->count() > 0)
                <button class="tab" data-tab-target="#tab-portfolio" style="padding: 16px 24px; border: none; background: transparent; color: var(--muted); cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent; transition: all 0.3s;">
                    🎨 معرض الأعمال ({{ $works->count() }})
                </button>
            @endif
        </div>
    </div>

    <!-- Tab Content -->
    <div>
        <!-- Overview Tab -->
        <div id="tab-overview" data-tab-panel>
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
                <!-- Main Content -->
                <div>
                    @if($profile)
                        <!-- About Section -->
                        <div class="card" style="margin-bottom: 24px;">
                            <h3 style="margin: 0 0 16px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                                👤 نبذة عن المستقل
                            </h3>
                            <p style="color: var(--muted); line-height: 1.6;">
                                مرحباً، أنا {{ $user->name }}، {{ $profile->title }} متخصص في {{ $profile->category }}.
                                أقدم خدمات عالية الجودة وأسعى دائماً لتحقيق رضا العملاء وتقديم أفضل النتائج.
                            </p>
                        </div>

                        <!-- Skills Section -->
                        @if($profile->skills)
                            <div class="card" style="margin-bottom: 24px;">
                                <h3 style="margin: 0 0 16px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                                    🛠️ المهارات
                                </h3>
                                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                    @foreach(explode(',', $profile->skills) as $skill)
                                        <span style="background: var(--primary); color: white; padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 500;">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Recent Works Preview -->
                    @if($works->count() > 0)
                        <div class="card">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h3 style="margin: 0; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                                    🎨 أحدث الأعمال
                                </h3>
                                <a href="{{ route('profile.portfolio', $user) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                    عرض الكل →
                                </a>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                                @foreach($works->take(4) as $work)
                                    <div style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 25px -3px rgb(0 0 0 / 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                        @if($work->thumbnail)
                                            <img src="{{ asset('storage/' . $work->thumbnail) }}" alt="{{ $work->title }}" style="width: 100%; height: 120px; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; color: var(--muted);">
                                                🖼️
                                            </div>
                                        @endif
                                        <div style="padding: 12px;">
                                            <h4 style="margin: 0 0 4px; font-size: 14px; color: var(--dark);">{{ Str::limit($work->title, 30) }}</h4>
                                            <p style="margin: 0; font-size: 12px; color: var(--muted);">{{ $work->delivered_at ? $work->delivered_at->format('M Y') : 'حديث' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Stats Card -->
                    <div class="card" style="margin-bottom: 24px;">
                        <h3 style="margin: 0 0 16px; color: var(--dark);">📊 الإحصائيات</h3>
                        <div style="display: grid; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted);">الأعمال المنجزة</span>
                                <span style="font-weight: 600; color: var(--dark);">{{ $works->count() }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted);">تاريخ الانضمام</span>
                                <span style="font-weight: 600; color: var(--dark);">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                                <span style="color: var(--muted);">الحالة</span>
                                <span style="background: var(--secondary); color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">متاح للعمل</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="card">
                        <h3 style="margin: 0 0 16px; color: var(--dark);">📞 التواصل</h3>
                        <div style="display: grid; gap: 12px;">
                            <a href="mailto:{{ $user->email }}" style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gray-50); border-radius: 8px; text-decoration: none; color: var(--dark); transition: all 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='var(--gray-50)'; this.style.color='var(--dark)'">
                                <span style="font-size: 18px;">📧</span>
                                <span>إرسال رسالة</span>
                            </a>
                            @if($user->role === 'freelancer')
                                <button style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--secondary); color: white; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s; width: 100%;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    <span style="font-size: 18px;">💼</span>
                                    <span>تكليف بمشروع</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Tab -->
        @if($user->role === 'freelancer' && $works->count() > 0)
            <div id="tab-portfolio" class="hidden" data-tab-panel>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
                    @foreach($works as $work)
                        <div class="card" style="overflow: hidden; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgb(0 0 0 / 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgb(0 0 0 / 0.1)'">
                            @if($work->thumbnail)
                                <img src="{{ asset('storage/' . $work->thumbnail) }}" alt="{{ $work->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 48px;">
                                    🖼️
                                </div>
                            @endif
                            <div style="padding: 20px;">
                                <h3 style="margin: 0 0 8px; color: var(--dark);">{{ $work->title }}</h3>
                                <p style="margin: 0 0 12px; color: var(--muted); font-size: 14px; line-height: 1.5;">{{ Str::limit($work->description, 100) }}</p>
                                
                                @if($work->skills)
                                    <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px;">
                                        @foreach(array_slice(explode(',', $work->skills), 0, 3) as $skill)
                                            <span style="background: var(--gray-100); color: var(--gray-600); padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                                                {{ trim($skill) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px;">
                                    <span style="color: var(--muted); font-size: 13px;">
                                        {{ $work->delivered_at ? $work->delivered_at->format('M Y') : 'حديث' }}
                                    </span>
                                    @if($work->preview_url)
                                        <a href="{{ $work->preview_url }}" target="_blank" style="color: var(--primary); font-size: 13px; font-weight: 600; text-decoration: none;">
                                            معاينة →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
