@extends('layouts.app')

@section('title', 'سحب الرصيد')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="margin: 0 0 12px; color: #1e293b; font-size: 2.5rem;">🏦 سحب الرصيد</h1>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">اسحب أموالك بطريقة آمنة وسريعة</p>
    </div>

    <!-- Current Balance -->
    <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 16px; margin-bottom: 30px; text-align: center; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
        <div style="font-size: 1rem; opacity: 0.9; margin-bottom: 8px;">رصيدك المتاح للسحب</div>
        <div style="font-size: 2.5rem; font-weight: 800;">${{ number_format($wallet->balance, 2) }}</div>
        @if($wallet->pending_balance > 0)
            <div style="font-size: 0.9rem; opacity: 0.8; margin-top: 8px;">
                رصيد معلق: ${{ number_format($wallet->pending_balance, 2) }}
            </div>
        @endif
    </div>

    @if($wallet->balance < 50)
        <!-- Insufficient Balance Warning -->
        <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 12px; padding: 25px; margin-bottom: 30px; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 15px;">⚠️</div>
            <h3 style="margin: 0 0 10px; color: #92400e;">الرصيد غير كافي للسحب</h3>
            <p style="margin: 0; color: #92400e; line-height: 1.6;">
                الحد الأدنى للسحب هو $50. رصيدك الحالي ${{ number_format($wallet->balance, 2) }}
            </p>
            <div style="margin-top: 20px;">
                <a href="{{ route('wallet.deposit') }}" class="btn primary" style="padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                    شحن الرصيد أولاً
                </a>
            </div>
        </div>
    @else
        <!-- Withdraw Form -->
        <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <form method="POST" action="{{ route('wallet.withdraw.process') }}">
                @csrf
                
                <!-- Amount Selection -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 12px; color: #374151; font-weight: 600; font-size: 1.1rem;">💰 المبلغ المطلوب سحبه</label>
                    
                    <!-- Quick Amount Buttons -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; margin-bottom: 20px;">
                        @php
                            $quickAmounts = [];
                            $balance = $wallet->balance;
                            if($balance >= 50) $quickAmounts[] = 50;
                            if($balance >= 100) $quickAmounts[] = 100;
                            if($balance >= 200) $quickAmounts[] = 200;
                            if($balance >= 500) $quickAmounts[] = 500;
                            if($balance >= 1000) $quickAmounts[] = 1000;
                            if($balance >= 2000) $quickAmounts[] = 2000;
                        @endphp
                        
                        @foreach($quickAmounts as $amount)
                            <button type="button" onclick="selectAmount({{ $amount }})" 
                                    class="amount-btn"
                                    style="padding: 15px 10px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-align: center; font-weight: 600; color: #374151;">
                                ${{ $amount }}
                            </button>
                        @endforeach
                        
                        <!-- All Balance Button -->
                        <button type="button" onclick="selectAmount({{ floor($wallet->balance) }})" 
                                class="amount-btn"
                                style="padding: 15px 10px; border: 2px solid #10b981; background: #10b981; color: white; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-align: center; font-weight: 600;">
                            كامل الرصيد
                        </button>
                    </div>
                    
                    <!-- Custom Amount Input -->
                    <div style="position: relative;">
                        <input type="number" 
                               name="amount" 
                               id="amount"
                               min="50" 
                               max="{{ $wallet->balance }}" 
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
                        الحد الأدنى: $50 • الحد الأقصى: ${{ number_format($wallet->balance, 2) }}
                    </div>
                </div>

                <!-- Fee Calculation -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                    <h4 style="margin: 0 0 15px; color: #374151; font-size: 1rem;">💳 تفاصيل الرسوم</h4>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748b;">المبلغ المطلوب:</span>
                        <span id="requested-amount" style="font-weight: 600; color: #1e293b;">$0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748b;">رسوم السحب (2%):</span>
                        <span id="fee-amount" style="font-weight: 600; color: #ef4444;">$0.00</span>
                    </div>
                    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 12px 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #374151; font-weight: 600;">المبلغ الصافي:</span>
                        <span id="net-amount" style="font-weight: 700; color: #10b981; font-size: 1.1rem;">$0.00</span>
                    </div>
                </div>

                <!-- Withdrawal Method -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 12px; color: #374151; font-weight: 600; font-size: 1.1rem;">🏦 طريقة السحب</label>
                    
                    <div style="display: grid; gap: 12px;">
                        <!-- OPay Option -->
                        <label style="display: flex; align-items: center; padding: 20px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: white;">
                            <input type="radio" name="withdrawal_method" value="opay" required style="margin-left: 15px; transform: scale(1.2);">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 50px; height: 50px; background: linear-gradient(45deg, #ff6b35, #f7931e); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.2rem;">O</div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">OPay</div>
                                        <div style="color: #64748b; font-size: 0.9rem;">سحب فوري • يصل خلال دقائق</div>
                                    </div>
                                </div>
                            </div>
                            <div style="color: #10b981; font-weight: 600; font-size: 0.9rem;">مُوصى به</div>
                        </label>

                        <!-- Bank Transfer Option -->
                        <label style="display: flex; align-items: center; padding: 20px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: white;">
                            <input type="radio" name="withdrawal_method" value="bank_transfer" style="margin-left: 15px; transform: scale(1.2);">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 50px; height: 50px; background: linear-gradient(45deg, #3b82f6, #1d4ed8); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🏦</div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">تحويل بنكي</div>
                                        <div style="color: #64748b; font-size: 0.9rem;">يستغرق 1-3 أيام عمل</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    
                    @error('withdrawal_method')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Account Details -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 12px; color: #374151; font-weight: 600; font-size: 1.1rem;">📝 تفاصيل الحساب</label>
                    
                    <textarea name="account_details" 
                              required
                              placeholder="أدخل تفاصيل حسابك (رقم المحفظة، رقم الحساب البنكي، اسم البنك، إلخ...)"
                              style="width: 100%; min-height: 120px; padding: 15px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; color: #1e293b; background: #f8fafc; resize: vertical; font-family: inherit;"></textarea>
                    
                    @error('account_details')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 8px;">{{ $message }}</div>
                    @enderror
                    
                    <div style="margin-top: 8px; color: #64748b; font-size: 0.9rem;">
                        تأكد من صحة البيانات لتجنب تأخير المعالجة
                    </div>
                </div>

                <!-- Important Notice -->
                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                    <div style="display: flex; align-items: start; gap: 12px;">
                        <div style="color: #92400e; font-size: 1.5rem;">⚠️</div>
                        <div>
                            <h4 style="margin: 0 0 8px; color: #92400e; font-size: 1rem;">تنبيه مهم</h4>
                            <ul style="margin: 0; color: #92400e; font-size: 0.9rem; line-height: 1.6;">
                                <li>سيتم مراجعة طلب السحب خلال 24 ساعة</li>
                                <li>تأكد من صحة بيانات الحساب لتجنب التأخير</li>
                                <li>رسوم السحب 2% من المبلغ المطلوب</li>
                                <li>لا يمكن إلغاء الطلب بعد الإرسال</li>
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
                            style="padding: 15px 40px; background: linear-gradient(45deg, #ef4444, #dc2626); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; cursor: pointer; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); transition: all 0.3s ease;">
                        🏦 طلب السحب
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

<script>
// Select amount function
function selectAmount(amount) {
    document.getElementById('amount').value = amount;
    updateFeeCalculation();
    
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

// Update fee calculation
function updateFeeCalculation() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    const fee = amount * 0.02;
    const netAmount = amount - fee;
    
    document.getElementById('requested-amount').textContent = '$' + amount.toFixed(2);
    document.getElementById('fee-amount').textContent = '$' + fee.toFixed(2);
    document.getElementById('net-amount').textContent = '$' + netAmount.toFixed(2);
}

// Amount input listener
document.getElementById('amount').addEventListener('input', updateFeeCalculation);

// Payment method selection styling
document.querySelectorAll('input[name="withdrawal_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('label').forEach(label => {
            if (label.querySelector('input[name="withdrawal_method"]')) {
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
    const maxBalance = {{ $wallet->balance }};
    const withdrawalMethod = document.querySelector('input[name="withdrawal_method"]:checked');
    const accountDetails = document.querySelector('textarea[name="account_details"]').value.trim();
    
    if (!amount || amount < 50 || amount > maxBalance) {
        e.preventDefault();
        alert('يرجى إدخال مبلغ صحيح بين $50 و $' + maxBalance.toFixed(2));
        return;
    }
    
    if (!withdrawalMethod) {
        e.preventDefault();
        alert('يرجى اختيار طريقة السحب');
        return;
    }
    
    if (!accountDetails || accountDetails.length < 10) {
        e.preventDefault();
        alert('يرجى إدخال تفاصيل الحساب بشكل كامل');
        return;
    }
    
    // Confirmation
    const fee = (amount * 0.02).toFixed(2);
    const netAmount = (amount - (amount * 0.02)).toFixed(2);
    
    if (!confirm(`هل أنت متأكد من طلب سحب $${amount}؟\n\nالرسوم: $${fee}\nالمبلغ الصافي: $${netAmount}`)) {
        e.preventDefault();
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '⏳ جاري المعالجة...';
    submitBtn.disabled = true;
});

// Initialize fee calculation
updateFeeCalculation();
</script>
@endsection
