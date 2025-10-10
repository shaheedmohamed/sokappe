@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('projects.show', $project) }}" style="color: var(--muted); text-decoration: none; font-size: 14px;">
            ← العودة للمشروع
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        <!-- Main Content -->
        <div>
            <!-- Project Summary -->
            <div class="card" style="margin-bottom: 24px;">
                <h1 style="margin: 0 0 16px; color: var(--dark); font-size: 24px; line-height: 1.3;">
                    💼 تقديم عرض على: {{ $project->title }}
                </h1>
                
                <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="margin: 0 0 12px; color: var(--muted); line-height: 1.6;">
                        {{ Str::limit($project->description, 200) }}
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                        <span style="color: var(--muted);">الميزانية المتوقعة:</span>
                        <span style="font-weight: 600; color: var(--primary);">{{ $project->budget_min }} - {{ $project->budget_max }} ج</span>
                    </div>
                </div>
            </div>

            <!-- Bid Form -->
            <div class="card">
                <h2 style="margin: 0 0 20px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    📝 تفاصيل عرضك
                </h2>

                <form method="POST" action="{{ route('projects.bid.store', $project) }}">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div class="form-group">
                            <label class="form-label" for="price">💰 السعر المقترح (بالجنيه المصري)</label>
                            <input class="form-input @error('price') error @enderror" type="number" id="price" name="price" value="{{ old('price') }}" required min="1" placeholder="مثال: 1500">
                            @error('price')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="days">⏱️ مدة التنفيذ (بالأيام)</label>
                            <input class="form-input @error('days') error @enderror" type="number" id="days" name="days" value="{{ old('days') }}" required min="1" placeholder="مثال: 7">
                            @error('days')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">💬 رسالة العرض</label>
                        <textarea class="form-input form-textarea @error('message') error @enderror" id="message" name="message" rows="6" placeholder="اشرح كيف ستنفذ هذا المشروع، خبرتك في هذا المجال، والقيمة التي ستضيفها...">{{ old('message') }}</textarea>
                        @error('message')<span class="form-error">{{ $message }}</span>@enderror
                        <div style="font-size: 12px; color: var(--muted); margin-top: 6px;">
                            💡 اكتب رسالة مقنعة تبرز خبرتك وتميزك عن المنافسين
                        </div>
                    </div>

                    <!-- Terms -->
                    <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid var(--primary);">
                        <h4 style="margin: 0 0 8px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                            🛡️ شروط تقديم العرض
                        </h4>
                        <ul style="margin: 0; padding-right: 20px; color: var(--muted); font-size: 14px; line-height: 1.6;">
                            <li>العرض ملزم لمدة 30 يوم من تاريخ التقديم</li>
                            <li>يجب الالتزام بالسعر والمدة المحددة في العرض</li>
                            <li>الموقع يحتفظ بنسبة 5% من قيمة المشروع كرسوم خدمة</li>
                            <li>يمكن التفاوض مع صاحب المشروع قبل قبول العرض</li>
                        </ul>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-outline">إلغاء</a>
                        <button type="submit" class="btn btn-primary">💼 تقديم العرض</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Project Owner -->
            <div class="card" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 16px; color: var(--dark);">👤 صاحب المشروع</h3>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                        {{ $project->user ? substr($project->user->name, 0, 1) : 'U' }}
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px; color: var(--dark);">{{ $project->user->name ?? 'مستخدم غير معروف' }}</h4>
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <span style="color: #fbbf24;">⭐⭐⭐⭐⭐</span>
                            <span style="font-size: 12px; color: var(--muted);">({{ rand(40, 50) / 10 }})</span>
                        </div>
                    </div>
                </div>

                <div style="display: grid; gap: 8px; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">عضو منذ</span>
                        <span style="color: var(--dark); font-weight: 600;">{{ $project->user ? $project->user->created_at->format('M Y') : 'غير محدد' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">المشاريع المنشورة</span>
                        <span style="color: var(--dark); font-weight: 600;">{{ rand(5, 25) }}</span>
                    </div>
                </div>
            </div>

            <!-- Other Bids Preview -->
            @if($otherBids->count() > 0)
                <div class="card" style="margin-bottom: 24px;">
                    <h3 style="margin: 0 0 16px; color: var(--dark);">👥 عروض أخرى ({{ $project->bids->count() }})</h3>
                    
                    @foreach($otherBids as $bid)
                        <div style="border-bottom: 1px solid var(--border); padding-bottom: 12px; margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                        {{ $bid->user ? substr($bid->user->name, 0, 1) : 'U' }}
                                    </div>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; color: var(--dark);">{{ $bid->user->name ?? 'مستخدم غير معروف' }}</div>
                                        <div style="font-size: 11px; color: var(--muted);">{{ $bid->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div style="text-align: left;">
                                    <div style="font-size: 14px; font-weight: 700; color: var(--primary);">{{ number_format($bid->amount) }} ج</div>
                                    <div style="font-size: 11px; color: var(--muted);">{{ $bid->delivery_time }} أيام</div>
                                </div>
                            </div>
                            
                            @if($bid->message)
                                <p style="margin: 0; font-size: 12px; color: var(--muted); line-height: 1.4;">
                                    {{ Str::limit($bid->message, 80) }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                    
                    <a href="{{ route('projects.show', $project) }}" style="display: block; text-align: center; color: var(--primary); font-size: 14px; font-weight: 600; text-decoration: none; margin-top: 8px;">
                        عرض جميع العروض →
                    </a>
                </div>
            @endif

            <!-- Tips -->
            <div class="card">
                <h3 style="margin: 0 0 16px; color: var(--dark);">💡 نصائح لعرض ناجح</h3>
                
                <div style="display: grid; gap: 12px; font-size: 14px;">
                    <div style="display: flex; gap: 8px;">
                        <span style="color: var(--secondary);">✓</span>
                        <span style="color: var(--muted);">اقرأ وصف المشروع بعناية</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <span style="color: var(--secondary);">✓</span>
                        <span style="color: var(--muted);">قدم سعراً تنافسياً ومعقولاً</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <span style="color: var(--secondary);">✓</span>
                        <span style="color: var(--muted);">اكتب رسالة مقنعة ومهنية</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <span style="color: var(--secondary);">✓</span>
                        <span style="color: var(--muted);">أظهر أعمالك السابقة المشابهة</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <span style="color: var(--secondary);">✓</span>
                        <span style="color: var(--muted);">كن واقعياً في تحديد المدة</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
