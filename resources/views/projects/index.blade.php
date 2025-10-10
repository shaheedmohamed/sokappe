@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 50px 40px; margin-bottom: 40px; color: white; text-align: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');"></div>
        
        <div style="position: relative; z-index: 2;">
            <h1 style="margin: 0 0 16px; font-size: 36px; font-weight: 800;">
                📋 تصفح المشاريع
            </h1>
            <p style="margin: 0 0 24px; font-size: 18px; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                اكتشف مشاريع جديدة وقدم عروضك للعملاء
            </p>
            
            @auth
                <a href="{{ route('projects.create') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 14px 28px; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='white'; this.style.color='var(--primary)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white'">
                    ✍️ أنشئ مشروع جديد
                </a>
            @endauth
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card" style="margin-bottom: 32px; padding: 24px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--dark); font-size: 14px;">🔍 البحث</label>
                <input type="text" placeholder="ابحث في المشاريع..." style="width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--dark); font-size: 14px;">📂 الفئة</label>
                <select style="width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; font-size: 14px;">
                    <option value="">جميع الفئات</option>
                    <option value="تطوير وبرمجة">تطوير وبرمجة</option>
                    <option value="تصميم وجرافيك">تصميم وجرافيك</option>
                    <option value="كتابة وترجمة">كتابة وترجمة</option>
                    <option value="تسويق رقمي">تسويق رقمي</option>
                    <option value="صوتيات ومرئيات">صوتيات ومرئيات</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--dark); font-size: 14px;">💰 الميزانية</label>
                <select style="width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; font-size: 14px;">
                    <option value="">جميع الميزانيات</option>
                    <option value="0-500">أقل من 500 ج</option>
                    <option value="500-1000">500 - 1000 ج</option>
                    <option value="1000-5000">1000 - 5000 ج</option>
                    <option value="5000+">أكثر من 5000 ج</option>
                </select>
            </div>
            <div>
                <button style="background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    🔍 بحث
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div style="background: linear-gradient(135deg, #fef3c7, #fbbf24); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 28px; font-weight: 800; color: #92400e; margin-bottom: 4px;">{{ $projects->total() }}</div>
            <div style="color: #92400e; font-size: 14px; font-weight: 600;">مشروع متاح</div>
        </div>
        <div style="background: linear-gradient(135deg, #dbeafe, #3b82f6); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(150, 300) }}</div>
            <div style="font-size: 14px; font-weight: 600;">مستقل نشط</div>
        </div>
        <div style="background: linear-gradient(135deg, #dcfce7, #10b981); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(50, 100) }}</div>
            <div style="font-size: 14px; font-weight: 600;">مشروع مكتمل اليوم</div>
        </div>
        <div style="background: linear-gradient(135deg, #fce7f3, #ec4899); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(20, 50) }}</div>
            <div style="font-size: 14px; font-weight: 600;">عرض جديد اليوم</div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 24px; margin-bottom: 40px;">
        @forelse($projects as $project)
            <div class="card" style="transition: all 0.3s; border: 2px solid transparent; position: relative;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                <!-- Project Header -->
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 8px; color: var(--dark); font-size: 18px; line-height: 1.4;">
                            <a href="{{ route('projects.show', $project) }}" style="color: inherit; text-decoration: none;">
                                {{ $project->title }}
                            </a>
                        </h3>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <span style="background: var(--secondary); color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                جديد
                            </span>
                            <span style="color: var(--muted); font-size: 13px;">
                                {{ $project->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div style="text-align: left; margin-right: 12px;">
                        <div style="font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">
                            {{ $project->budget_min }} - {{ $project->budget_max }} ج
                        </div>
                        <div style="font-size: 11px; color: var(--muted);">الميزانية</div>
                    </div>
                </div>

                <!-- Project Description -->
                <p style="margin: 0 0 16px; color: var(--muted); line-height: 1.6; font-size: 15px;">
                    {{ Str::limit($project->description, 150) }}
                </p>

                <!-- Project Skills -->
                @if($project->skills)
                    <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px;">
                        @foreach(array_slice(explode(',', $project->skills), 0, 4) as $skill)
                            <span style="background: var(--gray-100); color: var(--gray-600); padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 500;">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                        @if(count(explode(',', $project->skills)) > 4)
                            <span style="background: var(--gray-100); color: var(--gray-600); padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 500;">
                                +{{ count(explode(',', $project->skills)) - 4 }}
                            </span>
                        @endif
                    </div>
                @endif

                <!-- Project Meta -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; padding: 12px; background: var(--gray-50); border-radius: 8px; font-size: 13px;">
                    <div>
                        <span style="color: var(--muted); display: block;">العروض المقدمة</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $project->bids_count ?? rand(0, 15) }}</span>
                    </div>
                    <div>
                        <span style="color: var(--muted); display: block;">المدة المطلوبة</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $project->duration ?? 'غير محدد' }}</span>
                    </div>
                </div>

                <!-- Client Info -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                            {{ $project->user ? substr($project->user->name, 0, 1) : 'U' }}
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--dark);">{{ $project->user->name ?? 'مستخدم غير معروف' }}</div>
                            <div style="font-size: 11px; color: var(--muted);">عضو منذ {{ $project->user ? $project->user->created_at->format('M Y') : 'غير محدد' }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 4px;">
                        <span style="color: #fbbf24; font-size: 12px;">⭐⭐⭐⭐⭐</span>
                        <span style="font-size: 11px; color: var(--muted);">({{ rand(40, 50) / 10 }})</span>
                    </div>
                </div>

                <!-- Action Button -->
                <div style="border-top: 1px solid var(--border); padding-top: 16px;">
                    @auth
                        <a href="{{ route('projects.bid.create', $project) }}" class="btn btn-primary" style="width: 100%; text-decoration: none; text-align: center; font-size: 14px; font-weight: 600;">
                            💼 قدّم عرضك الآن
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%; text-decoration: none; text-align: center; font-size: 14px; font-weight: 600;">
                            سجل دخولك لتقديم عرض
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: var(--muted);">
                <div style="font-size: 64px; margin-bottom: 24px;">📋</div>
                <h3 style="margin: 0 0 12px; color: var(--dark);">لا توجد مشاريع متاحة حالياً</h3>
                <p style="margin: 0 0 24px; font-size: 16px;">كن أول من ينشر مشروع جديد!</p>
                @auth
                    <a href="{{ route('projects.create') }}" class="btn btn-primary" style="text-decoration: none;">
                        ✍️ أنشئ مشروع جديد
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $projects->links() }}
        </div>
    @endif

    <!-- Call to Action -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 40px; margin-top: 40px; text-align: center; color: white;">
        <h2 style="margin: 0 0 16px; font-size: 28px; font-weight: 800;">
            هل لديك مشروع؟
        </h2>
        <p style="margin: 0 0 24px; font-size: 16px; opacity: 0.9;">
            انشر مشروعك واحصل على عروض من أفضل المستقلين في الوطن العربي
        </p>
        @auth
            <a href="{{ route('projects.create') }}" class="btn" style="background: white; color: var(--primary); padding: 16px 32px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                ✍️ انشر مشروعك الآن
            </a>
        @else
            <a href="{{ route('register') }}" class="btn" style="background: white; color: var(--primary); padding: 16px 32px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                🚀 انضم الآن
            </a>
        @endauth
    </div>
</div>
@endsection
