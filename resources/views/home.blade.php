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
  
  /* Video Sections Responsive */
  .video-card { margin-bottom: 30px; }
  .demo-grid { 
    grid-template-columns: 1fr !important; 
    gap: 40px !important; 
  }
  .demo-container { 
    padding: 25px !important; 
    margin-bottom: 30px; 
  }
  .demo-screen { 
    min-height: 250px !important; 
    padding: 20px !important; 
  }
  
  /* Timeline Responsive */
  .timeline-item { 
    flex-direction: column !important; 
    text-align: center !important; 
  }
  .timeline-item > div { 
    padding: 0 !important; 
    margin-bottom: 20px; 
  }
  
  /* Skills Responsive */
  .skills-container { 
    justify-content: center !important; 
  }
  .skill-tag { 
    font-size: 0.9rem !important; 
    padding: 10px 20px !important; 
  }
}

@media (max-width: 480px) {
  .section-title h2 { font-size: 1.8rem !important; }
  .section-title p { font-size: 1rem !important; }
  .hero-buttons { flex-direction: column !important; }
  .hero-buttons a { width: 100% !important; text-align: center !important; }
  
  /* Video Cards Mobile */
  .video-card { 
    margin: 0 10px 20px 10px; 
  }
  .video-card h4 { 
    font-size: 1.1rem !important; 
  }
  .video-card p { 
    font-size: 0.85rem !important; 
  }
  
  /* Comparison Table Mobile */
  .comparison-table {
    display: block !important;
  }
  .comparison-table > div {
    display: block !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 15px !important;
  }
  .comparison-table > div:nth-child(3n+1) {
    font-weight: 700 !important;
    background: #f8fafc !important;
  }
}
</style>

<!-- Hero Section -->
<section class="hero" style="position: relative; z-index: 5;">
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
<section class="trust-section" style="position: relative; z-index: 10;">
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

