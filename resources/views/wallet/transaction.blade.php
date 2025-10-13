@extends('layouts.app')

@section('title', 'تفاصيل المعاملة')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0 0 8px; color: #1e293b; font-size: 2rem;">📋 تفاصيل المعاملة</h1>
            <p style="margin: 0; color: #64748b;">معرف المعاملة: #{{ $transaction->transaction_id }}</p>
        </div>
        <a href="{{ route('wallet.index') }}" 
           style="padding: 12px 20px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #d1d5db;">
            ← العودة للمحفظة
        </a>
    </div>

    <!-- Transaction Status -->
    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 80px; height: 80px; margin: 0 auto 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;
                @if($transaction->status === 'completed') background: linear-gradient(45deg, #10b981, #059669); color: white;
                @elseif($transaction->status === 'pending') background: linear-gradient(45deg, #f59e0b, #d97706); color: white;
                @elseif($transaction->status === 'processing') background: linear-gradient(45deg, #3b82f6, #1d4ed8); color: white;
                @elseif($transaction->status === 'failed') background: linear-gradient(45deg, #ef4444, #dc2626); color: white;
                @else background: linear-gradient(45deg, #6b7280, #4b5563); color: white; @endif">
                @if($transaction->status === 'completed') ✅
                @elseif($transaction->status === 'pending') ⏳
                @elseif($transaction->status === 'processing') 🔄
                @elseif($transaction->status === 'failed') ❌
                @else ⚫ @endif
            </div>
            
            <h2 style="margin: 0 0 8px; color: #1e293b; font-size: 1.5rem;">{{ $transaction->status_description }}</h2>
            <p style="margin: 0; color: #64748b; font-size: 1rem;">
                @if($transaction->status === 'completed')
                    تمت المعاملة بنجاح
                @elseif($transaction->status === 'pending')
                    المعاملة في انتظار المعالجة
                @elseif($transaction->status === 'processing')
                    جاري معالجة المعاملة
                @elseif($transaction->status === 'failed')
                    فشلت المعاملة
                @else
                    تم إلغاء المعاملة
                @endif
            </p>
        </div>

        <!-- Transaction Details Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <!-- Amount -->
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 5px;">المبلغ</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: @if($transaction->type === 'deposit') #10b981 @else #ef4444 @endif;">
                    @if($transaction->type === 'deposit')+@else-@endif{{ $transaction->formatted_amount }}
                </div>
            </div>

            <!-- Type -->
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 5px;">نوع المعاملة</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: #1e293b;">{{ $transaction->type_description }}</div>
            </div>

            @if($transaction->fee > 0)
            <!-- Fee -->
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 5px;">الرسوم</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: #ef4444;">{{ number_format($transaction->fee, 2) }} ج.م</div>
            </div>

            <!-- Net Amount -->
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 5px;">المبلغ الصافي</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: #10b981;">{{ $transaction->formatted_net_amount }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Transaction Information -->
    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1.3rem;">📄 معلومات المعاملة</h3>
        
        <div style="display: grid; gap: 15px;">
            <!-- Transaction ID -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">معرف المعاملة:</span>
                <span style="color: #1e293b; font-weight: 700; font-family: monospace;">#{{ $transaction->transaction_id }}</span>
            </div>

            <!-- Created Date -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">تاريخ الإنشاء:</span>
                <span style="color: #1e293b; font-weight: 700;">{{ $transaction->created_at->format('d/m/Y - H:i') }}</span>
            </div>

            @if($transaction->processed_at)
            <!-- Processed Date -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">تاريخ المعالجة:</span>
                <span style="color: #1e293b; font-weight: 700;">{{ $transaction->processed_at->format('d/m/Y - H:i') }}</span>
            </div>
            @endif

            @if($transaction->completed_at)
            <!-- Completed Date -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">تاريخ الإكمال:</span>
                <span style="color: #1e293b; font-weight: 700;">{{ $transaction->completed_at->format('d/m/Y - H:i') }}</span>
            </div>
            @endif

            @if($transaction->payment_method)
            <!-- Payment Method -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">طريقة الدفع:</span>
                <span style="color: #1e293b; font-weight: 700;">
                    @if($transaction->payment_method === 'opay') OPay
                    @elseif($transaction->payment_method === 'bank_transfer') تحويل بنكي
                    @elseif($transaction->payment_method === 'credit_card') بطاقة ائتمان
                    @else {{ $transaction->payment_method }} @endif
                </span>
            </div>
            @endif

            @if($transaction->external_id)
            <!-- External ID -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">المعرف الخارجي:</span>
                <span style="color: #1e293b; font-weight: 700; font-family: monospace;">{{ $transaction->external_id }}</span>
            </div>
            @endif

            <!-- Currency -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <span style="color: #64748b; font-weight: 600;">العملة:</span>
                <span style="color: #1e293b; font-weight: 700;">{{ $transaction->currency }}</span>
            </div>
        </div>
    </div>

    @if($transaction->description || $transaction->notes)
    <!-- Description & Notes -->
    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1.3rem;">📝 تفاصيل إضافية</h3>
        
        @if($transaction->description)
        <div style="margin-bottom: 20px;">
            <h4 style="margin: 0 0 10px; color: #374151; font-size: 1rem;">الوصف:</h4>
            <p style="margin: 0; color: #64748b; line-height: 1.6; padding: 15px; background: #f8fafc; border-radius: 8px;">
                {{ $transaction->description }}
            </p>
        </div>
        @endif

        @if($transaction->notes)
        <div>
            <h4 style="margin: 0 0 10px; color: #374151; font-size: 1rem;">ملاحظات:</h4>
            <p style="margin: 0; color: #64748b; line-height: 1.6; padding: 15px; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px;">
                {{ $transaction->notes }}
            </p>
        </div>
        @endif
    </div>
    @endif

    @if($transaction->project || $transaction->bid)
    <!-- Related Project/Bid -->
    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1.3rem;">🔗 مرتبط بـ</h3>
        
        @if($transaction->project)
        <div style="padding: 20px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 50px; height: 50px; background: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📋</div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #1e40af; font-size: 1.1rem;">{{ $transaction->project->title }}</h4>
                    <p style="margin: 0; color: #1e40af; font-size: 0.9rem;">مشروع #{{ $transaction->project->id }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($transaction->bid)
        <div style="padding: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; margin-top: 15px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 50px; height: 50px; background: #10b981; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">💼</div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #065f46; font-size: 1.1rem;">عرض #{{ $transaction->bid->id }}</h4>
                    <p style="margin: 0; color: #065f46; font-size: 0.9rem;">مبلغ العرض: {{ number_format($transaction->bid->amount, 2) }} ج.م</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Admin Actions (if admin) -->
    @if(Auth::user()->isAdmin() && $transaction->status !== 'completed')
    <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1.3rem;">⚙️ إجراءات الإدارة</h3>
        
        <form method="POST" action="{{ route('wallet.transaction.status', $transaction) }}">
            @csrf
            @method('PATCH')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; color: #374151; font-weight: 600;">تحديث الحالة:</label>
                    <select name="status" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem;">
                        <option value="pending" @if($transaction->status === 'pending') selected @endif>معلقة</option>
                        <option value="processing" @if($transaction->status === 'processing') selected @endif>قيد المعالجة</option>
                        <option value="completed" @if($transaction->status === 'completed') selected @endif>مكتملة</option>
                        <option value="failed" @if($transaction->status === 'failed') selected @endif>فاشلة</option>
                        <option value="cancelled" @if($transaction->status === 'cancelled') selected @endif>ملغية</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 8px; color: #374151; font-weight: 600;">ملاحظات:</label>
                    <input type="text" name="notes" placeholder="ملاحظات إضافية..." style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem;">
                </div>
            </div>
            
            <button type="submit" style="padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                تحديث المعاملة
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
