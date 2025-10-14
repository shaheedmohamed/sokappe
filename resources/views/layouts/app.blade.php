<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sokappe</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root { 
                --bg:#f8fafc; --card:#fff; --text:#1e293b; --muted:#64748b; 
                --primary:#0ea5e9; --secondary:#10b981; --accent:#f59e0b;
                --dark:#0f172a; --border:#e2e8f0; --shadow:0 4px 6px -1px rgb(0 0 0 / 0.1);
            }
            * { box-sizing: border-box; }
            body { margin:0; font-family: 'Inter', 'Segoe UI', Tahoma, Arial, sans-serif; background:var(--bg); color:var(--text); line-height:1.6; }
            a { color: var(--primary); text-decoration: none; transition: all 0.2s; }
            a:hover { color: var(--secondary); }
            .container { width:100%; margin-inline:auto; padding: 0 0px; }
            .container-full { width:100%; padding: 0; }
            
            /* Navigation */
            .navbar { background:#fff; border-bottom:1px solid var(--border); box-shadow: var(--shadow); position: sticky; top: 0; z-index: 100; }
            .nav-inner { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; max-width: 1200px; margin: 0 auto; }
            .brand { font-weight:800; font-size:24px; color:var(--primary); }
            .nav-links { display:flex; gap:20px; align-items:center; }
            .nav-links a { font-weight: 500; }
            
            /* Buttons */
            .btn { display:inline-block; padding:12px 24px; border:2px solid transparent; background:#fff; color:var(--text); border-radius:8px; cursor:pointer; font-weight:600; transition: all 0.3s; text-decoration: none; }
            .btn:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
            .btn.primary { background:linear-gradient(135deg, var(--primary), var(--secondary)); color:#fff; }
            .btn.secondary { background:var(--secondary); color:#fff; }
            .btn.outline { border-color: var(--primary); color: var(--primary); }
            .btn.block { display:block; width:100%; text-align:center; }
            
            /* Hero Section */
            .hero { 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white; text-align:center; padding:80px 0; position: relative; overflow: hidden;
            }
            .hero::before { content:''; position:absolute; top:0; left:0; right:0; bottom:0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>'); }
            .hero-content { position: relative; z-index: 2; }
            .hero h1 { margin:0 0 16px; font-size:48px; font-weight:800; }
            .hero p { margin:0 0 32px; font-size:20px; opacity:0.9; max-width: 600px; margin-inline: auto; }
            .hero-buttons { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; }
            
            /* Features Grid */
            .features { padding:80px 0; }
            .features-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:32px; margin-top: 48px; width: 100%; }
            .feature-card { 
                background:var(--card); border:1px solid var(--border); border-radius:16px; padding:32px; 
                text-align:center; transition: all 0.3s; position: relative; overflow: hidden;
            }
            .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1); }
            .feature-icon { width:64px; height:64px; margin:0 auto 24px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:28px; }
            .feature-card:nth-child(1) .feature-icon { background:linear-gradient(135deg, #667eea, #764ba2); color:white; }
            .feature-card:nth-child(2) .feature-icon { background:linear-gradient(135deg, #f093fb, #f5576c); color:white; }
            .feature-card:nth-child(3) .feature-icon { background:linear-gradient(135deg, #4facfe, #00f2fe); color:white; }
            .feature-card:nth-child(4) .feature-icon { background:linear-gradient(135deg, #43e97b, #38f9d7); color:white; }
            .feature-card h3 { margin:0 0 16px; font-size:24px; color:var(--dark); }
            .feature-card p { color:var(--muted); }
            
            /* Tabs & Content */
            .section { padding:60px 0; }
            .section-title { text-align:center; margin-bottom:48px; }
            .section-title h2 { font-size:36px; margin:0 0 16px; color:var(--dark); }
            .section-title p { font-size:18px; color:var(--muted); }
            .tabs { display:flex; gap:8px; border-bottom:2px solid var(--border); margin-bottom:32px; }
            .tab { padding:16px 24px; border:none; background:transparent; color:var(--muted); cursor:pointer; font-weight:600; border-bottom:3px solid transparent; transition: all 0.3s; }
            .tab.active { color:var(--primary); border-bottom-color:var(--primary); }
            .tab:hover { color:var(--primary); }
            
            /* Cards Grid */
            .grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:24px; width: 100%; }
            .card { 
                background:var(--card); border:1px solid var(--border); border-radius:12px; padding:24px; 
                transition: all 0.3s; position: relative; overflow: hidden;
            }
            .card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -3px rgb(0 0 0 / 0.1); }
            .card h3 { margin:0 0 12px; font-size:20px; color:var(--dark); }
            .card .meta { color:var(--muted); font-size:14px; margin-bottom:12px; }
            .card p { margin:0 0 16px; color:var(--muted); }
            
            /* Footer */
            .footer { background:var(--dark); color:#e2e8f0; padding:60px 0 20px; }
            .footer-content { display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:40px; margin-bottom:40px; }
            .footer-section h4 { margin:0 0 20px; color:white; font-size:18px; }
            .footer-section ul { list-style:none; padding:0; margin:0; }
            .footer-section li { margin-bottom:8px; }
            .footer-section a { color:#94a3b8; }
            .footer-section a:hover { color:white; }
            .footer-bottom { border-top:1px solid #334155; padding-top:20px; text-align:center; color:#94a3b8; }
            
            /* Forms */
            .form-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
            .form-header { text-align: center; margin-bottom: 32px; }
            .form-header h1 { font-size: 32px; margin: 0 0 8px; color: var(--dark); }
            .form-header p { color: var(--muted); font-size: 16px; }
            .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 32px; box-shadow: var(--shadow); }
            .form-group { margin-bottom: 20px; }
            .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
            .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark); font-size: 14px; }
            .form-input { 
                width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 8px; 
                font-size: 14px; transition: all 0.3s; background: #fff;
            }
            .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1); }
            .form-input.error { border-color: var(--danger); }
            .form-textarea { min-height: 120px; resize: vertical; font-family: inherit; }
            .form-error { color: var(--danger); font-size: 13px; margin-top: 6px; display: block; }
            .form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); }
            .form-success { background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0; }
            
            /* Enhanced Buttons */
            .btn-lg { padding: 16px 32px; font-size: 16px; }
            .btn-sm { padding: 8px 16px; font-size: 13px; }
            .btn-danger { background: var(--danger); color: white; border-color: var(--danger); }
            .btn-success { background: var(--secondary); color: white; border-color: var(--secondary); }
            
            /* Utilities */
            .muted { color:var(--muted); font-size:14px; }
            .hidden { display:none; }
            .text-center { text-align:center; }
            
            /* Responsive */
            @media (max-width: 768px) {
                .hero h1 { font-size:32px; }
                .hero p { font-size:16px; }
                .hero-buttons { flex-direction:column; align-items:center; }
                .nav-links { gap:12px; }
                .features-grid { grid-template-columns: 1fr; }
                
                /* Add bottom padding for mobile navigation */
                body {
                    padding-bottom: 80px !important;
                }
                
                /* Improve mobile spacing */
                .container {
                    padding: 0 16px;
                }
                
                /* Mobile-friendly buttons */
                .btn {
                    min-height: 44px;
                    padding: 12px 20px;
                    font-size: 16px;
                }
                
                /* Better mobile forms */
                .form-input {
                    min-height: 44px;
                    font-size: 16px; /* Prevents zoom on iOS */
                }
                
                /* Mobile-optimized cards */
                .card {
                    margin-bottom: 16px;
                }
                
                /* Mobile hero adjustments */
                .hero {
                    padding: 60px 0;
                }
                
                /* Mobile grid improvements */
                .grid {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }
            }
            
            /* Tab System */
            .tab.active { color: var(--primary) !important; border-bottom-color: var(--primary) !important; }
            .hidden { display: none !important; }
        </style>
    </head>
    <body>
        @includeIf('layouts.navigation')

        @isset($header)
            <header class="page">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            <!-- Flash Messages -->
            @if(session('success'))
                <div style="background: var(--secondary); color: white; padding: 16px; margin: 20px auto; max-width: 1200px; border-radius: 8px; display: flex; align-items: center; gap: 12px; box-shadow: var(--shadow);">
                    <span style="font-size: 20px;">✅</span>
                    <span style="font-weight: 600;">{{ session('success') }}</span>
                    <button onclick="this.parentElement.style.display='none'" style="margin-right: auto; background: none; border: none; color: white; font-size: 18px; cursor: pointer; padding: 4px;">×</button>
                </div>
            @endif
            
            @if(session('error'))
                <div id="errorAlert" style="background: var(--danger); color: white; padding: 16px; margin: 20px auto; max-width: 1200px; border-radius: 8px; display: flex; align-items: center; gap: 12px; box-shadow: var(--shadow); animation: slideDown 0.5s ease-out;">
                    <span style="font-size: 20px;">❌</span>
                    <span style="font-weight: 600;">{{ session('error') }}</span>
                    <button onclick="this.parentElement.style.display='none'" style="margin-right: auto; background: none; border: none; color: white; font-size: 18px; cursor: pointer; padding: 4px;">×</button>
                </div>
                <script>
                    // Auto-hide error message after 8 seconds
                    setTimeout(function() {
                        const errorAlert = document.getElementById('errorAlert');
                        if (errorAlert) {
                            errorAlert.style.animation = 'slideUp 0.5s ease-out';
                            setTimeout(() => errorAlert.style.display = 'none', 500);
                        }
                    }, 8000);
                </script>
                <style>
                    @keyframes slideDown {
                        from { opacity: 0; transform: translateY(-20px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    @keyframes slideUp {
                        from { opacity: 1; transform: translateY(0); }
                        to { opacity: 0; transform: translateY(-20px); }
                    }
                </style>
            @endif
            
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <script>
            // Tiny tabs logic (no dependencies)
            document.addEventListener('click', (e) => {
                const t = e.target.closest('[data-tab-target]');
                if(!t) return;
                e.preventDefault();
                const group = t.closest('[data-tabs]');
                group.querySelectorAll('[data-tab-target]').forEach(b=>b.classList.remove('active'));
                t.classList.add('active');
                const id = t.getAttribute('data-tab-target');
                group.querySelectorAll('[data-tab-panel]').forEach(p=>{
                    p.classList.toggle('hidden', '#'+p.id !== id);
                });
            });
        </script>
    </body>
</html>