<!-- Low Commission Section -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); position: relative; overflow: hidden;">
  <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: linear-gradient(45deg, #10b981, #059669); border-radius: 50%; opacity: 0.1; animation: float 8s ease-in-out infinite;"></div>
  <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); border-radius: 50%; opacity: 0.1; animation: float 6s ease-in-out infinite reverse;"></div>
  
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3.5rem; font-weight: 900; color: #065f46; margin-bottom: 20px;">💰 أقل عمولة في السوق!</h2>
      <p style="font-size: 1.3rem; color: #047857; font-weight: 600;">وفر أموالك مع عمولة منخفضة جداً مقارنة بالمنافسين</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 60px;">
      <!-- Sokappe Commission -->
      <div class="sokappe-commission" style="background: white; padding: 40px 30px; border-radius: 25px; text-align: center; box-shadow: 0 15px 40px rgba(16, 185, 129, 0.15); border: 3px solid #10b981; position: relative; overflow: hidden; animation: pulse 2s infinite; transition: all 0.5s ease;">
        <div style="position: absolute; top: -10px; right: -10px; background: #ef4444; color: white; padding: 8px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; transform: rotate(15deg);">الأفضل!</div>
        <div style="font-size: 4rem; margin-bottom: 20px;">🏆</div>
        <h3 style="color: #065f46; font-size: 2rem; font-weight: 800; margin-bottom: 15px;">Sokappe</h3>
        <div style="font-size: 4rem; font-weight: 900; color: #10b981; margin-bottom: 15px;">5%</div>
        <p style="color: #047857; font-size: 1.1rem; font-weight: 600;">عمولة فقط على المشاريع المكتملة</p>
        <div style="margin-top: 25px; padding: 20px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-radius: 15px;">
          <p style="color: #065f46; font-weight: 600; margin: 0;">✅ أول 3 مشاريع مجاناً تماماً!</p>
        </div>
      </div>
      
      <!-- Competitors -->
      <div class="competitor-commission" style="background: #f8fafc; padding: 40px 30px; border-radius: 25px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #e2e8f0; opacity: 0.8; transition: all 0.5s ease;">
        <div style="font-size: 4rem; margin-bottom: 20px;">😔</div>
        <h3 style="color: #64748b; font-size: 2rem; font-weight: 800; margin-bottom: 15px;">المنافسون</h3>
        <div style="font-size: 4rem; font-weight: 900; color: #ef4444; margin-bottom: 15px;">15-20%</div>
        <p style="color: #64748b; font-size: 1.1rem;">عمولة عالية + رسوم إضافية</p>
        <div style="margin-top: 25px; padding: 20px; background: #fee2e2; border-radius: 15px;">
          <p style="color: #dc2626; font-weight: 600; margin: 0;">❌ رسوم مخفية ومعقدة</p>
        </div>
      </div>
    </div>
    
    <!-- Savings Calculator -->
    <div style="background: white; padding: 50px 40px; border-radius: 25px; text-align: center; box-shadow: 0 20px 50px rgba(16, 185, 129, 0.1); border: 2px solid #10b981;">
      <h3 style="color: #065f46; font-size: 2.5rem; font-weight: 800; margin-bottom: 30px;">💡 احسب توفيرك معنا</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-bottom: 30px;">
        <div class="savings-card" style="padding: 25px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-radius: 15px; transition: all 0.3s ease;">
          <div style="font-size: 1.5rem; color: #065f46; font-weight: 700;">مشروع بـ 1000$</div>
          <div class="success-number" style="font-size: 1.2rem; color: #10b981; margin-top: 10px;">توفر: 150$ 💰</div>
        </div>
        <div class="savings-card" style="padding: 25px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-radius: 15px; transition: all 0.3s ease;">
          <div style="font-size: 1.5rem; color: #065f46; font-weight: 700;">مشروع بـ 5000$</div>
          <div class="success-number" style="font-size: 1.2rem; color: #10b981; margin-top: 10px;">توفر: 750$ 💰</div>
        </div>
        <div class="savings-card" style="padding: 25px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-radius: 15px; transition: all 0.3s ease;">
          <div style="font-size: 1.5rem; color: #065f46; font-weight: 700;">مشروع بـ 10000$</div>
          <div class="success-number" style="font-size: 1.2rem; color: #10b981; margin-top: 10px;">توفر: 1500$ 💰</div>
        </div>
      </div>
      <p style="color: #047857; font-size: 1.2rem; font-weight: 600;">كلما زاد حجم مشروعك، كلما وفرت أكثر معنا!</p>
    </div>
    
    <!-- Quick Comparison Table -->
    <div style="margin-top: 80px; background: white; border-radius: 25px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
      <div style="background: linear-gradient(135deg, #065f46, #047857); color: white; padding: 30px; text-align: center;">
        <h3 style="margin: 0; font-size: 2rem; font-weight: 800;">⚡ مقارنة سريعة</h3>
        <p style="margin: 10px 0 0; opacity: 0.9;">شاهد الفرق بنفسك!</p>
      </div>
      
      <div class="comparison-table" style="display: grid; grid-template-columns: 1fr 1fr 1fr; text-align: center;">
        <!-- Header -->
        <div style="padding: 20px; background: #f8fafc; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e2e8f0;">المميزة</div>
        <div style="padding: 20px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); font-weight: 700; color: #065f46; border-bottom: 2px solid #10b981;">🏆 Sokappe</div>
        <div style="padding: 20px; background: #fee2e2; font-weight: 700; color: #dc2626; border-bottom: 2px solid #ef4444;">😔 المنافسون</div>
        
        <!-- Commission -->
        <div style="padding: 20px; background: #f8fafc; color: #64748b; border-bottom: 1px solid #e2e8f0;">العمولة</div>
        <div style="padding: 20px; background: #ecfdf5; color: #065f46; font-weight: 700; font-size: 1.2rem; border-bottom: 1px solid #d1fae5;">5% فقط ✅</div>
        <div style="padding: 20px; background: #fef2f2; color: #dc2626; font-weight: 700; font-size: 1.2rem; border-bottom: 1px solid #fecaca;">15-20% ❌</div>
        
        <!-- Free Projects -->
        <div style="padding: 20px; background: #f8fafc; color: #64748b; border-bottom: 1px solid #e2e8f0;">مشاريع مجانية</div>
        <div style="padding: 20px; background: #ecfdf5; color: #065f46; font-weight: 700; border-bottom: 1px solid #d1fae5;">أول 3 مشاريع ✅</div>
        <div style="padding: 20px; background: #fef2f2; color: #dc2626; font-weight: 700; border-bottom: 1px solid #fecaca;">لا يوجد ❌</div>
        
        <!-- Hidden Fees -->
        <div style="padding: 20px; background: #f8fafc; color: #64748b; border-bottom: 1px solid #e2e8f0;">رسوم مخفية</div>
        <div style="padding: 20px; background: #ecfdf5; color: #065f46; font-weight: 700; border-bottom: 1px solid #d1fae5;">لا توجد ✅</div>
        <div style="padding: 20px; background: #fef2f2; color: #dc2626; font-weight: 700; border-bottom: 1px solid #fecaca;">موجودة ❌</div>
        
        <!-- Support -->
        <div style="padding: 20px; background: #f8fafc; color: #64748b; border-bottom: 1px solid #e2e8f0;">الدعم الفني</div>
        <div style="padding: 20px; background: #ecfdf5; color: #065f46; font-weight: 700; border-bottom: 1px solid #d1fae5;">24/7 عربي ✅</div>
        <div style="padding: 20px; background: #fef2f2; color: #dc2626; font-weight: 700; border-bottom: 1px solid #fecaca;">محدود ❌</div>
        
        <!-- Quality -->
        <div style="padding: 20px; background: #f8fafc; color: #64748b;">ضمان الجودة</div>
        <div style="padding: 20px; background: #ecfdf5; color: #065f46; font-weight: 700;">30 يوم ✅</div>
        <div style="padding: 20px; background: #fef2f2; color: #dc2626; font-weight: 700;">محدود ❌</div>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us Section -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; position: relative; overflow: hidden;">
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"stars\" width=\"50\" height=\"50\" patternUnits=\"userSpaceOnUse\"><circle cx=\"25\" cy=\"25\" r=\"2\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23stars)\"/></svg>') repeat;"></div>
  
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
    <div class="section-title" style="text-align: center; margin-bottom: 80px;">
      <h2 style="font-size: 3.5rem; font-weight: 900; color: white; margin-bottom: 20px;">🌟 لماذا نحن الأفضل؟</h2>
      <p style="font-size: 1.3rem; color: rgba(255,255,255,0.8);">مميزات حصرية تجعلنا الخيار الأول للعملاء والمحترفين</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
      <!-- Feature 1 -->
      <div style="background: rgba(255,255,255,0.1); padding: 40px 30px; border-radius: 25px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div style="font-size: 4rem; margin-bottom: 25px;">⚡</div>
        <h3 style="color: #fbbf24; font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">تسليم فوري</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.7; font-size: 1.1rem;">خدمات سريعة تبدأ من 24 ساعة مع ضمان الجودة والاحترافية في كل مشروع</p>
        <div style="margin-top: 20px; padding: 15px; background: rgba(251, 191, 36, 0.2); border-radius: 10px;">
          <span style="color: #fbbf24; font-weight: 700;">⏰ متوسط التسليم: 3 أيام</span>
        </div>
      </div>
      
      <!-- Feature 2 -->
      <div style="background: rgba(255,255,255,0.1); padding: 40px 30px; border-radius: 25px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div style="font-size: 4rem; margin-bottom: 25px;">🛡️</div>
        <h3 style="color: #10b981; font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">ضمان شامل</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.7; font-size: 1.1rem;">ضمان استرداد كامل للأموال + تعديلات مجانية + حماية قانونية للطرفين</p>
        <div style="margin-top: 20px; padding: 15px; background: rgba(16, 185, 129, 0.2); border-radius: 10px;">
          <span style="color: #10b981; font-weight: 700;">✅ ضمان 30 يوم</span>
        </div>
      </div>
      
      <!-- Feature 3 -->
      <div style="background: rgba(255,255,255,0.1); padding: 40px 30px; border-radius: 25px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div style="font-size: 4rem; margin-bottom: 25px;">🎯</div>
        <h3 style="color: #3b82f6; font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">دقة في الاختيار</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.7; font-size: 1.1rem;">خوارزمية ذكية لمطابقة المشاريع مع أنسب المحترفين حسب الخبرة والتخصص</p>
        <div style="margin-top: 20px; padding: 15px; background: rgba(59, 130, 246, 0.2); border-radius: 10px;">
          <span style="color: #3b82f6; font-weight: 700;">🎯 دقة 95%</span>
        </div>
      </div>
      
      <!-- Feature 4 -->
      <div style="background: rgba(255,255,255,0.1); padding: 40px 30px; border-radius: 25px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div style="font-size: 4rem; margin-bottom: 25px;">💎</div>
        <h3 style="color: #8b5cf6; font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">جودة مضمونة</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.7; font-size: 1.1rem;">فحص دقيق لكل محترف + اختبارات مهارات + تقييمات حقيقية من العملاء</p>
        <div style="margin-top: 20px; padding: 15px; background: rgba(139, 92, 246, 0.2); border-radius: 10px;">
          <span style="color: #8b5cf6; font-weight: 700;">⭐ تقييم 4.9/5</span>
        </div>
      </div>
      
      <!-- Feature 5 -->
      <div style="background: rgba(255,255,255,0.1); padding: 40px 30px; border-radius: 25px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div style="font-size: 4rem; margin-bottom: 25px;">🤝</div>
        <h3 style="color: #ef4444; font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">دعم مستمر</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.7; font-size: 1.1rem;">فريق دعم عربي متخصص متاح 24/7 لحل أي مشكلة أو استفسار فوراً</p>
        <div style="margin-top: 20px; padding: 15px; background: rgba(239, 68, 68, 0.2); border-radius: 10px;">
          <span style="color: #ef4444; font-weight: 700;">📞 رد خلال 5 دقائق</span>
        </div>
      </div>
      
      <!-- Feature 6 -->
      <div style="background: rgba(255,255,255,0.1); padding: 40px 30px; border-radius: 25px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div style="font-size: 4rem; margin-bottom: 25px;">🚀</div>
        <h3 style="color: #06b6d4; font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">تقنية متطورة</h3>
        <p style="color: rgba(255,255,255,0.9); line-height: 1.7; font-size: 1.1rem;">منصة حديثة بأحدث التقنيات لتجربة سلسة وآمنة مع واجهة سهلة الاستخدام</p>
        <div style="margin-top: 20px; padding: 15px; background: rgba(6, 182, 212, 0.2); border-radius: 10px;">
          <span style="color: #06b6d4; font-weight: 700;">🔧 تحديثات أسبوعية</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Success Stories Section -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); position: relative;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3.5rem; font-weight: 900; color: #92400e; margin-bottom: 20px;">🏆 قصص نجاح حقيقية</h2>
      <p style="font-size: 1.3rem; color: #b45309;">عملاء حققوا أهدافهم وتوفيرات مذهلة معنا</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
      <!-- Success Story 1 -->
      <div style="background: white; padding: 40px 30px; border-radius: 20px; box-shadow: 0 15px 40px rgba(146, 64, 14, 0.1); border-left: 5px solid #f59e0b; position: relative;">
        <div style="position: absolute; top: -10px; right: 20px; background: #10b981; color: white; padding: 5px 15px; border-radius: 15px; font-size: 0.8rem; font-weight: 700;">وفر 80%</div>
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=80&q=80" style="width: 60px; height: 60px; border-radius: 50%; border: 3px solid #f59e0b;" alt="Client">
          <div>
            <h4 style="color: #92400e; margin: 0; font-size: 1.2rem;">أحمد الشريف</h4>
            <p style="color: #b45309; margin: 0; font-size: 0.9rem;">مدير شركة تقنية</p>
          </div>
        </div>
        <p style="color: #374151; line-height: 1.7; font-style: italic; margin-bottom: 20px;">
          "كنت أدفع 20% عمولة في المنصات الأخرى، مع Sokappe وفرت آلاف الدولارات! الجودة ممتازة والأسعار معقولة جداً."
        </p>
        <div style="background: #fef3c7; padding: 15px; border-radius: 10px; text-align: center;">
          <span style="color: #92400e; font-weight: 700;">💰 وفر 8,000$ في 6 أشهر</span>
        </div>
      </div>
      
      <!-- Success Story 2 -->
      <div style="background: white; padding: 40px 30px; border-radius: 20px; box-shadow: 0 15px 40px rgba(146, 64, 14, 0.1); border-left: 5px solid #10b981; position: relative;">
        <div style="position: absolute; top: -10px; right: 20px; background: #3b82f6; color: white; padding: 5px 15px; border-radius: 15px; font-size: 0.8rem; font-weight: 700;">نمو 300%</div>
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
          <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=80&q=80" style="width: 60px; height: 60px; border-radius: 50%; border: 3px solid #10b981;" alt="Client">
          <div>
            <h4 style="color: #92400e; margin: 0; font-size: 1.2rem;">سارة محمد</h4>
            <p style="color: #b45309; margin: 0; font-size: 0.9rem;">رائدة أعمال</p>
          </div>
        </div>
        <p style="color: #374151; line-height: 1.7; font-style: italic; margin-bottom: 20px;">
          "بدأت بمشروع صغير وبفضل المحترفين هنا نمت شركتي 300%! العمولة المنخفضة ساعدتني أستثمر أكثر في التطوير."
        </p>
        <div style="background: #ecfdf5; padding: 15px; border-radius: 10px; text-align: center;">
          <span style="color: #065f46; font-weight: 700;">📈 نمو من 10K إلى 40K شهرياً</span>
        </div>
      </div>
      
      <!-- Success Story 3 -->
      <div style="background: white; padding: 40px 30px; border-radius: 20px; box-shadow: 0 15px 40px rgba(146, 64, 14, 0.1); border-left: 5px solid #8b5cf6; position: relative;">
        <div style="position: absolute; top: -10px; right: 20px; background: #ef4444; color: white; padding: 5px 15px; border-radius: 15px; font-size: 0.8rem; font-weight: 700;">توفير مذهل</div>
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=80&q=80" style="width: 60px; height: 60px; border-radius: 50%; border: 3px solid #8b5cf6;" alt="Client">
          <div>
            <h4 style="color: #92400e; margin: 0; font-size: 1.2rem;">خالد العتيبي</h4>
            <p style="color: #b45309; margin: 0; font-size: 0.9rem;">مؤسس ستارت أب</p>
          </div>
        </div>
        <p style="color: #374151; line-height: 1.7; font-style: italic; margin-bottom: 20px;">
          "المنصة غيرت مفهومي عن العمل الحر! جودة عالية، أسعار منافسة، وعمولة قليلة. أنصح كل رائد أعمال بتجربتها."
        </p>
        <div style="background: #f3e8ff; padding: 15px; border-radius: 10px; text-align: center;">
          <span style="color: #6b21a8; font-weight: 700;">⭐ 50+ مشروع ناجح</span>
        </div>
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

