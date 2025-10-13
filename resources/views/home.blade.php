@extends('layouts.app')

@section('content')
<style>
/* Enhanced Animations */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
  from { opacity: 0; transform: translateX(-50px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes slideInRight {
  from { opacity: 0; transform: translateX(50px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
  40% { transform: translateY(-10px); }
  60% { transform: translateY(-5px); }
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

@keyframes glow {
  0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
  50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.6); }
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

@keyframes rotate {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

@keyframes scaleIn {
  from { opacity: 0; transform: scale(0.8); }
  to { opacity: 1; transform: scale(1); }
}

/* Hero Section */
.hero {
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.95), rgba(139, 92, 246, 0.95)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
  position: relative;
  overflow: hidden;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
  animation: float 20s ease-in-out infinite;
}

.hero-content {
  animation: fadeInUp 1s ease-out;
  position: relative;
  z-index: 2;
}

/* Features Section */
.features {
  padding: 100px 0;
  background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
  position: relative;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  margin-top: 60px;
}

.feature-card {
  background: white;
  padding: 40px 30px;
  border-radius: 20px;
  text-align: center;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
  animation: fadeInUp 0.8s ease-out both;
}

.feature-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #3b82f6, #8b5cf6);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.feature-card:hover::before {
  transform: scaleX(1);
}

.feature-card:hover {
  transform: translateY(-15px);
  box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.feature-icon {
  font-size: 4rem;
  margin-bottom: 20px;
  display: block;
  animation: bounce 2s infinite;
}

/* Trust Section */
.trust-section {
  padding: 80px 0;
  background: white;
}

.trust-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
  margin-top: 50px;
}

.trust-item {
  text-align: center;
  padding: 30px 20px;
  border-radius: 15px;
  background: linear-gradient(135deg, #f8fafc, #e2e8f0);
  transition: all 0.3s ease;
  animation: scaleIn 0.6s ease-out both;
}

.trust-item:hover {
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.trust-number {
  font-size: 3rem;
  font-weight: 900;
  background: linear-gradient(45deg, #3b82f6, #8b5cf6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 10px;
}

/* How It Works Section */
.how-it-works {
  padding: 100px 0;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  position: relative;
}

.steps-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  margin-top: 60px;
}

.step-card {
  text-align: center;
  padding: 40px 20px;
  border-radius: 20px;
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.2);
  transition: all 0.3s ease;
  animation: fadeInUp 0.8s ease-out both;
}

.step-card:hover {
  transform: translateY(-10px);
  background: rgba(255,255,255,0.15);
}

.step-number {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(45deg, #fbbf24, #f59e0b);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: 900;
  margin: 0 auto 20px;
  color: white;
  animation: pulse 2s infinite;
}

/* Testimonials Section */
.testimonials {
  padding: 100px 0;
  background: white;
}

.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  margin-top: 60px;
}

.testimonial-card {
  background: linear-gradient(135deg, #f8fafc, #e2e8f0);
  padding: 40px 30px;
  border-radius: 20px;
  position: relative;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  animation: fadeInUp 0.8s ease-out both;
}

.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.testimonial-card::before {
  content: '"';
  position: absolute;
  top: -10px;
  left: 20px;
  font-size: 4rem;
  color: #3b82f6;
  font-family: serif;
}

.testimonial-author {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-top: 20px;
}

.author-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
}

/* CTA Section */
.cta-section {
  padding: 100px 0;
  background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
  color: white;
  text-align: center;
  position: relative;
}

.cta-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
  opacity: 0.1;
}

.cta-content {
  position: relative;
  z-index: 2;
}

/* Section Titles */
.section-title {
  text-align: center;
  margin-bottom: 20px;
  animation: fadeInUp 0.8s ease-out;
}

.section-title h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 20px;
  background: linear-gradient(45deg, #1f2937, #3b82f6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.section-title p {
  font-size: 1.2rem;
  color: #64748b;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Buttons */
.btn {
  display: inline-block;
  padding: 15px 30px;
  border-radius: 50px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.btn.primary {
  background: linear-gradient(45deg, #3b82f6, #8b5cf6);
  color: white;
  box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.btn.primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
}

.btn.outline {
  border: 2px solid #3b82f6;
  color: #3b82f6;
  background: transparent;
}

.btn.outline:hover {
  background: #3b82f6;
  color: white;
}

/* Responsive */
@media (max-width: 768px) {
  .hero h1 { font-size: 2.5rem; }
  .hero p { font-size: 1.1rem; }
  .section-title h2 { font-size: 2rem; }
  .features-grid { grid-template-columns: 1fr; }
  .steps-grid { grid-template-columns: 1fr; }
  .testimonials-grid { grid-template-columns: 1fr; }
}
</style>

<!-- Hero Section -->
<section class="hero">
  <div class="container-full">
    <div class="hero-content" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; text-align: center; color: white;">
      <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 30px;">
        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=126&q=80" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid white; box-shadow: 0 8px 32px rgba(0,0,0,0.3); animation: pulse 2s infinite;" alt="Success">
        <h1 style="font-size: 4rem; font-weight: 900; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); animation: slideInLeft 1.2s ease-out;">🚀 Sokappe</h1>
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=126&q=80" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid white; box-shadow: 0 8px 32px rgba(0,0,0,0.3);" alt="Team">
      </div>
      <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 20px; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">منصة العمل الحر الأولى في الوطن العربي</h2>
      <p style="font-size: 1.4rem; line-height: 1.8; margin-bottom: 40px; max-width: 800px; margin-left: auto; margin-right: auto; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">🎯 اربط مشروعك بأفضل المحترفين العرب • 💼 احصل على خدمات عالية الجودة • ⚡ تسليم سريع وضمان كامل</p>
      <div class="hero-buttons" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('projects.create') }}" class="btn primary" style="padding: 18px 40px; font-size: 1.2rem; font-weight: 700; border-radius: 50px; background: linear-gradient(45deg, #10b981, #059669); border: none; color: white; text-decoration: none; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); transition: all 0.3s ease;">🚀 ابدأ مشروعك الآن</a>
        <a href="{{ route('register') }}" class="btn outline" style="padding: 18px 40px; font-size: 1.2rem; font-weight: 700; border-radius: 50px; background: rgba(255,255,255,0.15); border: 2px solid white; color: white; text-decoration: none; backdrop-filter: blur(10px); transition: all 0.3s ease;">⭐ انضم كمحترف</a>
      </div>
      
      <!-- Trust Indicators -->
      <div style="margin-top: 60px; display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; opacity: 0.9;">
        <div style="text-align: center; animation: fadeInUp 1s ease-out 1.2s both;">
          <div style="font-size: 2.5rem; font-weight: 900; color: #fbbf24;">15K+</div>
          <div style="font-size: 0.9rem; opacity: 0.8;">مشروع مكتمل</div>
        </div>
        <div style="text-align: center; animation: fadeInUp 1s ease-out 1.4s both;">
          <div style="font-size: 2.5rem; font-weight: 900; color: #fbbf24;">8K+</div>
          <div style="font-size: 0.9rem; opacity: 0.8;">محترف موثوق</div>
        </div>
        <div style="text-align: center; animation: fadeInUp 1s ease-out 1.6s both;">
          <div style="font-size: 2.5rem; font-weight: 900; color: #fbbf24;">99%</div>
          <div style="font-size: 0.9rem; opacity: 0.8;">رضا العملاء</div>
        </div>
        <div style="text-align: center; animation: fadeInUp 1s ease-out 1.8s both;">
          <div style="font-size: 2.5rem; font-weight: 900; color: #fbbf24;">24/7</div>
          <div style="font-size: 0.9rem; opacity: 0.8;">دعم فني</div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Floating Elements -->
  <div style="position: absolute; top: 20%; left: 10%; animation: float 6s ease-in-out infinite;">
    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 60px; height: 60px; border-radius: 50%; opacity: 0.7; box-shadow: 0 4px 15px rgba(0,0,0,0.2);" alt="Code">
  </div>
  <div style="position: absolute; top: 30%; right: 15%; animation: float 8s ease-in-out infinite reverse;">
    <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 50px; height: 50px; border-radius: 50%; opacity: 0.6; box-shadow: 0 4px 15px rgba(0,0,0,0.2);" alt="Design">
  </div>
  <div style="position: absolute; bottom: 20%; left: 20%; animation: float 10s ease-in-out infinite;">
    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 70px; height: 70px; border-radius: 50%; opacity: 0.5; box-shadow: 0 4px 15px rgba(0,0,0,0.2);" alt="Success">
  </div>
</section>

<!-- Trust & Security Section -->
<section class="trust-section">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>🛡️ الثقة والأمان أولويتنا</h2>
      <p>نضمن لك تجربة آمنة وموثوقة مع أفضل المعايير العالمية</p>
    </div>
    
    <div class="trust-grid">
      <div class="trust-item" style="animation-delay: 0.1s;">
        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: block;" alt="Security">
        <div class="trust-number">256-bit</div>
        <h4 style="margin: 10px 0; color: #1f2937;">تشفير متقدم</h4>
        <p style="color: #64748b; font-size: 0.9rem;">حماية كاملة لبياناتك المالية والشخصية</p>
      </div>
      
      <div class="trust-item" style="animation-delay: 0.2s;">
        <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: block;" alt="Money Back">
        <div class="trust-number">100%</div>
        <h4 style="margin: 10px 0; color: #1f2937;">ضمان استرداد</h4>
        <p style="color: #64748b; font-size: 0.9rem;">استرد أموالك كاملة إذا لم تكن راضياً</p>
      </div>
      
      <div class="trust-item" style="animation-delay: 0.3s;">
        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: block;" alt="Support">
        <div class="trust-number">24/7</div>
        <h4 style="margin: 10px 0; color: #1f2937;">دعم مستمر</h4>
        <p style="color: #64748b; font-size: 0.9rem;">فريق دعم متخصص لمساعدتك في أي وقت</p>
      </div>
      
      <div class="trust-item" style="animation-delay: 0.4s;">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: block;" alt="Verified">
        <div class="trust-number">✓</div>
        <h4 style="margin: 10px 0; color: #1f2937;">محترفون موثقون</h4>
        <p style="color: #64748b; font-size: 0.9rem;">جميع المحترفين تم التحقق من هويتهم ومهاراتهم</p>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>✨ لماذا تختار Sokappe؟</h2>
      <p>منصة شاملة تجمع بين أصحاب المشاريع والخبراء المحترفين بأحدث التقنيات</p>
    </div>
    <div class="features-grid">
      <div class="feature-card" style="animation-delay: 0.1s;">
        <div class="feature-icon">💼</div>
        <h3 style="color: #1f2937; margin: 20px 0 15px;">مشاريع متنوعة</h3>
        <p style="color: #64748b; line-height: 1.6;">آلاف المشاريع في مختلف المجالات: التصميم، البرمجة، الكتابة، التسويق، والمزيد من التخصصات</p>
      </div>
      <div class="feature-card" style="animation-delay: 0.2s;">
        <div class="feature-icon">⭐</div>
        <h3 style="color: #1f2937; margin: 20px 0 15px;">خبراء محترفون</h3>
        <p style="color: #64748b; line-height: 1.6;">شبكة من أفضل المحترفين العرب المتخصصين والموثوقين مع تقييمات حقيقية من العملاء</p>
      </div>
      <div class="feature-card" style="animation-delay: 0.3s;">
        <div class="feature-icon">🔒</div>
        <h3 style="color: #1f2937; margin: 20px 0 15px;">دفع آمن</h3>
        <p style="color: #64748b; line-height: 1.6;">نظام دفع محمي بأحدث تقنيات الحماية يضمن حقوق الطرفين مع إمكانية استرداد الأموال</p>
      </div>
      <div class="feature-card" style="animation-delay: 0.4s;">
        <div class="feature-icon">⚡</div>
        <h3 style="color: #1f2937; margin: 20px 0 15px;">تسليم سريع</h3>
        <p style="color: #64748b; line-height: 1.6;">خدمات سريعة وجودة عالية مع إمكانية التسليم خلال 24 ساعة والمتابعة المستمرة</p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title" style="color: white;">
      <h2 style="color: white;">🚀 كيف يعمل Sokappe؟</h2>
      <p style="color: rgba(255,255,255,0.9);">خطوات بسيطة للوصول لأفضل النتائج في أقل وقت</p>
    </div>
    
    <div class="steps-grid">
      <div class="step-card" style="animation-delay: 0.1s;">
        <div class="step-number">1</div>
        <h3 style="color: white; margin: 20px 0 15px;">انشر مشروعك</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">اكتب تفاصيل مشروعك بوضوح وحدد الميزانية والمدة الزمنية المطلوبة</p>
      </div>
      
      <div class="step-card" style="animation-delay: 0.2s;">
        <div class="step-number">2</div>
        <h3 style="color: white; margin: 20px 0 15px;">اختر المحترف</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">استقبل عروض من محترفين مؤهلين واختر الأنسب حسب الخبرة والسعر</p>
      </div>
      
      <div class="step-card" style="animation-delay: 0.3s;">
        <div class="step-number">3</div>
        <h3 style="color: white; margin: 20px 0 15px;">تابع التقدم</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">تواصل مع المحترف وتابع سير العمل خطوة بخطوة حتى التسليم</p>
      </div>
      
      <div class="step-card" style="animation-delay: 0.4s;">
        <div class="step-number">4</div>
        <h3 style="color: white; margin: 20px 0 15px;">استلم النتيجة</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">احصل على عملك مكتملاً بأعلى جودة وقيّم تجربتك مع المحترف</p>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>💬 ماذا يقول عملاؤنا؟</h2>
      <p>تجارب حقيقية من عملاء راضين عن خدماتنا</p>
    </div>
    
    <div class="testimonials-grid">
      <div class="testimonial-card" style="animation-delay: 0.1s;">
        <p style="color: #374151; line-height: 1.7; margin-bottom: 20px; font-style: italic;">
          منصة رائعة! وجدت المحترف المناسب لمشروعي في وقت قياسي. الجودة عالية والسعر معقول جداً. أنصح بها بشدة.
        </p>
        <div class="testimonial-author">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="author-avatar" alt="Ahmed">
          <div>
            <h5 style="margin: 0; color: #1f2937;">أحمد محمد</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">مدير شركة تقنية</p>
          </div>
        </div>
      </div>
      
      <div class="testimonial-card" style="animation-delay: 0.2s;">
        <p style="color: #374151; line-height: 1.7; margin-bottom: 20px; font-style: italic;">
          تجربة مميزة! المحترفون هنا على مستوى عالي من الاحترافية. تم تسليم مشروعي قبل الموعد بجودة تفوق التوقعات.
        </p>
        <div class="testimonial-author">
          <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="author-avatar" alt="Fatima">
          <div>
            <h5 style="margin: 0; color: #1f2937;">فاطمة علي</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">رائدة أعمال</p>
          </div>
        </div>
      </div>
      
      <div class="testimonial-card" style="animation-delay: 0.3s;">
        <p style="color: #374151; line-height: 1.7; margin-bottom: 20px; font-style: italic;">
          كمحترف، وجدت في Sokappe المنصة المثالية لعرض خدماتي. العملاء جادون والمشاريع متنوعة ومربحة.
        </p>
        <div class="testimonial-author">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="author-avatar" alt="Omar">
          <div>
            <h5 style="margin: 0; color: #1f2937;">عمر خالد</h5>
            <p style="color: #64748b; font-size: 0.9rem;">مطور ويب محترف</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="cta-content">
    <div class="container-full" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
      <div style="text-align: center; animation: fadeInUp 0.8s ease-out;">
        <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px; color: white;">🎯 ابدأ رحلتك معنا اليوم</h2>
        <p style="font-size: 1.3rem; line-height: 1.7; margin-bottom: 40px; color: rgba(255,255,255,0.9);">
          انضم لآلاف العملاء والمحترفين الذين يحققون أهدافهم عبر منصة Sokappe
        </p>
        
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 50px;">
          <a href="{{ route('projects.create') }}" class="btn primary" style="padding: 20px 40px; font-size: 1.2rem; border-radius: 50px; background: linear-gradient(45deg, #10b981, #059669); box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);">
            🚀 انشر مشروعك مجاناً
          </a>
          <a href="{{ route('register') }}" class="btn outline" style="padding: 20px 40px; font-size: 1.2rem; border-radius: 50px; border: 2px solid white; color: white; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
            ⭐ ابدأ العمل كمحترف
          </a>
        </div>
        
        <!-- Final Trust Indicators -->
        <div style="display: flex; justify-content: center; gap: 50px; flex-wrap: wrap; opacity: 0.8;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80" style="width: 40px; height: 40px; border-radius: 50%;" alt="Team">
            <span style="color: white; font-size: 0.9rem;">فريق دعم محترف</span>
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80" style="width: 40px; height: 40px; border-radius: 50%;" alt="Security">
            <span style="color: white; font-size: 0.9rem;">حماية كاملة للأموال</span>
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80" style="width: 40px; height: 40px; border-radius: 50%;" alt="Success">
            <span style="color: white; font-size: 0.9rem;">ضمان الجودة</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); color: white; padding: 60px 0 30px; position: relative;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px;">
      
      <!-- Company Info -->
      <div style="animation: fadeInUp 0.6s ease-out;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
          <h4 style="margin: 0; font-size: 1.8rem; color: #3b82f6;">🚀 Sokappe</h4>
        </div>
        <p style="color: #d1d5db; line-height: 1.6; margin-bottom: 20px;">
          منصة العمل الحر الرائدة في الوطن العربي. نربط بين أصحاب المشاريع والخبراء المحترفين بأحدث التقنيات.
        </p>
        <div style="display: flex; gap: 15px;">
          <a href="#" style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3b82f6; text-decoration: none; transition: all 0.3s ease;">📘</a>
          <a href="#" style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3b82f6; text-decoration: none; transition: all 0.3s ease;">🐦</a>
          <a href="#" style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3b82f6; text-decoration: none; transition: all 0.3s ease;">📷</a>
          <a href="#" style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3b82f6; text-decoration: none; transition: all 0.3s ease;">💼</a>
        </div>
      </div>
      
      <!-- For Freelancers -->
      <div style="animation: fadeInUp 0.6s ease-out 0.1s both;">
        <h4 style="color: white; margin-bottom: 20px; font-size: 1.2rem;">💼 للمحترفين</h4>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">🚀 كيف تبدأ</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">💡 نصائح للنجاح</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">🛠️ أدوات المحترف</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">❓ مركز المساعدة</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">📊 إحصائياتي</a></li>
        </ul>
      </div>
      
      <!-- For Clients -->
      <div style="animation: fadeInUp 0.6s ease-out 0.2s both;">
        <h4 style="color: white; margin-bottom: 20px; font-size: 1.2rem;">🎯 لأصحاب المشاريع</h4>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="{{ route('projects.create') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">📝 انشر مشروعك</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">🔍 كيف تختار المحترف</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">✅ ضمانات الجودة</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">💰 الأسعار والعمولات</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">📈 مشاريعي</a></li>
        </ul>
      </div>
      
      <!-- Company -->
      <div style="animation: fadeInUp 0.6s ease-out 0.3s both;">
        <h4 style="color: white; margin-bottom: 20px; font-size: 1.2rem;">🏢 الشركة</h4>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">🌟 من نحن</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">📞 اتصل بنا</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">📋 الشروط والأحكام</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">🔒 سياسة الخصوصية</a></li>
          <li style="margin-bottom: 12px;"><a href="#" style="color: #d1d5db; text-decoration: none; transition: color 0.3s ease; font-size: 0.95rem;">📰 المدونة</a></li>
        </ul>
      </div>
    </div>
    
    <!-- Footer Bottom -->
    <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
      <div style="color: #9ca3af; font-size: 0.9rem;">
        &copy; 2024 Sokappe. جميع الحقوق محفوظة. 
        <span style="color: #3b82f6;">صُنع بـ ❤️ في الوطن العربي</span>
      </div>
      
      <div style="display: flex; align-items: center; gap: 20px; color: #9ca3af; font-size: 0.85rem;">
        <div style="display: flex; align-items: center; gap: 5px;">
          <span>🔒</span>
          <span>SSL آمن</span>
        </div>
        <div style="display: flex; align-items: center; gap: 5px;">
          <span>💳</span>
          <span>دفع محمي</span>
        </div>
        <div style="display: flex; align-items: center; gap: 5px;">
          <span>🏆</span>
          <span>جودة مضمونة</span>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Scroll to Top Button -->
<button id="scrollToTop" onclick="scrollToTop()" style="position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; color: white; font-size: 1.2rem; cursor: pointer; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); transition: all 0.3s ease; z-index: 1000; display: none;">
  ⬆️
</button>

<script>
// Scroll to top functionality
window.addEventListener('scroll', function() {
  const scrollBtn = document.getElementById('scrollToTop');
  if (window.pageYOffset > 300) {
    scrollBtn.style.display = 'block';
  } else {
    scrollBtn.style.display = 'none';
  }
});

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

// Add hover effects to footer links
document.querySelectorAll('footer a').forEach(link => {
  link.addEventListener('mouseenter', function() {
    this.style.color = '#3b82f6';
    this.style.transform = 'translateX(5px)';
  });
  
  link.addEventListener('mouseleave', function() {
    this.style.color = '#d1d5db';
    this.style.transform = 'translateX(0)';
  });
});

// Add hover effects to social icons
document.querySelectorAll('footer a[style*="border-radius: 50%"]').forEach(icon => {
  icon.addEventListener('mouseenter', function() {
    this.style.background = '#3b82f6';
    this.style.transform = 'scale(1.1)';
  });
  
  icon.addEventListener('mouseleave', function() {
    this.style.background = 'rgba(59, 130, 246, 0.2)';
    this.style.transform = 'scale(1)';
  });
});

// Animate elements on scroll
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, observerOptions);

// Observe all animated elements
document.querySelectorAll('.feature-card, .trust-item, .step-card, .testimonial-card').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(30px)';
  el.style.transition = 'all 0.6s ease-out';
  observer.observe(el);
});
</script>
@endsection
