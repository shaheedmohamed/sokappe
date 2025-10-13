@extends('layouts.app')

@section('content')
<div class="container-full" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 50px 40px; margin-bottom: 40px; color: white; text-align: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');"></div>
        
        <div style="position: relative; z-index: 2;">
            <h1 style="margin: 0 0 16px; font-size: 36px; font-weight: 800;">
                📋 تصفح المشاريع
            </h1>
            <p style="margin: 0 0 24px; font-size: 18px; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                اكتشف مشاريع جديدة وقدم عروضك للعملاء
            </p>
            
            @auth
                <a href="{{ route('projects.create.new') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 14px 28px; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='white'; this.style.color='var(--primary)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white'">
                    ✍️ أنشئ مشروع جديد
                </a>
            @endauth
        </div>
    </div>

    <!-- Main Content with Sidebar -->
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px; align-items: start;">
        
        <!-- Sidebar Filters -->
        <div class="card" style="padding: 24px; position: sticky; top: 100px;">
            <h3 style="margin: 0 0 20px; color: var(--dark); font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                🔍 فلترة المشاريع
            </h3>
            
            <!-- Search -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark); font-size: 14px;">البحث</label>
                <input type="text" id="searchInput" placeholder="ابحث في المشاريع..." style="width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; font-size: 14px; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
            </div>
            
            <!-- Categories -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 12px; font-weight: 600; color: var(--dark); font-size: 14px;">التخصص</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="" checked style="margin: 0;">
                        <span style="font-size: 13px;">جميع التخصصات</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="تطوير وبرمجة" style="margin: 0;">
                        <span style="font-size: 13px;">💻 تطوير وبرمجة</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="تصميم وجرافيك" style="margin: 0;">
                        <span style="font-size: 13px;">🎨 تصميم وجرافيك</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="كتابة وترجمة" style="margin: 0;">
                        <span style="font-size: 13px;">📝 كتابة وترجمة</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="تسويق رقمي" style="margin: 0;">
                        <span style="font-size: 13px;">📈 تسويق رقمي</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="صوتيات ومرئيات" style="margin: 0;">
                        <span style="font-size: 13px;">🎬 صوتيات ومرئيات</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="category" value="أعمال وخدمات استشارية" style="margin: 0;">
                        <span style="font-size: 13px;">💼 أعمال واستشارات</span>
                    </label>
                </div>
            </div>
            
            <!-- Budget Range -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 12px; font-weight: 600; color: var(--dark); font-size: 14px;">الميزانية</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="budget" value="" checked style="margin: 0;">
                        <span style="font-size: 13px;">جميع الميزانيات</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="budget" value="0-25" style="margin: 0;">
                        <span style="font-size: 13px;">💵 أقل من $25</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="budget" value="25-100" style="margin: 0;">
                        <span style="font-size: 13px;">💰 $25 - $100</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="budget" value="100-500" style="margin: 0;">
                        <span style="font-size: 13px;">💎 $100 - $500</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="budget" value="500+" style="margin: 0;">
                        <span style="font-size: 13px;">🏆 أكثر من $500</span>
                    </label>
                </div>
            </div>
            
            <!-- Apply Filters Button -->
            <button onclick="applyFilters()" style="width: 100%; background: linear-gradient(135deg, var(--primary), #8b5cf6); color: white; border: none; padding: 14px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 14px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                🔍 تطبيق الفلاتر
            </button>
            
            <!-- Clear Filters -->
            <button onclick="clearFilters()" style="width: 100%; background: transparent; color: var(--muted); border: 1px solid var(--border); padding: 12px 20px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s; font-size: 13px; margin-top: 8px;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--muted)'">
                🗑️ مسح الفلاتر
            </button>
        </div>
        
        <!-- Main Content -->
        <div>

    <!-- Stats Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div style="background: linear-gradient(135deg, #fef3c7, #fbbf24); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 28px; font-weight: 800; color: #92400e; margin-bottom: 4px;">{{ $projects->total() }}</div>
            <div style="color: #92400e; font-size: 14px; font-weight: 600;">مشروع متاح</div>
        </div>
        <div style="background: linear-gradient(135deg, #dbeafe, #3b82f6); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(150, 300) }}</div>
            <div style="font-size: 14px; font-weight: 600;">مستقل نشط</div>
        </div>
        <div style="background: linear-gradient(135deg, #dcfce7, #10b981); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(50, 100) }}</div>
            <div style="font-size: 14px; font-weight: 600;">مشروع مكتمل اليوم</div>
        </div>
        <div style="background: linear-gradient(135deg, #fce7f3, #ec4899); padding: 20px; border-radius: 12px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ rand(20, 50) }}</div>
            <div style="font-size: 14px; font-weight: 600;">عرض جديد اليوم</div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div id="projectsGrid" style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 40px;">
        @forelse($projects as $project)
            <div class="card" style="transition: all 0.3s; border: 2px solid transparent; position: relative; padding: 24px;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgb(0 0 0 / 0.1)'">
                <!-- Project Header -->
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start; margin-bottom: 20px;">
                    <div>
                        <h3 style="margin: 0 0 12px; color: var(--dark); font-size: 20px; line-height: 1.4; font-weight: 700;">
                            <a href="{{ route('projects.bid.create', $project) }}" style="color: inherit; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">
                                {{ $project->title }}
                            </a>
                        </h3>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                            <span style="background: linear-gradient(135deg, var(--secondary), #059669); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);">
                                🆕 جديد
                            </span>
                            <span style="color: var(--muted); font-size: 14px; display: flex; align-items: center; gap: 4px;">
                                🕒 {{ $project->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div style="text-align: center; padding: 16px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 16px; border: 2px solid rgba(59, 130, 246, 0.1);">
                        <div style="font-size: 22px; font-weight: 800; color: var(--primary); margin-bottom: 4px;">
                            {{ $project->budget_min }} - {{ $project->budget_max }} ج
                        </div>
                        <div style="font-size: 12px; color: var(--muted); font-weight: 600;">💰 الميزانية المطلوبة</div>
                    </div>
                </div>

                <!-- Project Description -->
                <div style="background: #f8fafc; padding: 16px; border-radius: 12px; margin-bottom: 20px; border-right: 4px solid var(--primary);">
                    <p style="margin: 0; color: var(--dark); line-height: 1.7; font-size: 16px;">
                        {{ Str::limit($project->description, 200) }}
                    </p>
                </div>

                <!-- Project Skills -->
                @if($project->skills && !empty(trim($project->skills)))
                    <div style="margin-bottom: 20px;">
                        <h4 style="margin: 0 0 10px; color: var(--dark); font-size: 14px; font-weight: 600;">🛠️ المهارات المطلوبة:</h4>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @php
                                $skillsArray = array_filter(array_map('trim', explode(',', $project->skills)), function($skill) {
                                    return !empty($skill);
                                });
                            @endphp
                            @foreach(array_slice($skillsArray, 0, 6) as $skill)
                                @if(!empty($skill))
                                    <span style="background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0369a1; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid rgba(3, 105, 161, 0.2);">
                                        {{ $skill }}
                                    </span>
                                @endif
                            @endforeach
                            @if(count($skillsArray) > 6)
                                <span style="background: #f1f5f9; color: var(--muted); padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    +{{ count($skillsArray) - 6 }} أخرى
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Project Meta -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 20px;">
                    <div style="text-align: center; padding: 16px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 12px;">
                        <div style="font-size: 24px; font-weight: 800; color: #92400e; margin-bottom: 4px;">{{ $project->bids_count ?? rand(0, 15) }}</div>
                        <div style="color: #92400e; font-size: 12px; font-weight: 600;">📝 عرض مقدم</div>
                    </div>
                    <div style="text-align: center; padding: 16px; background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-radius: 12px;">
                        <div style="font-size: 16px; font-weight: 700; color: #166534; margin-bottom: 4px;">{{ $project->duration ?? 'مرن' }}</div>
                        <div style="color: #166534; font-size: 12px; font-weight: 600;">⏱️ المدة المطلوبة</div>
                    </div>
                </div>

                <!-- Client Info (Name Only) -->
                <div style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); padding: 16px; border-radius: 12px; margin-bottom: 20px; text-align: center;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                            {{ $project->user ? substr($project->user->name, 0, 1) : 'U' }}
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">{{ $project->user->name ?? 'مستخدم غير معروف' }}</div>
                            <div style="font-size: 12px; color: var(--muted);">صاحب المشروع</div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div style="display: flex; gap: 12px;">
                    @auth
                        <a href="{{ route('projects.bid.create', $project) }}" class="btn btn-primary" style="flex: 1; text-decoration: none; text-align: center; font-size: 16px; font-weight: 700; padding: 16px 24px; background: linear-gradient(135deg, var(--primary), #8b5cf6); border-radius: 12px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.3)'">
                            💼 قدّم عرضك الآن
                        </a>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-outline" style="padding: 16px 20px; text-decoration: none; border-radius: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            👁️ عرض التفاصيل
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="flex: 1; text-decoration: none; text-align: center; font-size: 16px; font-weight: 700; padding: 16px 24px; background: linear-gradient(135deg, var(--primary), #8b5cf6); border-radius: 12px;">
                            🚀 سجل دخولك لتقديم عرض
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: var(--muted);">
                <div style="font-size: 64px; margin-bottom: 24px;">📋</div>
                <h3 style="margin: 0 0 12px; color: var(--dark);">لا توجد مشاريع متاحة حالياً</h3>
                <p style="margin: 0 0 24px; font-size: 16px;">كن أول من ينشر مشروع جديد!</p>
                @auth
                    <a href="{{ route('projects.create.new') }}" class="btn btn-primary" style="text-decoration: none;">
                        ✍️ أنشئ مشروع جديد
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $projects->links() }}
        </div>
    @endif

    <!-- Call to Action -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 40px; margin-top: 40px; text-align: center; color: white;">
        <h2 style="margin: 0 0 16px; font-size: 28px; font-weight: 800;">
            هل لديك مشروع؟
        </h2>
        <p style="margin: 0 0 24px; font-size: 16px; opacity: 0.9;">
            انشر مشروعك واحصل على عروض من أفضل المستقلين في الوطن العربي
        </p>
        @auth
            <a href="{{ route('projects.create') }}" class="btn" style="background: white; color: var(--primary); padding: 16px 32px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                ✍️ انشر مشروعك الآن
            </a>
        @else
            <a href="{{ route('register') }}" class="btn" style="background: white; color: var(--primary); padding: 16px 32px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px -5px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                🚀 انضم الآن
            </a>
        @endauth
    </div>
        </div> <!-- End Main Content -->
    </div> <!-- End Grid Container -->