<!-- Statistics & Analytics Section -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; position: relative; overflow: hidden;">
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"dots\" width=\"20\" height=\"20\" patternUnits=\"userSpaceOnUse\"><circle cx=\"10\" cy=\"10\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23dots)\"/></svg>') repeat;"></div>
  
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: white; margin-bottom: 20px;">📊 إحصائيات مذهلة</h2>
      <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8);">أرقام حقيقية تعكس نجاح منصتنا</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
      <div class="stat-card" style="text-align: center; padding: 40px 20px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div class="animated-counter" data-target="25000" style="font-size: 4rem; font-weight: 900; color: #fbbf24; margin-bottom: 15px;">0</div>
        <h4 style="color: white; margin: 10px 0; font-size: 1.3rem;">مشروع مكتمل</h4>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">بنجاح وجودة عالية</p>
      </div>
      
      <div class="stat-card" style="text-align: center; padding: 40px 20px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div class="animated-counter" data-target="12000" style="font-size: 4rem; font-weight: 900; color: #10b981; margin-bottom: 15px;">0</div>
        <h4 style="color: white; margin: 10px 0; font-size: 1.3rem;">محترف نشط</h4>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">من جميع أنحاء العالم العربي</p>
      </div>
      
      <div class="stat-card" style="text-align: center; padding: 40px 20px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div class="animated-counter" data-target="98" style="font-size: 4rem; font-weight: 900; color: #3b82f6; margin-bottom: 15px;">0</div>
        <h4 style="color: white; margin: 10px 0; font-size: 1.3rem;">معدل الرضا %</h4>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">من العملاء راضون تماماً</p>
      </div>
      
      <div class="stat-card" style="text-align: center; padding: 40px 20px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255,255,255,0.1)'">
        <div class="animated-counter" data-target="150" style="font-size: 4rem; font-weight: 900; color: #8b5cf6; margin-bottom: 15px;">0</div>
        <h4 style="color: white; margin: 10px 0; font-size: 1.3rem;">تخصص متاح</h4>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">في مختلف المجالات</p>
      </div>
    </div>
  </div>
</section>

<!-- Interactive Skills Showcase -->
<section style="padding: 100px 0; background: white; position: relative;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: #1f2937; margin-bottom: 20px;">🎨 مهارات متنوعة</h2>
      <p style="font-size: 1.2rem; color: #64748b;">اكتشف المهارات المطلوبة واختر ما يناسب مشروعك</p>
    </div>
    
    <div class="skills-container" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 50px;">
      <div class="skill-tag" style="padding: 12px 25px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);" onclick="showSkillInfo('web')" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.3)'">💻 تطوير الويب</div>
      
      <div class="skill-tag" style="padding: 12px 25px; background: linear-gradient(45deg, #10b981, #059669); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);" onclick="showSkillInfo('design')" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.3)'">🎨 التصميم الجرافيكي</div>
      
      <div class="skill-tag" style="padding: 12px 25px; background: linear-gradient(45deg, #f59e0b, #d97706); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);" onclick="showSkillInfo('marketing')" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(245, 158, 11, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(245, 158, 11, 0.3)'">📈 التسويق الرقمي</div>
      
      <div class="skill-tag" style="padding: 12px 25px; background: linear-gradient(45deg, #8b5cf6, #7c3aed); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);" onclick="showSkillInfo('writing')" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(139, 92, 246, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.3)'">✍️ كتابة المحتوى</div>
      
      <div class="skill-tag" style="padding: 12px 25px; background: linear-gradient(45deg, #ef4444, #dc2626); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);" onclick="showSkillInfo('mobile')" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(239, 68, 68, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3)'">📱 تطبيقات الجوال</div>
    </div>
    
    <div id="skill-info" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); padding: 40px; border-radius: 20px; text-align: center; min-height: 200px; display: flex; align-items: center; justify-content: center; transition: all 0.5s ease;">
      <p style="color: #64748b; font-size: 1.1rem;">اضغط على أي مهارة لمعرفة المزيد عنها</p>
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

