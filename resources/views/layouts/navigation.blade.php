<nav class="navbar" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(59, 130, 246, 0.1); box-shadow: 0 4px 20px rgba(0,0,0,0.08); width: 100%; padding: 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; max-width: 100%; width: 100%;">
    <!-- Brand -->
    <a class="brand" href="/" style="display: flex; align-items: center; gap: 8px; font-size: 24px; font-weight: 900; background: linear-gradient(45deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; flex-shrink: 0;">
      🚀 Sokappe
    </a>
    
    <!-- Main Navigation Links -->
    <div class="nav-center" style="display: flex; align-items: center; gap: 15px; flex: 1; justify-content: center; max-width: 600px;">
      <a href="{{ route('projects.index') }}" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; transition: all 0.3s ease; font-weight: 500;">
        <span class="emoji">💼</span> <span>تصفح المشاريع</span>
      </a>
      <a href="{{ route('services.index') }}" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; transition: all 0.3s ease; font-weight: 500;">
        <span class="emoji">⭐</span> <span>تصفح الخدمات</span>
      </a>
      <a href="{{ route('deals.index') }}" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 25px; background: linear-gradient(135deg, #fef3c7, #fbbf24); color: #92400e; font-weight: 600; box-shadow: 0 2px 10px rgba(251, 191, 36, 0.3);">
        <span class="emoji">💎</span> <span>الصفقات الذهبية</span>
      </a>
    </div>
    
    <!-- User Actions Section -->
    <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
      @auth
        <!-- Messages Dropdown -->
        <div style="position: relative; display: inline-block;">
          <button onclick="toggleMessagesDropdown()" style="position: relative; background: none; border: none; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; transition: all 0.3s ease; cursor: pointer; background: rgba(16, 185, 129, 0.1); color: #10b981;">
            <span style="font-size: 20px;">💬</span>
            <span id="messagesUnreadBadge" style="position: absolute; top: -2px; right: -2px; background: linear-gradient(45deg, #ef4444, #dc2626); color: white; min-width: 18px; height: 18px; border-radius: 50%; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; animation: pulse 2s infinite; padding: 0 4px;">0</span>
          </button>
          
          <div id="messagesDropdown" style="display: none; position: absolute; top: 100%; right: -150px; background: white; border: 1px solid rgba(59, 130, 246, 0.1); border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); width: 350px; z-index: 1000; overflow: hidden; backdrop-filter: blur(10px); margin-top: 8px;">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); padding: 16px; border-bottom: 1px solid rgba(59, 130, 246, 0.1); display: flex; justify-content: space-between; align-items: center;">
              <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #1f2937;">💬 الرسائل الأخيرة</h3>
              <a href="{{ route('messages.index') }}" style="font-size: 12px; color: #3b82f6; text-decoration: none; font-weight: 600;">عرض الكل</a>
            </div>
            
            <!-- Messages List -->
            <div id="messagesDropdownContent" style="max-height: 300px; overflow-y: auto;">
              <div style="padding: 20px; text-align: center; color: #64748b;">
                <div style="font-size: 24px; margin-bottom: 8px;">📭</div>
                <div>جاري تحميل الرسائل...</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Notifications Dropdown -->
        <div style="position: relative; display: inline-block;">
          <button onclick="toggleNotificationsDropdown()" style="position: relative; background: none; border: none; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; transition: all 0.3s ease; cursor: pointer; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
            <span style="font-size: 20px;">🔔</span>
            <span id="notificationsUnreadBadge" style="position: absolute; top: -2px; right: -2px; background: linear-gradient(45deg, #f59e0b, #d97706); color: white; min-width: 18px; height: 18px; border-radius: 50%; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; animation: pulse 2s infinite; padding: 0 4px;">0</span>
          </button>
          
          <div id="notificationsDropdown" style="display: none; position: absolute; top: 100%; right: -150px; background: white; border: 1px solid rgba(59, 130, 246, 0.1); border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); width: 350px; z-index: 1000; overflow: hidden; backdrop-filter: blur(10px); margin-top: 8px;">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); padding: 16px; border-bottom: 1px solid rgba(59, 130, 246, 0.1); display: flex; justify-content: space-between; align-items: center;">
              <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #1f2937;">🔔 الإشعارات</h3>
              <button onclick="markAllNotificationsAsRead()" style="background: none; border: none; font-size: 12px; color: #3b82f6; cursor: pointer; font-weight: 600;">تعيين كمقروء</button>
            </div>
            
            <!-- Notifications List -->
            <div id="notificationsDropdownContent" style="max-height: 300px; overflow-y: auto;">
              <div style="padding: 20px; text-align: center; color: #64748b;">
                <div style="font-size: 24px; margin-bottom: 8px;">🔕</div>
                <div>جاري تحميل الإشعارات...</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Quick Action Button -->
        <a href="{{ route('projects.create.new') }}" style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 50%; font-size: 18px; font-weight: 600; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: all 0.3s ease; text-decoration: none;" title="مشروع جديد">
          ➕
        </a>
        <!-- User Profile Dropdown -->
        <div style="position: relative; display: inline-block;">
          <button onclick="toggleDropdown()" style="background: none; border: none; display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 8px 12px; border-radius: 25px; transition: all 0.3s ease; background: rgba(59, 130, 246, 0.05);">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);">
              {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="user-profile-text" style="display: flex; flex-direction: column; align-items: start; text-align: right;">
              <span style="font-weight: 600; font-size: 14px; color: #1f2937;">{{ Str::limit(Auth::user()->name, 12) }}</span>
              <span style="font-size: 11px; color: #64748b;">{{ Auth::user()->role === 'admin' ? '🛡️ مدير' : (Auth::user()->role === 'freelancer' ? '⭐ محترف' : '💼 عميل') }}</span>
            </div>
            <span style="font-size: 10px; color: #64748b; transition: transform 0.3s ease;" id="dropdownArrow">▼</span>
          </button>
          
          <div id="userDropdown" style="display: none; position: fixed; top: 60px; left: 10px; background: white; border: 1px solid rgba(59, 130, 246, 0.1); border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); width: 250px; z-index: 9999; overflow: hidden; backdrop-filter: blur(10px); max-width: calc(100vw - 20px);">
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
        <a href="{{ route('login') }}" style="padding: 8px 16px; color: #64748b; text-decoration: none; font-weight: 500; transition: all 0.3s ease;">تسجيل الدخول</a>
        <a href="{{ route('register') }}" style="padding: 10px 20px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; border-radius: 25px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">انضم الآن</a>
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
    
    // Ensure dropdown stays within viewport
    const rect = dropdown.getBoundingClientRect();
    const viewportWidth = window.innerWidth;
    
    if (rect.right > viewportWidth) {
      const overflow = rect.right - viewportWidth;
      dropdown.style.transform = `translateX(-${overflow + 10}px)`;
    }
  } else {
    dropdown.style.animation = 'slideUp 0.3s ease-out';
    arrow.style.transform = 'rotate(0deg)';
    setTimeout(() => {
      dropdown.style.display = 'none';
      dropdown.style.transform = 'translateX(0)';
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
document.querySelectorAll('a[href*="projects"], a[href*="services"], a[href*="deals"]').forEach(link => {
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

// Add hover effects to circular buttons
document.querySelectorAll('button[style*="border-radius: 50%"], a[style*="border-radius: 50%"]').forEach(btn => {
  btn.addEventListener('mouseenter', function() {
    this.style.transform = 'scale(1.1)';
    this.style.boxShadow = this.style.boxShadow.replace(/rgba\([^)]+\)/g, match => {
      return match.replace(/0\.\d+\)/, '0.6)');
    });
  });
  
  btn.addEventListener('mouseleave', function() {
    this.style.transform = 'scale(1)';
    this.style.boxShadow = this.style.boxShadow.replace(/rgba\([^)]+\)/g, match => {
      return match.replace(/0\.\d+\)/, '0.3)');
    });
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

/* Responsive Design */
@media (max-width: 768px) {
  .navbar {
    padding: 8px 0 !important;
  }
  
  .navbar > div {
    padding: 8px 15px !important;
    gap: 8px !important;
  }
  
  .brand {
    font-size: 20px !important;
  }
  
  /* Hide text on small screens, keep only icons */
  .nav-center a span:not(.emoji) {
    display: none;
  }
  
  .nav-center a {
    padding: 8px 12px !important;
    font-size: 18px;
  }
  
  /* Make dropdowns responsive on mobile */
  #messagesDropdown, #notificationsDropdown {
    right: -100px !important;
    width: 300px !important;
    max-width: calc(100vw - 40px) !important;
  }
  
  #userDropdown {
    right: 0 !important;
    width: 280px !important;
    max-width: calc(100vw - 20px) !important;
    transform: translateX(0) !important;
  }
  
  /* Compact user profile */
  .user-profile-text {
    display: none !important;
  }
}

@media (max-width: 480px) {
  .nav-center {
    gap: 5px !important;
  }
  
  .nav-center a {
    padding: 6px 8px !important;
  }
}
`;

document.head.appendChild(style);

// Messages and Notifications Dropdown Functions
function toggleMessagesDropdown() {
  const dropdown = document.getElementById('messagesDropdown');
  const notificationsDropdown = document.getElementById('notificationsDropdown');
  
  // Close notifications dropdown if open
  if (notificationsDropdown.style.display === 'block') {
    notificationsDropdown.style.display = 'none';
  }
  
  if (dropdown.style.display === 'none' || !dropdown.style.display) {
    dropdown.style.display = 'block';
    dropdown.style.animation = 'slideDown 0.3s ease-out';
    loadMessages();
  } else {
    dropdown.style.animation = 'slideUp 0.3s ease-out';
    setTimeout(() => {
      dropdown.style.display = 'none';
    }, 300);
  }
}

function toggleNotificationsDropdown() {
  const dropdown = document.getElementById('notificationsDropdown');
  const messagesDropdown = document.getElementById('messagesDropdown');
  
  // Close messages dropdown if open
  if (messagesDropdown.style.display === 'block') {
    messagesDropdown.style.display = 'none';
  }
  
  if (dropdown.style.display === 'none' || !dropdown.style.display) {
    dropdown.style.display = 'block';
    dropdown.style.animation = 'slideDown 0.3s ease-out';
    loadNotifications();
  } else {
    dropdown.style.animation = 'slideUp 0.3s ease-out';
    setTimeout(() => {
      dropdown.style.display = 'none';
    }, 300);
  }
}

// Load messages for dropdown
function loadMessages() {
  fetch('/messages/unread-count')
    .then(response => response.json())
    .then(data => {
      const content = document.getElementById('messagesDropdownContent');
      
      if (data.count === 0) {
        content.innerHTML = `
          <div style="padding: 20px; text-align: center; color: #64748b;">
            <div style="font-size: 24px; margin-bottom: 8px;">📭</div>
            <div>لا توجد رسائل جديدة</div>
          </div>
        `;
      } else {
        // For now, show a simple message count
        content.innerHTML = `
          <div style="padding: 16px;">
            <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); padding: 12px; border-radius: 8px; text-align: center;">
              <div style="font-size: 18px; margin-bottom: 4px;">💬</div>
              <div style="font-weight: 600; color: #1e40af;">لديك ${data.count} رسائل غير مقروءة</div>
              <a href="/messages" style="display: inline-block; margin-top: 8px; padding: 6px 12px; background: #3b82f6; color: white; border-radius: 6px; text-decoration: none; font-size: 12px;">عرض الرسائل</a>
            </div>
          </div>
        `;
      }
      
      // Update badge
      const badge = document.getElementById('messagesUnreadBadge');
      if (data.count > 0) {
        badge.textContent = data.count > 99 ? '99+' : data.count;
        badge.style.display = 'flex';
      } else {
        badge.style.display = 'none';
      }
    })
    .catch(error => {
      console.error('Error loading messages:', error);
    });
}

// Load notifications for dropdown
function loadNotifications() {
  fetch('/notifications')
    .then(response => response.json())
    .then(data => {
      const content = document.getElementById('notificationsDropdownContent');
      
      if (data.notifications.length === 0) {
        content.innerHTML = `
          <div style="padding: 20px; text-align: center; color: #64748b;">
            <div style="font-size: 24px; margin-bottom: 8px;">🔕</div>
            <div>لا توجد إشعارات</div>
          </div>
        `;
      } else {
        let notificationsHtml = '';
        
        data.notifications.forEach(notification => {
          const isUnread = !notification.read_at;
          const timeAgo = getTimeAgo(notification.created_at);
          
          notificationsHtml += `
            <div onclick="handleNotificationClick(${notification.id})" style="
              padding: 12px 16px; 
              border-bottom: 1px solid #f1f5f9; 
              cursor: pointer; 
              transition: all 0.2s;
              background: ${isUnread ? 'rgba(59, 130, 246, 0.05)' : 'transparent'};
              border-right: ${isUnread ? '3px solid #3b82f6' : '3px solid transparent'};
            " onmouseover="this.style.background='rgba(59, 130, 246, 0.08)'" onmouseout="this.style.background='${isUnread ? 'rgba(59, 130, 246, 0.05)' : 'transparent'}'">
              <div style="display: flex; align-items: start; gap: 10px;">
                <div style="font-size: 20px; flex-shrink: 0;">${getNotificationIcon(notification.type)}</div>
                <div style="flex: 1; min-width: 0;">
                  <div style="font-weight: ${isUnread ? '700' : '500'}; font-size: 13px; color: #1f2937; margin-bottom: 2px;">
                    ${notification.title}
                  </div>
                  <div style="font-size: 12px; color: #64748b; line-height: 1.4; margin-bottom: 4px;">
                    ${notification.message}
                  </div>
                  <div style="font-size: 10px; color: #94a3b8;">
                    ${timeAgo}
                  </div>
                </div>
                ${isUnread ? '<div style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%; flex-shrink: 0; margin-top: 4px;"></div>' : ''}
              </div>
            </div>
          `;
        });
        
        content.innerHTML = notificationsHtml;
      }
      
      // Update badge
      const badge = document.getElementById('notificationsUnreadBadge');
      if (data.unread_count > 0) {
        badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
        badge.style.display = 'flex';
      } else {
        badge.style.display = 'none';
      }
    })
    .catch(error => {
      console.error('Error loading notifications:', error);
    });
}

// Handle notification click
function handleNotificationClick(notificationId) {
  // Mark as read and redirect
  fetch(`/notifications/${notificationId}/click`)
    .then(response => {
      if (response.redirected) {
        window.location.href = response.url;
      }
    })
    .catch(error => {
      console.error('Error handling notification click:', error);
    });
}

// Mark all notifications as read
function markAllNotificationsAsRead() {
  fetch('/notifications/read-all', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      loadNotifications(); // Reload notifications
      showNotification('تم تعيين جميع الإشعارات كمقروءة', 'success');
    }
  })
  .catch(error => {
    console.error('Error marking notifications as read:', error);
  });
}

// Get notification icon
function getNotificationIcon(type) {
  const icons = {
    'call_request': '📞',
    'message': '💬',
    'bid_accepted': '✅',
    'bid_rejected': '❌',
    'project_completed': '🎉',
    'payment_received': '💰'
  };
  return icons[type] || '🔔';
}

// Get time ago string
function getTimeAgo(dateString) {
  const date = new Date(dateString);
  const now = new Date();
  const diffInSeconds = Math.floor((now - date) / 1000);
  
  if (diffInSeconds < 60) return 'الآن';
  if (diffInSeconds < 3600) return `منذ ${Math.floor(diffInSeconds / 60)} دقيقة`;
  if (diffInSeconds < 86400) return `منذ ${Math.floor(diffInSeconds / 3600)} ساعة`;
  if (diffInSeconds < 604800) return `منذ ${Math.floor(diffInSeconds / 86400)} يوم`;
  return date.toLocaleDateString('ar-EG');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
  const messagesDropdown = document.getElementById('messagesDropdown');
  const notificationsDropdown = document.getElementById('notificationsDropdown');
  const userDropdown = document.getElementById('userDropdown');
  
  const messagesButton = event.target.closest('button[onclick="toggleMessagesDropdown()"]');
  const notificationsButton = event.target.closest('button[onclick="toggleNotificationsDropdown()"]');
  const userButton = event.target.closest('button[onclick="toggleDropdown()"]');
  
  if (!messagesButton && messagesDropdown.style.display === 'block') {
    messagesDropdown.style.animation = 'slideUp 0.3s ease-out';
    setTimeout(() => {
      messagesDropdown.style.display = 'none';
    }, 300);
  }
  
  if (!notificationsButton && notificationsDropdown.style.display === 'block') {
    notificationsDropdown.style.animation = 'slideUp 0.3s ease-out';
    setTimeout(() => {
      notificationsDropdown.style.display = 'none';
    }, 300);
  }
  
  if (!userButton && userDropdown.style.display === 'block') {
    const arrow = document.getElementById('dropdownArrow');
    userDropdown.style.animation = 'slideUp 0.3s ease-out';
    arrow.style.transform = 'rotate(0deg)';
    setTimeout(() => {
      userDropdown.style.display = 'none';
    }, 300);
  }
});

// Load initial counts
document.addEventListener('DOMContentLoaded', function() {
  // Load messages count
  fetch('/messages/unread-count')
    .then(response => response.json())
    .then(data => {
      const badge = document.getElementById('messagesUnreadBadge');
      if (data.count > 0) {
        badge.textContent = data.count > 99 ? '99+' : data.count;
        badge.style.display = 'flex';
      }
    })
    .catch(error => console.error('Error loading messages count:', error));
  
  // Load notifications count
  fetch('/notifications')
    .then(response => response.json())
    .then(data => {
      const badge = document.getElementById('notificationsUnreadBadge');
      if (data.unread_count > 0) {
        badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
        badge.style.display = 'flex';
      }
    })
    .catch(error => console.error('Error loading notifications count:', error));
});

console.log('🚀 Enhanced Navigation with Messages & Notifications Loaded Successfully!');
</script>
