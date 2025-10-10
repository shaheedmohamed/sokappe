@extends('layouts.guest')

@section('content')
<div class="auth-header">
    <h1>👋 مرحباً بعودتك</h1>
    <p>سجّل دخولك للوصول إلى حسابك</p>
</div>

<div class="auth-body">
    @if (session('status'))
        <div class="success-message">
            ✅ {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">📧 البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   class="form-input @error('email') error @enderror" placeholder="example@domain.com">
            @error('email')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">🔒 كلمة المرور</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                   class="form-input @error('password') error @enderror" placeholder="كلمة المرور">
            @error('password')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="remember_me" name="remember">
            <label for="remember_me">تذكرني في هذا الجهاز</label>
        </div>

        <button type="submit" class="btn btn-primary">
            🚀 تسجيل الدخول
        </button>

        @if (Route::has('password.request'))
            <div style="text-align: center; margin-top: 16px;">
                <a href="{{ route('password.request') }}" style="color: var(--gray-500); font-size: 14px;">
                    هل نسيت كلمة المرور؟
                </a>
            </div>
        @endif
    </form>
</div>

<div class="auth-footer">
    <p>ليس لديك حساب؟ <a href="{{ route('register') }}">أنشئ حساب جديد</a></p>
</div>
@endsection
