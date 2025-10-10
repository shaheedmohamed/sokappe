@extends('layouts.guest')

@section('content')
<div class="auth-header">
    <h1>🚀 انضم إلى Sokappe</h1>
    <p>أنشئ حسابك واكتشف عالم العمل الحر</p>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">👤 الاسم الكامل</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                   class="form-input @error('name') error @enderror" placeholder="أدخل اسمك الكامل">
            @error('name')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">📧 البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                   class="form-input @error('email') error @enderror" placeholder="example@domain.com">
            @error('email')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">🔒 كلمة المرور</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                   class="form-input @error('password') error @enderror" placeholder="كلمة مرور قوية">
            @error('password')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">🔐 تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                   class="form-input @error('password_confirmation') error @enderror" placeholder="أعد كتابة كلمة المرور">
            @error('password_confirmation')
                <div class="form-error">⚠️ {{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            ✨ إنشاء حساب جديد
        </button>
    </form>
</div>

<div class="auth-footer">
    <p>لديك حساب بالفعل؟ <a href="{{ route('login') }}">سجّل الدخول</a></p>
</div>
@endsection
