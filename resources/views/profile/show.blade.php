@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Profile Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 40px; margin-bottom: 30px; color: white; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 30px; position: relative; z-index: 2;">
            <img src="{{ $user->avatar_url }}" 
                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">
            <div style="flex: 1;">
                <h1 style="margin: 0 0 10px; font-size: 32px; font-weight: 700;">{{ $user->name }}</h1>
                @if($user->profile && $user->profile->title)
                    <p style="margin: 0 0 15px; font-size: 18px; opacity: 0.9;">{{ $user->profile->title }}</p>
                @endif
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 15px;">
                    @if($user->ratings_count > 0)
                        <div style="display: flex; align-items: center; gap: 5px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color: {{ $i <= $user->average_rating ? '#fbbf24' : 'rgba(255,255,255,0.3)' }}; font-size: 18px;">★</span>
                            @endfor
                            <span style="margin-right: 8px; font-weight: 600;">{{ number_format($user->average_rating, 1) }}</span>
                            <span style="opacity: 0.8;">({{ $user->ratings_count }} تقييم)</span>
                        </div>
                    @else
                        <span style="opacity: 0.8;">لم يتم التقييم بعد</span>
                    @endif
                    
                    @if($user->profile && $user->profile->location)
                        <div style="display: flex; align-items: center; gap: 5px; opacity: 0.9;">
                            <span>📍</span>
                            <span>{{ $user->profile->location }}</span>
                        </div>
                    @endif
                </div>
                
                @if($user->profile && $user->profile->available_for_hire)
                    <div style="display: inline-block; background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.3);">
                        ✅ متاح للتوظيف
                    </div>
                @endif
            </div>
            
            @if($user->profile && $user->profile->hourly_rate)
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 24px; font-weight: 700; margin-bottom: 5px;">${{ number_format($user->profile->hourly_rate, 0) }}</div>
                    <div style="font-size: 14px; opacity: 0.8;">السعر بالساعة</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div style="background: white; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
            <!-- Tabs -->
            <div style="display: flex;">
                <button class="tab-btn active" onclick="showTab('overview')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid #3b82f6;">
                    📊 نظرة عامة
                </button>
                <button class="tab-btn" onclick="showTab('portfolio')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent;">
                    🎨 معرض الأعمال ({{ $user->portfolios->count() }})
                </button>
                <button class="tab-btn" onclick="showTab('projects')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent;">
                    📋 المشاريع ({{ $user->projects->count() }})
                </button>
                <button class="tab-btn" onclick="showTab('ratings')" style="padding: 16px 24px; border: none; background: transparent; color: #64748b; cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent;">
                    ⭐ التقييمات ({{ $user->ratings_count }})
                </button>
            </div>
            
            <!-- Action Buttons -->
            @auth
                @if(Auth::id() === $user->id)
                    <div style="display: flex; gap: 10px; padding: 16px 24px;">
                        <!-- Edit Profile Button (Always visible) -->
                        <a href="{{ route('profile.edit-advanced') }}" 
                           style="padding: 8px 16px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                            ✏️ تعديل الملف الشخصي
                        </a>
                        
                        <!-- Add Work Button (Only visible on portfolio tab) -->
                        <a href="{{ route('portfolio.create') }}" id="addWorkBtn"
                           style="padding: 8px 16px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; display: none; align-items: center; gap: 6px;">
                            ➕ إضافة عمل
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <!-- Main Content -->
        <div>
            <!-- Overview Tab -->
            <div id="overview-tab" class="tab-content">
                <!-- Bio -->
                @if($user->profile && $user->profile->bio)
                    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                            👤 نبذة تعريفية
                        </h2>
                        <p style="margin: 0; color: #374151; line-height: 1.7; font-size: 15px;">{{ $user->profile->bio }}</p>
                    </div>
                @endif

                <!-- Experience -->
                @if($user->profile && $user->profile->experience)
                    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                            💼 الخبرة والإنجازات
                        </h2>
                        <div style="color: #374151; line-height: 1.7; font-size: 15px; white-space: pre-line;">{{ $user->profile->experience }}</div>
                    </div>
                @endif

                <!-- Skills -->
                @if($user->skills->count() > 0)
                    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                            🛠️ المهارات
                        </h2>
                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                            @foreach($user->skills as $skill)
                                @php
                                    $colors = [
                                        'beginner' => '#94a3b8',
                                        'intermediate' => '#3b82f6', 
                                        'advanced' => '#10b981',
                                        'expert' => '#f59e0b'
                                    ];
                                    $labels = [
                                        'beginner' => 'مبتدئ',
                                        'intermediate' => 'متوسط',
                                        'advanced' => 'متقدم', 
                                        'expert' => 'خبير'
                                    ];
                                    $color = $colors[$skill->proficiency] ?? '#64748b';
                                    $label = $labels[$skill->proficiency] ?? 'غير محدد';
                                @endphp
                                <div style="background: {{ $color }}20; color: {{ $color }}; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500; border: 1px solid {{ $color }}40;">
                                    {{ $skill->skill_name }} - {{ $label }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Projects Tab -->
            <div id="projects-tab" class="tab-content" style="display: none;">
                @if($user->projects->count() > 0)
                    @foreach($user->projects as $project)
                        <!-- Project Header -->
                        <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-left: 4px solid {{ $project->status === 'open' ? '#10b981' : ($project->status === 'in_progress' ? '#f59e0b' : '#6b7280') }};">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                                <div style="flex: 1;">
                                    <h3 style="margin: 0 0 8px; color: #1e293b; font-size: 18px;">
                                        <a href="{{ route('projects.show', $project) }}" style="color: #3b82f6; text-decoration: none;">
                                            {{ $project->title }}
                                        </a>
                                    </h3>
                                    <p style="margin: 0 0 12px; color: #64748b; line-height: 1.6;">
                                        {{ Str::limit($project->description, 150) }}
                                    </p>
                                    
                                    <!-- Project Meta -->
                                    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                                        <div style="display: flex; align-items: center; gap: 5px; color: #64748b; font-size: 13px;">
                                            <span>💰</span>
                                            <span>${{ number_format($project->budget_min, 2) }} - ${{ number_format($project->budget_max, 2) }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 5px; color: #64748b; font-size: 13px;">
                                            <span>📅</span>
                                            <span>{{ $project->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 5px; color: #64748b; font-size: 13px;">
                                            <span>📊</span>
                                            <span>{{ $project->bids->count() }} عرض</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div style="margin-right: 15px;">
                                    @if($project->status === 'open')
                                        <span style="background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            🟢 مفتوح
                                        </span>
                                    @elseif($project->status === 'in_progress')
                                        <span style="background: #fef3c7; color: #92400e; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            🟡 قيد التنفيذ
                                        </span>
                                    @else
                                        <span style="background: #f3f4f6; color: #4b5563; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            ⚫ مكتمل
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            @if(Auth::id() === $project->user_id)
                                <div style="display: flex; gap: 8px; margin-bottom: 15px; flex-wrap: wrap;">
                                    <a href="{{ route('projects.show', $project) }}" 
                                       style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;">
                                        👁️ عرض المشروع
                                    </a>
                                    @if($project->status === 'open')
                                        <a href="{{ route('projects.edit', $project) }}" 
                                           style="background: #f59e0b; color: white; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;">
                                            ✏️ تعديل
                                        </a>
                                    @endif
                                    
                                    <!-- Status Change Dropdown -->
                                    <div style="position: relative; display: inline-block;">
                                        <button onclick="toggleStatusMenu{{ $project->id }}()" 
                                                style="background: #6b7280; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                            ⚙️ تغيير الحالة
                                            <span style="font-size: 10px;">▼</span>
                                        </button>
                                        <div id="statusMenu{{ $project->id }}" style="display: none; position: absolute; top: 100%; left: 0; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 160px; z-index: 1000; margin-top: 4px;">
                                            @php
                                                $statusOptions = [
                                                    'open' => ['label' => '🟢 مفتوح', 'color' => '#10b981'],
                                                    'in_progress' => ['label' => '🟡 قيد التنفيذ', 'color' => '#f59e0b'],
                                                    'completed' => ['label' => '✅ مكتمل', 'color' => '#6b7280'],
                                                    'cancelled' => ['label' => '❌ ملغي', 'color' => '#ef4444'],
                                                ];
                                            @endphp
                                            @foreach($statusOptions as $status => $config)
                                                @if($status !== $project->status)
                                                    <form method="POST" action="{{ route('projects.update-status', $project) }}" style="margin: 0;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $status }}">
                                                        <button type="submit" 
                                                                style="width: 100%; text-align: right; padding: 8px 12px; background: none; border: none; color: #374151; cursor: pointer; font-size: 12px; border-bottom: 1px solid #f3f4f6;"
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
                                </div>
                            @endif
                        </div>

                        <!-- Project Bids (Each bid in separate row) -->
                        @if($project->bids->count() > 0)
                            @foreach($project->bids as $bid)
                                <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <!-- Freelancer Info -->
                                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                                            <img src="{{ $bid->freelancer->avatar_url }}" 
                                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                            <div>
                                                <div style="font-weight: 600; color: #1e293b; font-size: 16px; margin-bottom: 2px;">
                                                    <a href="{{ route('profile.show', $bid->freelancer) }}" style="color: #3b82f6; text-decoration: none;">
                                                        {{ $bid->freelancer->name }}
                                                    </a>
                                                </div>
                                                @if($bid->freelancer->profile && $bid->freelancer->profile->title)
                                                    <div style="color: #64748b; font-size: 13px;">{{ $bid->freelancer->profile->title }}</div>
                                                @endif
                                                @if($bid->freelancer->ratings_count > 0)
                                                    <div style="display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <span style="color: {{ $i <= $bid->freelancer->average_rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 12px;">★</span>
                                                        @endfor
                                                        <span style="color: #64748b; font-size: 11px; margin-right: 4px;">
                                                            ({{ $bid->freelancer->ratings_count }})
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Bid Details -->
                                        <div style="text-align: center; margin: 0 20px;">
                                            <div style="color: #10b981; font-weight: 700; font-size: 20px; margin-bottom: 4px;">
                                                ${{ number_format($bid->amount, 2) }}
                                            </div>
                                            <div style="color: #64748b; font-size: 12px;">
                                                {{ $bid->delivery_time }} أيام
                                            </div>
                                            <div style="color: #94a3b8; font-size: 11px; margin-top: 4px;">
                                                {{ $bid->created_at->diffForHumans() }}
                                            </div>
                                        </div>

                                        <!-- Status & Actions -->
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <!-- Status Badge -->
                                            @if($bid->status === 'pending')
                                                <span style="background: #fef3c7; color: #92400e; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                    ⏳ قيد الانتظار
                                                </span>
                                            @elseif($bid->status === 'accepted')
                                                <span style="background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                    ✅ مقبول
                                                </span>
                                            @else
                                                <span style="background: #fee2e2; color: #dc2626; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                    ❌ مرفوض
                                                </span>
                                            @endif

                                            <!-- Action Buttons -->
                                            @if(Auth::id() === $project->user_id)
                                                <div style="display: flex; gap: 6px;">
                                                    @if($bid->status === 'pending' && $project->status === 'open')
                                                        <form action="{{ route('bids.accept', $bid) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" 
                                                                    style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;"
                                                                    onclick="return confirm('هل أنت متأكد من قبول هذا العرض؟')">
                                                                ✅ قبول
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('bids.reject', $bid) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" 
                                                                    style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;"
                                                                    onclick="return confirm('هل أنت متأكد من رفض هذا العرض؟')">
                                                                ❌ رفض
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('messages.start-from-bid', $bid) }}" 
                                                       style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;">
                                                        💬 مراسلة
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bid Message -->
                                    @if($bid->message)
                                        <div style="margin-top: 15px; padding: 12px; background: #f8fafc; border-radius: 8px; border-right: 3px solid #3b82f6;">
                                            <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">رسالة العرض:</div>
                                            <div style="color: #374151; font-size: 14px; line-height: 1.5;">
                                                {{ $bid->message }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 40px; background: #f8fafc; border-radius: 8px; color: #64748b; margin-bottom: 20px;">
                                <span style="font-size: 32px; margin-bottom: 12px; display: block;">📭</span>
                                <span style="font-size: 16px;">لم يتم تقديم أي عروض على هذا المشروع</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.5;">📋</div>
                        <h3 style="margin: 0 0 12px; color: #1e293b; font-size: 24px;">لا توجد مشاريع</h3>
                        <p style="margin: 0 0 24px; color: #64748b; font-size: 16px;">
                            لم يتم إنشاء أي مشاريع بعد
                        </p>
                        
                        @auth
                            @if(Auth::id() === $user->id)
                                <a href="{{ route('projects.create') }}" 
                                   style="display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                                    ➕ إنشاء مشروع جديد
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Portfolio Tab -->
            <div id="portfolio-tab" class="tab-content" style="display: none;">
                @if($user->portfolios->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                        @foreach($user->portfolios as $portfolio)
                            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <img src="{{ $portfolio->main_image }}" 
                                     style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px;">
                                    <h3 style="margin: 0 0 10px; color: #1e293b; font-size: 16px;">{{ $portfolio->title }}</h3>
                                    <p style="margin: 0 0 15px; color: #64748b; font-size: 13px;">{{ Str::limit($portfolio->description, 100) }}</p>
                                    
                                    @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 15px;">
                                            @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                                                <span style="background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 8px; font-size: 10px;">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div style="display: flex; gap: 8px;">
                                        @if($portfolio->project_url)
                                            <a href="{{ $portfolio->project_url }}" target="_blank" 
                                               style="padding: 6px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 11px;">
                                                👁️ عرض المشروع
                                            </a>
                                        @endif
                                        @if($portfolio->github_url)
                                            <a href="{{ $portfolio->github_url }}" target="_blank" 
                                               style="padding: 6px 12px; background: #1f2937; color: white; text-decoration: none; border-radius: 6px; font-size: 11px;">
                                                💻 GitHub
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div style="font-size: 48px; margin-bottom: 15px;">🎨</div>
                        <h3 style="margin: 0 0 10px; color: #1e293b;">لا توجد أعمال</h3>
                        <p style="margin: 0; color: #64748b;">لم يتم إضافة أي أعمال إلى معرض الأعمال بعد</p>
                    </div>
                @endif
            </div>

            <!-- Ratings Tab -->
            <div id="ratings-tab" class="tab-content" style="display: none;">
                @if($user->ratings->count() > 0)
                    @foreach($user->ratings as $rating)
                        <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                                <img src="{{ $rating->client->avatar_url }}" 
                                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                <div>
                                    <h4 style="margin: 0 0 3px; color: #1e293b; font-size: 16px;">{{ $rating->client->name }}</h4>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="display: flex; align-items: center; gap: 2px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span style="color: {{ $i <= $rating->overall_rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 14px;">★</span>
                                            @endfor
                                            <span style="font-weight: 600; color: #1e293b; margin-left: 5px; font-size: 14px;">{{ $rating->overall_rating }}</span>
                                        </div>
                                        <span style="color: #64748b; font-size: 12px;">{{ $rating->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($rating->review)
                                <div style="color: #374151; line-height: 1.6; margin-bottom: 15px;">
                                    "{{ $rating->review }}"
                                </div>
                            @endif

                            <div style="background: #f8fafc; padding: 12px; border-radius: 8px;">
                                <span style="color: #64748b; font-size: 12px;">المشروع:</span>
                                <span style="color: #3b82f6; font-weight: 500; margin-right: 5px;">{{ $rating->project->title }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 60px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div style="font-size: 48px; margin-bottom: 15px;">⭐</div>
                        <h3 style="margin: 0 0 10px; color: #1e293b;">لم يتم التقييم بعد</h3>
                        <p style="margin: 0; color: #64748b;">لا توجد تقييمات لهذا المحترف حتى الآن</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Contact Info -->
            <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">📞 معلومات التواصل</h3>
                
                @if($user->profile && $user->profile->phone)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: #64748b;">📱</span>
                        <span style="color: #374151;">{{ $user->profile->phone }}</span>
                    </div>
                @endif
                
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="color: #64748b;">✉️</span>
                    <span style="color: #374151;">{{ $user->email }}</span>
                </div>
                
                @if($user->profile && $user->profile->website)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: #64748b;">🌐</span>
                        <a href="{{ $user->profile->website }}" target="_blank" style="color: #3b82f6; text-decoration: none;">الموقع الشخصي</a>
                    </div>
                @endif
                
                @if($user->profile && $user->profile->linkedin)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: #64748b;">💼</span>
                        <a href="{{ $user->profile->linkedin }}" target="_blank" style="color: #3b82f6; text-decoration: none;">LinkedIn</a>
                    </div>
                @endif
                
                @if($user->profile && $user->profile->github)
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="color: #64748b;">💻</span>
                        <a href="{{ $user->profile->github }}" target="_blank" style="color: #3b82f6; text-decoration: none;">GitHub</a>
                    </div>
                @endif
            </div>

            <!-- Languages -->
            @if($user->profile && $user->profile->languages && count($user->profile->languages) > 0)
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 18px;">🌍 اللغات</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($user->profile->languages as $language)
                            <span style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 16px; font-size: 13px;">
                                {{ $language }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 18px;">⚡ إجراءات سريعة</h3>
                
                @auth
                    @if(Auth::id() === $user->id)
                        <!-- Owner Actions -->
                        <a href="{{ route('profile.edit-advanced') }}" 
                           style="display: block; width: 100%; padding: 12px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                            ✏️ تعديل الملف الشخصي
                        </a>
                        
                        <a href="{{ route('portfolio.create') }}" 
                           style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                            ➕ إضافة عمل جديد
                        </a>
                        
                        <a href="{{ route('portfolio.index') }}" 
                           style="display: block; width: 100%; padding: 12px; background: #8b5cf6; color: white; text-decoration: none; border-radius: 6px; text-align: center; margin-bottom: 10px;">
                            🎨 إدارة معرض الأعمال
                        </a>
                    @else
                        <!-- Visitor Actions -->
                        <button onclick="showTab('ratings')" 
                                style="display: block; width: 100%; padding: 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                            ⭐ التقييمات ({{ $user->ratings_count }})
                        </button>
                        
                        <button onclick="showTab('portfolio')" 
                                style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                            🎨 معرض الأعمال ({{ $user->portfolios->count() }})
                        </button>
                        
                        <button style="width: 100%; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer;">
                            💬 إرسال رسالة
                        </button>
                    @endif
                @else
                    <!-- Guest Actions -->
                    <button onclick="showTab('ratings')" 
                            style="display: block; width: 100%; padding: 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                        ⭐ التقييمات ({{ $user->ratings_count }})
                    </button>
                    
                    <button onclick="showTab('portfolio')" 
                            style="display: block; width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; text-align: center; margin-bottom: 10px; cursor: pointer;">
                        🎨 معرض الأعمال ({{ $user->portfolios->count() }})
                    </button>
                    
                    <a href="{{ route('login') }}" 
                       style="display: block; width: 100%; padding: 12px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; text-align: center;">
                        🔑 تسجيل الدخول للتواصل
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.style.color = '#64748b';
            btn.style.borderBottomColor = 'transparent';
        });
        
        // Show selected tab
        document.getElementById(tabName + '-tab').style.display = 'block';
        
        // Add active class to clicked button
        event.target.style.color = '#3b82f6';
        event.target.style.borderBottomColor = '#3b82f6';
    }

    // Status menu functions for each project
    @if($user->projects->count() > 0)
        @foreach($user->projects as $project)
            window['toggleStatusMenu{{ $project->id }}'] = function() {
                const menu = document.getElementById('statusMenu{{ $project->id }}');
                if (menu) {
                    // Close all other menus first
                    document.querySelectorAll('[id^="statusMenu"]').forEach(m => {
                        if (m.id !== 'statusMenu{{ $project->id }}') {
                            m.style.display = 'none';
                        }
                    });
                    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                }
            };
        @endforeach
    @endif

    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
        const clickedButton = event.target.closest('button[onclick^="toggleStatusMenu"]');
        if (!clickedButton) {
            document.querySelectorAll('[id^="statusMenu"]').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
</script>
@endsection
