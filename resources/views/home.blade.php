@extends('layouts.app')

@section('content')
<style>
/* Hero Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideInLeft {
  from {
    opacity: 0;
    transform: translateX(-50px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(50px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(-5px);
  }
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes glow {
  0%, 100% {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
  }
  50% {
    box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
  }
}

/* Enhanced Hero Section */
.hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
  animation: float 20s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.hero-content {
  animation: fadeInUp 1s ease-out;
  position: relative;
  z-index: 2;
}

.hero h1 {
  animation: slideInLeft 1.2s ease-out 0.3s both;
  font-size: 3.5rem;
  font-weight: 800;
  background: linear-gradient(45deg, #ffffff, #e0e7ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.hero p {
  animation: slideInRight 1.2s ease-out 0.6s both;
  font-size: 1.3rem;
  line-height: 1.8;
  margin: 2rem 0;
  color: rgba(255,255,255,0.95);
}

.hero-buttons {
  animation: fadeInUp 1.2s ease-out 0.9s both;
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.hero-buttons .btn {
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.hero-buttons .btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.hero-buttons .btn.primary {
  animation: glow 2s ease-in-out infinite;
}

.hero-buttons .btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.5s;
}

.hero-buttons .btn:hover::before {
  left: 100%;
}

/* Feature Cards Animation */
.feature-card {
  transition: all 0.3s ease;
  animation: fadeInUp 0.8s ease-out both;
}

.feature-card:nth-child(1) { animation-delay: 0.2s; }
.feature-card:nth-child(2) { animation-delay: 0.4s; }
.feature-card:nth-child(3) { animation-delay: 0.6s; }
.feature-card:nth-child(4) { animation-delay: 0.8s; }

.feature-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.feature-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  animation: bounce 2s infinite;
}

.feature-card:hover .feature-icon {
  animation: pulse 0.6s ease-in-out;
}

/* Enhanced Cards */
.card {
  transition: all 0.3s ease;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  overflow: hidden;
  background: linear-gradient(145deg, #ffffff, #f8fafc);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.1);
  border-color: #3b82f6;
}

/* Tabs Enhancement */
.tab {
  transition: all 0.3s ease;
  position: relative;
}

.tab::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 3px;
  background: linear-gradient(90deg, #3b82f6, #8b5cf6);
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.tab.active::after,
.tab:hover::after {
  width: 100%;
}

/* Section Animations */
.section-title {
  animation: fadeInUp 0.8s ease-out;
}

.section-title h2 {
  background: linear-gradient(45deg, #1f2937, #3b82f6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Grid Animation */
.grid .card {
  animation: fadeInUp 0.6s ease-out both;
}

.grid .card:nth-child(1) { animation-delay: 0.1s; }
.grid .card:nth-child(2) { animation-delay: 0.2s; }
.grid .card:nth-child(3) { animation-delay: 0.3s; }
.grid .card:nth-child(4) { animation-delay: 0.4s; }
.grid .card:nth-child(5) { animation-delay: 0.5s; }
.grid .card:nth-child(6) { animation-delay: 0.6s; }

/* Footer Enhancement */
.footer {
  background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
  position: relative;
}

.footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, #3b82f6, transparent);
}

/* Responsive Enhancements */
@media (max-width: 768px) {
  .hero h1 {
    font-size: 2.5rem;
  }
  
  .hero p {
    font-size: 1.1rem;
  }
  
  .hero-buttons {
    justify-content: center;
  }
}
</style>

<!-- Hero Section -->
<section class="hero">
  <div class="container-full">
    <div class="hero-content" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
      <h1>منصة Sokappe للعمل الحر</h1>
      <p>اعرض مشروعك أو اطلب خدمتك الآن – Sokappe يوصلك بأفضل المحترفين والمواهب العربية في جميع المجالات</p>
      <div class="hero-buttons">
        <a href="{{ route('projects.create.new') }}" class="btn primary">ابدأ مشروعك الآن</a>
        <a href="{{ route('register') }}" class="btn outline" style="background:rgba(255,255,255,0.1); border-color:white; color:white;">انضم كمحترف</a>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>لماذا تختار Sokappe؟</h2>
      <p>منصة شاملة تجمع بين أصحاب المشاريع والخبراء المحترفين</p>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">💼</div>
        <h3>مشاريع متنوعة</h3>
        <p>آلاف المشاريع في مختلف المجالات: التصميم، البرمجة، الكتابة، التسويق، والمزيد</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">⭐</div>
        <h3>خبراء محترفون</h3>
        <p>شبكة من أفضل المحترفين العرب المتخصصين والموثوقين مع تقييمات حقيقية</p>
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
                <h3><a href="{{ route('projects.bid.create', $p) }}" style="color: inherit; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">{{ $p->title }}</a></h3>
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
            <p class="muted">انضم كمحترف وابدأ في عرض خدماتك</p>
            <a href="{{ route('services.create.new') }}" class="btn primary">اعرض خدمتك</a>
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
        <p>منصة العمل الحر الرائدة في الوطن العربي. نربط بين أصحاب المشاريع والخبراء المحترفين.</p>
      </div>
      <div class="footer-section">
        <h4>للمحترفين</h4>
        <ul>
          <li><a href="#">كيف تبدأ</a></li>
          <li><a href="#">نصائح للنجاح</a></li>
          <li><a href="#">أدوات المحترف</a></li>
          <li><a href="#">مركز المساعدة</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>لأصحاب المشاريع</h4>
        <ul>
          <li><a href="#">انشر مشروعك</a></li>
          <li><a href="#">كيف تختار المحترف</a></li>
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