<!-- Live Projects Feed -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); position: relative;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: #1f2937; margin-bottom: 20px;">🔥 مشاريع حية</h2>
      <p style="font-size: 1.2rem; color: #64748b;">شاهد المشاريع الجديدة التي يتم نشرها الآن</p>
    </div>
    
    <div class="live-projects" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
      <div class="project-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
        <div style="position: absolute; top: 0; right: 0; background: linear-gradient(45deg, #10b981, #059669); color: white; padding: 5px 15px; border-radius: 0 15px 0 15px; font-size: 0.8rem; font-weight: 600;">🔥 جديد</div>
        <h4 style="color: #1f2937; margin: 0 0 15px; font-size: 1.3rem;">تطوير متجر إلكتروني</h4>
        <p style="color: #64748b; margin: 0 0 20px; line-height: 1.6;">مطلوب تطوير متجر إلكتروني متكامل بنظام دفع آمن وإدارة المخزون</p>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <span style="color: #10b981; font-weight: 700; font-size: 1.1rem;">$2,500</span>
          <span style="color: #64748b; font-size: 0.9rem;">⏰ منذ 5 دقائق</span>
        </div>
      </div>
      
      <div class="project-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
        <div style="position: absolute; top: 0; right: 0; background: linear-gradient(45deg, #f59e0b, #d97706); color: white; padding: 5px 15px; border-radius: 0 15px 0 15px; font-size: 0.8rem; font-weight: 600;">⚡ عاجل</div>
        <h4 style="color: #1f2937; margin: 0 0 15px; font-size: 1.3rem;">تصميم هوية بصرية</h4>
        <p style="color: #64748b; margin: 0 0 20px; line-height: 1.6;">تصميم شعار وهوية بصرية كاملة لشركة ناشئة في مجال التكنولوجيا</p>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <span style="color: #10b981; font-weight: 700; font-size: 1.1rem;">$800</span>
          <span style="color: #64748b; font-size: 0.9rem;">⏰ منذ 12 دقيقة</span>
        </div>
      </div>
      
      <div class="project-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
        <h4 style="color: #1f2937; margin: 0 0 15px; font-size: 1.3rem;">كتابة محتوى تسويقي</h4>
        <p style="color: #64748b; margin: 0 0 20px; line-height: 1.6;">كتابة محتوى تسويقي لمواقع التواصل الاجتماعي وحملات إعلانية</p>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <span style="color: #10b981; font-weight: 700; font-size: 1.1rem;">$400</span>
          <span style="color: #64748b; font-size: 0.9rem;">⏰ منذ 18 دقيقة</span>
        </div>
      </div>
    </div>
    
    <div style="text-align: center; margin-top: 50px;">
      <a href="{{ route('projects.index') }}" style="display: inline-block; padding: 15px 40px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); color: white; text-decoration: none; border-radius: 25px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 35px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.3)'">
        🔍 استكشف جميع المشاريع
      </a>
    </div>
  </div>
</section>

<!-- Success Stories Timeline -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"stars\" width=\"50\" height=\"50\" patternUnits=\"userSpaceOnUse\"><circle cx=\"25\" cy=\"25\" r=\"2\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23stars)\"/></svg>') repeat;"></div>
  
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: white; margin-bottom: 20px;">🏆 قصص نجاح</h2>
      <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8);">رحلة نجاح حقيقية من بداية المشروع حتى التسليم</p>
    </div>
    
    <div class="timeline" style="position: relative; max-width: 800px; margin: 0 auto;">
      <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 4px; background: rgba(255,255,255,0.3); transform: translateX(-50%);"></div>
      
      <div class="timeline-item" style="display: flex; align-items: center; margin-bottom: 50px; position: relative;">
        <div style="flex: 1; text-align: right; padding-right: 30px;">
          <div style="background: rgba(255,255,255,0.1); padding: 25px; border-radius: 15px; backdrop-filter: blur(10px);">
            <h4 style="color: white; margin: 0 0 10px;">📝 نشر المشروع</h4>
            <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">أحمد ينشر مشروع تطوير تطبيق جوال</p>
          </div>
        </div>
        <div style="width: 20px; height: 20px; background: #fbbf24; border-radius: 50%; position: absolute; left: 50%; transform: translateX(-50%); z-index: 3;"></div>
        <div style="flex: 1; padding-left: 30px;"></div>
      </div>
      
      <div class="timeline-item" style="display: flex; align-items: center; margin-bottom: 50px; position: relative;">
        <div style="flex: 1; padding-right: 30px;"></div>
        <div style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; position: absolute; left: 50%; transform: translateX(-50%); z-index: 3;"></div>
        <div style="flex: 1; text-align: left; padding-left: 30px;">
          <div style="background: rgba(255,255,255,0.1); padding: 25px; border-radius: 15px; backdrop-filter: blur(10px);">
            <h4 style="color: white; margin: 0 0 10px;">🤝 اختيار المحترف</h4>
            <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">تم اختيار سارة المطورة المتخصصة</p>
          </div>
        </div>
      </div>
      
      <div class="timeline-item" style="display: flex; align-items: center; margin-bottom: 50px; position: relative;">
        <div style="flex: 1; text-align: right; padding-right: 30px;">
          <div style="background: rgba(255,255,255,0.1); padding: 25px; border-radius: 15px; backdrop-filter: blur(10px);">
            <h4 style="color: white; margin: 0 0 10px;">⚡ بدء العمل</h4>
            <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">سارة تبدأ تطوير التطبيق بأحدث التقنيات</p>
          </div>
        </div>
        <div style="width: 20px; height: 20px; background: #3b82f6; border-radius: 50%; position: absolute; left: 50%; transform: translateX(-50%); z-index: 3;"></div>
        <div style="flex: 1; padding-left: 30px;"></div>
      </div>
      
      <div class="timeline-item" style="display: flex; align-items: center; position: relative;">
        <div style="flex: 1; padding-right: 30px;"></div>
        <div style="width: 20px; height: 20px; background: #8b5cf6; border-radius: 50%; position: absolute; left: 50%; transform: translateX(-50%); z-index: 3;"></div>
        <div style="flex: 1; text-align: left; padding-left: 30px;">
          <div style="background: rgba(255,255,255,0.1); padding: 25px; border-radius: 15px; backdrop-filter: blur(10px);">
            <h4 style="color: white; margin: 0 0 10px;">🎉 التسليم والنجاح</h4>
            <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">تسليم التطبيق بجودة عالية وتقييم 5 نجوم</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Video Showcase Section -->
