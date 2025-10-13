@extends('layouts.app')

@section('title', 'إدارة المعاملات المالية')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0 0 8px; color: #1e293b; font-size: 2rem;">💳 إدارة المعاملات المالية</h1>
            <p style="margin: 0; color: #64748b;">مراجعة والموافقة على جميع المعاملات المالية</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.transactions.analytics') }}" class="btn outline" style="padding: 12px 20px; border: 2px solid #3b82f6; color: #3b82f6; text-decoration: none; border-radius: 8px; font-weight: 600;">
                📊 الإحصائيات
            </a>
            <a href="{{ route('admin.transactions.export', request()->query()) }}" class="btn primary" style="padding: 12px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                📥 تصدير CSV
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">{{ $stats['total_transactions'] }}</div>
            <div style="font-size: 0.9rem; opacity: 0.9;">إجمالي المعاملات</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">{{ $stats['pending_count'] }}</div>
            <div style="font-size: 0.9rem; opacity: 0.9;">معاملات معلقة</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">{{ $stats['completed_count'] }}</div>
            <div style="font-size: 0.9rem; opacity: 0.9;">معاملات مكتملة</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">${{ number_format($stats['total_volume'], 2) }}</div>
            <div style="font-size: 0.9rem; opacity: 0.9;">إجمالي الحجم</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">{{ $stats['pending_withdrawals'] }}</div>
            <div style="font-size: 0.9rem; opacity: 0.9;">طلبات سحب معلقة</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">{{ $stats['pending_deposits'] }}</div>
            <div style="font-size: 0.9rem; opacity: 0.9;">طلبات إيداع معلقة</div>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1.2rem;">🔍 فلترة المعاملات</h3>
        
        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <!-- Type Filter -->
            <div>
                <label style="display: block; margin-bottom: 5px; color: #374151; font-weight: 600; font-size: 0.9rem;">نوع المعاملة</label>
                <select name="type" style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px;">
                    <option value="">جميع الأنواع</option>
                    <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>إيداع</option>
                    <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>سحب</option>
                    <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>دفع</option>
                    <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>استرداد</option>
                    <option value="commission" {{ request('type') === 'commission' ? 'selected' : '' }}>عمولة</option>
                    <option value="bonus" {{ request('type') === 'bonus' ? 'selected' : '' }}>مكافأة</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label style="display: block; margin-bottom: 5px; color: #374151; font-weight: 600; font-size: 0.9rem;">الحالة</label>
                <select name="status" style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px;">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلقة</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>مكتملة</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>فاشلة</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغية</option>
                </select>
            </div>

            <!-- Payment Method Filter -->
            <div>
                <label style="display: block; margin-bottom: 5px; color: #374151; font-weight: 600; font-size: 0.9rem;">طريقة الدفع</label>
                <select name="payment_method" style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px;">
                    <option value="">جميع الطرق</option>
                    <option value="opay" {{ request('payment_method') === 'opay' ? 'selected' : '' }}>OPay</option>
                    <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                    <option value="credit_card" {{ request('payment_method') === 'credit_card' ? 'selected' : '' }}>بطاقة ائتمان</option>
                </select>
            </div>

            <!-- User Search -->
            <div>
                <label style="display: block; margin-bottom: 5px; color: #374151; font-weight: 600; font-size: 0.9rem;">بحث المستخدم</label>
                <input type="text" name="user_search" value="{{ request('user_search') }}" placeholder="اسم أو إيميل المستخدم" style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px;">
            </div>

            <!-- Date From -->
            <div>
                <label style="display: block; margin-bottom: 5px; color: #374151; font-weight: 600; font-size: 0.9rem;">من تاريخ</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px;">
            </div>

            <!-- Date To -->
            <div>
                <label style="display: block; margin-bottom: 5px; color: #374151; font-weight: 600; font-size: 0.9rem;">إلى تاريخ</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px;">
            </div>

            <!-- Submit Button -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    🔍 فلترة
                </button>
                <a href="{{ route('admin.transactions.index') }}" style="padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px; font-weight: 600;">
                    🔄 إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: #1e293b; font-size: 1.2rem;">📋 المعاملات ({{ $transactions->total() }})</h3>
        </div>

        @if($transactions->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">المعاملة</th>
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">المستخدم</th>
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">النوع</th>
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">المبلغ</th>
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">الحالة</th>
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">التاريخ</th>
                            <th style="padding: 12px; text-align: center; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 15px 12px;">
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">#{{ $transaction->transaction_id }}</div>
                                    @if($transaction->description)
                                        <div style="font-size: 0.85rem; color: #64748b;">{{ Str::limit($transaction->description, 40) }}</div>
                                    @endif
                                </td>
                                
                                <td style="padding: 15px 12px;">
                                    <div style="font-weight: 600; color: #1e293b;">{{ $transaction->user->name }}</div>
                                    <div style="font-size: 0.85rem; color: #64748b;">{{ $transaction->user->email }}</div>
                                </td>
                                
                                <td style="padding: 15px 12px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; 
                                        @if($transaction->type === 'deposit') background: #dcfce7; color: #166534;
                                        @elseif($transaction->type === 'withdrawal') background: #fef3c7; color: #92400e;
                                        @elseif($transaction->type === 'payment') background: #dbeafe; color: #1e40af;
                                        @else background: #f3f4f6; color: #374151; @endif">
                                        {{ $transaction->type_description }}
                                    </span>
                                    @if($transaction->payment_method)
                                        <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">{{ $transaction->payment_method }}</div>
                                    @endif
                                </td>
                                
                                <td style="padding: 15px 12px;">
                                    <div style="font-weight: 600; color: @if($transaction->type === 'deposit') #10b981 @else #ef4444 @endif;">
                                        @if($transaction->type === 'deposit')+@else-@endif${{ number_format($transaction->amount, 2) }}
                                    </div>
                                    @if($transaction->fee > 0)
                                        <div style="font-size: 0.8rem; color: #64748b;">رسوم: ${{ number_format($transaction->fee, 2) }}</div>
                                    @endif
                                </td>
                                
                                <td style="padding: 15px 12px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;
                                        @if($transaction->status === 'completed') background: #dcfce7; color: #166534;
                                        @elseif($transaction->status === 'pending') background: #fef3c7; color: #92400e;
                                        @elseif($transaction->status === 'processing') background: #dbeafe; color: #1e40af;
                                        @elseif($transaction->status === 'failed') background: #fee2e2; color: #dc2626;
                                        @else background: #f3f4f6; color: #374151; @endif">
                                        {{ $transaction->status_description }}
                                    </span>
                                </td>
                                
                                <td style="padding: 15px 12px; color: #64748b; font-size: 0.9rem;">
                                    {{ $transaction->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size: 0.8rem;">{{ $transaction->created_at->format('H:i') }}</span>
                                </td>
                                
                                <td style="padding: 15px 12px; text-align: center;">
                                    <div style="display: flex; gap: 5px; justify-content: center; flex-wrap: wrap;">
                                        <a href="{{ route('admin.transactions.show', $transaction) }}" 
                                           style="padding: 6px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                            👁️ عرض
                                        </a>
                                        
                                        @if($transaction->status === 'pending')
                                            <form method="POST" action="{{ route('admin.transactions.approve', $transaction) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" onclick="return confirm('هل أنت متأكد من الموافقة على هذه المعاملة؟')"
                                                        style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                                    ✅ موافقة
                                                </button>
                                            </form>
                                            
                                            <button onclick="showRejectModal({{ $transaction->id }})"
                                                    style="padding: 6px 12px; background: #ef4444; color: white; border: none; border-radius: 4px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                                ❌ رفض
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div style="margin-top: 20px; display: flex; justify-content: center;">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <div style="font-size: 4rem; margin-bottom: 16px;">📋</div>
                <h4 style="margin: 0 0 8px; color: #374151;">لا توجد معاملات</h4>
                <p style="margin: 0; font-size: 0.9rem;">لم يتم العثور على معاملات تطابق الفلاتر المحددة</p>
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%;">
        <h3 style="margin: 0 0 20px; color: #1e293b;">❌ رفض المعاملة</h3>
        
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #374151; font-weight: 600;">سبب الرفض:</label>
                <textarea name="reason" required placeholder="اكتب سبب رفض المعاملة..." 
                          style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; resize: vertical;"></textarea>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: end;">
                <button type="button" onclick="hideRejectModal()" 
                        style="padding: 12px 20px; background: #6b7280; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
                <button type="submit" 
                        style="padding: 12px 20px; background: #ef4444; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    رفض المعاملة
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(transactionId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    form.action = `/admin/transactions/${transactionId}/reject`;
    modal.style.display = 'flex';
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endsection
