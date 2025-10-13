@extends('layouts.app')

@section('title', 'شحن الرصيد')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="margin: 0 0 12px; color: #1e293b; font-size: 2.5rem;">💳 شحن الرصيد</h1>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">أضف أموال إلى محفظتك بطريقة آمنة وسريعة</p>
    </div>

    <!-- Current Balance -->
    <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 25px; border-radius: 16px; margin-bottom: 30px; text-align: center; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
        <div style="font-size: 1rem; opacity: 0.9; margin-bottom: 8px;">رصيدك الحالي</div>
        <div style="font-size: 2.5rem; font-weight: 800;">${{ number_format($wallet->balance, 2) }}</div>
    </div>

    <!-- Deposit Form -->
    <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('wallet.deposit.process') }}">
            @csrf
            
            <!-- Amount Selection -->
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 12px; color: #374151; font-weight: 600; font-size: 1.1rem;">💰 اختر المبلغ</label>
                
                <!-- Quick Amount Buttons -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; margin-bottom: 20px;">
                    @foreach([50, 100, 200, 500, 1000, 2000] as $amount)
                        <button type="button" onclick="selectAmount({{ $amount }})" 
                                class="amount-btn"
                                style="padding: 15px 10px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-align: center; font-weight: 600; color: #374151;">
                            ${{ $amount }}
                        </button>
                    @endforeach
                </div>
                
                <!-- Custom Amount Input -->
                <div style="position: relative;">
                    <input type="number" 
                           name="amount" 
                           id="amount"
                           min="10" 
                           max="10000" 
                           step="0.01"
                           required
                           placeholder="أدخل مبلغ مخصص"
                           style="width: 100%; padding: 15px 50px 15px 15px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1.1rem; font-weight: 600; color: #1e293b; background: #f8fafc;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 600;">$</span>
                </div>
                
                @error('amount')
                    <div style="color: #ef4444; font-size: 0.9rem; margin-top: 8px;">{{ $message }}</div>
                @enderror
                
                <div style="margin-top: 8px; color: #64748b; font-size: 0.9rem;">
                    الحد الأدنى: $10 • الحد الأقصى: $10,000
                </div>
            </div>

            <!-- Payment Method -->
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 12px; color: #374151; font-weight: 600; font-size: 1.1rem;">💳 طريقة الدفع</label>
                
                <div style="display: grid; gap: 12px;">
                    <!-- OPay Option -->
                    <label style="display: flex; align-items: center; padding: 20px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: white;">
                        <input type="radio" name="payment_method" value="opay" required style="margin-left: 15px; transform: scale(1.2);">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(45deg, #ff6b35, #f7931e); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.2rem;">O</div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">OPay</div>
                                    <div style="color: #64748b; font-size: 0.9rem;">دفع فوري وآمن • بدون رسوم إضافية</div>
                                </div>
                            </div>
                        </div>
                        <div style="color: #10b981; font-weight: 600; font-size: 0.9rem;">مُوصى به</div>
                    </label>

                    <!-- Bank Transfer Option -->
                    <label style="display: flex; align-items: center; padding: 20px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: white;">
                        <input type="radio" name="payment_method" value="bank_transfer" style="margin-left: 15px; transform: scale(1.2);">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🏦</div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">تحويل بنكي</div>
                                    <div style="color: #64748b; font-size: 0.9rem;">يستغرق 1-3 أيام عمل • بدون رسوم</div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Credit Card Option -->
                    <label style="display: flex; align-items: center; padding: 20px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: white;">
                        <input type="radio" name="payment_method" value="credit_card" style="margin-left: 15px; transform: scale(1.2);">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(45deg, #8b5cf6, #7c3aed); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">💳</div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">بطاقة ائتمان</div>
                                    <div style="color: #64748b; font-size: 0.9rem;">فوري • رسوم 2.5%</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                
                @error('payment_method')
                    <div style="color: #ef4444; font-size: 0.9rem; margin-top: 8px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Security Notice -->
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                <div style="display: flex; align-items: start; gap: 12px;">
                    <div style="color: #0369a1; font-size: 1.5rem;">🔒</div>
                    <div>
                        <h4 style="margin: 0 0 8px; color: #0c4a6e; font-size: 1rem;">معاملة آمنة ومحمية</h4>
                        <ul style="margin: 0; color: #0c4a6e; font-size: 0.9rem; line-height: 1.6;">
                            <li>جميع المعاملات محمية بتشفير SSL 256-bit</li>
                            <li>لا نحتفظ ببيانات البطاقات الائتمانية</li>
                            <li>ستتلقى تأكيد فوري عبر البريد الإلكتروني</li>
                            <li>يمكنك تتبع حالة المعاملة في أي وقت</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px; justify-content: center;">
                <a href="{{ route('wallet.index') }}" 
                   style="padding: 15px 30px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #d1d5db; transition: all 0.3s ease;">
                    ← العودة للمحفظة
                </a>
                
                <button type="submit" 
                        style="padding: 15px 40px; background: linear-gradient(45deg, #10b981, #059669); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; cursor: pointer; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: all 0.3s ease;">
                    💳 شحن الرصيد الآن
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Select amount function
function selectAmount(amount) {
    document.getElementById('amount').value = amount;
    
    // Update button styles
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.style.borderColor = '#e2e8f0';
        btn.style.background = 'white';
        btn.style.color = '#374151';
    });
    
    event.target.style.borderColor = '#3b82f6';
    event.target.style.background = '#3b82f6';
    event.target.style.color = 'white';
}

// Payment method selection styling
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('label').forEach(label => {
            if (label.querySelector('input[name="payment_method"]')) {
                label.style.borderColor = '#e2e8f0';
                label.style.background = 'white';
            }
        });
        
        this.closest('label').style.borderColor = '#3b82f6';
        this.closest('label').style.background = '#f8fafc';
    });
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const amount = parseFloat(document.getElementById('amount').value);
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (!amount || amount < 10 || amount > 10000) {
        e.preventDefault();
        alert('يرجى إدخال مبلغ صحيح بين $10 و $10,000');
        return;
    }
    
    if (!paymentMethod) {
        e.preventDefault();
        alert('يرجى اختيار طريقة الدفع');
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '⏳ جاري المعالجة...';
    submitBtn.disabled = true;
});
</script>
@endsection