<section style="padding: 100px 0; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; position: relative; overflow: hidden;">
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"video-bg\" width=\"30\" height=\"30\" patternUnits=\"userSpaceOnUse\"><circle cx=\"15\" cy=\"15\" r=\"1.5\" fill=\"%23ffffff\" opacity=\"0.05\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23video-bg)\"/></svg>') repeat;"></div>
  
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: white; margin-bottom: 20px;">🎬 شاهد كيف نعمل</h2>
      <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8);">فيديوهات توضيحية تشرح كيفية استخدام المنصة وقصص نجاح حقيقية</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
      <!-- Main Feature Video -->
      <div class="video-card" style="background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
        <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="playVideo('main-video')">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='scale(1)'">
              <div style="width: 0; height: 0; border-left: 25px solid white; border-top: 15px solid transparent; border-bottom: 15px solid transparent; margin-left: 5px;"></div>
            </div>
          </div>
          <iframe id="main-video" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none;" src="" frameborder="0" allowfullscreen></iframe>
        </div>
        <div style="padding: 25px;">
          <h4 style="color: white; margin: 0 0 15px; font-size: 1.3rem;">🚀 كيف تبدأ مشروعك الأول</h4>
          <p style="color: rgba(255,255,255,0.8); margin: 0; line-height: 1.6; font-size: 0.95rem;">شرح مفصل لكيفية نشر مشروعك واختيار المحترف المناسب في 5 دقائق فقط</p>
          <div style="margin-top: 15px; display: flex; align-items: center; gap: 15px; font-size: 0.9rem; color: rgba(255,255,255,0.7);">
            <span>⏱️ 5:30 دقيقة</span>
            <span>👁️ 12.5K مشاهدة</span>
          </div>
        </div>
      </div>
      
      <!-- Success Story Video -->
      <div class="video-card" style="background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
        <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="playVideo('success-video')">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='scale(1)'">
              <div style="width: 0; height: 0; border-left: 25px solid white; border-top: 15px solid transparent; border-bottom: 15px solid transparent; margin-left: 5px;"></div>
            </div>
          </div>
          <iframe id="success-video" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none;" src="" frameborder="0" allowfullscreen></iframe>
        </div>
        <div style="padding: 25px;">
          <h4 style="color: white; margin: 0 0 15px; font-size: 1.3rem;">🏆 قصة نجاح أحمد</h4>
          <p style="color: rgba(255,255,255,0.8); margin: 0; line-height: 1.6; font-size: 0.95rem;">كيف حقق أحمد نجاحاً باهراً في مشروعه وحصل على تطبيق احترافي بأقل التكاليف</p>
          <div style="margin-top: 15px; display: flex; align-items: center; gap: 15px; font-size: 0.9rem; color: rgba(255,255,255,0.7);">
            <span>⏱️ 3:45 دقيقة</span>
            <span>👁️ 8.2K مشاهدة</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Video Playlist -->
    <div style="margin-top: 60px; text-align: center;">
      <h3 style="color: white; margin: 0 0 30px; font-size: 1.8rem;">📚 المزيد من الفيديوهات</h3>
      <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
        <button class="playlist-btn" onclick="playVideo('tutorial-1')" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; font-size: 0.9rem;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
          🎯 نصائح للعملاء
        </button>
        <button class="playlist-btn" onclick="playVideo('tutorial-2')" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; font-size: 0.9rem;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
          💼 دليل المحترفين
        </button>
        <button class="playlist-btn" onclick="playVideo('tutorial-3')" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; font-size: 0.9rem;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
          🔒 الأمان والحماية
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Interactive Demo Section -->
<section style="padding: 100px 0; background: white; position: relative;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: #1f2937; margin-bottom: 20px;">🎮 جرب المنصة الآن</h2>
      <p style="font-size: 1.2rem; color: #64748b;">تجربة تفاعلية مباشرة لاستكشاف مميزات المنصة</p>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;" class="demo-grid">
      <!-- Interactive Demo -->
      <div class="demo-container" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border-radius: 20px; padding: 40px; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(45deg, #3b82f6, #8b5cf6); border-radius: 50%; opacity: 0.1;"></div>
        
        <div class="demo-screen" id="demo-screen" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); min-height: 300px; position: relative;">
          <div class="demo-content" id="demo-content">
            <div style="text-align: center; padding: 40px 20px;">
              <div style="font-size: 4rem; margin-bottom: 20px;">🚀</div>
              <h4 style="color: #1f2937; margin: 0 0 15px;">مرحباً بك في Sokappe</h4>
              <p style="color: #64748b; margin: 0;">اختر أحد الخيارات لتجربة المنصة</p>
            </div>
          </div>
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
          <button onclick="showDemo('client')" style="padding: 12px 25px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); color: white; border: none; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; font-weight: 600;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            👤 كعميل
          </button>
          <button onclick="showDemo('freelancer')" style="padding: 12px 25px; background: linear-gradient(45deg, #10b981, #059669); color: white; border: none; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; font-weight: 600;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            💼 كمحترف
          </button>
        </div>
      </div>
      
      <!-- Video Tutorial -->
      <div class="tutorial-video" style="position: relative;">
        <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="playVideo('demo-video')">
            <div style="text-align: center; color: white;">
              <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='scale(1)'">
                <div style="width: 0; height: 0; border-left: 35px solid white; border-top: 20px solid transparent; border-bottom: 20px solid transparent; margin-left: 8px;"></div>
              </div>
              <h4 style="margin: 0 0 10px; font-size: 1.5rem;">🎥 شاهد العرض التوضيحي</h4>
              <p style="margin: 0; opacity: 0.9; font-size: 1rem;">تعلم كيفية استخدام المنصة في 3 دقائق</p>
            </div>
          </div>
          <iframe id="demo-video" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none;" src="" frameborder="0" allowfullscreen></iframe>
        </div>
        
        <!-- Video Stats -->
        <div style="margin-top: 25px; display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
          <div style="text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">25K+</div>
            <div style="color: #64748b; font-size: 0.9rem;">مشاهدة</div>
          </div>
          <div style="text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 700; color: #10b981;">4.9/5</div>
            <div style="color: #64748b; font-size: 0.9rem;">تقييم</div>
          </div>
          <div style="text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">3:15</div>
            <div style="color: #64748b; font-size: 0.9rem;">مدة الفيديو</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Interactive FAQ Section -->
<section style="padding: 100px 0; background: white; position: relative;">
  <div class="container-full" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title" style="text-align: center; margin-bottom: 60px;">
      <h2 style="font-size: 3rem; font-weight: 800; color: #1f2937; margin-bottom: 20px;">❓ أسئلة شائعة</h2>
      <p style="font-size: 1.2rem; color: #64748b;">إجابات على أكثر الأسئلة تكراراً</p>
    </div>
    
    <div class="faq-container">
      <div class="faq-item" style="margin-bottom: 20px; border: 1px solid #e2e8f0; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
        <div class="faq-question" onclick="toggleFAQ(this)" style="padding: 25px; background: linear-gradient(135deg, #f8fafc, #e2e8f0); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
          <h4 style="margin: 0; color: #1f2937; font-size: 1.1rem;">كيف يمكنني ضمان جودة العمل؟</h4>
          <span class="faq-icon" style="font-size: 1.5rem; color: #3b82f6; transition: transform 0.3s ease;">+</span>
        </div>
        <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
          <div style="padding: 25px; background: white;">
            <p style="margin: 0; color: #64748b; line-height: 1.6;">نوفر نظام تقييمات شامل، ومراجعة أعمال المحترفين السابقة، وضمان استرداد الأموال في حالة عدم الرضا عن الجودة.</p>
          </div>
        </div>
      </div>
      
      <div class="faq-item" style="margin-bottom: 20px; border: 1px solid #e2e8f0; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
        <div class="faq-question" onclick="toggleFAQ(this)" style="padding: 25px; background: linear-gradient(135deg, #f8fafc, #e2e8f0); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
          <h4 style="margin: 0; color: #1f2937; font-size: 1.1rem;">ما هي طرق الدفع المتاحة؟</h4>
          <span class="faq-icon" style="font-size: 1.5rem; color: #3b82f6; transition: transform 0.3s ease;">+</span>
        </div>
        <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
          <div style="padding: 25px; background: white;">
            <p style="margin: 0; color: #64748b; line-height: 1.6;">نقبل جميع البطاقات الائتمانية، PayPal، التحويل البنكي، والمحافظ الرقمية مع حماية كاملة للمعاملات.</p>
          </div>
        </div>
      </div>
      
      <div class="faq-item" style="margin-bottom: 20px; border: 1px solid #e2e8f0; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
        <div class="faq-question" onclick="toggleFAQ(this)" style="padding: 25px; background: linear-gradient(135deg, #f8fafc, #e2e8f0); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
          <h4 style="margin: 0; color: #1f2937; font-size: 1.1rem;">كم يستغرق تنفيذ المشروع؟</h4>
          <span class="faq-icon" style="font-size: 1.5rem; color: #3b82f6; transition: transform 0.3s ease;">+</span>
        </div>
        <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
          <div style="padding: 25px; background: white;">
            <p style="margin: 0; color: #64748b; line-height: 1.6;">يختلف حسب نوع وحجم المشروع. المشاريع البسيطة تستغرق 1-3 أيام، والمعقدة قد تحتاج أسابيع. يتم تحديد المدة مسبقاً.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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

