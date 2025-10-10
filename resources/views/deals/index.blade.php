@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 60px 40px; margin-bottom: 40px; color: white; text-align: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');"></div>
        
        <div style="position: relative; z-index: 2;">
            <h1 style="margin: 0 0 16px; font-size: 42px; font-weight: 800; line-height: 1.2;">
                اعرض مشروعك أو اطلب خدمتك الآن
            </h1>
            <p style="margin: 0 0 32px; font-size: 20px; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                Sokappe يوصلك بأفضل المستقلين والصفقات المميزة
            </p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('projects.create') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 16px 32px; font-size: 18px; font-weight: 600; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='white'; this.style.color='var(--primary)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white'">
                    ✍️ أنشئ مشروع جديد
                </a>
                <a href="{{ route('services.create') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 16px 32px; font-size: 18px; font-weight: 600; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='white'; this.style.color='var(--primary)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white'">
                    🚀 اعرض خدمتك
                </a>
                <a href="{{ route('deals.create') }}" class="btn" style="background: var(--warning); color: white; border: 2px solid var(--warning); padding: 16px 32px; font-size: 18px; font-weight: 600; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(245, 158, 11, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    💎 الصفقات
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div style="border-bottom: 3px solid var(--border); margin-bottom: 40px;" data-tabs>
        <div style="display: flex; gap: 0; justify-content: center;">
            <button class="tab active" data-tab-target="#tab-projects" style="padding: 20px 32px; border: none; background: transparent; color: var(--muted); cursor: pointer; font-weight: 700; font-size: 18px; border-bottom: 4px solid transparent; transition: all 0.3s;">
                📋 المشاريع
            </button>
            <button class="tab" data-tab-target="#tab-services" style="padding: 20px 32px; border: none; background: transparent; color: var(--muted); cursor: pointer; font-weight: 700; font-size: 18px; border-bottom: 4px solid transparent; transition: all 0.3s;">
                ⚡ الخدمات الجاهزة
            </button>
            <button class="tab" data-tab-target="#tab-deals" style="padding: 20px 32px; border: none; background: transparent; color: var(--muted); cursor: pointer; font-weight: 700; font-size: 18px; border-bottom: 4px solid transparent; transition: all 0.3s;">
                💎 الصفقات
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div>
        <!-- Projects Tab -->
        <div id="tab-projects" data-tab-panel>
            <div style="display: grid; gap: 24px; margin-bottom: 40px;">
                <!-- Featured Projects Section -->
                <div class="card" style="background: linear-gradient(135deg, #fef3c7, #fbbf24); border: none; padding: 24px;">
                    <h2 style="margin: 0 0 16px; color: #92400e; display: flex; align-items: center; gap: 8px;">
                        🔥 الأكثر طلباً
                    </h2>
                    <p style="margin: 0; color: #92400e; opacity: 0.8;">مشاريع عليها منافسة عالية من أفضل المستقلين</p>
                </div>

                <!-- Projects Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px;">
                    @forelse(\App\Models\Project::latest()->take(6)->get() as $project)
                        <div class="card" style="transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                                <h3 style="margin: 0; color: var(--dark); font-size: 18px; line-height: 1.4;">
                                    {{ $project->title }}
                                </h3>
                                <span style="background: var(--secondary); color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; white-space: nowrap;">
                                    جديد
                                </span>
                            </div>
                            
                            <p style="margin: 0 0 16px; color: var(--muted); line-height: 1.6; font-size: 15px;">
                                {{ Str::limit($project->description, 120) }}
                            </p>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; padding: 12px; background: var(--gray-50); border-radius: 8px;">
                                <div>
                                    <span style="font-size: 12px; color: var(--muted); display: block;">الميزانية</span>
                                    <span style="font-weight: 600; color: var(--primary);">{{ $project->budget_min }} - {{ $project->budget_max }} ج</span>
                                </div>
                                <div>
                                    <span style="font-size: 12px; color: var(--muted); display: block;">المدة</span>
                                    <span style="font-weight: 600; color: var(--dark);">{{ $project->duration ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px; color: var(--muted);">
                                    {{ $project->created_at->diffForHumans() }}
                                </span>
                                <a href="{{ route('projects.bid.create', $project) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 14px; width: auto;">
                                    قدّم عرضك
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--muted);">
                            <div style="font-size: 64px; margin-bottom: 16px;">📋</div>
                            <h3 style="margin: 0 0 8px; color: var(--dark);">لا توجد مشاريع حالياً</h3>
                            <p style="margin: 0;">كن أول من ينشر مشروع جديد!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Services Tab -->
        <div id="tab-services" class="hidden" data-tab-panel>
            <div style="display: grid; gap: 24px; margin-bottom: 40px;">
                <!-- Featured Services Section -->
                <div class="card" style="background: linear-gradient(135deg, #dbeafe, #3b82f6); border: none; padding: 24px; color: white;">
                    <h2 style="margin: 0 0 16px; display: flex; align-items: center; gap: 8px;">
                        ⭐ الخدمات الرائجة
                    </h2>
                    <p style="margin: 0; opacity: 0.9;">الأكثر مبيعاً من خدمات المستقلين المحترفين</p>
                </div>

                <!-- Services Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
                    @forelse(\App\Models\Service::latest()->take(8)->get() as $service)
                        <div class="card" style="overflow: hidden; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgb(0 0 0 / 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgb(0 0 0 / 0.1)'">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" style="width: 100%; height: 180px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 180px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 48px;">
                                    ⚡
                                </div>
                            @endif
                            
                            <div style="padding: 20px;">
                                <h3 style="margin: 0 0 8px; color: var(--dark); font-size: 16px; line-height: 1.4;">
                                    {{ $service->title }}
                                </h3>
                                
                                <p style="margin: 0 0 12px; color: var(--muted); font-size: 14px; line-height: 1.5;">
                                    {{ Str::limit($service->description, 80) }}
                                </p>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                    <div>
                                        <span style="font-size: 20px; font-weight: 700; color: var(--primary);">{{ $service->price }} ج</span>
                                        <span style="font-size: 12px; color: var(--muted); display: block;">يبدأ من</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        <span style="color: #fbbf24;">⭐⭐⭐⭐⭐</span>
                                        <span style="font-size: 12px; color: var(--muted);">(4.9)</span>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 14px;">
                                    اطلب الآن
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--muted);">
                            <div style="font-size: 64px; margin-bottom: 16px;">⚡</div>
                            <h3 style="margin: 0 0 8px; color: var(--dark);">لا توجد خدمات حالياً</h3>
                            <p style="margin: 0;">كن أول من يعرض خدمة جاهزة!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Deals Tab -->
        <div id="tab-deals" class="hidden" data-tab-panel>
            <div style="display: grid; gap: 24px; margin-bottom: 40px;">
                <!-- Featured Deals Section -->
                <div class="card" style="background: linear-gradient(135deg, #fef3c7, #f59e0b); border: none; padding: 24px;">
                    <h2 style="margin: 0 0 16px; color: #92400e; display: flex; align-items: center; gap: 8px;">
                        💎 صفقات مميزة
                    </h2>
                    <p style="margin: 0; color: #92400e; opacity: 0.8;">عروض وطلبات متنوعة - الموقع يضمن حقوقك</p>
                </div>

                <!-- Deals Tabs -->
                <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                    <button class="deals-tab active" data-target="offers" style="padding: 12px 24px; border: 2px solid var(--primary); background: var(--primary); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        🛍️ العروض المتاحة
                    </button>
                    <button class="deals-tab" data-target="requests" style="padding: 12px 24px; border: 2px solid var(--primary); background: transparent; color: var(--primary); border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        🔍 الطلبات المطلوبة
                    </button>
                </div>

                <!-- Offers Grid -->
                <div id="offers-grid" class="deals-content">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                        @forelse($offers as $offer)
                            <div class="card" style="transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--warning)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                                @if($offer->images && count($offer->images) > 0)
                                    <img src="{{ asset('storage/' . $offer->images[0]) }}" alt="{{ $offer->title }}" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                @endif
                                
                                <div style="padding: 20px;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                        <h3 style="margin: 0; color: var(--dark); font-size: 16px; line-height: 1.4;">
                                            {{ $offer->title }}
                                        </h3>
                                        <span style="background: var(--warning); color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                            {{ $offer->category }}
                                        </span>
                                    </div>
                                    
                                    <p style="margin: 0 0 16px; color: var(--muted); line-height: 1.5; font-size: 14px;">
                                        {{ Str::limit($offer->description, 100) }}
                                    </p>
                                    
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                        <div>
                                            <span style="font-size: 18px; font-weight: 700; color: var(--warning);">{{ $offer->price }} ج</span>
                                            <span style="font-size: 12px; color: var(--muted); display: block;">السعر</span>
                                        </div>
                                        <div style="text-align: left;">
                                            <span style="font-size: 12px; color: var(--muted);">{{ $offer->user->name }}</span>
                                            <div style="display: flex; align-items: center; gap: 4px;">
                                                <span style="color: #fbbf24; font-size: 12px;">⭐⭐⭐⭐⭐</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('deals.show', $offer) }}" class="btn" style="width: 100%; padding: 12px; font-size: 14px; background: var(--warning); color: white; text-decoration: none; text-align: center; border-radius: 8px; font-weight: 600;">
                                        اطلب الآن
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--muted);">
                                <div style="font-size: 64px; margin-bottom: 16px;">🛍️</div>
                                <h3 style="margin: 0 0 8px; color: var(--dark);">لا توجد عروض حالياً</h3>
                                <p style="margin: 0;">كن أول من يعرض صفقة مميزة!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Requests Grid -->
                <div id="requests-grid" class="deals-content hidden">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                        @forelse($requests as $request)
                            <div class="card" style="transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                                <div style="padding: 20px;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                        <h3 style="margin: 0; color: var(--dark); font-size: 16px; line-height: 1.4;">
                                            {{ $request->title }}
                                        </h3>
                                        <span style="background: var(--primary); color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                            {{ $request->category }}
                                        </span>
                                    </div>
                                    
                                    <p style="margin: 0 0 16px; color: var(--muted); line-height: 1.5; font-size: 14px;">
                                        {{ Str::limit($request->description, 100) }}
                                    </p>
                                    
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                        <div>
                                            <span style="font-size: 18px; font-weight: 700; color: var(--primary);">{{ $request->price }} ج</span>
                                            <span style="font-size: 12px; color: var(--muted); display: block;">الميزانية</span>
                                        </div>
                                        <div style="text-align: left;">
                                            <span style="font-size: 12px; color: var(--muted);">{{ $request->user->name }}</span>
                                            <span style="font-size: 12px; color: var(--muted); display: block;">{{ $request->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('deals.show', $request) }}" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 14px; text-decoration: none; text-align: center;">
                                        قدم عرضك
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--muted);">
                                <div style="font-size: 64px; margin-bottom: 16px;">🔍</div>
                                <h3 style="margin: 0 0 8px; color: var(--dark);">لا توجد طلبات حالياً</h3>
                                <p style="margin: 0;">كن أول من يطلب صفقة!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    // Main tabs
    const tabs = document.querySelectorAll('.tab');
    const panels = document.querySelectorAll('[data-tab-panel]');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-tab-target');
            
            // Remove active class from all tabs and panels
            tabs.forEach(t => {
                t.classList.remove('active');
                t.style.color = 'var(--muted)';
                t.style.borderBottomColor = 'transparent';
            });
            panels.forEach(p => {
                p.classList.add('hidden');
            });
            
            // Add active class to clicked tab and corresponding panel
            this.classList.add('active');
            this.style.color = 'var(--primary)';
            this.style.borderBottomColor = 'var(--primary)';
            document.querySelector(target).classList.remove('hidden');
        });
    });
    
    // Deals sub-tabs
    const dealsTabs = document.querySelectorAll('.deals-tab');
    const dealsContent = document.querySelectorAll('.deals-content');
    
    dealsTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            
            // Remove active class from all deals tabs
            dealsTabs.forEach(t => {
                t.classList.remove('active');
                t.style.background = 'transparent';
                t.style.color = 'var(--primary)';
            });
            
            // Hide all deals content
            dealsContent.forEach(c => c.classList.add('hidden'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            this.style.background = 'var(--primary)';
            this.style.color = 'white';
            
            // Show corresponding content
            document.getElementById(target + '-grid').classList.remove('hidden');
        });
    });
});
</script>
@endsection
