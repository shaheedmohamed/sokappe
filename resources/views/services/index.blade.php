@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; padding: 50px 40px; margin-bottom: 40px; color: white; text-align: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');"></div>
        
        <div style="position: relative; z-index: 2;">
            <h1 style="margin: 0 0 16px; font-size: 36px; font-weight: 800;">
                ⚡ تصفح الخدمات
            </h1>
            <p style="margin: 0 0 24px; font-size: 18px; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                اكتشف خدمات جاهزة من مستقلين محترفين
            </p>
            
            @auth
                <a href="{{ route('services.create') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 14px 28px; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='white'; this.style.color='var(--secondary)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white'">
                    🚀 اعرض خدمتك
                </a>
            @endauth
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card" style="margin-bottom: 32px; padding: 24px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--dark); font-size: 14px;">🔍 البحث</label>
                <input type="text" placeholder="ابحث في الخدمات..." style="width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; font-size: 14px;">
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
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--dark); font-size: 14px;">💰 السعر</label>
                <select style="width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; font-size: 14px;">
                    <option value="">جميع الأسعار</option>
                    <option value="0-100">أقل من 100 ج</option>
                    <option value="100-500">100 - 500 ج</option>
                    <option value="500-1000">500 - 1000 ج</option>
                    <option value="1000+">أكثر من 1000 ج</option>
                </select>
            </div>
            <div>
                <button style="background: var(--secondary); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    🔍 بحث
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div style="background: linear-gradient(135deg, #dcfce7, #10b981); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ $services->total() }}</div>
            <div style="font-size: 14px; font-weight: 600;">خدمة متاحة</div>
        </div>
        <div style="background: linear-gradient(135deg, #dbeafe, #3b82f6); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(80, 150) }}</div>
            <div style="font-size: 14px; font-weight: 600;">مقدم خدمة</div>
        </div>
        <div style="background: linear-gradient(135deg, #fef3c7, #fbbf24); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 28px; font-weight: 800; color: #92400e; margin-bottom: 4px;">{{ rand(20, 50) }}</div>
            <div style="color: #92400e; font-size: 14px; font-weight: 600;">طلب جديد اليوم</div>
        </div>
        <div style="background: linear-gradient(135deg, #fce7f3, #ec4899); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">4.9</div>
            <div style="font-size: 14px; font-weight: 600;">متوسط التقييم</div>
        </div>
    </div>

    <!-- Services Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 40px;">
        @forelse($services as $service)
            <div class="card" style="overflow: hidden; transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--secondary)'; this.style.transform='translateY(-8px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                <!-- Service Image -->
                <div style="position: relative; overflow: hidden;">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" 
                             style="width: 100%; height: 200px; object-fit: cover; transition: all 0.3s;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
                    @else
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 64px;">
                            ⚡
                        </div>
                    @endif
                    
                    <!-- Service Badge -->
                    <div style="position: absolute; top: 12px; right: 12px;">
                        <span style="background: var(--secondary); color: white; padding: 6px 12px; border-radius: 16px; font-size: 11px; font-weight: 600;">
                            {{ $service->category }}
                        </span>
                    </div>
                </div>

                <!-- Service Content -->
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 8px; color: var(--dark); font-size: 16px; line-height: 1.4;">
                        <a href="{{ route('services.show', $service) }}" style="color: inherit; text-decoration: none;">
                            {{ $service->title }}
                        </a>
                    </h3>
                    
                    <p style="margin: 0 0 16px; color: var(--muted); font-size: 14px; line-height: 1.5;">
                        {{ Str::limit($service->description, 100) }}
                    </p>

                    <!-- Service Provider -->
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                            {{ $service->user ? substr($service->user->name, 0, 1) : 'U' }}
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--dark);">
                                <a href="{{ $service->user ? route('profile.show', $service->user) : '#' }}" style="color: inherit; text-decoration: none;">
                                    {{ $service->user->name ?? 'مستخدم غير معروف' }}
                                </a>
                            </div>
                            <div style="display: flex; align-items: center; gap: 4px;">
                                <span style="color: #fbbf24; font-size: 12px;">⭐⭐⭐⭐⭐</span>
                                <span style="font-size: 11px; color: var(--muted);">({{ rand(40, 50) / 10 }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Service Meta -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding: 12px; background: var(--gray-50); border-radius: 8px; font-size: 13px;">
                        <div>
                            <span style="color: var(--muted); display: block;">مدة التسليم</span>
                            <span style="font-weight: 600; color: var(--dark);">{{ $service->delivery_time }} أيام</span>
                        </div>
                        <div style="text-align: left;">
                            <span style="color: var(--muted); display: block;">المبيعات</span>
                            <span style="font-weight: 600; color: var(--secondary);">{{ rand(5, 50) }}</span>
                        </div>
                    </div>

                    <!-- Price and Action -->
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 20px; font-weight: 700; color: var(--secondary);">{{ number_format($service->price) }} ج</span>
                            <span style="font-size: 12px; color: var(--muted); display: block;">يبدأ من</span>
                        </div>
                        <a href="{{ route('services.show', $service) }}" class="btn" style="background: var(--secondary); color: white; padding: 10px 20px; font-size: 14px; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            اطلب الآن
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: var(--muted);">
                <div style="font-size: 64px; margin-bottom: 24px;">⚡</div>
                <h3 style="margin: 0 0 12px; color: var(--dark);">لا توجد خدمات متاحة حالياً</h3>
                <p style="margin: 0 0 24px; font-size: 16px;">كن أول من يعرض خدمة احترافية!</p>
                @auth
                    <a href="{{ route('services.create') }}" class="btn" style="background: var(--secondary); color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 600;">
                        🚀 اعرض خدمتك
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $services->links() }}
        </div>
    @endif

    <!-- Featured Categories -->
    <div style="margin-top: 40px;">
        <h2 style="text-align: center; margin-bottom: 32px; color: var(--dark); font-size: 28px; font-weight: 800;">
            الفئات الأكثر طلباً
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="background: linear-gradient(135deg, #dbeafe, #3b82f6); padding: 24px; border-radius: 16px; text-align: center; color: white; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 48px; margin-bottom: 12px;">💻</div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">تطوير وبرمجة</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">مواقع، تطبيقات، وحلول برمجية</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #fef3c7, #fbbf24); padding: 24px; border-radius: 16px; text-align: center; color: #92400e; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 48px; margin-bottom: 12px;">🎨</div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">تصميم وجرافيك</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">لوجوهات، هوية بصرية، وتصاميم</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #dcfce7, #10b981); padding: 24px; border-radius: 16px; text-align: center; color: white; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 48px; margin-bottom: 12px;">✍️</div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">كتابة وترجمة</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">محتوى، مقالات، وترجمة احترافية</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #fce7f3, #ec4899); padding: 24px; border-radius: 16px; text-align: center; color: white; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 48px; margin-bottom: 12px;">📱</div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 700;">تسويق رقمي</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">إعلانات، سوشيال ميديا، وSEO</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; padding: 40px; margin-top: 40px; text-align: center; color: white;">
        <h2 style="margin: 0 0 16px; font-size: 28px; font-weight: 800;">
            هل لديك خدمة مميزة؟
        </h2>
        <p style="margin: 0 0 24px; font-size: 16px; opacity: 0.9;">
            اعرض خدماتك واكسب المال من مهاراتك
        </p>
        @auth
            <a href="{{ route('services.create') }}" class="btn" style="background: white; color: var(--secondary); padding: 16px 32px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                🚀 اعرض خدمتك الآن
            </a>
        @else
            <a href="{{ route('register') }}" class="btn" style="background: white; color: var(--secondary); padding: 16px 32px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                🚀 انضم الآن
            </a>
        @endauth
    </div>
</div>
@endsection