</div>

<script>
// Filter functionality
function applyFilters() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const selectedCategories = Array.from(document.querySelectorAll('input[name="category"]:checked')).map(cb => cb.value);
    const selectedBudgets = Array.from(document.querySelectorAll('input[name="budget"]:checked')).map(cb => cb.value);
    
    const projects = document.querySelectorAll('#projectsGrid > div');
    
    projects.forEach(project => {
        const title = project.querySelector('h3').textContent.toLowerCase();
        const description = project.querySelector('p').textContent.toLowerCase();
        
        // Search filter
        const matchesSearch = searchTerm === '' || title.includes(searchTerm) || description.includes(searchTerm);
        
        // Category filter (simplified - in real app you'd check project category)
        const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes('');
        
        // Budget filter (simplified - in real app you'd check actual budget)
        const matchesBudget = selectedBudgets.length === 0 || selectedBudgets.includes('');
        
        if (matchesSearch && matchesCategory && matchesBudget) {
            project.style.display = 'block';
            project.style.animation = 'fadeInUp 0.5s ease-out';
        } else {
            project.style.display = 'none';
        }
    });
    
    // Show notification
    showNotification('تم تطبيق الفلاتر بنجاح!', 'success');
}

function clearFilters() {
    // Clear search
    document.getElementById('searchInput').value = '';
    
    // Uncheck all filters except "all" options
    document.querySelectorAll('input[name="category"]').forEach(cb => {
        cb.checked = cb.value === '';
    });
    document.querySelectorAll('input[name="budget"]').forEach(cb => {
        cb.checked = cb.value === '';
    });
    
    // Show all projects
    document.querySelectorAll('#projectsGrid > div').forEach(project => {
        project.style.display = 'block';
    });
    
    showNotification('تم مسح جميع الفلاتر', 'info');
}

