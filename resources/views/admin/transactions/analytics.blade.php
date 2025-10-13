@extends('layouts.app')

@section('title', 'إحصائيات المعاملات المالية')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0 0 8px; color: #1e293b; font-size: 2rem;">📊 إحصائيات المعاملات المالية</h1>
            <p style="margin: 0; color: #64748b;">تحليل شامل للأداء المالي والمعاملات</p>
        </div>
        <a href="{{ route('admin.transactions.index') }}" 
           style="padding: 12px 20px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #d1d5db;">
            ← العودة للمعاملات
        </a>
    </div>

    <!-- Total Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 25px; border-radius: 16px; text-align: center; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
            <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 8px;">${{ number_format($totalStats['total_volume'], 2) }}</div>
            <div style="font-size: 1rem; opacity: 0.9;">إجمالي حجم المعاملات</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 16px; text-align: center; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
            <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 8px;">${{ number_format($totalStats['total_fees'], 2) }}</div>
            <div style="font-size: 1rem; opacity: 0.9;">إجمالي الرسوم المحصلة</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 25px; border-radius: 16px; text-align: center; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
            <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 8px;">{{ number_format($totalStats['total_transactions']) }}</div>
            <div style="font-size: 1rem; opacity: 0.9;">إجمالي المعاملات</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 25px; border-radius: 16px; text-align: center; box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
            <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 8px;">{{ number_format($totalStats['active_users']) }}</div>
            <div style="font-size: 1rem; opacity: 0.9;">المستخدمين النشطين</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
        <!-- Transaction Types -->
        <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 25px; color: #1e293b; font-size: 1.3rem;">📈 المعاملات حسب النوع</h3>
            
            @if($typeStats->count() > 0)
                <div style="display: grid; gap: 15px;">
                    @foreach($typeStats as $stat)
                        @php
                            $percentage = $totalStats['total_transactions'] > 0 ? ($stat->count / $totalStats['total_transactions']) * 100 : 0;
                            $colors = [
                                'deposit' => ['bg' => '#dcfce7', 'text' => '#166534', 'bar' => '#10b981'],
                                'withdrawal' => ['bg' => '#fef3c7', 'text' => '#92400e', 'bar' => '#f59e0b'],
                                'payment' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'bar' => '#3b82f6'],
                                'refund' => ['bg' => '#fee2e2', 'text' => '#dc2626', 'bar' => '#ef4444'],
                                'commission' => ['bg' => '#f3e8ff', 'text' => '#7c3aed', 'bar' => '#8b5cf6'],
                                'bonus' => ['bg' => '#ecfdf5', 'text' => '#059669', 'bar' => '#10b981']
                            ];
                            $color = $colors[$stat->type] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'bar' => '#6b7280'];
                        @endphp
                        
                        <div style="padding: 20px; background: {{ $color['bg'] }}; border-radius: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span style="font-weight: 600; color: {{ $color['text'] }};">
                                    @if($stat->type === 'deposit') إيداع
                                    @elseif($stat->type === 'withdrawal') سحب
                                    @elseif($stat->type === 'payment') دفع
                                    @elseif($stat->type === 'refund') استرداد
                                    @elseif($stat->type === 'commission') عمولة
                                    @elseif($stat->type === 'bonus') مكافأة
                                    @else {{ $stat->type }} @endif
                                </span>
                                <span style="font-weight: 700; color: {{ $color['text'] }};">{{ $stat->count }} معاملة</span>
                            </div>
                            
                            <div style="background: rgba(255,255,255,0.5); border-radius: 6px; height: 8px; margin-bottom: 8px;">
                                <div style="background: {{ $color['bar'] }}; height: 100%; border-radius: 6px; width: {{ $percentage }}%;"></div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: {{ $color['text'] }};">
                                <span>${{ number_format($stat->total, 2) }}</span>
                                <span>{{ number_format($percentage, 1) }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #64748b;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">📊</div>
                    <p style="margin: 0;">لا توجد بيانات كافية للعرض</p>
                </div>
            @endif
        </div>

        <!-- Monthly Stats -->
        <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 25px; color: #1e293b; font-size: 1.3rem;">📅 الإحصائيات الشهرية</h3>
            
            @if($monthlyStats->count() > 0)
                <div style="display: grid; gap: 12px;">
                    @foreach($monthlyStats->take(6) as $stat)
                        @php
                            $monthName = [
                                1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                                5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                                9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
                            ][$stat->month];
                            $maxTotal = $monthlyStats->max('total');
                            $percentage = $maxTotal > 0 ? ($stat->total / $maxTotal) * 100 : 0;
                        @endphp
                        
                        <div style="padding: 15px; background: #f8fafc; border-radius: 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-weight: 600; color: #374151;">{{ $monthName }} {{ $stat->year }}</span>
                                <span style="font-weight: 700; color: #1e293b;">{{ $stat->count }} معاملة</span>
                            </div>
                            
                            <div style="background: #e2e8f0; border-radius: 4px; height: 6px; margin-bottom: 5px;">
                                <div style="background: #3b82f6; height: 100%; border-radius: 4px; width: {{ $percentage }}%;"></div>
                            </div>
                            
                            <div style="font-size: 0.9rem; color: #64748b; font-weight: 600;">
                                ${{ number_format($stat->total, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #64748b;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">📅</div>
                    <p style="margin: 0;">لا توجد بيانات شهرية</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Users -->
    <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 25px; color: #1e293b; font-size: 1.3rem;">🏆 أكثر المستخدمين نشاطاً</h3>
        
        @if($topUsers->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 15px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">المرتبة</th>
                            <th style="padding: 15px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">المستخدم</th>
                            <th style="padding: 15px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">النوع</th>
                            <th style="padding: 15px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">عدد المعاملات</th>
                            <th style="padding: 15px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">إجمالي المبلغ</th>
                            <th style="padding: 15px; text-align: right; border-bottom: 1px solid #e2e8f0; color: #374151; font-weight: 600;">آخر معاملة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topUsers as $index => $user)
                            @php
                                $totalAmount = $user->transactions->where('status', 'completed')->sum('amount');
                                $lastTransaction = $user->transactions->where('status', 'completed')->sortByDesc('created_at')->first();
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 15px;">
                                    <div style="width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white;
                                        @if($index === 0) background: #fbbf24;
                                        @elseif($index === 1) background: #9ca3af;
                                        @elseif($index === 2) background: #f97316;
                                        @else background: #6b7280; @endif">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                
                                <td style="padding: 15px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ $user->avatar_url }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" alt="Avatar">
                                        <div>
                                            <div style="font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                                            <div style="font-size: 0.85rem; color: #64748b;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td style="padding: 15px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;
                                        @if($user->role === 'freelancer') background: #dcfce7; color: #166534;
                                        @else background: #dbeafe; color: #1e40af; @endif">
                                        {{ $user->role === 'freelancer' ? 'محترف' : 'عميل' }}
                                    </span>
                                </td>
                                
                                <td style="padding: 15px;">
                                    <span style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">{{ $user->transactions_count }}</span>
                                </td>
                                
                                <td style="padding: 15px;">
                                    <span style="font-weight: 700; color: #10b981; font-size: 1.1rem;">${{ number_format($totalAmount, 2) }}</span>
                                </td>
                                
                                <td style="padding: 15px; color: #64748b; font-size: 0.9rem;">
                                    @if($lastTransaction)
                                        {{ $lastTransaction->created_at->diffForHumans() }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <div style="font-size: 4rem; margin-bottom: 16px;">🏆</div>
                <h4 style="margin: 0 0 8px; color: #374151;">لا توجد بيانات مستخدمين</h4>
                <p style="margin: 0; font-size: 0.9rem;">لم يتم العثور على مستخدمين نشطين</p>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('admin.transactions.export') }}" 
           style="padding: 15px 30px; background: linear-gradient(45deg, #10b981, #059669); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            📥 تصدير جميع البيانات
        </a>
        
        <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" 
           style="padding: 15px 30px; background: linear-gradient(45deg, #f59e0b, #d97706); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            ⏳ المعاملات المعلقة
        </a>
        
        <a href="{{ route('admin.transactions.index', ['type' => 'withdrawal', 'status' => 'pending']) }}" 
           style="padding: 15px 30px; background: linear-gradient(45deg, #ef4444, #dc2626); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            🏦 طلبات السحب المعلقة
        </a>
    </div>
</div>
@endsection
