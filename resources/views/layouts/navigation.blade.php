<nav class="navbar" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(59, 130, 246, 0.1); box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
  <div class="nav-inner">
    <a class="brand" href="/" style="display: flex; align-items: center; gap: 10px; font-size: 28px; font-weight: 900; background: linear-gradient(45deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
      🚀 Sokappe
    </a>
    <div class="nav-links" style="display: flex; align-items: center; gap: 25px;">
      <a href="{{ route('projects.index') }}" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; transition: all 0.3s ease; font-weight: 500;">
        💼 تصفح المشاريع
      </a>
      <a href="{{ route('services.index') }}" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; transition: all 0.3s ease; font-weight: 500;">
        ⭐ تصفح الخدمات
      </a>
      <a href="{{ route('deals.index') }}" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; background: linear-gradient(135deg, #fef3c7, #fbbf24); color: #92400e; font-weight: 600; box-shadow: 0 2px 10px rgba(251, 191, 36, 0.3);">
        💎 الصفقات الذهبية
      </a>
      @auth
        <a href="{{ route('messages.index') }}" style="position: relative; display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; transition: all 0.3s ease; font-weight: 500;">
          💬 الرسائل
          <span class="messages-unread-badge" style="position: absolute; top: 2px; right: 8px; background: linear-gradient(45deg, #ef4444, #dc2626); color: white; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; animation: pulse 2s infinite;">3</span>
        </a>
        
        <!-- Quick Action Buttons -->
        <div style="display: flex; gap: 8px; align-items: center;">
          <a href="{{ route('projects.create') }}" class="btn" style="padding: 10px 20px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 25px; font-size: 13px; font-weight: 600; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: all 0.3s ease;">
            ➕ مشروع جديد
          </a>
          @if(Auth::user()->role === 'freelancer')
            <a href="#" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-weight: 500; transition: all 0.3s ease;">
              🛠️ خدماتي
            </a>
          @endif
          @if(Auth::user()->role === 'employer')
            <a href="#" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-weight: 500; transition: all 0.3s ease;">
              📊 مشاريعي
            </a>
          @endif
        </div>
        <!-- User Profile Dropdown -->
        <div style="position: relative; display: inline-block;">
          <button onclick="toggleDropdown()" style="background: none; border: none; display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 8px 12px; border-radius: 25px; transition: all 0.3s ease; background: rgba(59, 130, 246, 0.05);">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);">
              {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div style="display: flex; flex-direction: column; align-items: start; text-align: right;">
              <span style="font-weight: 600; font-size: 14px; color: #1f2937;">{{ Str::limit(Auth::user()->name, 12) }}</span>
              <span style="font-size: 11px; color: #64748b;">{{ Auth::user()->role === 'admin' ? '🛡️ مدير' : (Auth::user()->role === 'freelancer' ? '⭐ محترف' : '💼 عميل') }}</span>
            </div>
            <span style="font-size: 10px; color: #64748b; transition: transform 0.3s ease;" id="dropdownArrow">▼</span>
          </button>
          
          <div id="userDropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid rgba(59, 130, 246, 0.1); border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); min-width: 220px; z-index: 1000; overflow: hidden; backdrop-filter: blur(10px);">
            <!-- User Info Header -->
            <div style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); padding: 16px; border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
              <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px;">
                  {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                  <div style="font-weight: 700; color: #1f2937; font-size: 15px;">{{ Auth::user()->name }}</div>
                  <div style="font-size: 12px; color: #64748b;">{{ Auth::user()->email }}</div>
                  <div style="font-size: 11px; color: #8b5cf6; font-weight: 600; margin-top: 2px;">
                    {{ Auth::user()->role === 'admin' ? '🛡️ مدير النظام' : (Auth::user()->role === 'freelancer' ? '⭐ محترف معتمد' : '💼 عميل مميز') }}
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Menu Items -->
            <div style="padding: 8px 0;">
              <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #374151; text-decoration: none; transition: all 0.3s ease; font-weight: 500;">
                <span style="font-size: 16px;">📊</span>
                <span>لوحة التحكم</span>
              </a>
              
              @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; font-weight: 600; margin: 4px 8px; border-radius: 8px;">
                  <span style="font-size: 16px;">🛡️</span>
                  <span>لوحة الإدارة</span>
                  <span style="margin-right: auto; font-size: 10px; background: #f59e0b; color: white; padding: 2px 6px; border-radius: 10px;">VIP</span>
                </a>
              @endif
              
              <a href="{{ route('profile.show', Auth::user()) }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #374151; text-decoration: none; transition: all 0.3s ease; font-weight: 500;">
                <span style="font-size: 16px;">👤</span>
                <span>الملف الشخصي</span>
              </a>
              
              <a href="{{ route('wallet.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #374151; text-decoration: none; transition: all 0.3s ease; font-weight: 500;">
                <span style="font-size: 16px;">💰</span>
                <span>محفظتي</span>
                <span style="margin-right: auto; font-size: 10px; background: #10b981; color: white; padding: 2px 6px; border-radius: 10px;">جديد</span>
              </a>
              
              <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #374151; text-decoration: none; transition: all 0.3s ease; font-weight: 500;">
                <span style="font-size: 16px;">⚙️</span>
                <span>الإعدادات</span>
              </a>
              
              <div style="border-top: 1px solid #f1f5f9; margin: 8px 0;"></div>
              
              <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: none; border: none; color: #ef4444; cursor: pointer; text-align: right; transition: all 0.3s ease; font-weight: 500;">
                  <span style="font-size: 16px;">🚪</span>
                  <span>تسجيل الخروج</span>
                </button>
              </form>
            </div>
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
  const arrow = document.getElementById('dropdownArrow');
  
  if (dropdown.style.display === 'none' || !dropdown.style.display) {
    dropdown.style.display = 'block';
    dropdown.style.animation = 'slideDown 0.3s ease-out';
    arrow.style.transform = 'rotate(180deg)';
  } else {
    dropdown.style.animation = 'slideUp 0.3s ease-out';
    arrow.style.transform = 'rotate(0deg)';
    setTimeout(() => {
      dropdown.style.display = 'none';
    }, 300);
  }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('userDropdown');
  const button = event.target.closest('button[onclick="toggleDropdown()"]');
  
  if (!button && dropdown.style.display === 'block') {
    const arrow = document.getElementById('dropdownArrow');
    dropdown.style.animation = 'slideUp 0.3s ease-out';
    arrow.style.transform = 'rotate(0deg)';
    setTimeout(() => {
      dropdown.style.display = 'none';
    }, 300);
  }
});

