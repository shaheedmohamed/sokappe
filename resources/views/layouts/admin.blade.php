<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة الإدارة') - Sokappe Admin</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #1a202c;
            line-height: 1.6;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
            background: linear-gradient(45deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.7;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 30px;
        }

        .nav-section-title {
            padding: 0 20px 10px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
            color: #94a3b8;
        }

        .nav-item {
            margin: 2px 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(-3px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-icon {
            font-size: 18px;
            margin-left: 12px;
            width: 20px;
            text-align: center;
        }

        .nav-badge {
            margin-right: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-right: 280px;
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
        }

        .user-role {
            font-size: 12px;
            color: #64748b;
        }

        .admin-content {
            padding: 30px;
        }

        /* Cards */
        .admin-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-right: 0;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .admin-content > * {
            animation: slideIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>🛡️ Sokappe</h2>
                <p>لوحة الإدارة</p>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">الرئيسية</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">📊</span>
                            لوحة التحكم
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.analytics') }}" class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                            <span class="nav-icon">📈</span>
                            التحليلات
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">إدارة المستخدمين</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <span class="nav-icon">👥</span>
                            المستخدمين
                            <span class="nav-badge">{{ \App\Models\User::count() }}</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">إدارة المحتوى</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            <span class="nav-icon">📋</span>
                            المشاريع
                            <span class="nav-badge">{{ \App\Models\Project::count() }}</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                            <span class="nav-icon">⚡</span>
                            الخدمات
                            <span class="nav-badge">{{ \App\Models\Service::count() }}</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.bids.index') }}" class="nav-link {{ request()->routeIs('admin.bids.*') ? 'active' : '' }}">
                            <span class="nav-icon">💼</span>
                            العروض
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">المراقبة</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                            <span class="nav-icon">💬</span>
                            الرسائل
                            <span class="nav-badge">{{ \App\Models\Conversation::count() }}</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.conversations.index') }}" class="nav-link {{ request()->routeIs('admin.conversations.*') ? 'active' : '' }}">
                            <span class="nav-icon">🗨️</span>
                            المحادثات القديمة
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <span class="nav-icon">🚨</span>
                            البلاغات
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">الإعدادات</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <span class="nav-icon">⚙️</span>
                            إعدادات النظام
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <span class="nav-icon">🌐</span>
                            عرض الموقع
                        </a>
                    </div>
                    <div class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: right;">
                                <span class="nav-icon">🚪</span>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="admin-header-content">
                    <h1 class="page-title">@yield('title', 'لوحة التحكم')</h1>
                    <div class="admin-user-menu">
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">مدير النظام</div>
                        </div>
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="admin-content">
                @if(session('success'))
                    <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background: #fef2f2; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            document.querySelector('.admin-sidebar').classList.toggle('open');
        }

        // Auto-refresh badges
        setInterval(() => {
            // You can add AJAX calls here to update badges
        }, 30000);
    </script>
</body>
</html>