// Add smooth scrolling for all anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Add loading animation for buttons
document.querySelectorAll('.btn').forEach(btn => {
  btn.addEventListener('click', function() {
    if (!this.classList.contains('loading')) {
      this.classList.add('loading');
      const originalText = this.textContent;
      this.innerHTML = '⏳ جاري التحميل...';
      
      setTimeout(() => {
        this.innerHTML = originalText;
        this.classList.remove('loading');
      }, 1500);
    }
  });
});

// Add parallax effect to hero background
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset;
  const hero = document.querySelector('.hero');
  if (hero) {
    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
  }
});

// Add typing effect to hero title
function typeWriter(element, text, speed = 100) {
  let i = 0;
  element.innerHTML = '';
  
  function type() {
    if (i < text.length) {
      element.innerHTML += text.charAt(i);
      i++;
      setTimeout(type, speed);
    }
  }
  
  type();
}

// Initialize typing effect when page loads
window.addEventListener('load', function() {
  const heroTitle = document.querySelector('.hero h2');
  if (heroTitle) {
    const originalText = heroTitle.textContent;
    setTimeout(() => {
      typeWriter(heroTitle, originalText, 50);
    }, 1000);
  }
});

// Add floating animation to trust numbers
document.querySelectorAll('.trust-number').forEach((num, index) => {
  setInterval(() => {
    num.style.transform = `translateY(${Math.sin(Date.now() / 1000 + index) * 5}px)`;
  }, 50);
});

// Add counter animation for statistics
function animateCounter(element, target, duration = 2000) {
  const start = parseInt(element.textContent) || 0;
  const increment = (target - start) / (duration / 16);
  let current = start;
  
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      element.textContent = target + (element.textContent.includes('K') ? 'K+' : element.textContent.includes('%') ? '%' : '');
      clearInterval(timer);
    } else {
      element.textContent = Math.floor(current) + (element.textContent.includes('K') ? 'K+' : element.textContent.includes('%') ? '%' : '');
    }
  }, 16);
}

// Animate counters when they come into view
const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
      entry.target.classList.add('animated');
      const text = entry.target.textContent;
      const number = parseInt(text.replace(/[^0-9]/g, ''));
      animateCounter(entry.target, number);
    }
  });
});

document.querySelectorAll('.trust-number').forEach(el => {
  counterObserver.observe(el);
});

// Add sparkle effect on hover for feature cards
document.querySelectorAll('.feature-card').forEach(card => {
  card.addEventListener('mouseenter', function() {
    createSparkles(this);
  });
});

function createSparkles(element) {
  for (let i = 0; i < 5; i++) {
    const sparkle = document.createElement('div');
    sparkle.innerHTML = '✨';
    sparkle.style.position = 'absolute';
    sparkle.style.pointerEvents = 'none';
    sparkle.style.fontSize = '12px';
    sparkle.style.left = Math.random() * 100 + '%';
    sparkle.style.top = Math.random() * 100 + '%';
    sparkle.style.animation = 'sparkle 1s ease-out forwards';
    
    element.style.position = 'relative';
    element.appendChild(sparkle);
    
    setTimeout(() => {
      sparkle.remove();
    }, 1000);
  }
}

// Add sparkle animation CSS
const sparkleCSS = `
@keyframes sparkle {
  0% { opacity: 0; transform: scale(0) rotate(0deg); }
  50% { opacity: 1; transform: scale(1) rotate(180deg); }
  100% { opacity: 0; transform: scale(0) rotate(360deg); }
}
`;

const style = document.createElement('style');
style.textContent = sparkleCSS;
document.head.appendChild(style);

// Add success message animation
function showSuccessMessage(message) {
  const successDiv = document.createElement('div');
  successDiv.innerHTML = `
    <div style="
      position: fixed;
      top: 20px;
      right: 20px;
      background: linear-gradient(45deg, #10b981, #059669);
      color: white;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
      z-index: 10000;
      animation: slideInRight 0.5s ease-out;
    ">
      ✅ ${message}
    </div>
  `;
  
  document.body.appendChild(successDiv);
  
  setTimeout(() => {
    successDiv.style.animation = 'slideOutRight 0.5s ease-out';
    setTimeout(() => {
      successDiv.remove();
    }, 500);
  }, 3000);
}

// Add slide animations for success messages
const slideCSS = `
@keyframes slideInRight {
  from { opacity: 0; transform: translateX(100px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes slideOutRight {
  from { opacity: 1; transform: translateX(0); }
  to { opacity: 0; transform: translateX(100px); }
}
`;

const slideStyle = document.createElement('style');
slideStyle.textContent = slideCSS;
document.head.appendChild(slideStyle);

console.log('🎉 Sokappe Home Page Loaded Successfully! 🚀');
</script>

<!-- New Sections -->

<!-- Stats Section -->
<section style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 80px 0;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>📊 أرقام تتحدث عن نفسها</h2>
      <p>إحصائيات حقيقية تعكس نجاح منصة Sokappe</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 50px;">
      <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; animation: fadeInUp 0.8s ease-out;">
        <div style="font-size: 4rem; margin-bottom: 10px;">💼</div>
        <div class="trust-number" style="font-size: 2.5rem; font-weight: 900; color: #3b82f6; margin-bottom: 10px;">25000</div>
        <h4 style="color: #1f2937; margin: 0;">مشروع مكتمل</h4>
      </div>
      
      <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; animation: fadeInUp 0.8s ease-out 0.1s both;">
        <div style="font-size: 4rem; margin-bottom: 10px;">⭐</div>
        <div class="trust-number" style="font-size: 2.5rem; font-weight: 900; color: #10b981; margin-bottom: 10px;">12000</div>
        <h4 style="color: #1f2937; margin: 0;">محترف نشط</h4>
      </div>
      
      <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; animation: fadeInUp 0.8s ease-out 0.2s both;">
        <div style="font-size: 4rem; margin-bottom: 10px;">🎯</div>
        <div class="trust-number" style="font-size: 2.5rem; font-weight: 900; color: #f59e0b; margin-bottom: 10px;">98</div>
        <h4 style="color: #1f2937; margin: 0;">معدل الرضا</h4>
      </div>
      
      <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; animation: fadeInUp 0.8s ease-out 0.3s both;">
        <div style="font-size: 4rem; margin-bottom: 10px;">🚀</div>
        <div class="trust-number" style="font-size: 2.5rem; font-weight: 900; color: #8b5cf6; margin-bottom: 10px;">48</div>
        <h4 style="color: #1f2937; margin: 0;">ساعة متوسط التسليم</h4>
      </div>
    </div>
  </div>
