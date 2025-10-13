<nav class="navbar">
  <div class="nav-inner">
    <a class="brand" href="/">Sokappe</a>
    <div class="nav-links">
      <a href="{{ route('projects.index') }}">تصفح المشاريع</a>
      <a href="{{ route('services.index') }}">تصفح الخدمات</a>
      <a href="{{ route('deals.index') }}">💎 الصفقات</a>
      @auth
        <a href="{{ route('messages.index') }}" style="position: relative;">
          💬 الرسائل
          <!-- <span class="messages-unread-badge" style="display: none; position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; width: 18px; height: 18px; border-radius: 50%; font-size: 11px; font-weight: 600; display: flex; align-items: center; justify-content: center;"></span> -->
        </a>
        <!-- <a href="{{ route('projects.create.new') }}" class="btn primary" style="padding: 8px 16px; margin: 0 5px;">+ إنشاء مشروع</a>
        <a href="{{ route('services.create.new') }}" class="btn outline" style="padding: 8px 16px; margin: 0 5px;">+ إنشاء خدمة</a> -->
        @if(Auth::user()->role === 'freelancer')
          <a href="#">خدماتي</a>
        @endif
        @if(Auth::user()->role === 'employer')
          <a href="#">مشاريعي</a>
        @endif
        <div style="position: relative; display: inline-block;">
          <button onclick="toggleDropdown()" style="background: none; border: none; display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text);">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
              {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
            <span style="font-size: 12px;">▼</span>
          </button>
          <div id="userDropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid var(--border); border-radius: 8px; box-shadow: var(--shadow); min-width: 200px; z-index: 1000;">
            <a href="{{ route('dashboard') }}" style="display: block; padding: 12px 16px; color: var(--text); text-decoration: none; border-bottom: 1px solid var(--border);">📊 لوحة التحكم</a>
            @if(Auth::user()->role === 'admin')
              <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 12px 16px; color: var(--text); text-decoration: none; border-bottom: 1px solid var(--border); background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; font-weight: 600;">
                🛡️ لوحة الإدارة
              </a>
            @endif
            <a href="{{ route('profile.show', Auth::user()) }}" style="display: block; padding: 12px 16px; color: var(--text); text-decoration: none; border-bottom: 1px solid var(--border);">👤 الملف الشخصي</a>
            <a href="{{ route('wallet.index') }}" style="display: block; padding: 12px 16px; color: var(--text); text-decoration: none; border-bottom: 1px solid var(--border);">💰 محفظتي</a>
            <a href="{{ route('profile.edit') }}" style="display: block; padding: 12px 16px; color: var(--text); text-decoration: none; border-bottom: 1px solid var(--border);">⚙️ الإعدادات</a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
              @csrf
              <button type="submit" style="width: 100%; text-align: right; padding: 12px 16px; background: none; border: none; color: var(--danger); cursor: pointer;">🚪 تسجيل الخروج</button>
            </form>
          </div>
        </div>
      @endauth
      @guest
        <a href="{{ route('login') }}">تسجيل الدخول</a>
        <a class="btn primary" href="{{ route('register') }}">انضم الآن</a>
      @endguest
    </div>
  </div>
</nav>

<script>
function toggleDropdown() {
  const dropdown = document.getElementById('userDropdown');
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('userDropdown');
  const button = event.target.closest('button');
  if (!button || !button.onclick) {
    dropdown.style.display = 'none';
  }
});
</script>
