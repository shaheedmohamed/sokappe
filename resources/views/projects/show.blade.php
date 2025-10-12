@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('projects.index') }}" style="color: var(--muted); text-decoration: none; font-size: 14px;">
            ← العودة للمشاريع
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        <!-- Main Content -->
        <div>
            <!-- Project Header -->
            <div class="card" style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                    <div>
                        <h1 style="margin: 0 0 12px; color: var(--dark); font-size: 28px; line-height: 1.3;">
                            <a href="{{ route('projects.bid.create', $project) }}" style="color: inherit; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">
                                {{ $project->title }}
                            </a>
                        </h1>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            @php
                                $statusConfig = [
                                    'open' => ['label' => '🟢 مفتوح', 'color' => '#10b981'],
                                    'in_progress' => ['label' => '🟡 قيد التنفيذ', 'color' => '#f59e0b'],
                                    'completed' => ['label' => '✅ مكتمل', 'color' => '#6b7280'],
                                    'cancelled' => ['label' => '❌ ملغي', 'color' => '#ef4444'],
                                ];
                                $currentStatus = $statusConfig[$project->status] ?? ['label' => '🆕 مشروع جديد', 'color' => 'var(--secondary)'];
                            @endphp
                            <span style="background: {{ $currentStatus['color'] }}; color: white; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 600;">
                                {{ $currentStatus['label'] }}
                            </span>
                            <span style="color: var(--muted); font-size: 14px;">
                                نُشر {{ $project->created_at->diffForHumans() }}
                            </span>
                            
                            @auth
                                @if(Auth::id() === $project->user_id)
                                    <!-- Status Change Button -->
                                    <div style="position: relative; display: inline-block;">
                                        <button onclick="toggleStatusMenu()" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                            ⚙️ تغيير الحالة
                                            <span style="font-size: 10px;">▼</span>
                                        </button>
                                        <div id="statusMenu" style="display: none; position: absolute; top: 100%; left: 0; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 180px; z-index: 1000; margin-top: 4px;">
                                            @foreach($statusConfig as $status => $config)
                                                @if($status !== $project->status)
                                                    <form method="POST" action="{{ route('projects.update-status', $project) }}" style="margin: 0;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $status }}">
                                                        <button type="submit" 
                                                                style="width: 100%; text-align: right; padding: 10px 16px; background: none; border: none; color: #374151; cursor: pointer; font-size: 13px; border-bottom: 1px solid #f3f4f6;"
                                                                onmouseover="this.style.backgroundColor='#f9fafb'"
                                                                onmouseout="this.style.backgroundColor='transparent'"
                                                                onclick="return confirm('هل أنت متأكد من تغيير حالة المشروع إلى: {{ $config['label'] }}؟')">
                                                            {{ $config['label'] }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-size: 24px; font-weight: 800; color: var(--primary); margin-bottom: 4px;">
                            {{ $project->budget_min }} - {{ $project->budget_max }} ج
                        </div>
                        <div style="font-size: 12px; color: var(--muted);">الميزانية المتوقعة</div>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="card" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 16px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    📋 تفاصيل المشروع
                </h3>
                <div style="color: var(--muted); line-height: 1.8; font-size: 16px; white-space: pre-line;">
                    {{ $project->description }}
                </div>
            </div>

            <!-- Project Skills -->
            @if($project->skills)
                <div class="card" style="margin-bottom: 24px;">
                    <h3 style="margin: 0 0 16px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                        🛠️ المهارات المطلوبة
                    </h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach(explode(',', $project->skills) as $skill)
                            <span style="background: var(--primary); color: white; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Project Bids -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin: 0; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                        💼 العروض المقدمة ({{ $project->bids->count() }})
                    </h3>
                    <div style="font-size: 14px; color: var(--muted);">
                        متوسط العروض: {{ $project->bids->count() > 0 ? number_format($project->bids->avg('amount')) : '0' }} ج
                    </div>
                </div>

                @forelse($project->bids as $bid)
                    <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 16px; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                                    {{ $bid->user ? substr($bid->user->name, 0, 1) : 'U' }}
                                </div>
                                <div>
                                    <h4 style="margin: 0 0 4px; color: var(--dark);">
                                        <a href="{{ $bid->user ? route('profile.show', $bid->user) : '#' }}" style="color: inherit; text-decoration: none;">
                                            {{ $bid->user->name ?? 'مستخدم غير معروف' }}
                                        </a>
                                    </h4>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="color: #fbbf24; font-size: 14px;">⭐⭐⭐⭐⭐</span>
                                        <span style="font-size: 12px; color: var(--muted);">({{ rand(40, 50) / 10 }})</span>
                                        <span style="font-size: 12px; color: var(--muted);">•</span>
                                        <span style="font-size: 12px; color: var(--muted);">{{ rand(10, 100) }} مشروع مكتمل</span>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-size: 20px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">
                                    {{ number_format($bid->amount) }} ج
                                </div>
                                <div style="font-size: 12px; color: var(--muted);">
                                    خلال {{ $bid->delivery_time ?? rand(3, 14) }} أيام
                                </div>
                            </div>
                        </div>

                        @if($bid->message)
                            <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin-bottom: 12px;">
                                <p style="margin: 0; color: var(--muted); line-height: 1.6; font-size: 15px;">
                                    {{ $bid->message }}
                                </p>
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; color: var(--muted);">
                                قُدم {{ $bid->created_at->diffForHumans() }}
                            </span>
                            @auth
                                @if(Auth::id() === $project->user_id)
                                    <div style="display: flex; gap: 8px;">
                                        @if($project->status === 'open' && $bid->status === 'pending')
                                            <form action="{{ route('bids.accept', $bid) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" style="background: var(--secondary); color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;" onclick="return confirm('هل أنت متأكد من قبول هذا العرض؟ سيتم رفض باقي العروض تلقائياً.')">
                                                    ✅ قبول العرض
                                                </button>
                                            </form>
                                        @elseif($bid->status === 'accepted')
                                            <span style="background: #10b981; color: white; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                ✅ مقبول
                                            </span>
                                        @elseif($bid->status === 'rejected')
                                            <span style="background: #ef4444; color: white; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                ❌ مرفوض
                                            </span>
                                        @else
                                            <button style="background: var(--secondary); color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;" disabled>
                                                قبول العرض
                                            </button>
                                        @endif
                                        <a href="{{ route('messages.start-from-bid', $bid) }}" 
                                           style="background: transparent; color: var(--primary); border: 1px solid var(--primary); padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-block;">
                                            💬 مراسلة
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px 20px; color: var(--muted);">
                        <div style="font-size: 48px; margin-bottom: 16px;">💼</div>
                        <h4 style="margin: 0 0 8px; color: var(--dark);">لا توجد عروض بعد</h4>
                        <p style="margin: 0; font-size: 14px;">كن أول من يقدم عرضه لهذا المشروع</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Client Info -->
            <div class="card" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 16px; color: var(--dark);">👤 صاحب المشروع</h3>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">
                        {{ $project->user ? substr($project->user->name, 0, 1) : 'U' }}
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px; color: var(--dark);">
                            <a href="{{ $project->user ? route('profile.show', $project->user) : '#' }}" style="color: inherit; text-decoration: none;">
                                {{ $project->user->name ?? 'مستخدم غير معروف' }}
                            </a>
                        </h4>
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <span style="color: #fbbf24;">⭐⭐⭐⭐⭐</span>
                            <span style="font-size: 12px; color: var(--muted);">({{ rand(40, 50) / 10 }})</span>
                        </div>
                    </div>
                </div>

                <div style="display: grid; gap: 8px; margin-bottom: 16px; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">تاريخ الانضمام</span>
                        <span style="color: var(--dark); font-weight: 600;">{{ $project->user ? $project->user->created_at->format('M Y') : 'غير محدد' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">المشاريع المنشورة</span>
                        <span style="color: var(--dark); font-weight: 600;">{{ rand(5, 25) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">المشاريع المكتملة</span>
                        <span style="color: var(--secondary); font-weight: 600;">{{ rand(3, 20) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">معدل الاستجابة</span>
                        <span style="color: var(--secondary); font-weight: 600;">{{ rand(85, 100) }}%</span>
                    </div>
                </div>

                <a href="{{ $project->user ? route('profile.show', $project->user) : '#' }}" style="display: block; text-align: center; padding: 12px; background: var(--gray-100); color: var(--dark); text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                    عرض الملف الشخصي
                </a>
            </div>

            <!-- Project Stats -->
            <div class="card" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 16px; color: var(--dark);">📊 إحصائيات المشروع</h3>
                
                <div style="display: grid; gap: 12px; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border);">
                        <span style="color: var(--muted);">العروض المقدمة</span>
                        <span style="font-weight: 600; color: var(--primary);">{{ $project->bids->count() }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border);">
                        <span style="color: var(--muted);">متوسط العروض</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $project->bids->count() > 0 ? number_format($project->bids->avg('amount')) : '0' }} ج</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border);">
                        <span style="color: var(--muted);">المدة المطلوبة</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $project->duration ?? 'غير محدد' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                        <span style="color: var(--muted);">حالة المشروع</span>
                        <span style="background: var(--secondary); color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">مفتوح</span>
                    </div>
                </div>
            </div>

            <!-- Bid Action -->
            @auth
                @if(Auth::id() !== $project->user_id)
                    @php
                        $userBid = $project->bids->where('user_id', Auth::id())->first();
                    @endphp
                    
                    @if($userBid)
                        <!-- User already submitted a bid -->
                        <div class="card" style="margin-bottom: 24px;">
                            <h3 style="margin: 0 0 16px; color: var(--dark);">✅ عرضك المقدم</h3>
                            
                            <div style="background: var(--secondary); color: white; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-size: 18px; font-weight: 700;">{{ number_format($userBid->amount) }} ج</span>
                                    <span style="font-size: 14px;">{{ $userBid->delivery_time }} أيام</span>
                                </div>
                                <div style="font-size: 12px; opacity: 0.9;">
                                    قُدم {{ $userBid->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            @if($userBid->message)
                                <div style="background: var(--gray-50); padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                                    <p style="margin: 0; font-size: 14px; color: var(--muted);">
                                        "{{ $userBid->message }}"
                                    </p>
                                </div>
                            @endif
                            
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: var(--warning); color: white; border-radius: 8px; font-size: 14px; font-weight: 600;">
                                <span>⏳</span>
                                <span>في انتظار رد صاحب المشروع</span>
                            </div>
                            
                            <div style="text-align: center; font-size: 12px; color: var(--muted); margin-top: 12px; line-height: 1.4;">
                                💡 لا يمكن تقديم أكثر من عرض واحد على نفس المشروع
                            </div>
                        </div>
                    @else
                        <!-- User can submit a bid -->
                        <div class="card" style="margin-bottom: 24px;">
                            <h3 style="margin: 0 0 16px; color: var(--dark);">💼 قدم عرضك</h3>
                            
                            <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="color: var(--muted);">الميزانية المتوقعة</span>
                                    <span style="font-size: 16px; font-weight: 700; color: var(--primary);">{{ $project->budget_min }} - {{ $project->budget_max }} ج</span>
                                </div>
                                <div style="font-size: 12px; color: var(--muted);">
                                    💡 قدم عرضاً تنافسياً لزيادة فرص قبولك
                                </div>
                            </div>
                            
                            <a href="{{ route('projects.bid.create', $project) }}" class="btn btn-primary" style="width: 100%; text-decoration: none; text-align: center; font-size: 16px; font-weight: 700; padding: 16px; margin-bottom: 12px;">
                                💼 قدّم عرضك الآن
                            </a>
                            
                            <div style="text-align: center; font-size: 12px; color: var(--muted); line-height: 1.4;">
                                🛡️ محمي بضمان Sokappe<br>
                                نضمن حقوقك في جميع المعاملات
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <div class="card" style="margin-bottom: 24px; text-align: center;">
                    <h3 style="margin: 0 0 12px; color: var(--dark);">🔐 مطلوب تسجيل الدخول</h3>
                    <p style="margin: 0 0 16px; color: var(--muted); font-size: 14px;">
                        سجل دخولك لتقديم عرض على هذا المشروع
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; text-decoration: none;">
                        تسجيل الدخول
                    </a>
                </div>
            @endauth

            <!-- Similar Projects -->
            <div class="card">
                <h3 style="margin: 0 0 16px; color: var(--dark);">🔍 مشاريع مشابهة</h3>
                
                @php
                    $similarProjects = \App\Models\Project::where('id', '!=', $project->id)->latest()->take(3)->get();
                @endphp
                
                @foreach($similarProjects as $similar)
                    <div style="border-bottom: 1px solid var(--border); padding-bottom: 12px; margin-bottom: 12px;">
                        <h4 style="margin: 0 0 4px; font-size: 14px;">
                            <a href="{{ route('projects.show', $similar) }}" style="color: var(--dark); text-decoration: none;">
                                {{ Str::limit($similar->title, 50) }}
                            </a>
                        </h4>
                        <div style="font-size: 12px; color: var(--muted);">
                            {{ $similar->budget_min }} - {{ $similar->budget_max }} ج
                        </div>
                    </div>
                @endforeach
                
                <a href="{{ route('projects.index') }}" style="display: block; text-align: center; color: var(--primary); font-size: 14px; font-weight: 600; text-decoration: none; margin-top: 8px;">
                    عرض المزيد →
                </a>
            </div>
        </div>
    </div>

    <!-- Project Info -->
    <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); text-align: center;">
        تم نشر هذا المشروع في {{ $project->created_at->format('d M Y') }} • آخر تحديث {{ $project->updated_at->diffForHumans() }}
    </div>
</div>

<script>
function toggleStatusMenu() {
    const menu = document.getElementById('statusMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('statusMenu');
    const button = event.target.closest('button[onclick="toggleStatusMenu()"]');
    
    if (!button && menu) {
        menu.style.display = 'none';
    }
});
</script>
@endsection