</section>

<!-- Categories Section -->
<section style="background: white; padding: 100px 0;">
  <div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="section-title">
      <h2>🎨 تخصصات متنوعة</h2>
      <p>اكتشف مجالات العمل المختلفة المتاحة على منصة Sokappe</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-top: 60px;">
      <div style="background: linear-gradient(135deg, #fef3c7, #fbbf24); padding: 30px; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer; animation: fadeInUp 0.8s ease-out;">
        <div style="font-size: 3rem; margin-bottom: 15px;">💻</div>
        <h4 style="color: #92400e; margin-bottom: 10px;">البرمجة والتطوير</h4>
        <p style="color: #a16207; font-size: 0.9rem;">تطبيقات الويب، الجوال، وأنظمة إدارة المحتوى</p>
      </div>
      
      <div style="background: linear-gradient(135deg, #dbeafe, #3b82f6); padding: 30px; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer; animation: fadeInUp 0.8s ease-out 0.1s both;">
        <div style="font-size: 3rem; margin-bottom: 15px;">🎨</div>
        <h4 style="color: white; margin-bottom: 10px;">التصميم والإبداع</h4>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">شعارات، هوية بصرية، وتصميم واجهات المستخدم</p>
      </div>
      
      <div style="background: linear-gradient(135deg, #d1fae5, #10b981); padding: 30px; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer; animation: fadeInUp 0.8s ease-out 0.2s both;">
        <div style="font-size: 3rem; margin-bottom: 15px;">📝</div>
        <h4 style="color: white; margin-bottom: 10px;">الكتابة والترجمة</h4>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">محتوى إبداعي، ترجمة احترافية، وكتابة تقنية</p>
      </div>
      
      <div style="background: linear-gradient(135deg, #fce7f3, #ec4899); padding: 30px; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer; animation: fadeInUp 0.8s ease-out 0.3s both;">
        <div style="font-size: 3rem; margin-bottom: 15px;">📈</div>
        <h4 style="color: white; margin-bottom: 10px;">التسويق الرقمي</h4>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">إدارة وسائل التواصل، SEO، والإعلانات المدفوعة</p>
      </div>
      
      <div style="background: linear-gradient(135deg, #e0e7ff, #8b5cf6); padding: 30px; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer; animation: fadeInUp 0.8s ease-out 0.4s both;">
        <div style="font-size: 3rem; margin-bottom: 15px;">📊</div>
        <h4 style="color: white; margin-bottom: 10px;">الأعمال والاستشارات</h4>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">خطط أعمال، دراسات جدوى، واستشارات إدارية</p>
      </div>
      
      <div style="background: linear-gradient(135deg, #f3e8ff, #7c3aed); padding: 30px; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer; animation: fadeInUp 0.8s ease-out 0.5s both;">
        <div style="font-size: 3rem; margin-bottom: 15px;">🎬</div>
        <h4 style="color: white; margin-bottom: 10px;">الفيديو والصوتيات</h4>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">مونتاج فيديو، تعليق صوتي، وإنتاج محتوى مرئي</p>
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
        &copy; 2025 Sokappe. جميع الحقوق محفوظة. 
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
// Interactive Functions for New Sections

// Animated Counter for Statistics
function animateCounters() {
  const counters = document.querySelectorAll('.animated-counter');
  
  counters.forEach(counter => {
    const target = parseInt(counter.getAttribute('data-target'));
    const increment = target / 100;
    let current = 0;
    
    const updateCounter = () => {
      if (current < target) {
        current += increment;
        counter.textContent = Math.floor(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = target;
      }
    };
    
    updateCounter();
  });
}

// Skills Showcase Interaction
function showSkillInfo(skill) {
  const skillInfo = document.getElementById('skill-info');
  
  const skillData = {
    web: {
      title: '💻 تطوير الويب',
      description: 'تطوير مواقع ويب حديثة وتطبيقات ويب تفاعلية باستخدام أحدث التقنيات مثل React, Vue, Laravel, Node.js',
      projects: '5,200+ مشروع',
      avgPrice: '$1,200',
      color: '#3b82f6'
    },
    design: {
      title: '🎨 التصميم الجرافيكي',
      description: 'تصميم هويات بصرية، شعارات، مطبوعات، وتصاميم رقمية احترافية تعبر عن علامتك التجارية',
      projects: '3,800+ مشروع',
      avgPrice: '$450',
      color: '#10b981'
    },
    marketing: {
      title: '📈 التسويق الرقمي',
      description: 'استراتيجيات تسويق رقمي شاملة، إدارة حملات إعلانية، وتحسين محركات البحث لزيادة المبيعات',
      projects: '2,900+ مشروع',
      avgPrice: '$800',
      color: '#f59e0b'
    },
    writing: {
      title: '✍️ كتابة المحتوى',
      description: 'كتابة محتوى تسويقي، مقالات، نصوص إعلانية، ومحتوى مواقع التواصل الاجتماعي باللغة العربية',
      projects: '4,100+ مشروع',
      avgPrice: '$300',
      color: '#8b5cf6'
    },
    mobile: {
      title: '📱 تطبيقات الجوال',
      description: 'تطوير تطبيقات جوال أصلية ومتقاطعة للأندرويد و iOS بأحدث التقنيات والمعايير',
      projects: '1,600+ مشروع',
      avgPrice: '$2,800',
      color: '#ef4444'
    }
  };
  
  const data = skillData[skill];
  
  skillInfo.innerHTML = `
    <div style="text-align: center;">
      <h3 style="color: ${data.color}; margin: 0 0 20px; font-size: 2rem;">${data.title}</h3>
      <p style="color: #64748b; margin: 0 0 30px; font-size: 1.1rem; line-height: 1.6;">${data.description}</p>
      <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap;">
        <div style="text-align: center;">
          <div style="font-size: 1.5rem; font-weight: 700; color: ${data.color};">${data.projects}</div>
          <div style="color: #64748b; font-size: 0.9rem;">مشاريع مكتملة</div>
        </div>
        <div style="text-align: center;">
          <div style="font-size: 1.5rem; font-weight: 700; color: ${data.color};">${data.avgPrice}</div>
          <div style="color: #64748b; font-size: 0.9rem;">متوسط السعر</div>
        </div>
      </div>
    </div>
  `;
}

// FAQ Toggle Function
function toggleFAQ(element) {
  const faqItem = element.parentElement;
  const answer = faqItem.querySelector('.faq-answer');
  const icon = element.querySelector('.faq-icon');
  
  // Close all other FAQs
  document.querySelectorAll('.faq-item').forEach(item => {
    if (item !== faqItem) {
      const otherAnswer = item.querySelector('.faq-answer');
      const otherIcon = item.querySelector('.faq-icon');
      otherAnswer.style.maxHeight = '0';
      otherIcon.textContent = '+';
      otherIcon.style.transform = 'rotate(0deg)';
    }
  });
  
  // Toggle current FAQ
  if (answer.style.maxHeight === '0px' || !answer.style.maxHeight) {
    answer.style.maxHeight = answer.scrollHeight + 'px';
    icon.textContent = '−';
    icon.style.transform = 'rotate(180deg)';
  } else {
    answer.style.maxHeight = '0';
    icon.textContent = '+';
    icon.style.transform = 'rotate(0deg)';
  }
}

// Savings Calculator Animation
function animateSavings() {
  const savingsCards = document.querySelectorAll('.savings-card');
  savingsCards.forEach((card, index) => {
    setTimeout(() => {
      card.style.transform = 'scale(1.05)';
      card.style.boxShadow = '0 25px 60px rgba(16, 185, 129, 0.2)';
      setTimeout(() => {
        card.style.transform = 'scale(1)';
        card.style.boxShadow = '0 15px 40px rgba(16, 185, 129, 0.1)';
      }, 300);
    }, index * 200);
  });
}

// Commission Comparison Animation
function animateCommissionCards() {
  const sokappeCard = document.querySelector('.sokappe-commission');
  const competitorCard = document.querySelector('.competitor-commission');
  
  if (sokappeCard && competitorCard) {
    // Animate Sokappe card (winner)
    setTimeout(() => {
      sokappeCard.style.transform = 'scale(1.1) rotate(2deg)';
      sokappeCard.style.boxShadow = '0 25px 60px rgba(16, 185, 129, 0.3)';
    }, 500);
    
    // Animate competitor card (loser)
    setTimeout(() => {
      competitorCard.style.transform = 'scale(0.95)';
      competitorCard.style.opacity = '0.7';
    }, 800);
    
    // Reset animations
    setTimeout(() => {
      sokappeCard.style.transform = 'scale(1) rotate(0deg)';
      sokappeCard.style.boxShadow = '0 15px 40px rgba(16, 185, 129, 0.15)';
      competitorCard.style.transform = 'scale(1)';
      competitorCard.style.opacity = '0.8';
    }, 2000);
  }
}

// Success Stories Counter Animation
function animateSuccessNumbers() {
  const successNumbers = document.querySelectorAll('.success-number');
  successNumbers.forEach(number => {
    const finalValue = parseInt(number.textContent.replace(/[^0-9]/g, ''));
    let currentValue = 0;
    const increment = finalValue / 50;
    
    const counter = setInterval(() => {
      currentValue += increment;
      if (currentValue >= finalValue) {
        number.textContent = finalValue.toLocaleString() + (number.textContent.includes('$') ? '$' : '');
        clearInterval(counter);
      } else {
        number.textContent = Math.floor(currentValue).toLocaleString() + (number.textContent.includes('$') ? '$' : '');
      }
    }, 50);
  });
}

// Initialize animations when sections come into view
const sectionObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      if (entry.target.querySelector('.animated-counter')) {
        animateCounters();
      }
      if (entry.target.querySelector('.savings-card')) {
        animateSavings();
      }
      if (entry.target.querySelector('.sokappe-commission')) {
        animateCommissionCards();
      }
      if (entry.target.querySelector('.success-number')) {
        animateSuccessNumbers();
      }
    }
  });
}, { threshold: 0.3 });

