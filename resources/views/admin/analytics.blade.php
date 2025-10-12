@extends('layouts.admin')

@section('title', 'التحليلات والإحصائيات')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Analytics Cards with Real Charts -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="admin-card">
        <h3 class="card-title">📊 نمو المستخدمين (آخر 7 أيام)</h3>
        <div style="height: 250px; padding: 10px;">
            <canvas id="usersChart"></canvas>
        </div>
    </div>

    <div class="admin-card">
        <h3 class="card-title">💰 المشاريع والخدمات</h3>
        <div style="height: 250px; padding: 10px;">
            <canvas id="projectsChart"></canvas>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="admin-card" style="margin-bottom: 30px;">
    <h3 class="card-title">💹 نظرة عامة على النشاط (آخر 30 يوم)</h3>
    <div style="height: 300px; padding: 20px;">
        <canvas id="activityChart"></canvas>
    </div>
</div>

<!-- Detailed Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #3b82f6; margin-bottom: 8px;">
            {{ $stats['total_users'] }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي المستخدمين</div>
        <div style="font-size: 12px; color: #10b981;">
            +{{ $stats['users_this_month'] }} هذا الشهر
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #10b981; margin-bottom: 8px;">
            {{ \App\Models\Project::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي المشاريع</div>
        <div style="font-size: 12px; color: #f59e0b;">
            {{ \App\Models\Project::where('status', 'open')->count() }} مفتوح
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #f59e0b; margin-bottom: 8px;">
            {{ \App\Models\Service::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي الخدمات</div>
        <div style="font-size: 12px; color: #8b5cf6;">
            {{ \App\Models\Service::whereDate('created_at', today())->count() }} جديد اليوم
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #8b5cf6; margin-bottom: 8px;">
            {{ \App\Models\Bid::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">إجمالي العروض</div>
        <div style="font-size: 12px; color: #ef4444;">
            {{ \App\Models\Bid::where('status', 'pending')->count() }} معلق
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #06b6d4; margin-bottom: 8px;">
            {{ \App\Models\Conversation::count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">المحادثات النشطة</div>
        <div style="font-size: 12px; color: #10b981;">
            {{ \App\Models\Message::whereDate('created_at', today())->count() }} رسالة اليوم
        </div>
    </div>

    <div class="admin-card" style="text-align: center; padding: 25px;">
        <div style="font-size: 36px; font-weight: 800; color: #84cc16; margin-bottom: 8px;">
            {{ \App\Models\User::where('role', 'freelancer')->count() }}
        </div>
        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">المحترفين</div>
        <div style="font-size: 12px; color: #3b82f6;">
            {{ \App\Models\User::where('role', 'employer')->count() }} عميل
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">📋 النشاط الأخير</h3>
        <div style="display: flex; gap: 10px;">
            <select style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                <option>آخر 24 ساعة</option>
                <option>آخر أسبوع</option>
                <option>آخر شهر</option>
            </select>
            <button class="btn btn-primary">تحديث</button>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: right; font-weight: 600;">النوع</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">المستخدم</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">التفاصيل</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600;">التوقيت</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\User::latest()->take(10)->get() as $user)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px;">
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                👤 مستخدم جديد
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500; font-size: 13px;">{{ $user->name }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            <div style="font-size: 13px; color: #1e293b;">انضم للمنصة</div>
                            <div style="font-size: 11px; color: #64748b;">
                                دور: {{ $user->role === 'freelancer' ? 'محترف' : 'عميل' }}
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            <div style="font-size: 12px; color: #64748b;">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
// Users Growth Chart (Last 7 days)
const usersCtx = document.getElementById('usersChart').getContext('2d');
const usersChart = new Chart(usersCtx, {
    type: 'line',
    data: {
        labels: [
            @php
                $days = [];
                $userCounts = [];
                for($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $days[] = $date->format('M d');
                    $userCounts[] = \App\Models\User::whereDate('created_at', $date->format('Y-m-d'))->count();
                }
            @endphp
            @foreach($days as $day)
                '{{ $day }}',
            @endforeach
        ],
        datasets: [{
            label: 'مستخدمين جدد',
            data: [{{ implode(',', $userCounts) }}],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Projects vs Services Chart
const projectsCtx = document.getElementById('projectsChart').getContext('2d');
const projectsChart = new Chart(projectsCtx, {
    type: 'doughnut',
    data: {
        labels: ['المشاريع', 'الخدمات', 'العروض'],
        datasets: [{
            data: [
                {{ \App\Models\Project::count() }},
                {{ \App\Models\Service::count() }},
                {{ \App\Models\Bid::count() }}
            ],
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#8b5cf6'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Activity Overview Chart (Last 30 days)
const activityCtx = document.getElementById('activityChart').getContext('2d');
const activityChart = new Chart(activityCtx, {
    type: 'bar',
    data: {
        labels: [
            @php
                $weeks = [];
                $projectData = [];
                $serviceData = [];
                for($i = 3; $i >= 0; $i--) {
                    $startDate = now()->subWeeks($i + 1);
                    $endDate = now()->subWeeks($i);
                    $weeks[] = 'أسبوع ' . ($i + 1);
                    $projectData[] = \App\Models\Project::whereBetween('created_at', [$startDate, $endDate])->count();
                    $serviceData[] = \App\Models\Service::whereBetween('created_at', [$startDate, $endDate])->count();
                }
            @endphp
            @foreach($weeks as $week)
                '{{ $week }}',
            @endforeach
        ],
        datasets: [{
            label: 'مشاريع جديدة',
            data: [{{ implode(',', $projectData) }}],
            backgroundColor: '#10b981',
            borderRadius: 4
        }, {
            label: 'خدمات جديدة',
            data: [{{ implode(',', $serviceData) }}],
            backgroundColor: '#f59e0b',
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Auto refresh charts every 30 seconds
setInterval(() => {
    location.reload();
}, 30000);
</script>
@endsection
