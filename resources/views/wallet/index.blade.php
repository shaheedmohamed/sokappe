@extends('layouts.app')

@section('title', 'محفظتي')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0 0 8px; color: #1e293b; font-size: 2rem;">💰 محفظتي</h1>
            <p style="margin: 0; color: #64748b;">إدارة رصيدك والمعاملات المالية</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('wallet.deposit') }}" class="btn primary" style="padding: 12px 24px; background: linear-gradient(45deg, #10b981, #059669); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                💳 شحن الرصيد
            </a>
            <a href="{{ route('wallet.withdraw') }}" class="btn outline" style="padding: 12px 24px; border: 2px solid #3b82f6; color: #3b82f6; text-decoration: none; border-radius: 8px; font-weight: 600;">
                🏦 سحب الرصيد
            </a>
        </div>
    </div>

    <!-- Balance Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <!-- Available Balance -->
        <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 25px; border-radius: 16px; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💰</div>
                <div>
                    <h3 style="margin: 0; font-size: 1rem; opacity: 0.9;">الرصيد المتاح</h3>
                    <p style="margin: 0; font-size: 2rem; font-weight: 800;">${{ number_format($wallet->balance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Balance -->
        <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 25px; border-radius: 16px; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">⏳</div>
                <div>
                    <h3 style="margin: 0; font-size: 1rem; opacity: 0.9;">الرصيد المعلق</h3>
                    <p style="margin: 0; font-size: 2rem; font-weight: 800;">${{ number_format($wallet->pending_balance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Earned -->
        <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 16px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📈</div>
                <div>
                    <h3 style="margin: 0; font-size: 1rem; opacity: 0.9;">إجمالي الأرباح</h3>
                    <p style="margin: 0; font-size: 2rem; font-weight: 800;">${{ number_format($stats['total_earned'], 2) }}</p>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 25px; border-radius: 16px; box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📅</div>
                <div>
                    <h3 style="margin: 0; font-size: 1rem; opacity: 0.9;">أرباح هذا الشهر</h3>
                    <p style="margin: 0; font-size: 2rem; font-weight: 800;">${{ number_format($stats['this_month_earned'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1.2rem;">📊 إحصائيات سريعة</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <div style="font-size: 2rem; font-weight: 800; color: #3b82f6; margin-bottom: 5px;">{{ $stats['transactions_count'] }}</div>
                <div style="color: #64748b; font-size: 0.9rem;">إجمالي المعاملات</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <div style="font-size: 2rem; font-weight: 800; color: #10b981; margin-bottom: 5px;">{{ number_format($stats['total_withdrawn'], 2) }}</div>
                <div style="color: #64748b; font-size: 0.9rem;">إجمالي المسحوبات</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <div style="font-size: 2rem; font-weight: 800; color: #f59e0b; margin-bottom: 5px;">{{ number_format($wallet->total_balance, 2) }}</div>
                <div style="color: #64748b; font-size: 0.9rem;">إجمالي الرصيد</div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: #1e293b; font-size: 1.2rem;">📋 آخر المعاملات</h3>
            @if($transactions->count() > 0)
                <span style="color: #64748b; font-size: 0.9rem;">{{ $transactions->total() }} معاملة</span>
            @endif
        </div>

        @if($transactions->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">المعاملة</th>
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
                                        <div style="font-size: 0.85rem; color: #64748b;">{{ Str::limit($transaction->description, 50) }}</div>
                                    @endif
                                </td>
                                <td style="padding: 15px 12px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; 
                                        @if($transaction->type === 'deposit') background: #dcfce7; color: #166534;
                                        @elseif($transaction->type === 'withdrawal') background: #fef3c7; color: #92400e;
                                        @elseif($transaction->type === 'payment') background: #dbeafe; color: #1e40af;
                                        @else background: #f3f4f6; color: #374151; @endif">
                                        {{ $transaction->type_description }}
                                    </span>
                                </td>
                                <td style="padding: 15px 12px;">
                                    <div style="font-weight: 600; color: @if($transaction->type === 'deposit') #10b981 @else #ef4444 @endif;">
                                        @if($transaction->type === 'deposit')+@else-@endif{{ $transaction->formatted_amount }}
                                    </div>
                                    @if($transaction->fee > 0)
                                        <div style="font-size: 0.8rem; color: #64748b;">رسوم: {{ number_format($transaction->fee, 2) }} ج.م</div>
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
                                    <a href="{{ route('wallet.transaction', $transaction) }}" 
                                       style="color: #3b82f6; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                        عرض التفاصيل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div style="margin-top: 20px; display: flex; justify-content: center;">
                    {{ $transactions->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <div style="font-size: 4rem; margin-bottom: 16px;">💳</div>
                <h4 style="margin: 0 0 8px; color: #374151;">لا توجد معاملات بعد</h4>
                <p style="margin: 0; font-size: 0.9rem;">ابدأ بشحن رصيدك لرؤية المعاملات هنا</p>
                <div style="margin-top: 20px;">
                    <a href="{{ route('wallet.deposit') }}" class="btn primary" style="padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                        شحن الرصيد الآن
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