// Observe all animated sections
document.addEventListener('DOMContentLoaded', function() {
  const animatedSections = document.querySelectorAll('section');
  animatedSections.forEach(section => {
    if (section.querySelector('.animated-counter') || 
        section.querySelector('.savings-card') || 
        section.querySelector('.sokappe-commission') ||
        section.querySelector('.success-number')) {
      sectionObserver.observe(section);
    }
  });
  
  // Auto-animate commission comparison every 5 seconds
  setInterval(animateCommissionCards, 5000);
});

// Video Player Functions
function playVideo(videoId) {
  const videoElement = document.getElementById(videoId);
  const placeholder = videoElement.previousElementSibling;
  
  // Sample video URLs - replace with actual video URLs
  const videoUrls = {
    'main-video': 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1',
    'success-video': 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1',
    'demo-video': 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1',
    'tutorial-1': 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1',
    'tutorial-2': 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1',
    'tutorial-3': 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1'
  };
  
  if (videoUrls[videoId]) {
    videoElement.src = videoUrls[videoId];
    placeholder.style.display = 'none';
    videoElement.style.display = 'block';
  }
}

// Interactive Demo Functions
function showDemo(type) {
  const demoContent = document.getElementById('demo-content');
  
  const demoData = {
    client: {
      title: '👤 تجربة العميل',
      content: `
        <div style="text-align: right; padding: 20px;">
          <h4 style="color: #1f2937; margin: 0 0 20px; text-align: center;">لوحة تحكم العميل</h4>
          <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-bottom: 15px; border-right: 4px solid #3b82f6;">
            <h5 style="margin: 0 0 10px; color: #3b82f6;">📋 نشر مشروع جديد</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">اكتب تفاصيل مشروعك وحدد الميزانية</p>
          </div>
          <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-bottom: 15px; border-right: 4px solid #10b981;">
            <h5 style="margin: 0 0 10px; color: #10b981;">👥 استقبال العروض</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">راجع عروض المحترفين واختر الأنسب</p>
          </div>
          <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border-right: 4px solid #f59e0b;">
            <h5 style="margin: 0 0 10px; color: #f59e0b;">🎯 متابعة التقدم</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">تابع سير العمل والتواصل المباشر</p>
          </div>
        </div>
      `
    },
    freelancer: {
      title: '💼 تجربة المحترف',
      content: `
        <div style="text-align: right; padding: 20px;">
          <h4 style="color: #1f2937; margin: 0 0 20px; text-align: center;">لوحة تحكم المحترف</h4>
          <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-bottom: 15px; border-right: 4px solid #10b981;">
            <h5 style="margin: 0 0 10px; color: #10b981;">🔍 استكشاف المشاريع</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">ابحث عن المشاريع المناسبة لمهاراتك</p>
          </div>
          <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-bottom: 15px; border-right: 4px solid #3b82f6;">
            <h5 style="margin: 0 0 10px; color: #3b82f6;">💡 تقديم العروض</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">اكتب عرضاً مميزاً يبرز خبرتك</p>
          </div>
          <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border-right: 4px solid #8b5cf6;">
            <h5 style="margin: 0 0 10px; color: #8b5cf6;">🚀 تنفيذ المشاريع</h5>
            <p style="margin: 0; color: #64748b; font-size: 0.9rem;">ابدأ العمل واحصل على أجرك</p>
          </div>
        </div>
      `
    }
  };
  
  const data = demoData[type];
  demoContent.innerHTML = data.content;
  
  // Add animation
  demoContent.style.opacity = '0';
  setTimeout(() => {
    demoContent.style.transition = 'opacity 0.5s ease';
    demoContent.style.opacity = '1';
  }, 100);
}

// Add video loading animation
function addVideoLoadingEffect() {
  const videoCards = document.querySelectorAll('.video-card');
  
  videoCards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    
    setTimeout(() => {
      card.style.transition = 'all 0.6s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 200);
  });
}

// Initialize video effects when page loads
document.addEventListener('DOMContentLoaded', function() {
  // Add loading effect to video cards
  const videoSection = document.querySelector('section:has(.video-card)');
  if (videoSection) {
    const videoObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          addVideoLoadingEffect();
          videoObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });
    
    videoObserver.observe(videoSection);
  }
  
  // Add hover effects to playlist buttons
  document.querySelectorAll('.playlist-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      // Remove active class from all buttons
      document.querySelectorAll('.playlist-btn').forEach(b => {
        b.style.background = 'rgba(255,255,255,0.1)';
        b.style.transform = 'translateY(0)';
      });
      
      // Add active class to clicked button
      this.style.background = 'rgba(255,255,255,0.3)';
      this.style.transform = 'translateY(-2px)';
    });
  });
});

// Add responsive video handling
function handleVideoResize() {
  const videos = document.querySelectorAll('.video-container');
  
  videos.forEach(video => {
    const iframe = video.querySelector('iframe');
    if (iframe && iframe.style.display !== 'none') {
      // Ensure video maintains aspect ratio on resize
      iframe.style.width = '100%';
      iframe.style.height = '100%';
    }
  });
}

// Listen for window resize
window.addEventListener('resize', handleVideoResize);
</script>

@endsection