// Handle checkbox groups (only one can be selected)
document.querySelectorAll('input[name="category"]').forEach(cb => {
    cb.addEventListener('change', function() {
        if (this.checked) {
            document.querySelectorAll('input[name="category"]').forEach(other => {
                if (other !== this) other.checked = false;
            });
        }
    });
});

document.querySelectorAll('input[name="budget"]').forEach(cb => {
    cb.addEventListener('change', function() {
        if (this.checked) {
            document.querySelectorAll('input[name="budget"]').forEach(other => {
                if (other !== this) other.checked = false;
            });
        }
    });
});

// Search on enter key
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        applyFilters();
    }
});

// Auto-apply filters on search input
document.getElementById('searchInput').addEventListener('input', function() {
    setTimeout(applyFilters, 300); // Debounce
});

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #3b82f6, #1d4ed8)'};
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideInRight 0.5s ease-out;
            max-width: 300px;
        ">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 18px;">${type === 'success' ? '✅' : 'ℹ️'}</span>
                <span style="font-weight: 600;">${message}</span>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.5s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(100px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideOutRight {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(100px); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive design */
@media (max-width: 768px) {
    .container-full > div:first-child {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
    
    .card[style*="position: sticky"] {
        position: relative !important;
        top: auto !important;
    }
}
`;

document.head.appendChild(style);

console.log('🔍 Project Filters Loaded Successfully!');
</script>

@endsection
