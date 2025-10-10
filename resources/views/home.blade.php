@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero">
  <div class="container-full">
    <div class="hero-content" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
      <h1>منصة Sokappe للعمل الحر</h1>
      <p>اعرض مشروعك أو اطلب خدمتك الآن – Sokappe يوصلك بأفضل المستقلين والمواهب العربية في جميع المجالات</p>
      <div class="hero-buttons">
        <a href="{{ route('projects.create') }}" class="btn primary">ابدأ مشروعك الآن</a>
        <a href="{{ route('register') }}" class="btn outline" style="background:rgba(255,255,255,0.1); border-color:white; color:white;">انضم كمستقل</a>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>لماذا تختار Sokappe؟</h2>
      <p>منصة شاملة تجمع بين أصحاب المشاريع والمستقلين المحترفين</p>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">💼</div>
        <h3>مشاريع متنوعة</h3>
        <p>آلاف المشاريع في مختلف المجالات: التصميم، البرمجة، الكتابة، التسويق، والمزيد</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">⭐</div>
        <h3>مستقلون محترفون</h3>
        <p>شبكة من أفضل المستقلين العرب المتخصصين والموثوقين مع تقييمات حقيقية</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h3>دفع آمن</h3>
        <p>نظام دفع محمي يضمن حقوق الطرفين مع إمكانية استرداد الأموال</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">⚡</div>
        <h3>تسليم سريع</h3>
        <p>خدمات سريعة وجودة عالية مع إمكانية التسليم خلال 24 ساعة</p>
      </div>
    </div>
  </div>
</section>

<!-- Projects & Services Section -->
<section class="section">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>استكشف المشاريع والخدمات</h2>
      <p>ابحث عن الفرص المناسبة أو اطلب الخدمة التي تحتاجها</p>
    </div>
    
    <div data-tabs>
      <div class="tabs" role="tablist">
        <button class="tab active" data-tab-target="#tab-projects" role="tab">المشاريع المفتوحة</button>
        <button class="tab" data-tab-target="#tab-services" role="tab">الخدمات الجاهزة</button>
      </div>
      
      <div id="tab-projects" data-tab-panel>
        @if(isset($projects) && $projects->count())
          <div class="grid">
            @foreach($projects as $p)
              <div class="card">
                <h3>{{ $p->title }}</h3>
                <div class="meta">
                  💰 {{ $p->budget_min ?? 'غير محدد' }} - {{ $p->budget_max ?? 'غير محدد' }} ج
                  • ⏱️ {{ $p->duration_days ?? 'مرن' }} يوم
                </div>
                <p>{{ Str::limit($p->description, 120) }}</p>
                <div style="text-align:end;">
                  <a href="{{ route('projects.bid.create', $p) }}" class="btn outline">قدّم عرضك</a>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center" style="padding:60px 20px;">
            <div style="font-size:48px; margin-bottom:16px;">📋</div>
            <h3>لا توجد مشاريع متاحة حالياً</h3>
            <p class="muted">كن أول من ينشر مشروعاً جديداً</p>
            <a href="#" class="btn primary">أنشئ مشروعك الأول</a>
          </div>
        @endif
      </div>

      <div id="tab-services" class="hidden" data-tab-panel>
        @if(isset($services) && $services->count())
          <div class="grid">
            @foreach($services as $s)
              <div class="card">
                @if($s->image)
                  <img src="{{ $s->image }}" alt="service" style="width:100%; height:180px; object-fit:cover; border-radius:8px; margin-bottom:16px;">
                @endif
                <h3>{{ $s->title }}</h3>
                <div class="meta">
                  💵 {{ $s->price }}ج • 🚀 {{ $s->delivery_days ?? 'حسب الاتفاق' }} يوم
                  @if($s->rating_avg > 0)
                    • ⭐ {{ number_format($s->rating_avg, 1) }}
                  @endif
                </div>
                <a href="#" class="btn block primary">اطلب الآن</a>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center" style="padding:60px 20px;">
            <div style="font-size:48px; margin-bottom:16px;">🛍️</div>
            <h3>لا توجد خدمات متاحة حالياً</h3>
            <p class="muted">انضم كمستقل وابدأ في عرض خدماتك</p>
            <a href="{{ route('services.create') }}" class="btn primary">اعرض خدمتك</a>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="footer-content">
      <div class="footer-section">
        <h4>Sokappe</h4>
        <p>منصة العمل الحر الرائدة في الوطن العربي. نربط بين أصحاب المشاريع والمستقلين المحترفين.</p>
      </div>
      <div class="footer-section">
        <h4>للمستقلين</h4>
        <ul>
          <li><a href="#">كيف تبدأ</a></li>
          <li><a href="#">نصائح للنجاح</a></li>
          <li><a href="#">أدوات المستقل</a></li>
          <li><a href="#">مركز المساعدة</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>لأصحاب المشاريع</h4>
        <ul>
          <li><a href="#">انشر مشروعك</a></li>
          <li><a href="#">كيف تختار المستقل</a></li>
          <li><a href="#">ضمانات الجودة</a></li>
          <li><a href="#">الأسعار والعمولات</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>الشركة</h4>
        <ul>
          <li><a href="#">من نحن</a></li>
          <li><a href="#">اتصل بنا</a></li>
          <li><a href="#">الشروط والأحكام</a></li>
          <li><a href="#">سياسة الخصوصية</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 Sokappe. جميع الحقوق محفوظة.</p>
    </div>
  </div>
</footer>
@endsection
