@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('deals.index') }}" style="color: var(--muted); text-decoration: none; font-size: 14px;">
            ← العودة للصفقات
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        <!-- Main Content -->
        <div>
            <!-- Deal Header -->
            <div class="card" style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                    <div>
                        <h1 style="margin: 0 0 8px; color: var(--dark); font-size: 28px; line-height: 1.3;">
                            {{ $deal->title }}
                        </h1>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <span style="background: var(--{{ $deal->type == 'offer' ? 'warning' : 'primary' }}); color: white; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 600;">
                                {{ $deal->type == 'offer' ? '🛍️ عرض للبيع' : '🔍 طلب للشراء' }}
                            </span>
                            <span style="background: var(--gray-100); color: var(--gray-600); padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 600;">
                                📂 {{ $deal->category }}
                            </span>
                        </div>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-size: 32px; font-weight: 800; color: var(--{{ $deal->type == 'offer' ? 'warning' : 'primary' }}); margin-bottom: 4px;">
                            {{ $deal->price }} ج
                        </div>
                        <div style="font-size: 12px; color: var(--muted);">
                            {{ $deal->type == 'offer' ? 'السعر' : 'الميزانية' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deal Images -->
            @if($deal->images && count($deal->images) > 0)
                <div class="card" style="margin-bottom: 24px; padding: 0; overflow: hidden;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2px;">
                        @foreach($deal->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="صورة الصفقة" 
                                 style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                                 onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Deal Description -->
            <div class="card" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 16px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    📋 تفاصيل الصفقة
                </h3>
                <div style="color: var(--muted); line-height: 1.8; font-size: 16px; white-space: pre-line;">
                    {{ $deal->description }}
                </div>
            </div>

            <!-- Safety Notice -->
            <div class="card" style="background: linear-gradient(135deg, #fef3c7, #fbbf24); border: none; margin-bottom: 24px;">
                <h3 style="margin: 0 0 12px; color: #92400e; display: flex; align-items: center; gap: 8px;">
                    🛡️ ضمان Sokappe
                </h3>
                <p style="margin: 0; color: #92400e; opacity: 0.9; line-height: 1.6;">
                    نحن نضمن حقوقك! المبلغ محفوظ في محفظة الموقع حتى تأكيد استلام الصفقة. 
                    في حالة وجود أي مشكلة، فريق الدعم متاح للمساعدة.
                </p>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Seller/Buyer Info -->
            <div class="card" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 16px; color: var(--dark);">
                    {{ $deal->type == 'offer' ? '👤 البائع' : '👤 الطالب' }}
                </h3>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                        {{ substr($deal->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px; color: var(--dark);">{{ $deal->user->name }}</h4>
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <span style="color: #fbbf24;">⭐⭐⭐⭐⭐</span>
                            <span style="font-size: 12px; color: var(--muted);">(4.8)</span>
                        </div>
                    </div>
                </div>

                <div style="display: grid; gap: 8px; margin-bottom: 16px; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">تاريخ الانضمام</span>
                        <span style="color: var(--dark); font-weight: 600;">{{ $deal->user->created_at->format('M Y') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">الصفقات المكتملة</span>
                        <span style="color: var(--dark); font-weight: 600;">{{ rand(5, 50) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">معدل الاستجابة</span>
                        <span style="color: var(--secondary); font-weight: 600;">98%</span>
                    </div>
                </div>

                <a href="{{ route('profile.show', $deal->user) }}" style="display: block; text-align: center; padding: 10px; background: var(--gray-100); color: var(--dark); text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                    عرض الملف الشخصي
                </a>
            </div>

            <!-- Action Card -->
            @auth
                @if($deal->user_id != Auth::id())
                    <div class="card" style="margin-bottom: 24px;">
                        <h3 style="margin: 0 0 16px; color: var(--dark);">
                            {{ $deal->type == 'offer' ? '🛒 اطلب الآن' : '💼 قدم عرضك' }}
                        </h3>
                        
                        @if($deal->type == 'offer')
                            <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="color: var(--muted);">السعر الإجمالي</span>
                                    <span style="font-size: 20px; font-weight: 700; color: var(--warning);">{{ $deal->price }} ج</span>
                                </div>
                                <div style="font-size: 12px; color: var(--muted);">
                                    + رسوم الموقع (5%)
                                </div>
                            </div>
                            
                            <button class="btn" style="width: 100%; background: var(--warning); color: white; font-size: 16px; font-weight: 700; padding: 16px; margin-bottom: 12px;" onclick="initiateOrder()">
                                🛒 اطلب الآن
                            </button>
                        @else
                            <form action="#" method="POST" style="margin-bottom: 16px;">
                                @csrf
                                <div style="margin-bottom: 12px;">
                                    <label style="display: block; margin-bottom: 6px; font-size: 14px; color: var(--dark); font-weight: 600;">عرضك (بالجنيه)</label>
                                    <input type="number" name="offer_price" class="form-input" placeholder="{{ $deal->price }}" min="1" required>
                                </div>
                                <div style="margin-bottom: 16px;">
                                    <label style="display: block; margin-bottom: 6px; font-size: 14px; color: var(--dark); font-weight: 600;">رسالة (اختياري)</label>
                                    <textarea name="message" class="form-input" rows="3" placeholder="اشرح عرضك أو اطرح أسئلة..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 16px; font-weight: 700; padding: 16px;">
                                    💼 أرسل عرضك
                                </button>
                            </form>
                        @endif
                        
                        <button class="btn btn-outline" style="width: 100%; margin-bottom: 8px;" onclick="contactSeller()">
                            💬 تواصل مع {{ $deal->type == 'offer' ? 'البائع' : 'الطالب' }}
                        </button>
                        
                        <div style="text-align: center; font-size: 12px; color: var(--muted); line-height: 1.4;">
                            🛡️ محمي بضمان Sokappe<br>
                            المبلغ محفوظ حتى تأكيد الاستلام
                        </div>
                    </div>
                @endif
            @else
                <div class="card" style="margin-bottom: 24px; text-align: center;">
                    <h3 style="margin: 0 0 12px; color: var(--dark);">🔐 مطلوب تسجيل الدخول</h3>
                    <p style="margin: 0 0 16px; color: var(--muted); font-size: 14px;">
                        سجل دخولك للتفاعل مع هذه الصفقة
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; text-decoration: none;">
                        تسجيل الدخول
                    </a>
                </div>
            @endauth

            <!-- Report Card -->
            <div class="card" style="text-align: center;">
                <button style="background: none; border: none; color: var(--danger); font-size: 14px; cursor: pointer;" onclick="reportDeal()">
                    🚨 الإبلاغ عن هذه الصفقة
                </button>
            </div>
        </div>
    </div>

    <!-- Deal Info -->
    <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); text-align: center;">
        تم نشر هذه الصفقة في {{ $deal->created_at->format('d M Y') }} • آخر تحديث {{ $deal->updated_at->diffForHumans() }}
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 1000; cursor: pointer;" onclick="closeImageModal()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
        <img id="modalImage" src="" alt="صورة مكبرة" style="max-width: 100%; max-height: 100%; object-fit: contain;">
    </div>
    <button onclick="closeImageModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; font-size: 24px; padding: 8px 12px; border-radius: 50%; cursor: pointer;">×</button>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function initiateOrder() {
    if (confirm('هل أنت متأكد من طلب هذه الصفقة؟\n\nسيتم حجز المبلغ في محفظة الموقع حتى تأكيد الاستلام.')) {
        // Here you would typically redirect to payment/order page
        alert('سيتم توجيهك لصفحة الدفع...');
    }
}

function contactSeller() {
    alert('سيتم فتح نافذة المحادثة...');
}

function reportDeal() {
    const reason = prompt('سبب الإبلاغ:');
    if (reason) {
        alert('تم إرسال البلاغ. سيتم مراجعته من قبل الفريق.');
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