// Add hover effects to navigation links
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('mouseenter', function() {
    if (!this.style.background.includes('gradient')) {
      this.style.background = 'rgba(59, 130, 246, 0.1)';
      this.style.color = '#3b82f6';
      this.style.transform = 'translateY(-2px)';
    }
  });
  
  link.addEventListener('mouseleave', function() {
    if (!this.style.background.includes('gradient')) {
      this.style.background = 'transparent';
      this.style.color = 'inherit';
      this.style.transform = 'translateY(0)';
    }
  });
});

// Add hover effects to dropdown items
document.querySelectorAll('#userDropdown a, #userDropdown button').forEach(item => {
  item.addEventListener('mouseenter', function() {
    if (!this.style.background.includes('gradient')) {
      this.style.background = 'rgba(59, 130, 246, 0.05)';
      this.style.transform = 'translateX(5px)';
    }
  });
  
  item.addEventListener('mouseleave', function() {
    if (!this.style.background.includes('gradient')) {
      this.style.background = 'transparent';
      this.style.transform = 'translateX(0)';
    }
  });
});

// Add scroll effect to navbar
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 50) {
    navbar.style.background = 'rgba(255,255,255,0.98)';
    navbar.style.backdropFilter = 'blur(20px)';
    navbar.style.boxShadow = '0 8px 32px rgba(0,0,0,0.12)';
  } else {
    navbar.style.background = 'rgba(255,255,255,0.95)';
    navbar.style.backdropFilter = 'blur(10px)';
    navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.08)';
  }
});

// Add notification animation
function showNotification(message, type = 'success') {
  const notification = document.createElement('div');
  notification.innerHTML = `
    <div style="
      position: fixed;
      top: 80px;
      right: 20px;
      background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
      color: white;
      padding: 16px 24px;
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.2);
      z-index: 10000;
      animation: slideInRight 0.5s ease-out;
      max-width: 300px;
    ">
      <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 18px;">${type === 'success' ? '✅' : '❌'}</span>
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
@keyframes slideDown {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes slideUp {
  from { opacity: 1; transform: translateY(0); }
  to { opacity: 0; transform: translateY(-10px); }
}

@keyframes slideInRight {
  from { opacity: 0; transform: translateX(100px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes slideOutRight {
  from { opacity: 1; transform: translateX(0); }
  to { opacity: 0; transform: translateX(100px); }
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

/* Enhanced hover effects */
.nav-links a:hover {
  transform: translateY(-2px) !important;
}

.btn:hover {
  transform: translateY(-3px) !important;
  box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4) !important;
}

/* Messages badge animation */
.messages-unread-badge {
  animation: pulse 2s infinite;
}
`;

document.head.appendChild(style);

console.log('🚀 Enhanced Navigation Loaded Successfully!');
</script>
